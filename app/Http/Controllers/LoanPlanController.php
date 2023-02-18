<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanPlanRequest;
use App\Http\Requests\UpdateLoanPlanRequest;
use App\Repositories\LoanPlanRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\LoanPlan;

class LoanPlanController extends AppBaseController
{
    /** @var LoanPlanRepository $loanPlanRepository*/
    private $loanPlanRepository;

    public function __construct(LoanPlanRepository $loanPlanRepo)
    {
        $this->loanPlanRepository = $loanPlanRepo;
    }

    /**
     * Display a listing of the LoanPlan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanPlans = LoanPlan::orderBy('value','ASC')->get();

        return view('loan_plans.index')
            ->with('loanPlans', $loanPlans);
    }

    /**
     * Show the form for creating a new LoanPlan.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_plans.create');
    }

    /**
     * Store a newly created LoanPlan in storage.
     *
     * @param CreateLoanPlanRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanPlanRequest $request)
    {


        //if existing value
        $existing_value = LoanPlan::where('value',$request->value)->first();

        if($existing_value){

            Flash::error('Loan Plan already exists');

            return redirect(route('loanPlans.index'));

        }else{

            if($request->value == 1){
                $new_plan = new LoanPlan();
                $new_plan->value = $request->value;
                $new_plan->period_unit = 'Month';
                $new_plan->save();
                Flash::success('Loan Plan saved successfully.');

                return redirect(route('loanPlans.index'));

            }else{
                $new_plan = new LoanPlan();
                $new_plan->value = $request->value;
                $new_plan->period_unit = 'Months';
                $new_plan->save();
                Flash::success('Loan Plan saved successfully.');

                return redirect(route('loanPlans.index'));

            }
        }





    }

    /**
     * Display the specified LoanPlan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            Flash::error('Loan Plan not found');

            return redirect(route('loanPlans.index'));
        }

        return view('loan_plans.show')->with('loanPlan', $loanPlan);
    }



     * Show the form for editing the specified LoanPlan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            Flash::error('Loan Plan not found');

            return redirect(route('loanPlans.index'));
        }

        return view('loan_plans.edit')->with('loanPlan', $loanPlan);
    }

    /**
     * Update the specified LoanPlan in storage.
     *
     * @param int $id
     * @param UpdateLoanPlanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanPlanRequest $request)
    {
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            Flash::error('Loan Plan not found');

            return redirect(route('loanPlans.index'));
        }

        $loanPlan = $this->loanPlanRepository->update($request->all(), $id);

        Flash::success('Loan Plan updated successfully.');

        return redirect(route('loanPlans.index'));
    }

    /**
     * Remove the specified LoanPlan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanPlan = $this->loanPlanRepository->find($id);

        if (empty($loanPlan)) {
            Flash::error('Loan Plan not found');

            return redirect(route('loanPlans.index'));
        }

        $this->loanPlanRepository->delete($id);

        Flash::success('Loan Plan deleted successfully.');

        return redirect(route('loanPlans.index'));
    }
}
