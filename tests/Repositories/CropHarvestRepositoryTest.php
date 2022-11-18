<?php namespace Tests\Repositories;

use App\Models\CropHarvest;
use App\Repositories\CropHarvestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropHarvestRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropHarvestRepository
     */
    protected $cropHarvestRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropHarvestRepo = \App::make(CropHarvestRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->make()->toArray();

        $createdCropHarvest = $this->cropHarvestRepo->create($cropHarvest);

        $createdCropHarvest = $createdCropHarvest->toArray();
        $this->assertArrayHasKey('id', $createdCropHarvest);
        $this->assertNotNull($createdCropHarvest['id'], 'Created CropHarvest must have id specified');
        $this->assertNotNull(CropHarvest::find($createdCropHarvest['id']), 'CropHarvest with given id must be in DB');
        $this->assertModelData($cropHarvest, $createdCropHarvest);
    }

    /**
     * @test read
     */
    public function test_read_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();

        $dbCropHarvest = $this->cropHarvestRepo->find($cropHarvest->id);

        $dbCropHarvest = $dbCropHarvest->toArray();
        $this->assertModelData($cropHarvest->toArray(), $dbCropHarvest);
    }

    /**
     * @test update
     */
    public function test_update_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();
        $fakeCropHarvest = CropHarvest::factory()->make()->toArray();

        $updatedCropHarvest = $this->cropHarvestRepo->update($fakeCropHarvest, $cropHarvest->id);

        $this->assertModelData($fakeCropHarvest, $updatedCropHarvest->toArray());
        $dbCropHarvest = $this->cropHarvestRepo->find($cropHarvest->id);
        $this->assertModelData($fakeCropHarvest, $dbCropHarvest->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_harvest()
    {
        $cropHarvest = CropHarvest::factory()->create();

        $resp = $this->cropHarvestRepo->delete($cropHarvest->id);

        $this->assertTrue($resp);
        $this->assertNull(CropHarvest::find($cropHarvest->id), 'CropHarvest should not exist in DB');
    }
}
