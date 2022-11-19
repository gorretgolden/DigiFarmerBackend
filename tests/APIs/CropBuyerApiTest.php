<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropBuyer;

class CropBuyerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_buyers', $cropBuyer
        );

        $this->assertApiResponse($cropBuyer);
    }

    /**
     * @test
     */
    public function test_read_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_buyers/'.$cropBuyer->id
        );

        $this->assertApiResponse($cropBuyer->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();
        $editedCropBuyer = CropBuyer::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_buyers/'.$cropBuyer->id,
            $editedCropBuyer
        );

        $this->assertApiResponse($editedCropBuyer);
    }

    /**
     * @test
     */
    public function test_delete_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_buyers/'.$cropBuyer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_buyers/'.$cropBuyer->id
        );

        $this->response->assertStatus(404);
    }
}
