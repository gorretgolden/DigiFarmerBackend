<?php namespace Tests\Repositories;

use App\Models\InsuaranceVendorService;
use App\Repositories\InsuaranceVendorServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class InsuaranceVendorServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var InsuaranceVendorServiceRepository
     */
    protected $insuaranceVendorServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->insuaranceVendorServiceRepo = \App::make(InsuaranceVendorServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->make()->toArray();

        $createdInsuaranceVendorService = $this->insuaranceVendorServiceRepo->create($insuaranceVendorService);

        $createdInsuaranceVendorService = $createdInsuaranceVendorService->toArray();
        $this->assertArrayHasKey('id', $createdInsuaranceVendorService);
        $this->assertNotNull($createdInsuaranceVendorService['id'], 'Created InsuaranceVendorService must have id specified');
        $this->assertNotNull(InsuaranceVendorService::find($createdInsuaranceVendorService['id']), 'InsuaranceVendorService with given id must be in DB');
        $this->assertModelData($insuaranceVendorService, $createdInsuaranceVendorService);
    }

    /**
     * @test read
     */
    public function test_read_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();

        $dbInsuaranceVendorService = $this->insuaranceVendorServiceRepo->find($insuaranceVendorService->id);

        $dbInsuaranceVendorService = $dbInsuaranceVendorService->toArray();
        $this->assertModelData($insuaranceVendorService->toArray(), $dbInsuaranceVendorService);
    }

    /**
     * @test update
     */
    public function test_update_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();
        $fakeInsuaranceVendorService = InsuaranceVendorService::factory()->make()->toArray();

        $updatedInsuaranceVendorService = $this->insuaranceVendorServiceRepo->update($fakeInsuaranceVendorService, $insuaranceVendorService->id);

        $this->assertModelData($fakeInsuaranceVendorService, $updatedInsuaranceVendorService->toArray());
        $dbInsuaranceVendorService = $this->insuaranceVendorServiceRepo->find($insuaranceVendorService->id);
        $this->assertModelData($fakeInsuaranceVendorService, $dbInsuaranceVendorService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_insuarance_vendor_service()
    {
        $insuaranceVendorService = InsuaranceVendorService::factory()->create();

        $resp = $this->insuaranceVendorServiceRepo->delete($insuaranceVendorService->id);

        $this->assertTrue($resp);
        $this->assertNull(InsuaranceVendorService::find($insuaranceVendorService->id), 'InsuaranceVendorService should not exist in DB');
    }
}
