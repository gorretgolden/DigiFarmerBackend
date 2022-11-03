<?php namespace Tests\Repositories;

use App\Models\Crop;
use App\Repositories\CropRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropRepository
     */
    protected $cropRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropRepo = \App::make(CropRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop()
    {
        $crop = Crop::factory()->make()->toArray();

        $createdCrop = $this->cropRepo->create($crop);

        $createdCrop = $createdCrop->toArray();
        $this->assertArrayHasKey('id', $createdCrop);
        $this->assertNotNull($createdCrop['id'], 'Created Crop must have id specified');
        $this->assertNotNull(Crop::find($createdCrop['id']), 'Crop with given id must be in DB');
        $this->assertModelData($crop, $createdCrop);
    }

    /**
     * @test read
     */
    public function test_read_crop()
    {
        $crop = Crop::factory()->create();

        $dbCrop = $this->cropRepo->find($crop->id);

        $dbCrop = $dbCrop->toArray();
        $this->assertModelData($crop->toArray(), $dbCrop);
    }

    /**
     * @test update
     */
    public function test_update_crop()
    {
        $crop = Crop::factory()->create();
        $fakeCrop = Crop::factory()->make()->toArray();

        $updatedCrop = $this->cropRepo->update($fakeCrop, $crop->id);

        $this->assertModelData($fakeCrop, $updatedCrop->toArray());
        $dbCrop = $this->cropRepo->find($crop->id);
        $this->assertModelData($fakeCrop, $dbCrop->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop()
    {
        $crop = Crop::factory()->create();

        $resp = $this->cropRepo->delete($crop->id);

        $this->assertTrue($resp);
        $this->assertNull(Crop::find($crop->id), 'Crop should not exist in DB');
    }
}
