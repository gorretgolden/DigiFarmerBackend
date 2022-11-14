<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlotAPIRequest;
use App\Http\Requests\API\UpdatePlotAPIRequest;
use App\Models\Plot;
use App\Repositories\PlotRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

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
        $plots = $this->plotRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($plots->toArray(), 'Plots retrieved successfully');
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
        $existing_plot = Plot::where('name',$request->name)->orWhere('crop_id',$request->crop_id)->first();
        if(!$existing_plot){
            $plot = $this->plotRepository->create($input);
            $success['name'] = $request->name;
            $success['size'] = $request->size;
            $success['size_unit'] = $request->size_unit;
            $success['farm'] = $plot->farm;
            $success['crop'] = $plot->crop;

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Plot created successfully'
             ];

        return response()->json($response,200);

        }
        else{
            $response = [
                'success'=>true,
                'message'=> 'Plot name  or crop on the plot already exits'
             ];

             return response()->json($response,401);

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

            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Plot details retrieved successfully'
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
    public function update($id, UpdatePlotAPIRequest $request)
    {
        $input = $request->all();

        /** @var Plot $plot */
        $plot = $this->plotRepository->find($id);

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
