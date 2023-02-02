<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AgronomistVendorService.json;

class AgronomistVendorService.jsonApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/agronomist_vendor_service.jsons', $agronomistVendorService.json
        );

        $this->assertApiResponse($agronomistVendorService.json);
    }

    /**
     * @test
     */
    public function test_read_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/agronomist_vendor_service.jsons/'.$agronomistVendorService.json->id
        );

        $this->assertApiResponse($agronomistVendorService.json->toArray());
    }

    /**
     * @test
     */
    public function test_update_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();
        $editedAgronomistVendorService.json = AgronomistVendorService.json::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/agronomist_vendor_service.jsons/'.$agronomistVendorService.json->id,
            $editedAgronomistVendorService.json
        );

        $this->assertApiResponse($editedAgronomistVendorService.json);
    }

    /**
     * @test
     */
    public function test_delete_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/agronomist_vendor_service.jsons/'.$agronomistVendorService.json->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/agronomist_vendor_service.jsons/'.$agronomistVendorService.json->id
        );

        $this->response->assertStatus(404);
    }
}
