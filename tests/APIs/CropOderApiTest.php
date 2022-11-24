<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropOder;

class CropOderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_oder()
    {
        $cropOder = CropOder::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_oders', $cropOder
        );

        $this->assertApiResponse($cropOder);
    }

    /**
     * @test
     */
    public function test_read_crop_oder()
    {
        $cropOder = CropOder::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_oders/'.$cropOder->id
        );

        $this->assertApiResponse($cropOder->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_oder()
    {
        $cropOder = CropOder::factory()->create();
        $editedCropOder = CropOder::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_oders/'.$cropOder->id,
            $editedCropOder
        );

        $this->assertApiResponse($editedCropOder);
    }

    /**
     * @test
     */
    public function test_delete_crop_oder()
    {
        $cropOder = CropOder::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_oders/'.$cropOder->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_oders/'.$cropOder->id
        );

        $this->response->assertStatus(404);
    }
}
