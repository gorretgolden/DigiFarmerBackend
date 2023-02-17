<?php namespace Tests\Repositories;

use App\Models\FinanceVendorCategories;
use App\Repositories\FinanceVendorCategoriesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FinanceVendorCategoriesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FinanceVendorCategoriesRepository
     */
    protected $financeVendorCategoriesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->financeVendorCategoriesRepo = \App::make(FinanceVendorCategoriesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->make()->toArray();

        $createdFinanceVendorCategories = $this->financeVendorCategoriesRepo->create($financeVendorCategories);

        $createdFinanceVendorCategories = $createdFinanceVendorCategories->toArray();
        $this->assertArrayHasKey('id', $createdFinanceVendorCategories);
        $this->assertNotNull($createdFinanceVendorCategories['id'], 'Created FinanceVendorCategories must have id specified');
        $this->assertNotNull(FinanceVendorCategories::find($createdFinanceVendorCategories['id']), 'FinanceVendorCategories with given id must be in DB');
        $this->assertModelData($financeVendorCategories, $createdFinanceVendorCategories);
    }

    /**
     * @test read
     */
    public function test_read_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();

        $dbFinanceVendorCategories = $this->financeVendorCategoriesRepo->find($financeVendorCategories->id);

        $dbFinanceVendorCategories = $dbFinanceVendorCategories->toArray();
        $this->assertModelData($financeVendorCategories->toArray(), $dbFinanceVendorCategories);
    }

    /**
     * @test update
     */
    public function test_update_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();
        $fakeFinanceVendorCategories = FinanceVendorCategories::factory()->make()->toArray();

        $updatedFinanceVendorCategories = $this->financeVendorCategoriesRepo->update($fakeFinanceVendorCategories, $financeVendorCategories->id);

        $this->assertModelData($fakeFinanceVendorCategories, $updatedFinanceVendorCategories->toArray());
        $dbFinanceVendorCategories = $this->financeVendorCategoriesRepo->find($financeVendorCategories->id);
        $this->assertModelData($fakeFinanceVendorCategories, $dbFinanceVendorCategories->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_finance_vendor_categories()
    {
        $financeVendorCategories = FinanceVendorCategories::factory()->create();

        $resp = $this->financeVendorCategoriesRepo->delete($financeVendorCategories->id);

        $this->assertTrue($resp);
        $this->assertNull(FinanceVendorCategories::find($financeVendorCategories->id), 'FinanceVendorCategories should not exist in DB');
    }
}
