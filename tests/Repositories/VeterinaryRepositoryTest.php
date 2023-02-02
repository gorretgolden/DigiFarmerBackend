<?php namespace Tests\Repositories;

use App\Models\Veterinary;
use App\Repositories\VeterinaryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VeterinaryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VeterinaryRepository
     */
    protected $veterinaryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->veterinaryRepo = \App::make(VeterinaryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_veterinary()
    {
        $veterinary = Veterinary::factory()->make()->toArray();

        $createdVeterinary = $this->veterinaryRepo->create($veterinary);

        $createdVeterinary = $createdVeterinary->toArray();
        $this->assertArrayHasKey('id', $createdVeterinary);
        $this->assertNotNull($createdVeterinary['id'], 'Created Veterinary must have id specified');
        $this->assertNotNull(Veterinary::find($createdVeterinary['id']), 'Veterinary with given id must be in DB');
        $this->assertModelData($veterinary, $createdVeterinary);
    }

    /**
     * @test read
     */
    public function test_read_veterinary()
    {
        $veterinary = Veterinary::factory()->create();

        $dbVeterinary = $this->veterinaryRepo->find($veterinary->id);

        $dbVeterinary = $dbVeterinary->toArray();
        $this->assertModelData($veterinary->toArray(), $dbVeterinary);
    }

    /**
     * @test update
     */
    public function test_update_veterinary()
    {
        $veterinary = Veterinary::factory()->create();
        $fakeVeterinary = Veterinary::factory()->make()->toArray();

        $updatedVeterinary = $this->veterinaryRepo->update($fakeVeterinary, $veterinary->id);

        $this->assertModelData($fakeVeterinary, $updatedVeterinary->toArray());
        $dbVeterinary = $this->veterinaryRepo->find($veterinary->id);
        $this->assertModelData($fakeVeterinary, $dbVeterinary->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_veterinary()
    {
        $veterinary = Veterinary::factory()->create();

        $resp = $this->veterinaryRepo->delete($veterinary->id);

        $this->assertTrue($resp);
        $this->assertNull(Veterinary::find($veterinary->id), 'Veterinary should not exist in DB');
    }
}
