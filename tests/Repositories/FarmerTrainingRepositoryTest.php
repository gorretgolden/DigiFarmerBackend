<?php namespace Tests\Repositories;

use App\Models\FarmerTraining;
use App\Repositories\FarmerTrainingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FarmerTrainingRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FarmerTrainingRepository
     */
    protected $farmerTrainingRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->farmerTrainingRepo = \App::make(FarmerTrainingRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->make()->toArray();

        $createdFarmerTraining = $this->farmerTrainingRepo->create($farmerTraining);

        $createdFarmerTraining = $createdFarmerTraining->toArray();
        $this->assertArrayHasKey('id', $createdFarmerTraining);
        $this->assertNotNull($createdFarmerTraining['id'], 'Created FarmerTraining must have id specified');
        $this->assertNotNull(FarmerTraining::find($createdFarmerTraining['id']), 'FarmerTraining with given id must be in DB');
        $this->assertModelData($farmerTraining, $createdFarmerTraining);
    }

    /**
     * @test read
     */
    public function test_read_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();

        $dbFarmerTraining = $this->farmerTrainingRepo->find($farmerTraining->id);

        $dbFarmerTraining = $dbFarmerTraining->toArray();
        $this->assertModelData($farmerTraining->toArray(), $dbFarmerTraining);
    }

    /**
     * @test update
     */
    public function test_update_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();
        $fakeFarmerTraining = FarmerTraining::factory()->make()->toArray();

        $updatedFarmerTraining = $this->farmerTrainingRepo->update($fakeFarmerTraining, $farmerTraining->id);

        $this->assertModelData($fakeFarmerTraining, $updatedFarmerTraining->toArray());
        $dbFarmerTraining = $this->farmerTrainingRepo->find($farmerTraining->id);
        $this->assertModelData($fakeFarmerTraining, $dbFarmerTraining->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_farmer_training()
    {
        $farmerTraining = FarmerTraining::factory()->create();

        $resp = $this->farmerTrainingRepo->delete($farmerTraining->id);

        $this->assertTrue($resp);
        $this->assertNull(FarmerTraining::find($farmerTraining->id), 'FarmerTraining should not exist in DB');
    }
}
