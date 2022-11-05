<?php namespace Tests\Repositories;

use App\Models\SellerProductCategory;
use App\Repositories\SellerProductCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SellerProductCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SellerProductCategoryRepository
     */
    protected $sellerProductCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sellerProductCategoryRepo = \App::make(SellerProductCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->make()->toArray();

        $createdSellerProductCategory = $this->sellerProductCategoryRepo->create($sellerProductCategory);

        $createdSellerProductCategory = $createdSellerProductCategory->toArray();
        $this->assertArrayHasKey('id', $createdSellerProductCategory);
        $this->assertNotNull($createdSellerProductCategory['id'], 'Created SellerProductCategory must have id specified');
        $this->assertNotNull(SellerProductCategory::find($createdSellerProductCategory['id']), 'SellerProductCategory with given id must be in DB');
        $this->assertModelData($sellerProductCategory, $createdSellerProductCategory);
    }

    /**
     * @test read
     */
    public function test_read_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();

        $dbSellerProductCategory = $this->sellerProductCategoryRepo->find($sellerProductCategory->id);

        $dbSellerProductCategory = $dbSellerProductCategory->toArray();
        $this->assertModelData($sellerProductCategory->toArray(), $dbSellerProductCategory);
    }

    /**
     * @test update
     */
    public function test_update_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();
        $fakeSellerProductCategory = SellerProductCategory::factory()->make()->toArray();

        $updatedSellerProductCategory = $this->sellerProductCategoryRepo->update($fakeSellerProductCategory, $sellerProductCategory->id);

        $this->assertModelData($fakeSellerProductCategory, $updatedSellerProductCategory->toArray());
        $dbSellerProductCategory = $this->sellerProductCategoryRepo->find($sellerProductCategory->id);
        $this->assertModelData($fakeSellerProductCategory, $dbSellerProductCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_seller_product_category()
    {
        $sellerProductCategory = SellerProductCategory::factory()->create();

        $resp = $this->sellerProductCategoryRepo->delete($sellerProductCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(SellerProductCategory::find($sellerProductCategory->id), 'SellerProductCategory should not exist in DB');
    }
}
