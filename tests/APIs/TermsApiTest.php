<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Terms;

class TermsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_terms()
    {
        $terms = Terms::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/terms', $terms
        );

        $this->assertApiResponse($terms);
    }

    /**
     * @test
     */
    public function test_read_terms()
    {
        $terms = Terms::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/terms/'.$terms->id
        );

        $this->assertApiResponse($terms->toArray());
    }

    /**
     * @test
     */
    public function test_update_terms()
    {
        $terms = Terms::factory()->create();
        $editedTerms = Terms::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/terms/'.$terms->id,
            $editedTerms
        );

        $this->assertApiResponse($editedTerms);
    }

    /**
     * @test
     */
    public function test_delete_terms()
    {
        $terms = Terms::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/terms/'.$terms->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/terms/'.$terms->id
        );

        $this->response->assertStatus(404);
    }
}
