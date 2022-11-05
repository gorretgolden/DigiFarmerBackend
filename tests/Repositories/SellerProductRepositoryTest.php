<?php namespace Tests\Repositories;

use App\Models\SellerProduct;
use App\Repositories\SellerProductRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SellerProductRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SellerProductRepository
     */
    protected $sellerProductRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->sellerProductRepo = \App::make(SellerProductRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->make()->toArray();

        $createdSellerProduct = $this->sellerProductRepo->create($sellerProduct);

        $createdSellerProduct = $createdSellerProduct->toArray();
        $this->assertArrayHasKey('id', $createdSellerProduct);
        $this->assertNotNull($createdSellerProduct['id'], 'Created SellerProduct must have id specified');
        $this->assertNotNull(SellerProduct::find($createdSellerProduct['id']), 'SellerProduct with given id must be in DB');
        $this->assertModelData($sellerProduct, $createdSellerProduct);
    }

    /**
     * @test read
     */
    public function test_read_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();

        $dbSellerProduct = $this->sellerProductRepo->find($sellerProduct->id);

        $dbSellerProduct = $dbSellerProduct->toArray();
        $this->assertModelData($sellerProduct->toArray(), $dbSellerProduct);
    }

    /**
     * @test update
     */
    public function test_update_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();
        $fakeSellerProduct = SellerProduct::factory()->make()->toArray();

        $updatedSellerProduct = $this->sellerProductRepo->update($fakeSellerProduct, $sellerProduct->id);

        $this->assertModelData($fakeSellerProduct, $updatedSellerProduct->toArray());
        $dbSellerProduct = $this->sellerProductRepo->find($sellerProduct->id);
        $this->assertModelData($fakeSellerProduct, $dbSellerProduct->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_seller_product()
    {
        $sellerProduct = SellerProduct::factory()->create();

        $resp = $this->sellerProductRepo->delete($sellerProduct->id);

        $this->assertTrue($resp);
        $this->assertNull(SellerProduct::find($sellerProduct->id), 'SellerProduct should not exist in DB');
    }
}
