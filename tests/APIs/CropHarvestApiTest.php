<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropHarvest;

class CropHarvestApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_harvests', $cropHarvest
        );

        $this->assertApiResponse($cropHarvest);
    }

    /**
     * @test
     */
    public function test_read_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_harvests/'.$cropHarvest->id
        );

        $this->assertApiResponse($cropHarvest->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();
        $editedCropHarvest = CropHarvest::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_harvests/'.$cropHarvest->id,
            $editedCropHarvest
        );

        $this->assertApiResponse($editedCropHarvest);
    }

    /**
     * @test
     */
    public function test_delete_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_harvests/'.$cropHarvest->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_harvests/'.$cropHarvest->id
        );

        $this->response->assertStatus(404);
    }
}
