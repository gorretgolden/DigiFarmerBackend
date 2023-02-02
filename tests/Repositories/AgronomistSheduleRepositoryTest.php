<?php namespace Tests\Repositories;

use App\Models\AgronomistShedule;
use App\Repositories\AgronomistSheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AgronomistSheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AgronomistSheduleRepository
     */
    protected $agronomistSheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->agronomistSheduleRepo = \App::make(AgronomistSheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->make()->toArray();

        $createdAgronomistShedule = $this->agronomistSheduleRepo->create($agronomistShedule);

        $createdAgronomistShedule = $createdAgronomistShedule->toArray();
        $this->assertArrayHasKey('id', $createdAgronomistShedule);
        $this->assertNotNull($createdAgronomistShedule['id'], 'Created AgronomistShedule must have id specified');
        $this->assertNotNull(AgronomistShedule::find($createdAgronomistShedule['id']), 'AgronomistShedule with given id must be in DB');
        $this->assertModelData($agronomistShedule, $createdAgronomistShedule);
    }

    /**
     * @test read
     */
    public function test_read_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();

        $dbAgronomistShedule = $this->agronomistSheduleRepo->find($agronomistShedule->id);

        $dbAgronomistShedule = $dbAgronomistShedule->toArray();
        $this->assertModelData($agronomistShedule->toArray(), $dbAgronomistShedule);
    }

    /**
     * @test update
     */
    public function test_update_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();
        $fakeAgronomistShedule = AgronomistShedule::factory()->make()->toArray();

        $updatedAgronomistShedule = $this->agronomistSheduleRepo->update($fakeAgronomistShedule, $agronomistShedule->id);

        $this->assertModelData($fakeAgronomistShedule, $updatedAgronomistShedule->toArray());
        $dbAgronomistShedule = $this->agronomistSheduleRepo->find($agronomistShedule->id);
        $this->assertModelData($fakeAgronomistShedule, $dbAgronomistShedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();

        $resp = $this->agronomistSheduleRepo->delete($agronomistShedule->id);

        $this->assertTrue($resp);
        $this->assertNull(AgronomistShedule::find($agronomistShedule->id), 'AgronomistShedule should not exist in DB');
    }
}
