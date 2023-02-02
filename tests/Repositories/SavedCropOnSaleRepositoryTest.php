<?php namespace Tests\Repositories;

use App\Models\SavedCropOnSale;
use App\Repositories\SavedCropOnSaleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SavedCropOnSaleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SavedCropOnSaleRepository
     */
    protected $savedCropOnSaleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->savedCropOnSaleRepo = \App::make(SavedCropOnSaleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->make()->toArray();

        $createdSavedCropOnSale = $this->savedCropOnSaleRepo->create($savedCropOnSale);

        $createdSavedCropOnSale = $createdSavedCropOnSale->toArray();
        $this->assertArrayHasKey('id', $createdSavedCropOnSale);
        $this->assertNotNull($createdSavedCropOnSale['id'], 'Created SavedCropOnSale must have id specified');
        $this->assertNotNull(SavedCropOnSale::find($createdSavedCropOnSale['id']), 'SavedCropOnSale with given id must be in DB');
        $this->assertModelData($savedCropOnSale, $createdSavedCropOnSale);
    }

    /**
     * @test read
     */
    public function test_read_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();

        $dbSavedCropOnSale = $this->savedCropOnSaleRepo->find($savedCropOnSale->id);

        $dbSavedCropOnSale = $dbSavedCropOnSale->toArray();
        $this->assertModelData($savedCropOnSale->toArray(), $dbSavedCropOnSale);
    }

    /**
     * @test update
     */
    public function test_update_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();
        $fakeSavedCropOnSale = SavedCropOnSale::factory()->make()->toArray();

        $updatedSavedCropOnSale = $this->savedCropOnSaleRepo->update($fakeSavedCropOnSale, $savedCropOnSale->id);

        $this->assertModelData($fakeSavedCropOnSale, $updatedSavedCropOnSale->toArray());
        $dbSavedCropOnSale = $this->savedCropOnSaleRepo->find($savedCropOnSale->id);
        $this->assertModelData($fakeSavedCropOnSale, $dbSavedCropOnSale->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();

        $resp = $this->savedCropOnSaleRepo->delete($savedCropOnSale->id);

        $this->assertTrue($resp);
        $this->assertNull(SavedCropOnSale::find($savedCropOnSale->id), 'SavedCropOnSale should not exist in DB');
    }
}
