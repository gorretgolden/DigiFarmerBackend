<?php

namespace App\Http\Controllers;

use App\DataTables\CommissionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;
use App\Repositories\CommissionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CommissionController extends AppBaseController
{
    /** @var CommissionRepository $commissionRepository*/
    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepo)
    {
        $this->commissionRepository = $commissionRepo;
    }

    /**
     * Display a listing of the Commission.
     *
     * @param CommissionDataTable $commissionDataTable
     *
     * @return Response
     */
    public function index(CommissionDataTable $commissionDataTable)
    {
        return $commissionDataTable->render('commissions.index');
    }

    /**
     * Show the form for creating a new Commission.
     *
     * @return Response
     */
    public function create()
    {
        return view('commissions.create');
    }

    /**
     * Store a newly created Commission in storage.
     *
     * @param CreateCommissionRequest $request
     *
     * @return Response
     */
    public function store(CreateCommissionRequest $request)
    {
        $input = $request->all();
        $input['unit'] = '%';

        $commission = $this->commissionRepository->create($input);

        Flash::success('Commission saved successfully.');

        return redirect(route('commissions.index'));
    }

    /**
     * Display the specified Commission.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            Flash::error('Commission not found');

            return redirect(route('commissions.index'));
        }

        return view('commissions.show')->with('commission', $commission);
    }

    /**
     * Show the form for editing the specified Commission.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            Flash::error('Commission not found');

            return redirect(route('commissions.index'));
        }

        return view('commissions.edit')->with('commission', $commission);
    }

    /**
     * Update the specified Commission in storage.
     *
     * @param int $id
     * @param UpdateCommissionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCommissionRequest $request)
    {
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            Flash::error('Commission not found');

            return redirect(route('commissions.index'));
        }

        $commission = $this->commissionRepository->update($request->all(), $id);

        Flash::success('Commission updated successfully.');

        return redirect(route('commissions.index'));
    }

    /**
     * Remove the specified Commission from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $commission = $this->commissionRepository->find($id);

        if (empty($commission)) {
            Flash::error('Commission not found');

            return redirect(route('commissions.index'));
        }

        $this->commissionRepository->delete($id);

        Flash::success('Commission deleted successfully.');

        return redirect(route('commissions.index'));
    }
}
