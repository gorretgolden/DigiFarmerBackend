<?php namespace Tests\Repositories;

use App\Models\VendorCategory;
use App\Repositories\VendorCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VendorCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VendorCategoryRepository
     */
    protected $vendorCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->vendorCategoryRepo = \App::make(VendorCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->make()->toArray();

        $createdVendorCategory = $this->vendorCategoryRepo->create($vendorCategory);

        $createdVendorCategory = $createdVendorCategory->toArray();
        $this->assertArrayHasKey('id', $createdVendorCategory);
        $this->assertNotNull($createdVendorCategory['id'], 'Created VendorCategory must have id specified');
        $this->assertNotNull(VendorCategory::find($createdVendorCategory['id']), 'VendorCategory with given id must be in DB');
        $this->assertModelData($vendorCategory, $createdVendorCategory);
    }

    /**
     * @test read
     */
    public function test_read_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();

        $dbVendorCategory = $this->vendorCategoryRepo->find($vendorCategory->id);

        $dbVendorCategory = $dbVendorCategory->toArray();
        $this->assertModelData($vendorCategory->toArray(), $dbVendorCategory);
    }

    /**
     * @test update
     */
    public function test_update_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();
        $fakeVendorCategory = VendorCategory::factory()->make()->toArray();

        $updatedVendorCategory = $this->vendorCategoryRepo->update($fakeVendorCategory, $vendorCategory->id);

        $this->assertModelData($fakeVendorCategory, $updatedVendorCategory->toArray());
        $dbVendorCategory = $this->vendorCategoryRepo->find($vendorCategory->id);
        $this->assertModelData($fakeVendorCategory, $dbVendorCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_vendor_category()
    {
        $vendorCategory = VendorCategory::factory()->create();

        $resp = $this->vendorCategoryRepo->delete($vendorCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(VendorCategory::find($vendorCategory->id), 'VendorCategory should not exist in DB');
    }
}
