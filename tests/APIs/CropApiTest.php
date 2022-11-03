<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Crop;

class CropApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop()
    {
        $crop = Crop::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crops', $crop
        );

        $this->assertApiResponse($crop);
    }

    /**
     * @test
     */
    public function test_read_crop()
    {
        $crop = Crop::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crops/'.$crop->id
        );

        $this->assertApiResponse($crop->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop()
    {
        $crop = Crop::factory()->create();
        $editedCrop = Crop::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crops/'.$crop->id,
            $editedCrop
        );

        $this->assertApiResponse($editedCrop);
    }

    /**
     * @test
     */
    public function test_delete_crop()
    {
        $crop = Crop::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crops/'.$crop->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crops/'.$crop->id
        );

        $this->response->assertStatus(404);
    }
}
