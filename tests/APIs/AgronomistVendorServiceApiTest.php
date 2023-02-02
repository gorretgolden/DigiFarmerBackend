<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AgronomistVendorService;

class AgronomistVendorServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/agronomist_vendor_services', $agronomistVendorService
        );

        $this->assertApiResponse($agronomistVendorService);
    }

    /**
     * @test
     */
    public function test_read_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/agronomist_vendor_services/'.$agronomistVendorService->id
        );

        $this->assertApiResponse($agronomistVendorService->toArray());
    }

    /**
     * @test
     */
    public function test_update_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();
        $editedAgronomistVendorService = AgronomistVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/agronomist_vendor_services/'.$agronomistVendorService->id,
            $editedAgronomistVendorService
        );

        $this->assertApiResponse($editedAgronomistVendorService);
    }

    /**
     * @test
     */
    public function test_delete_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/agronomist_vendor_services/'.$agronomistVendorService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/agronomist_vendor_services/'.$agronomistVendorService->id
        );

        $this->response->assertStatus(404);
    }
}
