<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FinanceVendorService;

class FinanceVendorServiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/finance_vendor_services', $financeVendorService
        );

        $this->assertApiResponse($financeVendorService);
    }

    /**
     * @test
     */
    public function test_read_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/finance_vendor_services/'.$financeVendorService->id
        );

        $this->assertApiResponse($financeVendorService->toArray());
    }

    /**
     * @test
     */
    public function test_update_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();
        $editedFinanceVendorService = FinanceVendorService::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/finance_vendor_services/'.$financeVendorService->id,
            $editedFinanceVendorService
        );

        $this->assertApiResponse($editedFinanceVendorService);
    }

    /**
     * @test
     */
    public function test_delete_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/finance_vendor_services/'.$financeVendorService->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/finance_vendor_services/'.$financeVendorService->id
        );

        $this->response->assertStatus(404);
    }
}
