<?php namespace Tests\Repositories;

use App\Models\AgronomistVendorService.json;
use App\Repositories\AgronomistVendorService.jsonRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AgronomistVendorService.jsonRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AgronomistVendorService.jsonRepository
     */
    protected $agronomistVendorService.jsonRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->agronomistVendorService.jsonRepo = \App::make(AgronomistVendorService.jsonRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->make()->toArray();

        $createdAgronomistVendorService.json = $this->agronomistVendorService.jsonRepo->create($agronomistVendorService.json);

        $createdAgronomistVendorService.json = $createdAgronomistVendorService.json->toArray();
        $this->assertArrayHasKey('id', $createdAgronomistVendorService.json);
        $this->assertNotNull($createdAgronomistVendorService.json['id'], 'Created AgronomistVendorService.json must have id specified');
        $this->assertNotNull(AgronomistVendorService.json::find($createdAgronomistVendorService.json['id']), 'AgronomistVendorService.json with given id must be in DB');
        $this->assertModelData($agronomistVendorService.json, $createdAgronomistVendorService.json);
    }

    /**
     * @test read
     */
    public function test_read_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();

        $dbAgronomistVendorService.json = $this->agronomistVendorService.jsonRepo->find($agronomistVendorService.json->id);

        $dbAgronomistVendorService.json = $dbAgronomistVendorService.json->toArray();
        $this->assertModelData($agronomistVendorService.json->toArray(), $dbAgronomistVendorService.json);
    }

    /**
     * @test update
     */
    public function test_update_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();
        $fakeAgronomistVendorService.json = AgronomistVendorService.json::factory()->make()->toArray();

        $updatedAgronomistVendorService.json = $this->agronomistVendorService.jsonRepo->update($fakeAgronomistVendorService.json, $agronomistVendorService.json->id);

        $this->assertModelData($fakeAgronomistVendorService.json, $updatedAgronomistVendorService.json->toArray());
        $dbAgronomistVendorService.json = $this->agronomistVendorService.jsonRepo->find($agronomistVendorService.json->id);
        $this->assertModelData($fakeAgronomistVendorService.json, $dbAgronomistVendorService.json->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_agronomist_vendor_service.json()
    {
        $agronomistVendorService.json = AgronomistVendorService.json::factory()->create();

        $resp = $this->agronomistVendorService.jsonRepo->delete($agronomistVendorService.json->id);

        $this->assertTrue($resp);
        $this->assertNull(AgronomistVendorService.json::find($agronomistVendorService.json->id), 'AgronomistVendorService.json should not exist in DB');
    }
}
