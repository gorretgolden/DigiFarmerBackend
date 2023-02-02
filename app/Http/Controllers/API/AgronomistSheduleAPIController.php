<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAgronomistSheduleAPIRequest;
use App\Http\Requests\API\UpdateAgronomistSheduleAPIRequest;
use App\Models\AgronomistShedule;
use App\Repositories\AgronomistSheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\AgronomistSlot;
use Label84\HoursHelper\Facades\HoursHelper;


/**
 * Class AgronomistSheduleController
 * @package App\Http\Controllers\API
 */

class AgronomistSheduleAPIController extends AppBaseController
{
    /** @var  AgronomistSheduleRepository */
    private $agronomistSheduleRepository;

    public function __construct(AgronomistSheduleRepository $agronomistSheduleRepo)
    {
        $this->agronomistSheduleRepository = $agronomistSheduleRepo;
    }

    /**
     * Display a listing of the AgronomistShedule.
     * GET|HEAD /agronomistShedules
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistShedules = $this->agronomistSheduleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($agronomistShedules->toArray(), 'Agronomist Shedules retrieved successfully');
    }

    /**
     * Store a newly created AgronomistShedule in storage.
     * POST /agronomistShedules
     *
     * @param CreateAgronomistSheduleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAgronomistSheduleAPIRequest $request)
    {
        $input = $request->all();
        $trimed_start =$request->starting_time;
        $trimed_end =$request->ending_time;
        $slots = [];


        $hours = HoursHelper::create(trim($trimed_start,' AM'),trim($trimed_end,' PM'),$request->time_interval, 'g:i A');
        $slots = $hours;
     //   dd($slots);
        $existing_schedule = AgronomistShedule::where('date',$request->date)->where('agronomist_id',$request->agronomist_id)->first();


        if($existing_schedule){

            $response = [
                'success'=>false,

                'message'=> 'Agronomist date schedule for this service exists'
             ];

             return response()->json($response,200);


        }
        else{


            $schedule = AgronomistShedule::create([
                'agronomist_id' => $request->agronomist_id,
                'date' => $request->date,
                'starting_time'=>$request->starting_time,
                'ending_time'=>$request->ending_time,
                'time_interval'=>$request->time_interval
            ]);


            foreach ($slots as $slot) {
                AgronomistSlot::create([
                    'agronomist_shedule_id' => $schedule->id,
                    'time' => $slot


                ]);
            }


            $response = [
                'success'=>true,
                'data'=> $schedule,
                'message'=> 'Agronomist Shedule saved successfully'
             ];

             return response()->json($response,200);
            }


    }

    /**
     * Display the specified AgronomistShedule.
     * GET|HEAD /agronomistShedules/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AgronomistShedule $agronomistShedule */
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            return $this->sendError('Agronomist Shedule not found');
        }

        return $this->sendResponse($agronomistShedule->toArray(), 'Agronomist Shedule retrieved successfully');
    }

    //slots
    public function schedule_slots($id)
    {
        /** @var AgronomistShedule $agronomistShedule */
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            return $this->sendError('Agronomist Shedule not found');
        }else{


            $slots =  $agronomistShedule->slots->map(function ($item){
                return collect([
                    'id' => $item->id,
                    'time' => $item->time,
                    'status' => $item->status,

                  ]);
            });
            $response = [
                'success'=>true,
                'data'=>[
                    'total-slots' =>$agronomistShedule->slots->count(),
                    'slots'=>$slots,

                ],
                'message'=> 'agronomist slots retrieved successfully '
             ];

             return response()->json($response,200);

        }


    }

    /**
     * Update the specified AgronomistShedule in storage.
     * PUT/PATCH /agronomistShedules/{id}
     *
     * @param int $id
     * @param UpdateAgronomistSheduleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgronomistSheduleAPIRequest $request)
    {
        $input = $request->all();

        /** @var AgronomistShedule $agronomistShedule */
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            return $this->sendError('Agronomist Shedule not found');
        }

        $agronomistShedule = $this->agronomistSheduleRepository->update($input, $id);

        return $this->sendResponse($agronomistShedule->toArray(), 'AgronomistShedule updated successfully');
    }

    /**
     * Remove the specified AgronomistShedule from storage.
     * DELETE /agronomistShedules/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AgronomistShedule $agronomistShedule */
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            return $this->sendError('Agronomist Shedule not found');
        }

        $agronomistShedule->delete();

        return $this->sendSuccess('Agronomist Shedule deleted successfully');
    }
}
