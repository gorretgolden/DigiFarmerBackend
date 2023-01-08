<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgronomistSlotRequest;
use App\Http\Requests\UpdateAgronomistSlotRequest;
use App\Repositories\AgronomistSlotRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AgronomistSlotController extends AppBaseController
{
    /** @var AgronomistSlotRepository $agronomistSlotRepository*/
    private $agronomistSlotRepository;

    public function __construct(AgronomistSlotRepository $agronomistSlotRepo)
    {
        $this->agronomistSlotRepository = $agronomistSlotRepo;
    }

    /**
     * Display a listing of the AgronomistSlot.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $agronomistSlots = $this->agronomistSlotRepository->all();

        return view('agronomist_slots.index')
            ->with('agronomistSlots', $agronomistSlots);
    }

    /**
     * Show the form for creating a new AgronomistSlot.
     *
     * @return Response
     */
    public function create()
    {
        return view('agronomist_slots.create');
    }

    /**
     * Store a newly created AgronomistSlot in storage.
     *
     * @param CreateAgronomistSlotRequest $request
     *
     * @return Response
     */
    public function store(CreateAgronomistSlotRequest $request)
    {
        $input = $request->all();

        $agronomistSlot = $this->agronomistSlotRepository->create($input);

        Flash::success('Agronomist Slot saved successfully.');

        return redirect(route('agronomistSlots.index'));
    }

    /**
     * Display the specified AgronomistSlot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agronomistSlot = $this->agronomistSlotRepository->find($id);

        if (empty($agronomistSlot)) {
            Flash::error('Agronomist Slot not found');

            return redirect(route('agronomistSlots.index'));
        }

        return view('agronomist_slots.show')->with('agronomistSlot', $agronomistSlot);
    }

    /**
     * Show the form for editing the specified AgronomistSlot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agronomistSlot = $this->agronomistSlotRepository->find($id);

        if (empty($agronomistSlot)) {
            Flash::error('Agronomist Slot not found');

            return redirect(route('agronomistSlots.index'));
        }

        return view('agronomist_slots.edit')->with('agronomistSlot', $agronomistSlot);
    }

    /**
     * Update the specified AgronomistSlot in storage.
     *
     * @param int $id
     * @param UpdateAgronomistSlotRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgronomistSlotRequest $request)
    {
        $agronomistSlot = $this->agronomistSlotRepository->find($id);

        if (empty($agronomistSlot)) {
            Flash::error('Agronomist Slot not found');

            return redirect(route('agronomistSlots.index'));
        }

        $agronomistSlot = $this->agronomistSlotRepository->update($request->all(), $id);

        Flash::success('Agronomist Slot updated successfully.');

        return redirect(route('agronomistSlots.index'));
    }

    /**
     * Remove the specified AgronomistSlot from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agronomistSlot = $this->agronomistSlotRepository->find($id);

        if (empty($agronomistSlot)) {
            Flash::error('Agronomist Slot not found');

            return redirect(route('agronomistSlots.index'));
        }

        $this->agronomistSlotRepository->delete($id);

        Flash::success('Agronomist Slot deleted successfully.');

        return redirect(route('agronomistSlots.index'));
    }
}
