<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AnimalFeedSubCategory;

class AnimalFeedSubCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/animal_feed_sub_categories', $animalFeedSubCategory
        );

        $this->assertApiResponse($animalFeedSubCategory);
    }

    /**
     * @test
     */
    public function test_read_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/animal_feed_sub_categories/'.$animalFeedSubCategory->id
        );

        $this->assertApiResponse($animalFeedSubCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();
        $editedAnimalFeedSubCategory = AnimalFeedSubCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/animal_feed_sub_categories/'.$animalFeedSubCategory->id,
            $editedAnimalFeedSubCategory
        );

        $this->assertApiResponse($editedAnimalFeedSubCategory);
    }

    /**
     * @test
     */
    public function test_delete_animal_feed_sub_category()
    {
        $animalFeedSubCategory = AnimalFeedSubCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/animal_feed_sub_categories/'.$animalFeedSubCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/animal_feed_sub_categories/'.$animalFeedSubCategory->id
        );

        $this->response->assertStatus(404);
    }
}
