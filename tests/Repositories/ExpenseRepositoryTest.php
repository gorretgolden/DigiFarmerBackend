<?php namespace Tests\Repositories;

use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ExpenseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ExpenseRepository
     */
    protected $expenseRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->expenseRepo = \App::make(ExpenseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_expense()
    {
        $expense = Expense::factory()->make()->toArray();

        $createdExpense = $this->expenseRepo->create($expense);

        $createdExpense = $createdExpense->toArray();
        $this->assertArrayHasKey('id', $createdExpense);
        $this->assertNotNull($createdExpense['id'], 'Created Expense must have id specified');
        $this->assertNotNull(Expense::find($createdExpense['id']), 'Expense with given id must be in DB');
        $this->assertModelData($expense, $createdExpense);
    }

    /**
     * @test read
     */
    public function test_read_expense()
    {
        $expense = Expense::factory()->create();

        $dbExpense = $this->expenseRepo->find($expense->id);

        $dbExpense = $dbExpense->toArray();
        $this->assertModelData($expense->toArray(), $dbExpense);
    }

    /**
     * @test update
     */
    public function test_update_expense()
    {
        $expense = Expense::factory()->create();
        $fakeExpense = Expense::factory()->make()->toArray();

        $updatedExpense = $this->expenseRepo->update($fakeExpense, $expense->id);

        $this->assertModelData($fakeExpense, $updatedExpense->toArray());
        $dbExpense = $this->expenseRepo->find($expense->id);
        $this->assertModelData($fakeExpense, $dbExpense->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_expense()
    {
        $expense = Expense::factory()->create();

        $resp = $this->expenseRepo->delete($expense->id);

        $this->assertTrue($resp);
        $this->assertNull(Expense::find($expense->id), 'Expense should not exist in DB');
    }
}
