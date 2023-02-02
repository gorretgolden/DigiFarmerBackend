<?php namespace Tests\Repositories;

use App\Models\RentVendorCategory;
use App\Repositories\RentVendorCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RentVendorCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RentVendorCategoryRepository
     */
    protected $rentVendorCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->rentVendorCategoryRepo = \App::make(RentVendorCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->make()->toArray();

        $createdRentVendorCategory = $this->rentVendorCategoryRepo->create($rentVendorCategory);

        $createdRentVendorCategory = $createdRentVendorCategory->toArray();
        $this->assertArrayHasKey('id', $createdRentVendorCategory);
        $this->assertNotNull($createdRentVendorCategory['id'], 'Created RentVendorCategory must have id specified');
        $this->assertNotNull(RentVendorCategory::find($createdRentVendorCategory['id']), 'RentVendorCategory with given id must be in DB');
        $this->assertModelData($rentVendorCategory, $createdRentVendorCategory);
    }

    /**
     * @test read
     */
    public function test_read_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();

        $dbRentVendorCategory = $this->rentVendorCategoryRepo->find($rentVendorCategory->id);

        $dbRentVendorCategory = $dbRentVendorCategory->toArray();
        $this->assertModelData($rentVendorCategory->toArray(), $dbRentVendorCategory);
    }

    /**
     * @test update
     */
    public function test_update_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();
        $fakeRentVendorCategory = RentVendorCategory::factory()->make()->toArray();

        $updatedRentVendorCategory = $this->rentVendorCategoryRepo->update($fakeRentVendorCategory, $rentVendorCategory->id);

        $this->assertModelData($fakeRentVendorCategory, $updatedRentVendorCategory->toArray());
        $dbRentVendorCategory = $this->rentVendorCategoryRepo->find($rentVendorCategory->id);
        $this->assertModelData($fakeRentVendorCategory, $dbRentVendorCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_rent_vendor_category()
    {
        $rentVendorCategory = RentVendorCategory::factory()->create();

        $resp = $this->rentVendorCategoryRepo->delete($rentVendorCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(RentVendorCategory::find($rentVendorCategory->id), 'RentVendorCategory should not exist in DB');
    }
}
