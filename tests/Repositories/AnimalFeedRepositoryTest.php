<?php namespace Tests\Repositories;

use App\Models\AnimalFeed;
use App\Repositories\AnimalFeedRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AnimalFeedRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AnimalFeedRepository
     */
    protected $animalFeedRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->animalFeedRepo = \App::make(AnimalFeedRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->make()->toArray();

        $createdAnimalFeed = $this->animalFeedRepo->create($animalFeed);

        $createdAnimalFeed = $createdAnimalFeed->toArray();
        $this->assertArrayHasKey('id', $createdAnimalFeed);
        $this->assertNotNull($createdAnimalFeed['id'], 'Created AnimalFeed must have id specified');
        $this->assertNotNull(AnimalFeed::find($createdAnimalFeed['id']), 'AnimalFeed with given id must be in DB');
        $this->assertModelData($animalFeed, $createdAnimalFeed);
    }

    /**
     * @test read
     */
    public function test_read_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();

        $dbAnimalFeed = $this->animalFeedRepo->find($animalFeed->id);

        $dbAnimalFeed = $dbAnimalFeed->toArray();
        $this->assertModelData($animalFeed->toArray(), $dbAnimalFeed);
    }

    /**
     * @test update
     */
    public function test_update_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();
        $fakeAnimalFeed = AnimalFeed::factory()->make()->toArray();

        $updatedAnimalFeed = $this->animalFeedRepo->update($fakeAnimalFeed, $animalFeed->id);

        $this->assertModelData($fakeAnimalFeed, $updatedAnimalFeed->toArray());
        $dbAnimalFeed = $this->animalFeedRepo->find($animalFeed->id);
        $this->assertModelData($fakeAnimalFeed, $dbAnimalFeed->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_animal_feed()
    {
        $animalFeed = AnimalFeed::factory()->create();

        $resp = $this->animalFeedRepo->delete($animalFeed->id);

        $this->assertTrue($resp);
        $this->assertNull(AnimalFeed::find($animalFeed->id), 'AnimalFeed should not exist in DB');
    }
}
