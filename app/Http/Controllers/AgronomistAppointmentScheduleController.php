<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgronomistAppointmentScheduleRequest;
use App\Http\Requests\UpdateAgronomistAppointmentScheduleRequest;
use App\Repositories\AgronomistAppointmentScheduleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AgronomistAppointmentScheduleController extends AppBaseController
{
    /** @var AgronomistAppointmentScheduleRepository $agronomistAppointmentScheduleRepository*/
    private $agronomistAppointmentScheduleRepository;

    public function __construct(AgronomistAppointmentScheduleRepository $agronomistAppointmentScheduleRepo)
    {
        $this->agronomistAppointmentScheduleRepository = $agronomistAppointmentScheduleRepo;
    }

    /**
     * Display a listing of the AgronomistAppointmentSchedule.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistAppointmentSchedules = $this->agronomistAppointmentScheduleRepository->all();

        return view('agronomist_appointment_schedules.index')
            ->with('agronomistAppointmentSchedules', $agronomistAppointmentSchedules);
    }

    /**
     * Show the form for creating a new AgronomistAppointmentSchedule.
     *
     * @return Response
     */
    public function create()
    {
        return view('agronomist_appointment_schedules.create');
    }

    /**
     * Store a newly created AgronomistAppointmentSchedule in storage.
     *
     * @param CreateAgronomistAppointmentScheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateAgronomistAppointmentScheduleRequest $request)
    {
        $input = $request->all();

        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->create($input);

        Flash::success('Agronomist Appointment Schedule saved successfully.');

        return redirect(route('agronomistAppointmentSchedules.index'));
    }

    /**
     * Display the specified AgronomistAppointmentSchedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->find($id);

        if (empty($agronomistAppointmentSchedule)) {
            Flash::error('Agronomist Appointment Schedule not found');

            return redirect(route('agronomistAppointmentSchedules.index'));
        }

        return view('agronomist_appointment_schedules.show')->with('agronomistAppointmentSchedule', $agronomistAppointmentSchedule);
    }

    /**
     * Show the form for editing the specified AgronomistAppointmentSchedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->find($id);

        if (empty($agronomistAppointmentSchedule)) {
            Flash::error('Agronomist Appointment Schedule not found');

            return redirect(route('agronomistAppointmentSchedules.index'));
        }

        return view('agronomist_appointment_schedules.edit')->with('agronomistAppointmentSchedule', $agronomistAppointmentSchedule);
    }

    /**
     * Update the specified AgronomistAppointmentSchedule in storage.
     *
     * @param int $id
     * @param UpdateAgronomistAppointmentScheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgronomistAppointmentScheduleRequest $request)
    {
        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->find($id);

        if (empty($agronomistAppointmentSchedule)) {
            Flash::error('Agronomist Appointment Schedule not found');

            return redirect(route('agronomistAppointmentSchedules.index'));
        }

        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->update($request->all(), $id);

        Flash::success('Agronomist Appointment Schedule updated successfully.');

        return redirect(route('agronomistAppointmentSchedules.index'));
    }

    /**
     * Remove the specified AgronomistAppointmentSchedule from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agronomistAppointmentSchedule = $this->agronomistAppointmentScheduleRepository->find($id);

        if (empty($agronomistAppointmentSchedule)) {
            Flash::error('Agronomist Appointment Schedule not found');

            return redirect(route('agronomistAppointmentSchedules.index'));
        }

        $this->agronomistAppointmentScheduleRepository->delete($id);

        Flash::success('Agronomist Appointment Schedule deleted successfully.');

        return redirect(route('agronomistAppointmentSchedules.index'));
    }
}
