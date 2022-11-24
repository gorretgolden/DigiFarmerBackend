<?php namespace Tests\Repositories;

use App\Models\FinanceVendorService;
use App\Repositories\FinanceVendorServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FinanceVendorServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FinanceVendorServiceRepository
     */
    protected $financeVendorServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->financeVendorServiceRepo = \App::make(FinanceVendorServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->make()->toArray();

        $createdFinanceVendorService = $this->financeVendorServiceRepo->create($financeVendorService);

        $createdFinanceVendorService = $createdFinanceVendorService->toArray();
        $this->assertArrayHasKey('id', $createdFinanceVendorService);
        $this->assertNotNull($createdFinanceVendorService['id'], 'Created FinanceVendorService must have id specified');
        $this->assertNotNull(FinanceVendorService::find($createdFinanceVendorService['id']), 'FinanceVendorService with given id must be in DB');
        $this->assertModelData($financeVendorService, $createdFinanceVendorService);
    }

    /**
     * @test read
     */
    public function test_read_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();

        $dbFinanceVendorService = $this->financeVendorServiceRepo->find($financeVendorService->id);

        $dbFinanceVendorService = $dbFinanceVendorService->toArray();
        $this->assertModelData($financeVendorService->toArray(), $dbFinanceVendorService);
    }

    /**
     * @test update
     */
    public function test_update_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();
        $fakeFinanceVendorService = FinanceVendorService::factory()->make()->toArray();

        $updatedFinanceVendorService = $this->financeVendorServiceRepo->update($fakeFinanceVendorService, $financeVendorService->id);

        $this->assertModelData($fakeFinanceVendorService, $updatedFinanceVendorService->toArray());
        $dbFinanceVendorService = $this->financeVendorServiceRepo->find($financeVendorService->id);
        $this->assertModelData($fakeFinanceVendorService, $dbFinanceVendorService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_finance_vendor_service()
    {
        $financeVendorService = FinanceVendorService::factory()->create();

        $resp = $this->financeVendorServiceRepo->delete($financeVendorService->id);

        $this->assertTrue($resp);
        $this->assertNull(FinanceVendorService::find($financeVendorService->id), 'FinanceVendorService should not exist in DB');
    }
}
