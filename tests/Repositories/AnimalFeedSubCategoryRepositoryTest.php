<?php namespace Tests\Repositories;

use App\Models\AnimalFeedSubCategory;
use App\Repositories\AnimalFeedSubCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnimalFeedSubCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimalFeedSubCategoryRepository
     */
    protected $animalFeedSubCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animalFeedSubCategoryRepo = \App::make(AnimalFeedSubCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->make()->toArray();

        $createdAnimalFeedSubCategory = $this->animalFeedSubCategoryRepo->create($animalFeedSubCategory);

        $createdAnimalFeedSubCategory = $createdAnimalFeedSubCategory->toArray();
        $this->assertArrayHasKey('id', $createdAnimalFeedSubCategory);
        $this->assertNotNull($createdAnimalFeedSubCategory['id'], 'Created AnimalFeedSubCategory must have id specified');
        $this->assertNotNull(AnimalFeedSubCategory::find($createdAnimalFeedSubCategory['id']), 'AnimalFeedSubCategory with given id must be in DB');
        $this->assertModelData($animalFeedSubCategory, $createdAnimalFeedSubCategory);
    }

    /**
     * @test read
     */
    public function test_read_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();

        $dbAnimalFeedSubCategory = $this->animalFeedSubCategoryRepo->find($animalFeedSubCategory->id);

        $dbAnimalFeedSubCategory = $dbAnimalFeedSubCategory->toArray();
        $this->assertModelData($animalFeedSubCategory->toArray(), $dbAnimalFeedSubCategory);
    }

    /**
     * @test update
     */
    public function test_update_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();
        $fakeAnimalFeedSubCategory = AnimalFeedSubCategory::factory()->make()->toArray();

        $updatedAnimalFeedSubCategory = $this->animalFeedSubCategoryRepo->update($fakeAnimalFeedSubCategory, $animalFeedSubCategory->id);

        $this->assertModelData($fakeAnimalFeedSubCategory, $updatedAnimalFeedSubCategory->toArray());
        $dbAnimalFeedSubCategory = $this->animalFeedSubCategoryRepo->find($animalFeedSubCategory->id);
        $this->assertModelData($fakeAnimalFeedSubCategory, $dbAnimalFeedSubCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();

        $resp = $this->animalFeedSubCategoryRepo->delete($animalFeedSubCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(AnimalFeedSubCategory::find($animalFeedSubCategory->id), 'AnimalFeedSubCategory should not exist in DB');
    }
}
