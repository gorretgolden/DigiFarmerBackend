<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SellerProduct;

class SellerProductApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/seller_products', $sellerProduct
        );

        $this->assertApiResponse($sellerProduct);
    }

    /**
     * @test
     */
    public function test_read_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/seller_products/'.$sellerProduct->id
        );

        $this->assertApiResponse($sellerProduct->toArray());
    }

    /**
     * @test
     */
    public function test_update_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();
        $editedSellerProduct = SellerProduct::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/seller_products/'.$sellerProduct->id,
            $editedSellerProduct
        );

        $this->assertApiResponse($editedSellerProduct);
    }

    /**
     * @test
     */
    public function test_delete_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/seller_products/'.$sellerProduct->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/seller_products/'.$sellerProduct->id
        );

        $this->response->assertStatus(404);
    }
}
