<?php namespace Tests\Repositories;

use App\Models\RentVendorService;
use App\Repositories\RentVendorServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RentVendorServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RentVendorServiceRepository
     */
    protected $rentVendorServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->rentVendorServiceRepo = \App::make(RentVendorServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->make()->toArray();

        $createdRentVendorService = $this->rentVendorServiceRepo->create($rentVendorService);

        $createdRentVendorService = $createdRentVendorService->toArray();
        $this->assertArrayHasKey('id', $createdRentVendorService);
        $this->assertNotNull($createdRentVendorService['id'], 'Created RentVendorService must have id specified');
        $this->assertNotNull(RentVendorService::find($createdRentVendorService['id']), 'RentVendorService with given id must be in DB');
        $this->assertModelData($rentVendorService, $createdRentVendorService);
    }

    /**
     * @test read
     */
    public function test_read_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();

        $dbRentVendorService = $this->rentVendorServiceRepo->find($rentVendorService->id);

        $dbRentVendorService = $dbRentVendorService->toArray();
        $this->assertModelData($rentVendorService->toArray(), $dbRentVendorService);
    }

    /**
     * @test update
     */
    public function test_update_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();
        $fakeRentVendorService = RentVendorService::factory()->make()->toArray();

        $updatedRentVendorService = $this->rentVendorServiceRepo->update($fakeRentVendorService, $rentVendorService->id);

        $this->assertModelData($fakeRentVendorService, $updatedRentVendorService->toArray());
        $dbRentVendorService = $this->rentVendorServiceRepo->find($rentVendorService->id);
        $this->assertModelData($fakeRentVendorService, $dbRentVendorService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_rent_vendor_service()
    {
        $rentVendorService = RentVendorService::factory()->create();

        $resp = $this->rentVendorServiceRepo->delete($rentVendorService->id);

        $this->assertTrue($resp);
        $this->assertNull(RentVendorService::find($rentVendorService->id), 'RentVendorService should not exist in DB');
    }
}
