<?php namespace Tests\Repositories;

use App\Models\TrainingVendorService;
use App\Repositories\TrainingVendorServiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TrainingVendorServiceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TrainingVendorServiceRepository
     */
    protected $trainingVendorServiceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->trainingVendorServiceRepo = \App::make(TrainingVendorServiceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->make()->toArray();

        $createdTrainingVendorService = $this->trainingVendorServiceRepo->create($trainingVendorService);

        $createdTrainingVendorService = $createdTrainingVendorService->toArray();
        $this->assertArrayHasKey('id', $createdTrainingVendorService);
        $this->assertNotNull($createdTrainingVendorService['id'], 'Created TrainingVendorService must have id specified');
        $this->assertNotNull(TrainingVendorService::find($createdTrainingVendorService['id']), 'TrainingVendorService with given id must be in DB');
        $this->assertModelData($trainingVendorService, $createdTrainingVendorService);
    }

    /**
     * @test read
     */
    public function test_read_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();

        $dbTrainingVendorService = $this->trainingVendorServiceRepo->find($trainingVendorService->id);

        $dbTrainingVendorService = $dbTrainingVendorService->toArray();
        $this->assertModelData($trainingVendorService->toArray(), $dbTrainingVendorService);
    }

    /**
     * @test update
     */
    public function test_update_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();
        $fakeTrainingVendorService = TrainingVendorService::factory()->make()->toArray();

        $updatedTrainingVendorService = $this->trainingVendorServiceRepo->update($fakeTrainingVendorService, $trainingVendorService->id);

        $this->assertModelData($fakeTrainingVendorService, $updatedTrainingVendorService->toArray());
        $dbTrainingVendorService = $this->trainingVendorServiceRepo->find($trainingVendorService->id);
        $this->assertModelData($fakeTrainingVendorService, $dbTrainingVendorService->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_training_vendor_service()
    {
        $trainingVendorService = TrainingVendorService::factory()->create();

        $resp = $this->trainingVendorServiceRepo->delete($trainingVendorService->id);

        $this->assertTrue($resp);
        $this->assertNull(TrainingVendorService::find($trainingVendorService->id), 'TrainingVendorService should not exist in DB');
    }
}
