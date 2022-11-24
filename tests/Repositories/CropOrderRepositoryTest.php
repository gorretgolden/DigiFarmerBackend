<?php namespace Tests\Repositories;

use App\Models\CropOrder;
use App\Repositories\CropOrderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CropOrderRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CropOrderRepository
     */
    protected $cropOrderRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cropOrderRepo = \App::make(CropOrderRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_crop_order()
    {
        $cropOrder = CropOrder::factory()->make()->toArray();

        $createdCropOrder = $this->cropOrderRepo->create($cropOrder);

        $createdCropOrder = $createdCropOrder->toArray();
        $this->assertArrayHasKey('id', $createdCropOrder);
        $this->assertNotNull($createdCropOrder['id'], 'Created CropOrder must have id specified');
        $this->assertNotNull(CropOrder::find($createdCropOrder['id']), 'CropOrder with given id must be in DB');
        $this->assertModelData($cropOrder, $createdCropOrder);
    }

    /**
     * @test read
     */
    public function test_read_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();

        $dbCropOrder = $this->cropOrderRepo->find($cropOrder->id);

        $dbCropOrder = $dbCropOrder->toArray();
        $this->assertModelData($cropOrder->toArray(), $dbCropOrder);
    }

    /**
     * @test update
     */
    public function test_update_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();
        $fakeCropOrder = CropOrder::factory()->make()->toArray();

        $updatedCropOrder = $this->cropOrderRepo->update($fakeCropOrder, $cropOrder->id);

        $this->assertModelData($fakeCropOrder, $updatedCropOrder->toArray());
        $dbCropOrder = $this->cropOrderRepo->find($cropOrder->id);
        $this->assertModelData($fakeCropOrder, $dbCropOrder->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_crop_order()
    {
        $cropOrder = CropOrder::factory()->create();

        $resp = $this->cropOrderRepo->delete($cropOrder->id);

        $this->assertTrue($resp);
        $this->assertNull(CropOrder::find($cropOrder->id), 'CropOrder should not exist in DB');
    }
}
