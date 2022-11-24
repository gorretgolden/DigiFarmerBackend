<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlotAPIRequest;
use App\Http\Requests\API\UpdatePlotAPIRequest;
use App\Models\Plot;
use App\Repositories\PlotRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropHarvest;
use App\Models\Farm;

/**
 * Class PlotController
 * @package App\Http\Controllers\API
 */

class PlotAPIController extends AppBaseController
{
    /** @var  PlotRepository */
    private $plotRepository;

    public function __construct(PlotRepository $plotRepo)
    {
        $this->plotRepository = $plotRepo;
    }

    /**
     * Display a listing of the Plot.
     * GET|HEAD /plots
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $plots = Plot::with(['farm','crop','crop_harvests','district'])->get();
        $response = [
            'success'=>true,
            'data'=> $plots,
            'message'=> 'Plots retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created Plot in storage.
     * POST /plots
     *
     * @param CreatePlotAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $existing_plot = Plot::where('name',$request->name)->first();
        $existing_crop_on_plot =Plot::where('crop_id',$request->crop_id)->first();
        $existing_crop_on_plot_farm =Plot::where('farm_id',$request->farm_id)->first();

        if($existing_plot ){
            $response = [
                'success'=>false,
                'message'=> 'Plot name  already exits'
             ];

             return response()->json($response,409);
        }
        elseif($existing_crop_on_plot && $existing_crop_on_plot_farm){
            $response = [
                'success'=>false,
                'message'=> 'A plot with this crop exits on the farm'
             ];

             return response()->json($response,409);
        }
        if(!$existing_plot){
            $plot = $this->plotRepository->create($input);
            $success['name'] = $request->name;
            $success['size'] = $request->size;
            $success['size_unit'] = $request->size_unit;
            $success['farm'] = $plot->farm;
            $success['crop'] = $plot->crop;
            $success['district'] = $plot->district->name;

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Plot created successfully'
             ];

        return response()->json($response,200);

        }
        else{
            $response = [
                'success'=>false,
                'message'=> 'Plot name  or crop on the plot already exits'
             ];

             return response()->json($response,409);

        }




        return $this->sendResponse($plot->toArray(), 'Plot saved successfully');
    }

    /**
     * Display the specified Plot.
     * GET|HEAD /plots/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Plot $plot */
        $plot = Plot::find($id);
        $totalPlotHarvest =  CropHarvest::where('plot_id',$id)->sum('quantity');

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }
        else{
            $success['name'] = $plot->name;
            $success['size'] = $plot->size;
            $success['size_unit'] = $plot->size_unit;
            $success['district'] = $plot->district->name;
            $success['farm'] = $plot->farm;
            $success['crop'] = $plot->crop;
            $success['crop-harvests'] = $plot->crop_harvests;
            $success['total-harvest'] = $totalPlotHarvest;

            $response = [
                'success'=>true,
                'data'=>[
                    'success'=>$success

                ],
                'message'=> 'Plot details retrieved successfully'
             ];

             return response()->json($response,200);
        }


    }

    //get plots for a farm

    public function plots_on_farm($id,Request $request)
    {
        /** @var Plot $plot */
        $farm = Farm::find($id);


        if (empty($farm)) {
            return $this->sendError('Farm not found');
        }
        else{
            $success['plots'] = $farm->plots;


            $response = [
                'success'=>true,
                'data'=>[
                    'success'=>$success

                ],
                'message'=> 'Plots on the farm retrieved successfully'
             ];

             return response()->json($response,200);
        }


    }

    /**
     * Update the specified Plot in storage.
     * PUT/PATCH /plots/{id}
     *
     * @param int $id
     * @param UpdatePlotAPIRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        $input = $request->all();

        /** @var Plot $plot */
        $plot =  Plot::find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }

        $plot = $this->plotRepository->update($input, $id);

        return $this->sendResponse($plot->toArray(), 'Plot updated successfully');
    }

    /**
     * Remove the specified Plot from storage.
     * DELETE /plots/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Plot $plot */
        $plot = $this->plotRepository->find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }

        $plot->delete();

        return $this->sendSuccess('Plot deleted successfully');
    }
}
