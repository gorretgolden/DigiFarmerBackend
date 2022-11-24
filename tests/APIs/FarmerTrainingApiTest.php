<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FarmerTraining;

class FarmerTrainingApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/farmer_trainings', $farmerTraining
        );

        $this->assertApiResponse($farmerTraining);
    }

    /**
     * @test
     */
    public function test_read_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/farmer_trainings/'.$farmerTraining->id
        );

        $this->assertApiResponse($farmerTraining->toArray());
    }

    /**
     * @test
     */
    public function test_update_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();
        $editedFarmerTraining = FarmerTraining::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/farmer_trainings/'.$farmerTraining->id,
            $editedFarmerTraining
        );

        $this->assertApiResponse($editedFarmerTraining);
    }

    /**
     * @test
     */
    public function test_delete_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/farmer_trainings/'.$farmerTraining->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/farmer_trainings/'.$farmerTraining->id
        );

        $this->response->assertStatus(404);
    }
}
