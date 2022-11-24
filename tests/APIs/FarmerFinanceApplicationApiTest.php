<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FarmerFinanceApplication;

class FarmerFinanceApplicationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/farmer_finance_applications', $farmerFinanceApplication
        );

        $this->assertApiResponse($farmerFinanceApplication);
    }

    /**
     * @test
     */
    public function test_read_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/farmer_finance_applications/'.$farmerFinanceApplication->id
        );

        $this->assertApiResponse($farmerFinanceApplication->toArray());
    }

    /**
     * @test
     */
    public function test_update_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();
        $editedFarmerFinanceApplication = FarmerFinanceApplication::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/farmer_finance_applications/'.$farmerFinanceApplication->id,
            $editedFarmerFinanceApplication
        );

        $this->assertApiResponse($editedFarmerFinanceApplication);
    }

    /**
     * @test
     */
    public function test_delete_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/farmer_finance_applications/'.$farmerFinanceApplication->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/farmer_finance_applications/'.$farmerFinanceApplication->id
        );

        $this->response->assertStatus(404);
    }
}
