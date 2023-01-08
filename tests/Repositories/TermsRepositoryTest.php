<?php namespace Tests\Repositories;

use App\Models\Terms;
use App\Repositories\TermsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TermsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TermsRepository
     */
    protected $termsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->termsRepo = \App::make(TermsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_terms()
    {
        $terms = Terms::factory()->make()->toArray();

        $createdTerms = $this->termsRepo->create($terms);

        $createdTerms = $createdTerms->toArray();
        $this->assertArrayHasKey('id', $createdTerms);
        $this->assertNotNull($createdTerms['id'], 'Created Terms must have id specified');
        $this->assertNotNull(Terms::find($createdTerms['id']), 'Terms with given id must be in DB');
        $this->assertModelData($terms, $createdTerms);
    }

    /**
     * @test read
     */
    public function test_read_terms()
    {
        $terms = Terms::factory()->create();

        $dbTerms = $this->termsRepo->find($terms->id);

        $dbTerms = $dbTerms->toArray();
        $this->assertModelData($terms->toArray(), $dbTerms);
    }

    /**
     * @test update
     */
    public function test_update_terms()
    {
        $terms = Terms::factory()->create();
        $fakeTerms = Terms::factory()->make()->toArray();

        $updatedTerms = $this->termsRepo->update($fakeTerms, $terms->id);

        $this->assertModelData($fakeTerms, $updatedTerms->toArray());
        $dbTerms = $this->termsRepo->find($terms->id);
        $this->assertModelData($fakeTerms, $dbTerms->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_terms()
    {
        $terms = Terms::factory()->create();

        $resp = $this->termsRepo->delete($terms->id);

        $this->assertTrue($resp);
        $this->assertNull(Terms::find($terms->id), 'Terms should not exist in DB');
    }
}
