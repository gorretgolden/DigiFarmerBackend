<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AnimalFeedCategory;

class AnimalFeedCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/animal_feed_categories', $animalFeedCategory
        );

        $this->assertApiResponse($animalFeedCategory);
    }

    /**
     * @test
     */
    public function test_read_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/animal_feed_categories/'.$animalFeedCategory->id
        );

        $this->assertApiResponse($animalFeedCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();
        $editedAnimalFeedCategory = AnimalFeedCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/animal_feed_categories/'.$animalFeedCategory->id,
            $editedAnimalFeedCategory
        );

        $this->assertApiResponse($editedAnimalFeedCategory);
    }

    /**
     * @test
     */
    public function test_delete_animal_feed_category()
    {
        $animalFeedCategory = AnimalFeedCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/animal_feed_categories/'.$animalFeedCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/animal_feed_categories/'.$animalFeedCategory->id
        );

        $this->response->assertStatus(404);
    }
}
