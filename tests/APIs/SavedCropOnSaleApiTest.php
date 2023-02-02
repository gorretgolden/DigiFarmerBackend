<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SavedCropOnSale;

class SavedCropOnSaleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/saved_crop_on_sales', $savedCropOnSale
        );

        $this->assertApiResponse($savedCropOnSale);
    }

    /**
     * @test
     */
    public function test_read_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/saved_crop_on_sales/'.$savedCropOnSale->id
        );

        $this->assertApiResponse($savedCropOnSale->toArray());
    }

    /**
     * @test
     */
    public function test_update_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();
        $editedSavedCropOnSale = SavedCropOnSale::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/saved_crop_on_sales/'.$savedCropOnSale->id,
            $editedSavedCropOnSale
        );

        $this->assertApiResponse($editedSavedCropOnSale);
    }

    /**
     * @test
     */
    public function test_delete_saved_crop_on_sale()
    {
        $savedCropOnSale = SavedCropOnSale::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/saved_crop_on_sales/'.$savedCropOnSale->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/saved_crop_on_sales/'.$savedCropOnSale->id
        );

        $this->response->assertStatus(404);
    }
}
