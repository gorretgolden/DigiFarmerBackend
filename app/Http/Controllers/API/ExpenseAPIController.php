<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExpenseAPIRequest;
use App\Http\Requests\API\UpdateExpenseAPIRequest;
use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Farm;
use DB;
/**
 * Class ExpenseController
 * @package App\Http\Controllers\API
 */

class ExpenseAPIController extends AppBaseController
{
    /** @var  ExpenseRepository */
    private $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepo)
    {
        $this->expenseRepository = $expenseRepo;
    }

    /**
     * Display a listing of the Expense.
     * GET|HEAD /expenses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $expenses =Expense::with(['plot','expense_category'])->get();
        $response = [
            'success'=>true,
            'data'=> $expenses,
            'message'=> 'Expenses retrieved successfully'
         ];
         return response()->json($response,200);
    }

    /**
     * Store a newly created Expense in storage.
     * POST /expenses
     *
     * @param CreateExpenseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseAPIRequest $request)
    {
        $input = $request->all();
        $existing_expense = Expense::where('expense_category_id',$request->expense_category_id)->where('plot_id',$request->plot_id)->first();

        if(!$existing_expense){
            $expense = $this->expenseRepository->create($input);

            return $this->sendResponse($expense->toArray(), 'Expense saved successfully');
        }
        else{

            $response = [
                'success'=>false,

                'message'=> 'An expense with this expense category exists on the plot'
             ];

             return response()->json($response,409);
        }


    }


    //get expenses on a farmer plot
    public function expensePlots(Request $request)
    {

      $farms = Farm::where('owner',auth()->user()->username)->get();


      $plot_expenses = [];
      foreach( collect($farms) as $farm){
         $plots = $farm->plots;

         foreach($farm->plots as $plot){
            $plot_expenses[] = $plot->expenses;
           // dd($plot_expenses);

         };

      }

      $response = [
        'success'=>false,
        'data' =>$plot_expenses,
        'message'=> 'retrieved'
      ];

      return response()->json($response,202);



    }


    /**
     * Display the specified Expense.
     * GET|HEAD /expenses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $expense= Expense::find($id);

        if (empty($expense)) {
            return $this->sendError('Plot expense enot found');
        }
        else{
            $success['amount'] = $expense->amount;
            $success['expense_category'] = $expense->expense_category;
            $success['plot'] = $expense->plot;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Expense details retrieved successfully'
             ];

             return response()->json($response,200);
        }

    }

    /**
     * Update the specified Expense in storage.
     * PUT/PATCH /expenses/{id}
     *
     * @param int $id
     * @param UpdateExpenseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense = $this->expenseRepository->update($input, $id);

        return $this->sendResponse($expense->toArray(), 'Expense updated successfully');
    }

    /**
     * Remove the specified Expense from storage.
     * DELETE /expenses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense->delete();

        return $this->sendSuccess('Expense deleted successfully');
    }
}
