<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CropBuyerCropOnSale;

class CropBuyerCropOnSaleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/crop_buyer_crop_on_sales', $cropBuyerCropOnSale
        );

        $this->assertApiResponse($cropBuyerCropOnSale);
    }

    /**
     * @test
     */
    public function test_read_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/crop_buyer_crop_on_sales/'.$cropBuyerCropOnSale->id
        );

        $this->assertApiResponse($cropBuyerCropOnSale->toArray());
    }

    /**
     * @test
     */
    public function test_update_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();
        $editedCropBuyerCropOnSale = CropBuyerCropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/crop_buyer_crop_on_sales/'.$cropBuyerCropOnSale->id,
            $editedCropBuyerCropOnSale
        );

        $this->assertApiResponse($editedCropBuyerCropOnSale);
    }

    /**
     * @test
     */
    public function test_delete_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/crop_buyer_crop_on_sales/'.$cropBuyerCropOnSale->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/crop_buyer_crop_on_sales/'.$cropBuyerCropOnSale->id
        );

        $this->response->assertStatus(404);
    }
}
