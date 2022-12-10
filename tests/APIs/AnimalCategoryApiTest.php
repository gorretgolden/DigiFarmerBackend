<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AnimalCategory;

class AnimalCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/animal_categories', $animalCategory
        );

        $this->assertApiResponse($animalCategory);
    }

    /**
     * @test
     */
    public function test_read_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/animal_categories/'.$animalCategory->id
        );

        $this->assertApiResponse($animalCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();
        $editedAnimalCategory = AnimalCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/animal_categories/'.$animalCategory->id,
            $editedAnimalCategory
        );

        $this->assertApiResponse($editedAnimalCategory);
    }

    /**
     * @test
     */
    public function test_delete_animal_category()
    {
        $animalCategory = AnimalCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/animal_categories/'.$animalCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/animal_categories/'.$animalCategory->id
        );

        $this->response->assertStatus(404);
    }
}
