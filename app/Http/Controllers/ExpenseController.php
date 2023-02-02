<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Repositories\ExpenseRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Expense;
use DB;

class ExpenseController extends AppBaseController
{
    /** @var ExpenseRepository $expenseRepository*/
    private $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepo)
    {
        $this->expenseRepository = $expenseRepo;
    }

    /**
     * Display a listing of the Expense.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $expenses = Expense::join('plots', 'expenses.plot_id', '=', 'plots.id')
              ->join('farms', 'plots.farm_id', '=', 'farms.id')
              ->get();
        // $expenses = DB::table('expenses')
        //   ->leftJoin('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
        //     ->leftJoin('plots', 'plots.id', '=', 'expenses.plot_id')
        //     ->leftJoin('farms', 'farms.id', '=', 'plots.farm_id')
        //     ->select('expenses.amount','expense_categories.name','plots.name','farms.name','farms.owner')
        //     ->get();


        dd($expenses);
        return view('expenses.index')
            ->with('expenses', $expenses);
    }

    /**
     * Show the form for creating a new Expense.
     *
     * @return Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created Expense in storage.
     *
     * @param CreateExpenseRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseRequest $request)
    {
        $input = $request->all();

        $existing_expense = Expense::where('expense_category_id',$request->expense_category_id)->where('plot_id',$request->plot_id)->first();

        if(!$existing_expense){
            $expense = $this->expenseRepository->create($input);

           Flash::success('Expense saved successfully.');
        }
        else{
            Flash::error('An expense with this expense category exists.');
        }



        return redirect(route('expenses.index'));
    }

    /**
     * Display the specified Expense.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            Flash::error('Expense not found');

            return redirect(route('expenses.index'));
        }

        return view('expenses.show')->with('expense', $expense);
    }

    /**
     * Show the form for editing the specified Expense.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            Flash::error('Expense not found');

            return redirect(route('expenses.index'));
        }

        return view('expenses.edit')->with('expense', $expense);
    }

    /**
     * Update the specified Expense in storage.
     *
     * @param int $id
     * @param UpdateExpenseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseRequest $request)
    {
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            Flash::error('Expense not found');

            return redirect(route('expenses.index'));
        }

        $expense = $this->expenseRepository->update($request->all(), $id);

        Flash::success('Expense updated successfully.');

        return redirect(route('expenses.index'));
    }

    /**
     * Remove the specified Expense from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            Flash::error('Expense not found');

            return redirect(route('expenses.index'));
        }

        $this->expenseRepository->delete($id);

        Flash::success('Expense deleted successfully.');

        return redirect(route('expenses.index'));
    }
}
