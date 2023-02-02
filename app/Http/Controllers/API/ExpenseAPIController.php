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

      $farms = Farm::where('owner',auth()->user()->username)->with('plots')->get();
      $farm_plots = collect($farms)->pluck('plots')[0];

      $plot_expenses =[];


      foreach($farm_plots as $plot){
        $plot_expenses =  $plot->expenses->map(function ($item){
            return collect([
                'id' => $item->id,
                'amount' => $item->amount,
                'plot' => $item->plot->name,
                'farm' => $item->plot->farm->name,
                'expense_category' => $item->expense_category->name,
                'created_at' => $item->created_at->format('d/m/Y'),

              ]);
            });

      }




      if(empty($farms)){
          $response = [
            'success'=>false,
            'message'=> 'farmer has no farms'
          ];

          return response()->json($response,200);

      }else{



        $response = [
            'success'=>true,
            'data' =>[
                'total-expenses'=>$plot_expenses->count(),
                'expenses'=>$plot_expenses
            ],
            'message'=> 'Expenses on farm plots retrieved'
          ];

          return response()->json($response,200);

    }





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
            $success['expense_category'] = $expense->expense_category->name;
            $success['plot'] = $expense->plot->name;
            $success['created_at'] = $expense->created_at->format('d/m/Y');


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
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }else{

                $request->validate(['amount'=>'required|integer']);
                $expense->amount = $request->amount;
                $expense->save();
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
