<?php namespace Tests\Repositories;

use App\Models\Animal;
use App\Repositories\AnimalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnimalRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimalRepository
     */
    protected $animalRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animalRepo = \App::make(AnimalRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_animal()
    {
        $animal = Animal::factory()->make()->toArray();

        $createdAnimal = $this->animalRepo->create($animal);

        $createdAnimal = $createdAnimal->toArray();
        $this->assertArrayHasKey('id', $createdAnimal);
        $this->assertNotNull($createdAnimal['id'], 'Created Animal must have id specified');
        $this->assertNotNull(Animal::find($createdAnimal['id']), 'Animal with given id must be in DB');
        $this->assertModelData($animal, $createdAnimal);
    }

    /**
     * @test read
     */
    public function test_read_animal()
    {
        $animal = Animal::factory()->create();

        $dbAnimal = $this->animalRepo->find($animal->id);

        $dbAnimal = $dbAnimal->toArray();
        $this->assertModelData($animal->toArray(), $dbAnimal);
    }

    /**
     * @test update
     */
    public function test_update_animal()
    {
        $animal = Animal::factory()->create();
        $fakeAnimal = Animal::factory()->make()->toArray();

        $updatedAnimal = $this->animalRepo->update($fakeAnimal, $animal->id);

        $this->assertModelData($fakeAnimal, $updatedAnimal->toArray());
        $dbAnimal = $this->animalRepo->find($animal->id);
        $this->assertModelData($fakeAnimal, $dbAnimal->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_animal()
    {
        $animal = Animal::factory()->create();

        $resp = $this->animalRepo->delete($animal->id);

        $this->assertTrue($resp);
        $this->assertNull(Animal::find($animal->id), 'Animal should not exist in DB');
    }
}
