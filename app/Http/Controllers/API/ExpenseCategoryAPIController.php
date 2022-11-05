<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExpenseCategoryAPIRequest;
use App\Http\Requests\API\UpdateExpenseCategoryAPIRequest;
use App\Models\ExpenseCategory;
use App\Repositories\ExpenseCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ExpenseCategoryController
 * @package App\Http\Controllers\API
 */

class ExpenseCategoryAPIController extends AppBaseController
{
    /** @var  ExpenseCategoryRepository */
    private $expenseCategoryRepository;

    public function __construct(ExpenseCategoryRepository $expenseCategoryRepo)
    {
        $this->expenseCategoryRepository = $expenseCategoryRepo;
    }

    /**
     * Display a listing of the ExpenseCategory.
     * GET|HEAD /expenseCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $expenseCategories = $this->expenseCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($expenseCategories->toArray(), 'Expense Categories retrieved successfully');
    }

    /**
     * Store a newly created ExpenseCategory in storage.
     * POST /expenseCategories
     *
     * @param CreateExpenseCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseCategoryAPIRequest $request)
    {
        $input = $request->all();

        $expenseCategory = $this->expenseCategoryRepository->create($input);

        return $this->sendResponse($expenseCategory->toArray(), 'Expense Category saved successfully');
    }

    /**
     * Display the specified ExpenseCategory.
     * GET|HEAD /expenseCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ExpenseCategory $expenseCategory */
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            return $this->sendError('Expense Category not found');
        }

        return $this->sendResponse($expenseCategory->toArray(), 'Expense Category retrieved successfully');
    }

    /**
     * Update the specified ExpenseCategory in storage.
     * PUT/PATCH /expenseCategories/{id}
     *
     * @param int $id
     * @param UpdateExpenseCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var ExpenseCategory $expenseCategory */
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            return $this->sendError('Expense Category not found');
        }

        $expenseCategory = $this->expenseCategoryRepository->update($input, $id);

        return $this->sendResponse($expenseCategory->toArray(), 'ExpenseCategory updated successfully');
    }

    /**
     * Remove the specified ExpenseCategory from storage.
     * DELETE /expenseCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ExpenseCategory $expenseCategory */
        $expenseCategory = $this->expenseCategoryRepository->find($id);

        if (empty($expenseCategory)) {
            return $this->sendError('Expense Category not found');
        }

        $expenseCategory->delete();

        return $this->sendSuccess('Expense Category deleted successfully');
    }
}
