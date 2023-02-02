<?php

namespace App\Http\Controllers;

use App\DataTables\VeterinarySheduleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVeterinarySheduleRequest;
use App\Http\Requests\UpdateVeterinarySheduleRequest;
use App\Repositories\VeterinarySheduleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VeterinaryShedule;
use App\Models\VeterinarySlot;
use Label84\HoursHelper\Facades\HoursHelper;

class VeterinarySheduleController extends AppBaseController
{
    /** @var VeterinarySheduleRepository $veterinarySheduleRepository*/
    private $veterinarySheduleRepository;

    public function __construct(VeterinarySheduleRepository $veterinarySheduleRepo)
    {
        $this->veterinarySheduleRepository = $veterinarySheduleRepo;
    }

    /**
     * Display a listing of the VeterinaryShedule.
     *
     * @param VeterinarySheduleDataTable $veterinarySheduleDataTable
     *
     * @return Response
     */
    public function index(VeterinarySheduleDataTable $veterinarySheduleDataTable)
    {
        return $veterinarySheduleDataTable->render('veterinary_shedules.index');
    }

    /**
     * Show the form for creating a new VeterinaryShedule.
     *
     * @return Response
     */
    public function create()
    {
        return view('veterinary_shedules.create');
    }

    /**
     * Store a newly created VeterinaryShedule in storage.
     *
     * @param CreateVeterinarySheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateVeterinarySheduleRequest $request)
    {
        $input = $request->all();
        //dd($request->all());
        $trimed_start =$request->starting_time;
        $trimed_end =$request->ending_time;
        $slots = [];

        $hours = HoursHelper::create(trim($trimed_start,' AM'),trim($trimed_end,' PM'),$request->time_interval, 'g:i A');
        $slots = $hours;
     //   dd($slots);
        $existing_schedule = VeterinaryShedule::where('date',$request->date)->where('veterinary_id',$request->veterinary_id)->first();


        if($existing_schedule){
            Flash::error('Veterinary day schedule for this service exists.');

            return redirect(route('veterinaryShedules.index'));

        }
        else{

            $appointment = VeterinaryShedule::create([
                'veterinary_id' => $request->veterinary_id,
                'date' => $request->date,
                'starting_time'=>$request->starting_time,
                'ending_time'=>$request->ending_time,
                'time_interval'=>$request->time_interval
            ]);


            foreach ($slots as $slot) {
                VeterinarySlot::create([
                    'veterinary_shedule_id' => $appointment->id,
                    'time' => $slot


                ]);
            }

            Flash::success('Veterinary Shedule saved successfully.');

            return redirect(route('veterinaryShedules.index'));


        }



    }

    /**
     * Display the specified VeterinaryShedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            Flash::error('Veterinary Shedule not found');

            return redirect(route('veterinaryShedules.index'));
        }

        return view('veterinary_shedules.show')->with('veterinaryShedule', $veterinaryShedule);
    }

    /**
     * Show the form for editing the specified VeterinaryShedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            Flash::error('Veterinary Shedule not found');

            return redirect(route('veterinaryShedules.index'));
        }

        return view('veterinary_shedules.edit')->with('veterinaryShedule', $veterinaryShedule);
    }

    /**
     * Update the specified VeterinaryShedule in storage.
     *
     * @param int $id
     * @param UpdateVeterinarySheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVeterinarySheduleRequest $request)
    {
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            Flash::error('Veterinary Shedule not found');

            return redirect(route('veterinaryShedules.index'));
        }

        $veterinaryShedule = $this->veterinarySheduleRepository->update($request->all(), $id);

        Flash::success('Veterinary Shedule updated successfully.');

        return redirect(route('veterinaryShedules.index'));
    }

    /**
     * Remove the specified VeterinaryShedule from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $veterinaryShedule = $this->veterinarySheduleRepository->find($id);

        if (empty($veterinaryShedule)) {
            Flash::error('Veterinary Shedule not found');

            return redirect(route('veterinaryShedules.index'));
        }

        $this->veterinarySheduleRepository->delete($id);

        Flash::success('Veterinary Shedule deleted successfully.');

        return redirect(route('veterinaryShedules.index'));
    }
}
