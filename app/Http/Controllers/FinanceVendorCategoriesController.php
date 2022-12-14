<?php

namespace App\Http\Controllers;

use App\DataTables\FinanceVendorCategoriesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFinanceVendorCategoriesRequest;
use App\Http\Requests\UpdateFinanceVendorCategoriesRequest;
use App\Repositories\FinanceVendorCategoriesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FinanceVendorCategoriesController extends AppBaseController
{
    /** @var FinanceVendorCategoriesRepository $financeVendorCategoriesRepository*/
    private $financeVendorCategoriesRepository;

    public function __construct(FinanceVendorCategoriesRepository $financeVendorCategoriesRepo)
    {
        $this->financeVendorCategoriesRepository = $financeVendorCategoriesRepo;
    }

    /**
     * Display a listing of the FinanceVendorCategories.
     *
     * @param FinanceVendorCategoriesDataTable $financeVendorCategoriesDataTable
     *
     * @return Response
     */
    public function index(FinanceVendorCategoriesDataTable $financeVendorCategoriesDataTable)
    {
        return $financeVendorCategoriesDataTable->render('finance_vendor_categories.index');
    }

    /**
     * Show the form for creating a new FinanceVendorCategories.
     *
     * @return Response
     */
    public function create()
    {
        return view('finance_vendor_categories.create');
    }

    /**
     * Store a newly created FinanceVendorCategories in storage.
     *
     * @param CreateFinanceVendorCategoriesRequest $request
     *
     * @return Response
     */
    public function store(CreateFinanceVendorCategoriesRequest $request)
    {
        $input = $request->all();

        $financeVendorCategories = $this->financeVendorCategoriesRepository->create($input);

        Flash::success('Finance Vendor Categories saved successfully.');

        return redirect(route('financeVendorCategories.index'));
    }

    /**
     * Display the specified FinanceVendorCategories.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            Flash::error('Finance Vendor Categories not found');

            return redirect(route('financeVendorCategories.index'));
        }

        return view('finance_vendor_categories.show')->with('financeVendorCategories', $financeVendorCategories);
    }

    /**
     * Show the form for editing the specified FinanceVendorCategories.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            Flash::error('Finance Vendor Categories not found');

            return redirect(route('financeVendorCategories.index'));
        }

        return view('finance_vendor_categories.edit')->with('financeVendorCategories', $financeVendorCategories);
    }

    /**
     * Update the specified FinanceVendorCategories in storage.
     *
     * @param int $id
     * @param UpdateFinanceVendorCategoriesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinanceVendorCategoriesRequest $request)
    {
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            Flash::error('Finance Vendor Categories not found');

            return redirect(route('financeVendorCategories.index'));
        }

        $financeVendorCategories = $this->financeVendorCategoriesRepository->update($request->all(), $id);

        Flash::success('Finance Vendor Categories updated successfully.');

        return redirect(route('financeVendorCategories.index'));
    }

    /**
     * Remove the specified FinanceVendorCategories from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $financeVendorCategories = $this->financeVendorCategoriesRepository->find($id);

        if (empty($financeVendorCategories)) {
            Flash::error('Finance Vendor Categories not found');

            return redirect(route('financeVendorCategories.index'));
        }

        $this->financeVendorCategoriesRepository->delete($id);

        Flash::success('Finance Vendor Categories deleted successfully.');

        return redirect(route('financeVendorCategories.index'));
    }
}
