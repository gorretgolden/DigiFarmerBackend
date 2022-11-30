<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AnimalFeed;

class AnimalFeedApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/animal_feeds', $animalFeed
        );

        $this->assertApiResponse($animalFeed);
    }

    /**
     * @test
     */
    public function test_read_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/animal_feeds/'.$animalFeed->id
        );

        $this->assertApiResponse($animalFeed->toArray());
    }

    /**
     * @test
     */
    public function test_update_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();
        $editedAnimalFeed = AnimalFeed::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/animal_feeds/'.$animalFeed->id,
            $editedAnimalFeed
        );

        $this->assertApiResponse($editedAnimalFeed);
    }

    /**
     * @test
     */
    public function test_delete_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/animal_feeds/'.$animalFeed->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/animal_feeds/'.$animalFeed->id
        );

        $this->response->assertStatus(404);
    }
}
