<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanPayBackRequest;
use App\Http\Requests\UpdateLoanPayBackRequest;
use App\Repositories\LoanPayBackRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\LoanPayback;
class LoanPayBackController extends AppBaseController
{
    /** @var LoanPayBackRepository $loanPayBackRepository*/
    private $loanPayBackRepository;

    public function __construct(LoanPayBackRepository $loanPayBackRepo)
    {
        $this->loanPayBackRepository = $loanPayBackRepo;
    }

    /**
     * Display a listing of the LoanPayBack.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $loanPayBacks = $this->loanPayBackRepository->all();

        return view('loan_pay_backs.index')
            ->with('loanPayBacks', $loanPayBacks);
    }

    /**
     * Show the form for creating a new LoanPayBack.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_pay_backs.create');
    }

    /**
     * Store a newly created LoanPayBack in storage.
     *
     * @param CreateLoanPayBackRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanPayBackRequest $request)
    {
        $input = $request->all();
        if(LoanPayBack::where('name',$request->name)->first()){
            Flash::error('Loan Payback exists.');

            return redirect(route('loanPayBacks.index'));

        }
        else{

            $loanPayBack = $this->loanPayBackRepository->create($input);

            Flash::success('Loan Pay Back saved successfully.');

            return redirect(route('loanPayBacks.index'));
        }


    }

    /**
     * Display the specified LoanPayBack.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanPayBack = $this->loanPayBackRepository->find($id);

        if (empty($loanPayBack)) {
            Flash::error('Loan Pay Back not found');

            return redirect(route('loanPayBacks.index'));
        }

        return view('loan_pay_backs.show')->with('loanPayBack', $loanPayBack);
    }

    /**
     * Show the form for editing the specified LoanPayBack.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanPayBack = $this->loanPayBackRepository->find($id);

        if (empty($loanPayBack)) {
            Flash::error('Loan Pay Back not found');

            return redirect(route('loanPayBacks.index'));
        }

        return view('loan_pay_backs.edit')->with('loanPayBack', $loanPayBack);
    }

    /**
     * Update the specified LoanPayBack in storage.
     *
     * @param int $id
     * @param UpdateLoanPayBackRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanPayBackRequest $request)
    {
        $loanPayBack = $this->loanPayBackRepository->find($id);

        if (empty($loanPayBack)) {
            Flash::error('Loan Pay Back not found');

            return redirect(route('loanPayBacks.index'));
        }

        $loanPayBack = $this->loanPayBackRepository->update($request->all(), $id);

        Flash::success('Loan Pay Back updated successfully.');

        return redirect(route('loanPayBacks.index'));
    }

    /**
     * Remove the specified LoanPayBack from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanPayBack = $this->loanPayBackRepository->find($id);

        if (empty($loanPayBack)) {
            Flash::error('Loan Pay Back not found');

            return redirect(route('loanPayBacks.index'));
        }

        $this->loanPayBackRepository->delete($id);

        Flash::success('Loan Pay Back deleted successfully.');

        return redirect(route('loanPayBacks.index'));
    }
}
