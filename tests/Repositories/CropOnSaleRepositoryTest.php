<?php namespace Tests\Repositories;

use App\Models\CropOnSale;
use App\Repositories\CropOnSaleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropOnSaleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropOnSaleRepository
     */
    protected $cropOnSaleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropOnSaleRepo = \App::make(CropOnSaleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->make()->toArray();

        $createdCropOnSale = $this->cropOnSaleRepo->create($cropOnSale);

        $createdCropOnSale = $createdCropOnSale->toArray();
        $this->assertArrayHasKey('id', $createdCropOnSale);
        $this->assertNotNull($createdCropOnSale['id'], 'Created CropOnSale must have id specified');
        $this->assertNotNull(CropOnSale::find($createdCropOnSale['id']), 'CropOnSale with given id must be in DB');
        $this->assertModelData($cropOnSale, $createdCropOnSale);
    }

    /**
     * @test read
     */
    public function test_read_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();

        $dbCropOnSale = $this->cropOnSaleRepo->find($cropOnSale->id);

        $dbCropOnSale = $dbCropOnSale->toArray();
        $this->assertModelData($cropOnSale->toArray(), $dbCropOnSale);
    }

    /**
     * @test update
     */
    public function test_update_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();
        $fakeCropOnSale = CropOnSale::factory()->make()->toArray();

        $updatedCropOnSale = $this->cropOnSaleRepo->update($fakeCropOnSale, $cropOnSale->id);

        $this->assertModelData($fakeCropOnSale, $updatedCropOnSale->toArray());
        $dbCropOnSale = $this->cropOnSaleRepo->find($cropOnSale->id);
        $this->assertModelData($fakeCropOnSale, $dbCropOnSale->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_on_sale()
    {
        $cropOnSale = CropOnSale::factory()->create();

        $resp = $this->cropOnSaleRepo->delete($cropOnSale->id);

        $this->assertTrue($resp);
        $this->assertNull(CropOnSale::find($cropOnSale->id), 'CropOnSale should not exist in DB');
    }
}
