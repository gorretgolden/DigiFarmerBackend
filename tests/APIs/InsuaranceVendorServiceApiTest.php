<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\InsuaranceVendorService;

class InsuaranceVendorServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/insuarance_vendor_services', $insuaranceVendorService
        );

        $this->assertApiResponse($insuaranceVendorService);
    }

    /**
     * @test
     */
    public function test_read_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/insuarance_vendor_services/'.$insuaranceVendorService->id
        );

        $this->assertApiResponse($insuaranceVendorService->toArray());
    }

    /**
     * @test
     */
    public function test_update_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();
        $editedInsuaranceVendorService = InsuaranceVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/insuarance_vendor_services/'.$insuaranceVendorService->id,
            $editedInsuaranceVendorService
        );

        $this->assertApiResponse($editedInsuaranceVendorService);
    }

    /**
     * @test
     */
    public function test_delete_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/insuarance_vendor_services/'.$insuaranceVendorService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/insuarance_vendor_services/'.$insuaranceVendorService->id
        );

        $this->response->assertStatus(404);
    }
}
