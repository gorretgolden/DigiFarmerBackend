<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RentVendorCategory;

class RentVendorCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/rent_vendor_categories', $rentVendorCategory
        );

        $this->assertApiResponse($rentVendorCategory);
    }

    /**
     * @test
     */
    public function test_read_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/rent_vendor_categories/'.$rentVendorCategory->id
        );

        $this->assertApiResponse($rentVendorCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();
        $editedRentVendorCategory = RentVendorCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/rent_vendor_categories/'.$rentVendorCategory->id,
            $editedRentVendorCategory
        );

        $this->assertApiResponse($editedRentVendorCategory);
    }

    /**
     * @test
     */
    public function test_delete_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/rent_vendor_categories/'.$rentVendorCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/rent_vendor_categories/'.$rentVendorCategory->id
        );

        $this->response->assertStatus(404);
    }
}
