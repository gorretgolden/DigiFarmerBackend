<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVeterinarySheduleAPIRequest;
use App\Http\Requests\API\UpdateVeterinarySheduleAPIRequest;
use App\Models\VeterinaryShedule;
use App\Repositories\VeterinarySheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VeterinarySlot;
use Label84\HoursHelper\Facades\HoursHelper;
/**
 * Class VeterinarySheduleController
 * @package App\Http\Controllers\API
 */

class VeterinarySheduleAPIController extends AppBaseController
{
    /** @var  VeterinarySheduleRepository */
    private $veterinarySheduleRepository;

    public function __construct(VeterinarySheduleRepository $veterinarySheduleRepo)
    {
        $this->veterinarySheduleRepository = $veterinarySheduleRepo;
    }

    /**
     * Display a listing of the VeterinaryShedule.
     * GET|HEAD /veterinaryShedules
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $veterinaryShedules = $this->veterinarySheduleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($veterinaryShedules->toArray(), 'Veterinary Shedules retrieved successfully');
    }

    /**
     * Store a newly created VeterinaryShedule in storage.
     * POST /veterinaryShedules
     *
     * @param CreateVeterinarySheduleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVeterinarySheduleAPIRequest $request)
    {
        $input = $request->all();
        $trimed_start =$request->starting_time;
        $trimed_end =$request->ending_time;
        $slots = [];

        $hours = HoursHelper::create(trim($trimed_start,' AM'),trim($trimed_end,' PM'),$request->time_interval, 'g:i A');
        $slots = $hours;
        $existing_schedule = VeterinaryShedule::where('date',$request->date)->where('veterinary_id',$request->veterinary_id)->first();


        if($existing_schedule){

            $response = [
                'success'=>false,

                'message'=> 'Veterinary date schedule for this service exists'
             ];

             return response()->json($response,200);


        }
        else{


            $schedule = VeterinaryShedule::create([
                'veterinary_id' => $request->veterinary_id,
                'date' => $request->date,
                'starting_time'=>$request->starting_time,
                'ending_time'=>$request->ending_time,
                'time_interval'=>$request->time_interval
            ]);


            foreach ($slots as $slot) {
                VeterinarySlot::create([
                    'veterinary_shedule_id' => $schedule->id,
                    'time' => $slot


                ]);
            }


            $response = [
                'success'=>true,
                'data'=> $schedule,
                'message'=> 'Veterinary Shedule saved successfully'
             ];

             return response()->json($response,200);
            }


    }

    /**
     * Display the specified VeterinaryShedule.
     * GET|HEAD /veterinaryShedules/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VeterinaryShedule $veterinaryShedule */
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            return $this->sendError('Veterinary Shedule not found');
        }

        return $this->sendResponse($veterinaryShedule->toArray(), 'Veterinary Shedule retrieved successfully');
    }


     //slots
     public function schedule_slots($id)
     {


        /** @var VeterinaryShedule $veterinaryShedule */
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            return $this->sendError('Veterinary Shedule not found');
        }else{


             $slots =  $veterinaryShedule->slots->map(function ($item){
                 return collect([
                     'id' => $item->id,
                     'time' => $item->time,
                     'status' => $item->status,

                   ]);
             });
             $response = [
                 'success'=>true,
                 'data'=>[
                     'total-slots' =>$veterinaryShedule->slots->count(),
                     'slots'=>$slots,

                 ],
                 'message'=> 'veterinary slots retrieved successfully '
              ];

              return response()->json($response,200);

         }


     }
    /**
     * Update the specified VeterinaryShedule in storage.
     * PUT/PATCH /veterinaryShedules/{id}
     *
     * @param int $id
     * @param UpdateVeterinarySheduleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVeterinarySheduleAPIRequest $request)
    {
        $input = $request->all();

        /** @var VeterinaryShedule $veterinaryShedule */
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            return $this->sendError('Veterinary Shedule not found');
        }

        $veterinaryShedule = $this->veterinarySheduleRepository->update($input, $id);

        return $this->sendResponse($veterinaryShedule->toArray(), 'VeterinaryShedule updated successfully');
    }

    /**
     * Remove the specified VeterinaryShedule from storage.
     * DELETE /veterinaryShedules/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VeterinaryShedule $veterinaryShedule */
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            return $this->sendError('Veterinary Shedule not found');
        }

        $veterinaryShedule->delete();

        return $this->sendSuccess('Veterinary Shedule deleted successfully');
    }
}
