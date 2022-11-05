<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Slider;

class SliderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_slider()
    {
        $slider = Slider::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sliders', $slider
        );

        $this->assertApiResponse($slider);
    }

    /**
     * @test
     */
    public function test_read_slider()
    {
        $slider = Slider::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/sliders/'.$slider->id
        );

        $this->assertApiResponse($slider->toArray());
    }

    /**
     * @test
     */
    public function test_update_slider()
    {
        $slider = Slider::factory()->create();
        $editedSlider = Slider::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sliders/'.$slider->id,
            $editedSlider
        );

        $this->assertApiResponse($editedSlider);
    }

    /**
     * @test
     */
    public function test_delete_slider()
    {
        $slider = Slider::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sliders/'.$slider->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sliders/'.$slider->id
        );

        $this->response->assertStatus(404);
    }
}
