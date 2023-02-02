<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\VeterinaryShedule;

class VeterinarySheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/veterinary_shedules', $veterinaryShedule
        );

        $this->assertApiResponse($veterinaryShedule);
    }

    /**
     * @test
     */
    public function test_read_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/veterinary_shedules/'.$veterinaryShedule->id
        );

        $this->assertApiResponse($veterinaryShedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();
        $editedVeterinaryShedule = VeterinaryShedule::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/veterinary_shedules/'.$veterinaryShedule->id,
            $editedVeterinaryShedule
        );

        $this->assertApiResponse($editedVeterinaryShedule);
    }

    /**
     * @test
     */
    public function test_delete_veterinary_shedule()
    {
        $veterinaryShedule = VeterinaryShedule::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/veterinary_shedules/'.$veterinaryShedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/veterinary_shedules/'.$veterinaryShedule->id
        );

        $this->response->assertStatus(404);
    }
}
