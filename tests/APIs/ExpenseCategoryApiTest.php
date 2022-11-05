<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ExpenseCategory;

class ExpenseCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/expense_categories', $expenseCategory
        );

        $this->assertApiResponse($expenseCategory);
    }

    /**
     * @test
     */
    public function test_read_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/expense_categories/'.$expenseCategory->id
        );

        $this->assertApiResponse($expenseCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();
        $editedExpenseCategory = ExpenseCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/expense_categories/'.$expenseCategory->id,
            $editedExpenseCategory
        );

        $this->assertApiResponse($editedExpenseCategory);
    }

    /**
     * @test
     */
    public function test_delete_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/expense_categories/'.$expenseCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/expense_categories/'.$expenseCategory->id
        );

        $this->response->assertStatus(404);
    }
}
