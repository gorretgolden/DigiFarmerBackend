<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Veterinary;

class VeterinaryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_veterinary()
    {
        $veterinary = Veterinary::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/veterinaries', $veterinary
        );

        $this->assertApiResponse($veterinary);
    }

    /**
     * @test
     */
    public function test_read_veterinary()
    {
        $veterinary = Veterinary::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/veterinaries/'.$veterinary->id
        );

        $this->assertApiResponse($veterinary->toArray());
    }

    /**
     * @test
     */
    public function test_update_veterinary()
    {
        $veterinary = Veterinary::factory()->create();
        $editedVeterinary = Veterinary::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/veterinaries/'.$veterinary->id,
            $editedVeterinary
        );

        $this->assertApiResponse($editedVeterinary);
    }

    /**
     * @test
     */
    public function test_delete_veterinary()
    {
        $veterinary = Veterinary::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/veterinaries/'.$veterinary->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/veterinaries/'.$veterinary->id
        );

        $this->response->assertStatus(404);
    }
}
