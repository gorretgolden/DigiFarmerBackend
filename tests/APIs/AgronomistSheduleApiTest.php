<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AgronomistShedule;

class AgronomistSheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/agronomist_shedules', $agronomistShedule
        );

        $this->assertApiResponse($agronomistShedule);
    }

    /**
     * @test
     */
    public function test_read_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/agronomist_shedules/'.$agronomistShedule->id
        );

        $this->assertApiResponse($agronomistShedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();
        $editedAgronomistShedule = AgronomistShedule::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/agronomist_shedules/'.$agronomistShedule->id,
            $editedAgronomistShedule
        );

        $this->assertApiResponse($editedAgronomistShedule);
    }

    /**
     * @test
     */
    public function test_delete_agronomist_shedule()
    {
        $agronomistShedule = AgronomistShedule::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/agronomist_shedules/'.$agronomistShedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/agronomist_shedules/'.$agronomistShedule->id
        );

        $this->response->assertStatus(404);
    }
}
