<?php namespace Tests\Repositories;

use App\Models\AgronomistVendorService;
use App\Repositories\AgronomistVendorServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AgronomistVendorServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AgronomistVendorServiceRepository
     */
    protected $agronomistVendorServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->agronomistVendorServiceRepo = \App::make(AgronomistVendorServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->make()->toArray();

        $createdAgronomistVendorService = $this->agronomistVendorServiceRepo->create($agronomistVendorService);

        $createdAgronomistVendorService = $createdAgronomistVendorService->toArray();
        $this->assertArrayHasKey('id', $createdAgronomistVendorService);
        $this->assertNotNull($createdAgronomistVendorService['id'], 'Created AgronomistVendorService must have id specified');
        $this->assertNotNull(AgronomistVendorService::find($createdAgronomistVendorService['id']), 'AgronomistVendorService with given id must be in DB');
        $this->assertModelData($agronomistVendorService, $createdAgronomistVendorService);
    }

    /**
     * @test read
     */
    public function test_read_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();

        $dbAgronomistVendorService = $this->agronomistVendorServiceRepo->find($agronomistVendorService->id);

        $dbAgronomistVendorService = $dbAgronomistVendorService->toArray();
        $this->assertModelData($agronomistVendorService->toArray(), $dbAgronomistVendorService);
    }

    /**
     * @test update
     */
    public function test_update_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();
        $fakeAgronomistVendorService = AgronomistVendorService::factory()->make()->toArray();

        $updatedAgronomistVendorService = $this->agronomistVendorServiceRepo->update($fakeAgronomistVendorService, $agronomistVendorService->id);

        $this->assertModelData($fakeAgronomistVendorService, $updatedAgronomistVendorService->toArray());
        $dbAgronomistVendorService = $this->agronomistVendorServiceRepo->find($agronomistVendorService->id);
        $this->assertModelData($fakeAgronomistVendorService, $dbAgronomistVendorService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_agronomist_vendor_service()
    {
        $agronomistVendorService = AgronomistVendorService::factory()->create();

        $resp = $this->agronomistVendorServiceRepo->delete($agronomistVendorService->id);

        $this->assertTrue($resp);
        $this->assertNull(AgronomistVendorService::find($agronomistVendorService->id), 'AgronomistVendorService should not exist in DB');
    }
}
