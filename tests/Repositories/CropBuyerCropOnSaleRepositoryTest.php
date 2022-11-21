<?php namespace Tests\Repositories;

use App\Models\CropBuyerCropOnSale;
use App\Repositories\CropBuyerCropOnSaleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropBuyerCropOnSaleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropBuyerCropOnSaleRepository
     */
    protected $cropBuyerCropOnSaleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropBuyerCropOnSaleRepo = \App::make(CropBuyerCropOnSaleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->make()->toArray();

        $createdCropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepo->create($cropBuyerCropOnSale);

        $createdCropBuyerCropOnSale = $createdCropBuyerCropOnSale->toArray();
        $this->assertArrayHasKey('id', $createdCropBuyerCropOnSale);
        $this->assertNotNull($createdCropBuyerCropOnSale['id'], 'Created CropBuyerCropOnSale must have id specified');
        $this->assertNotNull(CropBuyerCropOnSale::find($createdCropBuyerCropOnSale['id']), 'CropBuyerCropOnSale with given id must be in DB');
        $this->assertModelData($cropBuyerCropOnSale, $createdCropBuyerCropOnSale);
    }

    /**
     * @test read
     */
    public function test_read_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();

        $dbCropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepo->find($cropBuyerCropOnSale->id);

        $dbCropBuyerCropOnSale = $dbCropBuyerCropOnSale->toArray();
        $this->assertModelData($cropBuyerCropOnSale->toArray(), $dbCropBuyerCropOnSale);
    }

    /**
     * @test update
     */
    public function test_update_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();
        $fakeCropBuyerCropOnSale = CropBuyerCropOnSale::factory()->make()->toArray();

        $updatedCropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepo->update($fakeCropBuyerCropOnSale, $cropBuyerCropOnSale->id);

        $this->assertModelData($fakeCropBuyerCropOnSale, $updatedCropBuyerCropOnSale->toArray());
        $dbCropBuyerCropOnSale = $this->cropBuyerCropOnSaleRepo->find($cropBuyerCropOnSale->id);
        $this->assertModelData($fakeCropBuyerCropOnSale, $dbCropBuyerCropOnSale->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_buyer_crop_on_sale()
    {
        $cropBuyerCropOnSale = CropBuyerCropOnSale::factory()->create();

        $resp = $this->cropBuyerCropOnSaleRepo->delete($cropBuyerCropOnSale->id);

        $this->assertTrue($resp);
        $this->assertNull(CropBuyerCropOnSale::find($cropBuyerCropOnSale->id), 'CropBuyerCropOnSale should not exist in DB');
    }
}
