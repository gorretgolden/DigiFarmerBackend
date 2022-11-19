<?php namespace Tests\Repositories;

use App\Models\CropBuyer;
use App\Repositories\CropBuyerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropBuyerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropBuyerRepository
     */
    protected $cropBuyerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropBuyerRepo = \App::make(CropBuyerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->make()->toArray();

        $createdCropBuyer = $this->cropBuyerRepo->create($cropBuyer);

        $createdCropBuyer = $createdCropBuyer->toArray();
        $this->assertArrayHasKey('id', $createdCropBuyer);
        $this->assertNotNull($createdCropBuyer['id'], 'Created CropBuyer must have id specified');
        $this->assertNotNull(CropBuyer::find($createdCropBuyer['id']), 'CropBuyer with given id must be in DB');
        $this->assertModelData($cropBuyer, $createdCropBuyer);
    }

    /**
     * @test read
     */
    public function test_read_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();

        $dbCropBuyer = $this->cropBuyerRepo->find($cropBuyer->id);

        $dbCropBuyer = $dbCropBuyer->toArray();
        $this->assertModelData($cropBuyer->toArray(), $dbCropBuyer);
    }

    /**
     * @test update
     */
    public function test_update_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();
        $fakeCropBuyer = CropBuyer::factory()->make()->toArray();

        $updatedCropBuyer = $this->cropBuyerRepo->update($fakeCropBuyer, $cropBuyer->id);

        $this->assertModelData($fakeCropBuyer, $updatedCropBuyer->toArray());
        $dbCropBuyer = $this->cropBuyerRepo->find($cropBuyer->id);
        $this->assertModelData($fakeCropBuyer, $dbCropBuyer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_buyer()
    {
        $cropBuyer = CropBuyer::factory()->create();

        $resp = $this->cropBuyerRepo->delete($cropBuyer->id);

        $this->assertTrue($resp);
        $this->assertNull(CropBuyer::find($cropBuyer->id), 'CropBuyer should not exist in DB');
    }
}
