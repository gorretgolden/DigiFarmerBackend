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
use App\Models\Address;
use App\Models\User;
//use App\Models\District;

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
        $plots = Plot::with(['farm','crop','crop_harvests','expenses'])->get();
        $response = [
            'success'=>true,
            'data'=> $plots,
            'message'=> 'Plots retrieved successfully'
         ];
         return response()->json($response,200);
    }


    //get animals on plot
    public function animals_on_plot(Request $request,$id)
    {

        $plot = Plot::find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }



        $plot_animals =  $plot->animals->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'total' => $item->total,
                    'animal_category' => $item->animal_category->name,
                    'plot'=> $item->plot->name,
                    'farm'=> $item->plot->farm->name,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });




        if($plot->animals->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'plot has no animals'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-animal-types' =>$plot->animals->count(),
                    'total-plot-animals'=>$plot->animals->sum('total'),
                    'animals'=>$plot_animals,

                ],
                'message'=> 'plot animals retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }


    //get expenses on a plot
    public function expenses_on_plot(Request $request,$id)
    {

        $plot = Plot::find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }

        $plot_expenses =  $plot->expenses->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'amount' => $item->amount,
                    'expense_category' => $item->expense_category->name,
                    'plot'=> $item->plot->name,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });


        if($plot->expenses->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'plot has no expenses'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total' =>$plot->expenses->count(),
                    'total-expense-cost' =>$plot->expenses->sum('amount'),
                    'expenses'=>$plot_expenses,

                ],
                'message'=> 'plot expenses retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }


    public function tasks_on_plot(Request $request,$id)
    {

        $plot = Plot::find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }

        $plot_tasks =  $plot->tasks->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'name' => $item->name,
                    'task_date' => $item->task_date,
                    'status'=>$item->status,
                    'plot'=> $item->plot->name,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });


        if($plot->tasks->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'plot has no tasks'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total' =>$plot->tasks->count(),
                    'tasks'=>$plot_tasks,

                ],
                'message'=> 'plot tasks retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }


    //get plot harvests
    public function crop_harvests_on_plot(Request $request,$id)
    {

        $plot = Plot::find($id);

        if (empty($plot)) {
            return $this->sendError('Plot not found');
        }

        $plot_harvests =  $plot->crop_harvests->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'quantity' => $item->quantity.$item->quantity_unit,
                    'plot'=> $item->plot->name,
                    'created_at' => $item->created_at->format('d/m/Y'),

                  ]);
        });


        if($plot->crop_harvests->count()==0){
            $response = [
                'success'=>false,
                'message'=> 'plot has no crop harvests'
             ];
             return response()->json($response,404);

        }else{

            $response = [
                'success'=>true,
                'data'=>[
                    'total-number-of-harvests' =>$plot->crop_harvests->count(),
                    'total-harvest-amount' =>$plot->crop_harvests->sum('quantity')."kg",
                    'crop_harvests'=>$plot_harvests,

                ],
                'message'=> 'plot crop harvests retrieved successfully '
             ];

             return response()->json($response,200);

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
         $total_plot_sizes =$farm->plots->sum('size');

         $balance = $farm->field_area - $total_plot_sizes;


         if($total_plot_sizes==$farm->field_area){

            $response = [
                'success'=>false,
                'message'=> 'No available space on the farm'
             ];
             return response()->json($response,404);

         }elseif($request->size>$farm->field_area){
            $response = [
                'success'=>false,
                'message'=> 'Plot size cannot be greater than farm size'
             ];

             return response()->json($response,400);

         }elseif(($total_plot_sizes + $request->size) > $farm->field_area){

            $response = [
                'success'=>false,
                'message'=> 'farm is left with'.' '. $balance .' '.'acres'
             ];
             return response()->json($response,400);
         }





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
             $new_plot->district = $farm->address->district_name;
             $new_plot->size = $request->size;
             $new_plot->size_unit ='Acres';
             $new_plot->save();


             $success['name'] = $request->name;
             $success['size'] = $request->size." "."Acres";
             $success['farm'] = $new_plot->farm->name;
             $success['crop'] = $new_plot->crop->name;
             $success['district'] = $farm->address->district_name;

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
            $success['farm'] = $plot->farm->name;
            $success['crop'] = $plot->crop->name;
            $success['created_at'] = $plot->created_at->format('d/m/Y');


            $response = [
                'success'=>true,
                'data'=>$success,
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

    public function farmPlots(Request $request)
    {


        $farms = Farm::where('owner', auth()->user()->username)->with('plots')->get();
        $farm_plots =collect($farms)->pluck('plots')[0];








        $trials = $farm_plots->map(function ($item){
            return collect([
                'id' => $item->id,
                'name' => $item->name,
                'crop' => $item->crop->name,
                'farm' => $item->farm->name,
                'size' => $item->size,
                'size_unit' => $item->size_unit,
                'location' => $item->district,
                'created_at' =>$item->created_at->format('d/m/y')




            ]);
        });


       // dd($trials->toarray());




        $success = $farms;
        if(empty($farms)){
            $response = [
                'success'=>false,
                'message'=> 'farmer has no farms'
             ];


             return response()->json($response,404);


        }elseif($farm_plots == []){
            $response = [
                'success'=>false,
                'message'=> 'no plots exit on the farms'
             ];


             return response()->json($response,404);


        }
        else{




            $response = [
                'success'=>true,
                'data'=> [
                    'total-plots'=>$trials->count(),
                    'plots'=>$trials->toarray()


                ],
                'message'=> 'plots on farms retrieved '
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
