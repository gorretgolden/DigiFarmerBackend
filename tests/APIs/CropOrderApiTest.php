<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropOrder;

class CropOrderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_order()
    {
        $cropOrder = CropOrder::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_orders', $cropOrder
        );

        $this->assertApiResponse($cropOrder);
    }

    /**
     * @test
     */
    public function test_read_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_orders/'.$cropOrder->id
        );

        $this->assertApiResponse($cropOrder->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();
        $editedCropOrder = CropOrder::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_orders/'.$cropOrder->id,
            $editedCropOrder
        );

        $this->assertApiResponse($editedCropOrder);
    }

    /**
     * @test
     */
    public function test_delete_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_orders/'.$cropOrder->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_orders/'.$cropOrder->id
        );

        $this->response->assertStatus(404);
    }
}
