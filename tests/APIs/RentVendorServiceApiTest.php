<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RentVendorService;

class RentVendorServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/rent_vendor_services', $rentVendorService
        );

        $this->assertApiResponse($rentVendorService);
    }

    /**
     * @test
     */
    public function test_read_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/rent_vendor_services/'.$rentVendorService->id
        );

        $this->assertApiResponse($rentVendorService->toArray());
    }

    /**
     * @test
     */
    public function test_update_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();
        $editedRentVendorService = RentVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/rent_vendor_services/'.$rentVendorService->id,
            $editedRentVendorService
        );

        $this->assertApiResponse($editedRentVendorService);
    }

    /**
     * @test
     */
    public function test_delete_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/rent_vendor_services/'.$rentVendorService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/rent_vendor_services/'.$rentVendorService->id
        );

        $this->response->assertStatus(404);
    }
}
