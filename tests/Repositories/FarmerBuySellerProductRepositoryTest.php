<?php namespace Tests\Repositories;

use App\Models\FarmerBuySellerProduct;
use App\Repositories\FarmerBuySellerProductRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FarmerBuySellerProductRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FarmerBuySellerProductRepository
     */
    protected $farmerBuySellerProductRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->farmerBuySellerProductRepo = \App::make(FarmerBuySellerProductRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->make()->toArray();

        $createdFarmerBuySellerProduct = $this->farmerBuySellerProductRepo->create($farmerBuySellerProduct);

        $createdFarmerBuySellerProduct = $createdFarmerBuySellerProduct->toArray();
        $this->assertArrayHasKey('id', $createdFarmerBuySellerProduct);
        $this->assertNotNull($createdFarmerBuySellerProduct['id'], 'Created FarmerBuySellerProduct must have id specified');
        $this->assertNotNull(FarmerBuySellerProduct::find($createdFarmerBuySellerProduct['id']), 'FarmerBuySellerProduct with given id must be in DB');
        $this->assertModelData($farmerBuySellerProduct, $createdFarmerBuySellerProduct);
    }

    /**
     * @test read
     */
    public function test_read_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();

        $dbFarmerBuySellerProduct = $this->farmerBuySellerProductRepo->find($farmerBuySellerProduct->id);

        $dbFarmerBuySellerProduct = $dbFarmerBuySellerProduct->toArray();
        $this->assertModelData($farmerBuySellerProduct->toArray(), $dbFarmerBuySellerProduct);
    }

    /**
     * @test update
     */
    public function test_update_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();
        $fakeFarmerBuySellerProduct = FarmerBuySellerProduct::factory()->make()->toArray();

        $updatedFarmerBuySellerProduct = $this->farmerBuySellerProductRepo->update($fakeFarmerBuySellerProduct, $farmerBuySellerProduct->id);

        $this->assertModelData($fakeFarmerBuySellerProduct, $updatedFarmerBuySellerProduct->toArray());
        $dbFarmerBuySellerProduct = $this->farmerBuySellerProductRepo->find($farmerBuySellerProduct->id);
        $this->assertModelData($fakeFarmerBuySellerProduct, $dbFarmerBuySellerProduct->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_farmer_buy_seller_product()
    {
        $farmerBuySellerProduct = FarmerBuySellerProduct::factory()->create();

        $resp = $this->farmerBuySellerProductRepo->delete($farmerBuySellerProduct->id);

        $this->assertTrue($resp);
        $this->assertNull(FarmerBuySellerProduct::find($farmerBuySellerProduct->id), 'FarmerBuySellerProduct should not exist in DB');
    }
}
