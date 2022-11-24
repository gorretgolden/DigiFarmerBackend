<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\VendorCategory;

class VendorCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/vendor_categories', $vendorCategory
        );

        $this->assertApiResponse($vendorCategory);
    }

    /**
     * @test
     */
    public function test_read_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/vendor_categories/'.$vendorCategory->id
        );

        $this->assertApiResponse($vendorCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();
        $editedVendorCategory = VendorCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/vendor_categories/'.$vendorCategory->id,
            $editedVendorCategory
        );

        $this->assertApiResponse($editedVendorCategory);
    }

    /**
     * @test
     */
    public function test_delete_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/vendor_categories/'.$vendorCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/vendor_categories/'.$vendorCategory->id
        );

        $this->response->assertStatus(404);
    }
}
