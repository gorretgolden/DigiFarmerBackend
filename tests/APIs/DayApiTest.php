<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Day;

class DayApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_day()
    {
        $day = Day::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/days', $day
        );

        $this->assertApiResponse($day);
    }

    /**
     * @test
     */
    public function test_read_day()
    {
        $day = Day::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/days/'.$day->id
        );

        $this->assertApiResponse($day->toArray());
    }

    /**
     * @test
     */
    public function test_update_day()
    {
        $day = Day::factory()->create();
        $editedDay = Day::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/days/'.$day->id,
            $editedDay
        );

        $this->assertApiResponse($editedDay);
    }

    /**
     * @test
     */
    public function test_delete_day()
    {
        $day = Day::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/days/'.$day->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/days/'.$day->id
        );

        $this->response->assertStatus(404);
    }
}
