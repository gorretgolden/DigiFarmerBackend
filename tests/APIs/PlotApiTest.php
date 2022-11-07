<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Plot;

class PlotApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_plot()
    {
        $plot = Plot::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/plots', $plot
        );

        $this->assertApiResponse($plot);
    }

    /**
     * @test
     */
    public function test_read_plot()
    {
        $plot = Plot::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/plots/'.$plot->id
        );

        $this->assertApiResponse($plot->toArray());
    }

    /**
     * @test
     */
    public function test_update_plot()
    {
        $plot = Plot::factory()->create();
        $editedPlot = Plot::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/plots/'.$plot->id,
            $editedPlot
        );

        $this->assertApiResponse($editedPlot);
    }

    /**
     * @test
     */
    public function test_delete_plot()
    {
        $plot = Plot::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/plots/'.$plot->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/plots/'.$plot->id
        );

        $this->response->assertStatus(404);
    }
}
