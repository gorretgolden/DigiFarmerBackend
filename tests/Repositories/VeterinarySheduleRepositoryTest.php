<?php namespace Tests\Repositories;

use App\Models\VeterinaryShedule;
use App\Repositories\VeterinarySheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VeterinarySheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VeterinarySheduleRepository
     */
    protected $veterinarySheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->veterinarySheduleRepo = \App::make(VeterinarySheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->make()->toArray();

        $createdVeterinaryShedule = $this->veterinarySheduleRepo->create($veterinaryShedule);

        $createdVeterinaryShedule = $createdVeterinaryShedule->toArray();
        $this->assertArrayHasKey('id', $createdVeterinaryShedule);
        $this->assertNotNull($createdVeterinaryShedule['id'], 'Created VeterinaryShedule must have id specified');
        $this->assertNotNull(VeterinaryShedule::find($createdVeterinaryShedule['id']), 'VeterinaryShedule with given id must be in DB');
        $this->assertModelData($veterinaryShedule, $createdVeterinaryShedule);
    }

    /**
     * @test read
     */
    public function test_read_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();

        $dbVeterinaryShedule = $this->veterinarySheduleRepo->find($veterinaryShedule->id);

        $dbVeterinaryShedule = $dbVeterinaryShedule->toArray();
        $this->assertModelData($veterinaryShedule->toArray(), $dbVeterinaryShedule);
    }

    /**
     * @test update
     */
    public function test_update_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();
        $fakeVeterinaryShedule = VeterinaryShedule::factory()->make()->toArray();

        $updatedVeterinaryShedule = $this->veterinarySheduleRepo->update($fakeVeterinaryShedule, $veterinaryShedule->id);

        $this->assertModelData($fakeVeterinaryShedule, $updatedVeterinaryShedule->toArray());
        $dbVeterinaryShedule = $this->veterinarySheduleRepo->find($veterinaryShedule->id);
        $this->assertModelData($fakeVeterinaryShedule, $dbVeterinaryShedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();

        $resp = $this->veterinarySheduleRepo->delete($veterinaryShedule->id);

        $this->assertTrue($resp);
        $this->assertNull(VeterinaryShedule::find($veterinaryShedule->id), 'VeterinaryShedule should not exist in DB');
    }
}
