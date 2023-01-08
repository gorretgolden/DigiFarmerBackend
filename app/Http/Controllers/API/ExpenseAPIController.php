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
      $farm_plot_expenses = collect($farms)->pluck('plots')[0];




     //maping through the collection to concatnate plots with expenses
       $farm_plot_expenses = $farm_plot_expenses->map(function ($item){
        return collect([
            'id' => $item->id,
            'name' => $item->name,
            'location' => $item->location,
            'size' => $item->size . " ". $item->size_unit ,
            'farm' => $item->farm->name,
            'crop' => $item->crop->name,
            'expenses' => $item->expenses->map(function ($details){
                return [
                    'id' => $details->id,
                    'amount' => $details->amount,
                    'category' => $details->expense_category->name,
                    'plot'=> $details->plot->name


                ];
              }),
          ]);
        });


        //dd($farm_plot_expenses);

      if(empty($farms)){
          $response = [
            'success'=>false,
            'message'=> 'farmer has no farms'
          ];

          return response()->json($response,200);

      }else{
        $response = [
            'success'=>false,
            'data' =>$farm_plot_expenses,
            'message'=> 'Expenses on farm plot retrieved'
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
