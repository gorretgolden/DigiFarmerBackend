<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgronomistSheduleRequest;
use App\Http\Requests\UpdateAgronomistSheduleRequest;
use App\Repositories\AgronomistSheduleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\AgronomistShedule;
use App\Models\AgronomistSlot;


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
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistShedules = $this->agronomistSheduleRepository->all();

        return view('agronomist_shedules.index')
            ->with('agronomistShedules', $agronomistShedules);
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
        //dd($input);

        $existing_schedule = AgronomistShedule::where('day_id',$request->day_id)->where('agronomist_vendor_service_id',$request->agronomist_vendor_service_id)->first();

        if($existing_schedule){
            Flash::error('Agronomist day schedule for this service exists.');

            return redirect(route('agronomistShedules.index'));

        }
        else{

            $appointment = AgronomistShedule::create([
                'agronomist_vendor_service_id' => $request->agronomist_vendor_service_id,
                'day_id' => $request->day_id
            ]);

            foreach ($request->time as $time) {
                AgronomistSlot::create([
                    'agronomist_shedule_id' => $appointment->id,
                    'time' => $time

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
     * @throws \Exception
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
