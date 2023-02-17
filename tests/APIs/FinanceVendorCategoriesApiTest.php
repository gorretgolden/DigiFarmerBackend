<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FinanceVendorCategories;

class FinanceVendorCategoriesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/finance_vendor_categories', $financeVendorCategories
        );

        $this->assertApiResponse($financeVendorCategories);
    }

    /**
     * @test
     */
    public function test_read_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/finance_vendor_categories/'.$financeVendorCategories->id
        );

        $this->assertApiResponse($financeVendorCategories->toArray());
    }

    /**
     * @test
     */
    public function test_update_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();
        $editedFinanceVendorCategories = FinanceVendorCategories::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/finance_vendor_categories/'.$financeVendorCategories->id,
            $editedFinanceVendorCategories
        );

        $this->assertApiResponse($editedFinanceVendorCategories);
    }

    /**
     * @test
     */
    public function test_delete_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/finance_vendor_categories/'.$financeVendorCategories->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/finance_vendor_categories/'.$financeVendorCategories->id
        );

        $this->response->assertStatus(404);
    }
}
