<?php namespace Tests\Repositories;

use App\Models\ExpenseCategory;
use App\Repositories\ExpenseCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ExpenseCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExpenseCategoryRepository
     */
    protected $expenseCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->expenseCategoryRepo = \App::make(ExpenseCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->make()->toArray();

        $createdExpenseCategory = $this->expenseCategoryRepo->create($expenseCategory);

        $createdExpenseCategory = $createdExpenseCategory->toArray();
        $this->assertArrayHasKey('id', $createdExpenseCategory);
        $this->assertNotNull($createdExpenseCategory['id'], 'Created ExpenseCategory must have id specified');
        $this->assertNotNull(ExpenseCategory::find($createdExpenseCategory['id']), 'ExpenseCategory with given id must be in DB');
        $this->assertModelData($expenseCategory, $createdExpenseCategory);
    }

    /**
     * @test read
     */
    public function test_read_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $dbExpenseCategory = $this->expenseCategoryRepo->find($expenseCategory->id);

        $dbExpenseCategory = $dbExpenseCategory->toArray();
        $this->assertModelData($expenseCategory->toArray(), $dbExpenseCategory);
    }

    /**
     * @test update
     */
    public function test_update_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();
        $fakeExpenseCategory = ExpenseCategory::factory()->make()->toArray();

        $updatedExpenseCategory = $this->expenseCategoryRepo->update($fakeExpenseCategory, $expenseCategory->id);

        $this->assertModelData($fakeExpenseCategory, $updatedExpenseCategory->toArray());
        $dbExpenseCategory = $this->expenseCategoryRepo->find($expenseCategory->id);
        $this->assertModelData($fakeExpenseCategory, $dbExpenseCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_expense_category()
    {
        $expenseCategory = ExpenseCategory::factory()->create();

        $resp = $this->expenseCategoryRepo->delete($expenseCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(ExpenseCategory::find($expenseCategory->id), 'ExpenseCategory should not exist in DB');
    }
}
