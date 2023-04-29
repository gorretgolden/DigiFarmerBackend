<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlotRequest;
use App\Http\Requests\UpdatePlotRequest;
use App\Repositories\PlotRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Plot;
use App\Models\Farm;
use App\Models\CropHarvest;

class PlotController extends AppBaseController
{
    /** @var PlotRepository $plotRepository*/
    private $plotRepository;

    public function __construct(PlotRepository $plotRepo)
    {
        $this->plotRepository = $plotRepo;
    }

    /**
     * Display a listing of the Plot.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $plots = Plot::latest()->paginate();

        return view('plots.index')
            ->with('plots', $plots);
    }

    /**
     * Show the form for creating a new Plot.
     *
     * @return Response
     */
    public function create()
    {
        return view('plots.create');
    }

    /**
     * Store a newly created Plot in storage.
     *
     * @param CreatePlotRequest $request
     *
     * @return Response
     */
    public function store(CreatePlotRequest $request)
    {

        //get the farm
        $farm = Farm::where('id',$request->farm_id)->first();

        $total_plot_sizes =$farm->plots->sum('size');

        $balance = $farm->field_area - $total_plot_sizes;



       if($total_plot_sizes==$farm->field_area){
          Flash::error('No available space on the farm');
          return redirect(route('plots.index'));


     }elseif($request->size>$farm->field_area){

        Flash::error('Plot size cannot be greater than farm size');
        return redirect(route('plots.index'));



     }elseif(($total_plot_sizes + $request->size) > $farm->field_area){

        Flash::error(" 'farm is left with'.' '. $balance .' '.'acres' ");
        return redirect(route('plots.index'));


     }


        if(!$farm){

            Flash::error('No farm selected');
            return redirect(route('plots.index'));

        }elseif(collect($farm->plots)->contains('name',$request->name)){

            Flash::error('Plot name exists on the farm.');
            return redirect(route('plots.index'));

        }elseif(collect($farm->plots)->contains('crop_id',$request->crop_id)){

            Flash::error('Crop selected already exists on a plot');
            return redirect(route('plots.index'));

        }else{

            $new_plot = new Plot();
            $new_plot->name = ucwords($request->name);
            $new_plot->farm_id = $request->farm_id;
            $new_plot->crop_id = $request->crop_id;
            $new_plot->district = $farm->address->district_name;
            $new_plot->size = $request->size;
            $new_plot->size_unit = "Acres";
            $new_plot->save();


            Flash::success('Plot saved successfuly');
            return redirect(route('plots.index'));


        }


    }

    /**
     * Display the specified Plot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $plot = $this->plotRepository->find($id);

        if (empty($plot)) {
            Flash::error('Plot not found');

            return redirect(route('plots.index'));
        }

        return view('plots.show')->with('plot', $plot);
    }

    /**
     * Show the form for editing the specified Plot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $plot = $this->plotRepository->find($id);

        if (empty($plot)) {
            Flash::error('Plot not found');

            return redirect(route('plots.index'));
        }

        return view('plots.edit')->with('plot', $plot);
    }

    /**
     * Update the specified Plot in storage.
     *
     * @param int $id
     * @param UpdatePlotRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlotRequest $request)
    {
        $plot = $this->plotRepository->find($id);

        if (empty($plot)) {
            Flash::error('Plot not found');

            return redirect(route('plots.index'));
        }

        $plot = $this->plotRepository->update($request->all(), $id);

        Flash::success('Plot updated successfully.');

        return redirect(route('plots.index'));
    }

    /**
     * Remove the specified Plot from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $plot = $this->plotRepository->find($id);

        if (empty($plot)) {
            Flash::error('Plot not found');

            return redirect(route('plots.index'));
        }

        $this->plotRepository->delete($id);

        Flash::success('Plot deleted successfully.');

        return redirect(route('plots.index'));
    }
}

// Flash::error('The crop'. ' '. $request->crop->name .''. 'already exists on'.' '. $plot->name);
// return redirect(route('plots.index'));
//check if plots exist

         //dd($farm->plots);
        //  $farm_plot_names = collect($farm->plots)->pluck('name');
        //  $farm_plot_crop_ids = collect($farm->plots)->pluck('crop_id');
        //  $farm_plot_ids = collect($farm->plots)->pluck('id');
         //dd($farm_plot_names);

        //  else{
        //     $collection = $farm->plots;

        //     for ($i = 0; $i < $collection->count(); $i++) {

        //         if ($plot->name == $request->name ) {

        //             Flash::error('Name already exits on  your farm plots');


        //         } elseif($plot->crop_id == $request->crop_id){

        //             Flash::error('The crop already exists on');


        //         }else{
                    // $new_plot = new Plot();
                    // $new_plot->name = $request->name;
                    // $new_plot->farm_id = $request->farm_id;
                    // $new_plot->crop_id = $request->crop_id;
                    // $new_plot->district_id = $request->district_id;
                    // $new_plot->size = $request->size;
                    // $new_plot->size_unit = $request->size_unit;
                    // $new_plot->save();
                    // Flash::success('Plot saved successfuly');
                    // return redirect(route('plots.index'));


        //         }

        //     }
