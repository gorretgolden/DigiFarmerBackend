<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FarmerBuySellerProduct;

class FarmerBuySellerProductApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/farmer_buy_seller_products', $farmerBuySellerProduct
        );

        $this->assertApiResponse($farmerBuySellerProduct);
    }

    /**
     * @test
     */
    public function test_read_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/farmer_buy_seller_products/'.$farmerBuySellerProduct->id
        );

        $this->assertApiResponse($farmerBuySellerProduct->toArray());
    }

    /**
     * @test
     */
    public function test_update_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();
        $editedFarmerBuySellerProduct = FarmerBuySellerProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/farmer_buy_seller_products/'.$farmerBuySellerProduct->id,
            $editedFarmerBuySellerProduct
        );

        $this->assertApiResponse($editedFarmerBuySellerProduct);
    }

    /**
     * @test
     */
    public function test_delete_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/farmer_buy_seller_products/'.$farmerBuySellerProduct->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/farmer_buy_seller_products/'.$farmerBuySellerProduct->id
        );

        $this->response->assertStatus(404);
    }
}
