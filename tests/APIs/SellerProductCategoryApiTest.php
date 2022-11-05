<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SellerProductCategory;

class SellerProductCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/seller_product_categories', $sellerProductCategory
        );

        $this->assertApiResponse($sellerProductCategory);
    }

    /**
     * @test
     */
    public function test_read_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/seller_product_categories/'.$sellerProductCategory->id
        );

        $this->assertApiResponse($sellerProductCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();
        $editedSellerProductCategory = SellerProductCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/seller_product_categories/'.$sellerProductCategory->id,
            $editedSellerProductCategory
        );

        $this->assertApiResponse($editedSellerProductCategory);
    }

    /**
     * @test
     */
    public function test_delete_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/seller_product_categories/'.$sellerProductCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/seller_product_categories/'.$sellerProductCategory->id
        );

        $this->response->assertStatus(404);
    }
}
