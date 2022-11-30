<?php namespace Tests\Repositories;

use App\Models\AnimalFeedCategory;
use App\Repositories\AnimalFeedCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnimalFeedCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimalFeedCategoryRepository
     */
    protected $animalFeedCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animalFeedCategoryRepo = \App::make(AnimalFeedCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->make()->toArray();

        $createdAnimalFeedCategory = $this->animalFeedCategoryRepo->create($animalFeedCategory);

        $createdAnimalFeedCategory = $createdAnimalFeedCategory->toArray();
        $this->assertArrayHasKey('id', $createdAnimalFeedCategory);
        $this->assertNotNull($createdAnimalFeedCategory['id'], 'Created AnimalFeedCategory must have id specified');
        $this->assertNotNull(AnimalFeedCategory::find($createdAnimalFeedCategory['id']), 'AnimalFeedCategory with given id must be in DB');
        $this->assertModelData($animalFeedCategory, $createdAnimalFeedCategory);
    }

    /**
     * @test read
     */
    public function test_read_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();

        $dbAnimalFeedCategory = $this->animalFeedCategoryRepo->find($animalFeedCategory->id);

        $dbAnimalFeedCategory = $dbAnimalFeedCategory->toArray();
        $this->assertModelData($animalFeedCategory->toArray(), $dbAnimalFeedCategory);
    }

    /**
     * @test update
     */
    public function test_update_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();
        $fakeAnimalFeedCategory = AnimalFeedCategory::factory()->make()->toArray();

        $updatedAnimalFeedCategory = $this->animalFeedCategoryRepo->update($fakeAnimalFeedCategory, $animalFeedCategory->id);

        $this->assertModelData($fakeAnimalFeedCategory, $updatedAnimalFeedCategory->toArray());
        $dbAnimalFeedCategory = $this->animalFeedCategoryRepo->find($animalFeedCategory->id);
        $this->assertModelData($fakeAnimalFeedCategory, $dbAnimalFeedCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();

        $resp = $this->animalFeedCategoryRepo->delete($animalFeedCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(AnimalFeedCategory::find($animalFeedCategory->id), 'AnimalFeedCategory should not exist in DB');
    }
}
