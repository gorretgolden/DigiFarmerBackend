<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LoanPlan;

class LoanPlanApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/loan_plans', $loanPlan
        );

        $this->assertApiResponse($loanPlan);
    }

    /**
     * @test
     */
    public function test_read_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/loan_plans/'.$loanPlan->id
        );

        $this->assertApiResponse($loanPlan->toArray());
    }

    /**
     * @test
     */
    public function test_update_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();
        $editedLoanPlan = LoanPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/loan_plans/'.$loanPlan->id,
            $editedLoanPlan
        );

        $this->assertApiResponse($editedLoanPlan);
    }

    /**
     * @test
     */
    public function test_delete_loan_plan()
    {
        $loanPlan = LoanPlan::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/loan_plans/'.$loanPlan->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/loan_plans/'.$loanPlan->id
        );

        $this->response->assertStatus(404);
    }
}
