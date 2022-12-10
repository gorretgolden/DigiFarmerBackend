<?php namespace Tests\Repositories;

use App\Models\AnimalCategory;
use App\Repositories\AnimalCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnimalCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimalCategoryRepository
     */
    protected $animalCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animalCategoryRepo = \App::make(AnimalCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->make()->toArray();

        $createdAnimalCategory = $this->animalCategoryRepo->create($animalCategory);

        $createdAnimalCategory = $createdAnimalCategory->toArray();
        $this->assertArrayHasKey('id', $createdAnimalCategory);
        $this->assertNotNull($createdAnimalCategory['id'], 'Created AnimalCategory must have id specified');
        $this->assertNotNull(AnimalCategory::find($createdAnimalCategory['id']), 'AnimalCategory with given id must be in DB');
        $this->assertModelData($animalCategory, $createdAnimalCategory);
    }

    /**
     * @test read
     */
    public function test_read_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();

        $dbAnimalCategory = $this->animalCategoryRepo->find($animalCategory->id);

        $dbAnimalCategory = $dbAnimalCategory->toArray();
        $this->assertModelData($animalCategory->toArray(), $dbAnimalCategory);
    }

    /**
     * @test update
     */
    public function test_update_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();
        $fakeAnimalCategory = AnimalCategory::factory()->make()->toArray();

        $updatedAnimalCategory = $this->animalCategoryRepo->update($fakeAnimalCategory, $animalCategory->id);

        $this->assertModelData($fakeAnimalCategory, $updatedAnimalCategory->toArray());
        $dbAnimalCategory = $this->animalCategoryRepo->find($animalCategory->id);
        $this->assertModelData($fakeAnimalCategory, $dbAnimalCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();

        $resp = $this->animalCategoryRepo->delete($animalCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(AnimalCategory::find($animalCategory->id), 'AnimalCategory should not exist in DB');
    }
}
