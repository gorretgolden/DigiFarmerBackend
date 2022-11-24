<?php namespace Tests\Repositories;

use App\Models\FarmerFinanceApplication;
use App\Repositories\FarmerFinanceApplicationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FarmerFinanceApplicationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FarmerFinanceApplicationRepository
     */
    protected $farmerFinanceApplicationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->farmerFinanceApplicationRepo = \App::make(FarmerFinanceApplicationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->make()->toArray();

        $createdFarmerFinanceApplication = $this->farmerFinanceApplicationRepo->create($farmerFinanceApplication);

        $createdFarmerFinanceApplication = $createdFarmerFinanceApplication->toArray();
        $this->assertArrayHasKey('id', $createdFarmerFinanceApplication);
        $this->assertNotNull($createdFarmerFinanceApplication['id'], 'Created FarmerFinanceApplication must have id specified');
        $this->assertNotNull(FarmerFinanceApplication::find($createdFarmerFinanceApplication['id']), 'FarmerFinanceApplication with given id must be in DB');
        $this->assertModelData($farmerFinanceApplication, $createdFarmerFinanceApplication);
    }

    /**
     * @test read
     */
    public function test_read_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();

        $dbFarmerFinanceApplication = $this->farmerFinanceApplicationRepo->find($farmerFinanceApplication->id);

        $dbFarmerFinanceApplication = $dbFarmerFinanceApplication->toArray();
        $this->assertModelData($farmerFinanceApplication->toArray(), $dbFarmerFinanceApplication);
    }

    /**
     * @test update
     */
    public function test_update_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();
        $fakeFarmerFinanceApplication = FarmerFinanceApplication::factory()->make()->toArray();

        $updatedFarmerFinanceApplication = $this->farmerFinanceApplicationRepo->update($fakeFarmerFinanceApplication, $farmerFinanceApplication->id);

        $this->assertModelData($fakeFarmerFinanceApplication, $updatedFarmerFinanceApplication->toArray());
        $dbFarmerFinanceApplication = $this->farmerFinanceApplicationRepo->find($farmerFinanceApplication->id);
        $this->assertModelData($fakeFarmerFinanceApplication, $dbFarmerFinanceApplication->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_farmer_finance_application()
    {
        $farmerFinanceApplication = FarmerFinanceApplication::factory()->create();

        $resp = $this->farmerFinanceApplicationRepo->delete($farmerFinanceApplication->id);

        $this->assertTrue($resp);
        $this->assertNull(FarmerFinanceApplication::find($farmerFinanceApplication->id), 'FarmerFinanceApplication should not exist in DB');
    }
}
