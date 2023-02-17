<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanPlanAPIRequest;
use App\Http\Requests\API\UpdateLoanPlanAPIRequest;
use App\Models\LoanPlan;
use App\Repositories\LoanPlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LoanPlanController
 * @package App\Http\Controllers\API
 */

class LoanPlanAPIController extends AppBaseController
{
    /** @var  LoanPlanRepository */
    private $loanPlanRepository;

    public function __construct(LoanPlanRepository $loanPlanRepo)
    {
        $this->loanPlanRepository = $loanPlanRepo;
    }

    /**
     * Display a listing of the LoanPlan.
     * GET|HEAD /loanPlans
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $loanPlans = LoanPlan::orderBy('value','ASC')->get(['id','value','period_unit']);
        return $this->sendResponse($loanPlans->toArray(), 'Loan Plans retrieved successfully');
    }

    /**
     * Store a newly created LoanPlan in storage.
     * POST /loanPlans
     *
     * @param CreateLoanPlanAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanPlanAPIRequest $request)
    {
        $input = $request->all();

        $loanPlan = $this->loanPlanRepository->create($input);

        return $this->sendResponse($loanPlan->toArray(), 'Loan Plan saved successfully');
    }

    /**
     * Display the specified LoanPlan.
     * GET|HEAD /loanPlans/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LoanPlan $loanPlan */
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            return $this->sendError('Loan Plan not found');
        }

        return $this->sendResponse($loanPlan->toArray(), 'Loan Plan retrieved successfully');
    }

    /**
     * Update the specified LoanPlan in storage.
     * PUT/PATCH /loanPlans/{id}
     *
     * @param int $id
     * @param UpdateLoanPlanAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanPlanAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanPlan $loanPlan */
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            return $this->sendError('Loan Plan not found');
        }

        $loanPlan = $this->loanPlanRepository->update($input, $id);

        return $this->sendResponse($loanPlan->toArray(), 'LoanPlan updated successfully');
    }

    /**
     * Remove the specified LoanPlan from storage.
     * DELETE /loanPlans/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LoanPlan $loanPlan */
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            return $this->sendError('Loan Plan not found');
        }

        $loanPlan->delete();

        return $this->sendSuccess('Loan Plan deleted successfully');
    }
}
