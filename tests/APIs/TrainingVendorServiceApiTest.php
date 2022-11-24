<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TrainingVendorService;

class TrainingVendorServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/training_vendor_services', $trainingVendorService
        );

        $this->assertApiResponse($trainingVendorService);
    }

    /**
     * @test
     */
    public function test_read_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/training_vendor_services/'.$trainingVendorService->id
        );

        $this->assertApiResponse($trainingVendorService->toArray());
    }

    /**
     * @test
     */
    public function test_update_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();
        $editedTrainingVendorService = TrainingVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/training_vendor_services/'.$trainingVendorService->id,
            $editedTrainingVendorService
        );

        $this->assertApiResponse($editedTrainingVendorService);
    }

    /**
     * @test
     */
    public function test_delete_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/training_vendor_services/'.$trainingVendorService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/training_vendor_services/'.$trainingVendorService->id
        );

        $this->response->assertStatus(404);
    }
}
