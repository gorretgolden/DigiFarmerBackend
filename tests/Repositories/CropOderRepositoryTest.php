<?php namespace Tests\Repositories;

use App\Models\CropOder;
use App\Repositories\CropOderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropOderRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropOderRepository
     */
    protected $cropOderRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropOderRepo = \App::make(CropOderRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_oder()
    {
        $cropOder = CropOder::factory()->make()->toArray();

        $createdCropOder = $this->cropOderRepo->create($cropOder);

        $createdCropOder = $createdCropOder->toArray();
        $this->assertArrayHasKey('id', $createdCropOder);
        $this->assertNotNull($createdCropOder['id'], 'Created CropOder must have id specified');
        $this->assertNotNull(CropOder::find($createdCropOder['id']), 'CropOder with given id must be in DB');
        $this->assertModelData($cropOder, $createdCropOder);
    }

    /**
     * @test read
     */
    public function test_read_crop_oder()
    {
        $cropOder = CropOder::factory()->create();

        $dbCropOder = $this->cropOderRepo->find($cropOder->id);

        $dbCropOder = $dbCropOder->toArray();
        $this->assertModelData($cropOder->toArray(), $dbCropOder);
    }

    /**
     * @test update
     */
    public function test_update_crop_oder()
    {
        $cropOder = CropOder::factory()->create();
        $fakeCropOder = CropOder::factory()->make()->toArray();

        $updatedCropOder = $this->cropOderRepo->update($fakeCropOder, $cropOder->id);

        $this->assertModelData($fakeCropOder, $updatedCropOder->toArray());
        $dbCropOder = $this->cropOderRepo->find($cropOder->id);
        $this->assertModelData($fakeCropOder, $dbCropOder->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_oder()
    {
        $cropOder = CropOder::factory()->create();

        $resp = $this->cropOderRepo->delete($cropOder->id);

        $this->assertTrue($resp);
        $this->assertNull(CropOder::find($cropOder->id), 'CropOder should not exist in DB');
    }
}
