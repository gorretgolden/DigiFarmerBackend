<?php namespace Tests\Repositories;

use App\Models\LoanPlan;
use App\Repositories\LoanPlanRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LoanPlanRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LoanPlanRepository
     */
    protected $loanPlanRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->loanPlanRepo = \App::make(LoanPlanRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->make()->toArray();

        $createdLoanPlan = $this->loanPlanRepo->create($loanPlan);

        $createdLoanPlan = $createdLoanPlan->toArray();
        $this->assertArrayHasKey('id', $createdLoanPlan);
        $this->assertNotNull($createdLoanPlan['id'], 'Created LoanPlan must have id specified');
        $this->assertNotNull(LoanPlan::find($createdLoanPlan['id']), 'LoanPlan with given id must be in DB');
        $this->assertModelData($loanPlan, $createdLoanPlan);
    }

    /**
     * @test read
     */
    public function test_read_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();

        $dbLoanPlan = $this->loanPlanRepo->find($loanPlan->id);

        $dbLoanPlan = $dbLoanPlan->toArray();
        $this->assertModelData($loanPlan->toArray(), $dbLoanPlan);
    }

    /**
     * @test update
     */
    public function test_update_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();
        $fakeLoanPlan = LoanPlan::factory()->make()->toArray();

        $updatedLoanPlan = $this->loanPlanRepo->update($fakeLoanPlan, $loanPlan->id);

        $this->assertModelData($fakeLoanPlan, $updatedLoanPlan->toArray());
        $dbLoanPlan = $this->loanPlanRepo->find($loanPlan->id);
        $this->assertModelData($fakeLoanPlan, $dbLoanPlan->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();

        $resp = $this->loanPlanRepo->delete($loanPlan->id);

        $this->assertTrue($resp);
        $this->assertNull(LoanPlan::find($loanPlan->id), 'LoanPlan should not exist in DB');
    }
}
