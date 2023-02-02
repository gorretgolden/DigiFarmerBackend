<?php

namespace App\Http\Controllers;

use App\DataTables\AgronomistSheduleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAgronomistSheduleRequest;
use App\Http\Requests\UpdateAgronomistSheduleRequest;
use App\Repositories\AgronomistSheduleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\AgronomistShedule;
use App\Models\AgronomistSlot;
use Label84\HoursHelper\Facades\HoursHelper;

class AgronomistSheduleController extends AppBaseController
{
    /** @var AgronomistSheduleRepository $agronomistSheduleRepository*/
    private $agronomistSheduleRepository;

    public function __construct(AgronomistSheduleRepository $agronomistSheduleRepo)
    {
        $this->agronomistSheduleRepository = $agronomistSheduleRepo;
    }

    /**
     * Display a listing of the AgronomistShedule.
     *
     * @param AgronomistSheduleDataTable $agronomistSheduleDataTable
     *
     * @return Response
     */
    public function index(AgronomistSheduleDataTable $agronomistSheduleDataTable)
    {
        return $agronomistSheduleDataTable->render('agronomist_shedules.index');
    }

    /**
     * Show the form for creating a new AgronomistShedule.
     *
     * @return Response
     */
    public function create()
    {
        return view('agronomist_shedules.create');
    }

    /**
     * Store a newly created AgronomistShedule in storage.
     *
     * @param CreateAgronomistSheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateAgronomistSheduleRequest $request)
    {

        $input = $request->all();
        //dd($request->all());
        $trimed_start =$request->starting_time;
        $trimed_end =$request->ending_time;
        $slots = [];


        $hours = HoursHelper::create(trim($trimed_start,' AM'),trim($trimed_end,' PM'),$request->time_interval, 'g:i A');
        $slots = $hours;
     //   dd($slots);
        $existing_schedule = AgronomistShedule::where('date',$request->date)->where('agronomist_id',$request->agronomist_id)->first();


        if($existing_schedule){
            Flash::error('Agronomist date schedule for this service exists.');


            return redirect(route('agronomistShedules.index'));


        }
        else{



            $appointment = AgronomistShedule::create([
                'agronomist_id' => $request->agronomist_id,
                'date' => $request->date,
                'starting_time'=>$request->starting_time,
                'ending_time'=>$request->ending_time,
                'time_interval'=>$request->time_interval
            ]);


            foreach ($slots as $slot) {
                AgronomistSlot::create([
                    'agronomist_shedule_id' => $appointment->id,
                    'time' => $slot


                ]);
            }


            Flash::success('Agronomist Schedule saved successfully.');


            return redirect(route('agronomistShedules.index'));


        }



    }

    /**
     * Display the specified AgronomistShedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            Flash::error('Agronomist Shedule not found');

            return redirect(route('agronomistShedules.index'));
        }

        return view('agronomist_shedules.show')->with('agronomistShedule', $agronomistShedule);
    }

    /**
     * Show the form for editing the specified AgronomistShedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            Flash::error('Agronomist Shedule not found');

            return redirect(route('agronomistShedules.index'));
        }

        return view('agronomist_shedules.edit')->with('agronomistShedule', $agronomistShedule);
    }

    /**
     * Update the specified AgronomistShedule in storage.
     *
     * @param int $id
     * @param UpdateAgronomistSheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgronomistSheduleRequest $request)
    {
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            Flash::error('Agronomist Shedule not found');

            return redirect(route('agronomistShedules.index'));
        }

        $agronomistShedule = $this->agronomistSheduleRepository->update($request->all(), $id);

        Flash::success('Agronomist Shedule updated successfully.');

        return redirect(route('agronomistShedules.index'));
    }

    /**
     * Remove the specified AgronomistShedule from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agronomistShedule = $this->agronomistSheduleRepository->find($id);

        if (empty($agronomistShedule)) {
            Flash::error('Agronomist Shedule not found');

            return redirect(route('agronomistShedules.index'));
        }

        $this->agronomistSheduleRepository->delete($id);

        Flash::success('Agronomist Shedule deleted successfully.');

        return redirect(route('agronomistShedules.index'));
    }
}
