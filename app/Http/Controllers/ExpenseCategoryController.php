<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Repositories\ExpenseCategoryRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ExpenseCategoryController extends AppBaseController
{
    /** @var ExpenseCategoryRepository $expenseCategoryRepository*/
    private $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepo)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepo;
    }

    /**
     * Display a listing of the ExpenseCategory.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $expenseCategories = $this->expenseCategoryRepository->all();

        return view('expense_categories.index')
            ->with('expenseCategories', $expenseCategories);
    }

    /**
     * Show the form for creating a new ExpenseCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('expense_categories.create');
    }

    /**
     * Store a newly created ExpenseCategory in storage.
     *
     * @param CreateExpenseCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseCategoryRequest $request)
    {
        $input = $request->all();

        $expenseCategory = $this->expenseCategoryRepository->create($input);

        Flash::success('Expense Category saved successfully.');

        return redirect(route('expenseCategories.index'));
    }

    /**
     * Display the specified ExpenseCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            Flash::error('Expense Category not found');

            return redirect(route('expenseCategories.index'));
        }

        return view('expense_categories.show')->with('expenseCategory', $expenseCategory);
    }

    /**
     * Show the form for editing the specified ExpenseCategory.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            Flash::error('Expense Category not found');

            return redirect(route('expenseCategories.index'));
        }

        return view('expense_categories.edit')->with('expenseCategory', $expenseCategory);
    }

    /**
     * Update the specified ExpenseCategory in storage.
     *
     * @param int $id
     * @param UpdateExpenseCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseCategoryRequest $request)
    {
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            Flash::error('Expense Category not found');

            return redirect(route('expenseCategories.index'));
        }

        $expenseCategory = $this->expenseCategoryRepository->update($request->all(), $id);

        Flash::success('Expense Category updated successfully.');

        return redirect(route('expenseCategories.index'));
    }

    /**
     * Remove the specified ExpenseCategory from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            Flash::error('Expense Category not found');

            return redirect(route('expenseCategories.index'));
        }

        $this->expenseCategoryRepository->delete($id);

        Flash::success('Expense Category deleted successfully.');

        return redirect(route('expenseCategories.index'));
    }
}
