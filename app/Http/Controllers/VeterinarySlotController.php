<?php

namespace App\Http\Controllers;

use App\DataTables\VeterinarySlotDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVeterinarySlotRequest;
use App\Http\Requests\UpdateVeterinarySlotRequest;
use App\Repositories\VeterinarySlotRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class VeterinarySlotController extends AppBaseController
{
    /** @var VeterinarySlotRepository $veterinarySlotRepository*/
    private $veterinarySlotRepository;

    public function __construct(VeterinarySlotRepository $veterinarySlotRepo)
    {
        $this->veterinarySlotRepository = $veterinarySlotRepo;
    }

    /**
     * Display a listing of the VeterinarySlot.
     *
     * @param VeterinarySlotDataTable $veterinarySlotDataTable
     *
     * @return Response
     */
    public function index(VeterinarySlotDataTable $veterinarySlotDataTable)
    {
        return $veterinarySlotDataTable->render('veterinary_slots.index');
    }

    /**
     * Show the form for creating a new VeterinarySlot.
     *
     * @return Response
     */
    public function create()
    {
        return view('veterinary_slots.create');
    }

    /**
     * Store a newly created VeterinarySlot in storage.
     *
     * @param CreateVeterinarySlotRequest $request
     *
     * @return Response
     */
    public function store(CreateVeterinarySlotRequest $request)
    {
        $input = $request->all();

        $veterinarySlot = $this->veterinarySlotRepository->create($input);

        Flash::success('Veterinary Slot saved successfully.');

        return redirect(route('veterinarySlots.index'));
    }

    /**
     * Display the specified VeterinarySlot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $veterinarySlot = $this->veterinarySlotRepository->find($id);

        if (empty($veterinarySlot)) {
            Flash::error('Veterinary Slot not found');

            return redirect(route('veterinarySlots.index'));
        }

        return view('veterinary_slots.show')->with('veterinarySlot', $veterinarySlot);
    }

    /**
     * Show the form for editing the specified VeterinarySlot.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $veterinarySlot = $this->veterinarySlotRepository->find($id);

        if (empty($veterinarySlot)) {
            Flash::error('Veterinary Slot not found');

            return redirect(route('veterinarySlots.index'));
        }

        return view('veterinary_slots.edit')->with('veterinarySlot', $veterinarySlot);
    }

    /**
     * Update the specified VeterinarySlot in storage.
     *
     * @param int $id
     * @param UpdateVeterinarySlotRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVeterinarySlotRequest $request)
    {
        $veterinarySlot = $this->veterinarySlotRepository->find($id);

        if (empty($veterinarySlot)) {
            Flash::error('Veterinary Slot not found');

            return redirect(route('veterinarySlots.index'));
        }

        $veterinarySlot = $this->veterinarySlotRepository->update($request->all(), $id);

        Flash::success('Veterinary Slot updated successfully.');

        return redirect(route('veterinarySlots.index'));
    }

    /**
     * Remove the specified VeterinarySlot from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $veterinarySlot = $this->veterinarySlotRepository->find($id);

        if (empty($veterinarySlot)) {
            Flash::error('Veterinary Slot not found');

            return redirect(route('veterinarySlots.index'));
        }

        $this->veterinarySlotRepository->delete($id);

        Flash::success('Veterinary Slot deleted successfully.');

        return redirect(route('veterinarySlots.index'));
    }
}
