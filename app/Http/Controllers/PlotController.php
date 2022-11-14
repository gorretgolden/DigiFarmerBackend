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
        $plots = $this->plotRepository->all();

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
        $existing_plot = Plot::where('name',$request->name)->orWhere('crop_id',$request->crop_id)->first();
        if(!$existing_plot){
            $new_plot = new Plot();
            $new_plot->name = $request->name;
            $new_plot->farm_id = $request->farm_id;
            $new_plot->crop_id = $request->crop_id;
            $new_plot->district_id = $request->district_id;
            $new_plot->size = $request->size;
            $new_plot->size_unit = $request->size_unit;

            $new_plot->save();
            Flash::success('Plot saved successfully.');

        }
        else{
            Flash::error('Plot  name or crop on the plot already exists');
        }


        return redirect(route('plots.index'));
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
