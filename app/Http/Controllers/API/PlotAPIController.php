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
use App\Models\User;

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

   //get farm farmer plots
    public function farmPlots(Request $request)
    {
        $farm_plots = [];//farm plots

        $farmer = User::where('id', auth()->user()->id)->first();
        //dd($user_farms->count());


        if($farmer->farms->count()== 0){

            //dd('Farmer has no farms');
            $response = [
                'success'=>false,
                'data'=> $success,
                'message'=> 'Farmer has no farms'
             ];

             return response()->json($response,404);

        }else{

             foreach ($farmer->farms as $farm){

                if($farm->plots->count() == 0){

                   //dd('No plots exit on this farm');
                    $response = [
                        'success'=>false,
                        'data'=> $success,
                        'message'=> 'No plots exit on this farm'
                     ];

                     return response()->json($response,404);


                }else{
                    $data = collect($farm->plots);

                    $farm_plots = $data;

                   $response = [
                    'success'=>true,
                    'data'=> [
                        'total-plots'=>$farm_plots->count(),
                        'farm-plots'=>$farm_plots,
                        'farmer'=>$farmer,


                    ],
                    'message'=> 'Farm plots retrieved successfully'
                 ];

                 return response()->json($response,200);
                }

            }
        }
    }
    /**
     * Store a newly created Plot in storage.
     * POST /plots
     *
     * @param CreatePlotAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePlotAPIRequest $request)
    {
         //get the farm
         $farm = Farm::where('id',$request->farm_id)->first();

         if(!$farm){

            $response = [
                'success'=>false,
                'message'=> 'No farm selected'
             ];

             return response()->json($response,400);

         }elseif(collect($farm->plots)->contains('name',$request->name)){


             $response = [
                'success'=>false,
                'message'=> 'Plot with this name already exits on the farm'
             ];

             return response()->json($response,409);

         }elseif(collect($farm->plots)->contains('crop_id',$request->crop_id)){

            $response = [
                'success'=>false,
                'message'=> 'Crop selected already exists on a plot'
             ];

             return response()->json($response,409);

         }else{

             $new_plot = new Plot();
             $new_plot->name = $request->name;
             $new_plot->farm_id = $request->farm_id;
             $new_plot->crop_id = $request->crop_id;
             $new_plot->district = $farm->address;
             $new_plot->size = $request->size;
             $new_plot->size_unit = $request->size_unit;
             $new_plot->save();


             $success['name'] = $request->name;
             $success['size'] = $request->size;
             $success['size_unit'] = $request->size_unit;
             $success['farm'] = $new_plot->farm;
             $success['crop'] = $new_plot->crop;
             $success['district'] = $farm->address;

             $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Plot created successfully'
              ];

            return response()->json($response,200);



         }


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
            $success['district'] = $plot->district;
            $success['farm'] = $plot->farm;
            $success['crop'] = $plot->crop;
            $success['animals'] = $plot->animals;
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
