<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropOnSale;

class CropOnSaleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_on_sales', $cropOnSale
        );

        $this->assertApiResponse($cropOnSale);
    }

    /**
     * @test
     */
    public function test_read_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_on_sales/'.$cropOnSale->id
        );

        $this->assertApiResponse($cropOnSale->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();
        $editedCropOnSale = CropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_on_sales/'.$cropOnSale->id,
            $editedCropOnSale
        );

        $this->assertApiResponse($editedCropOnSale);
    }

    /**
     * @test
     */
    public function test_delete_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_on_sales/'.$cropOnSale->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_on_sales/'.$cropOnSale->id
        );

        $this->response->assertStatus(404);
    }
}
