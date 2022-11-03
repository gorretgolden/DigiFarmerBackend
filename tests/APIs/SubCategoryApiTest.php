<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SubCategory;

class SubCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sub_category()
    {
        $subCategory = SubCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sub_categories', $subCategory
        );

        $this->assertApiResponse($subCategory);
    }

    /**
     * @test
     */
    public function test_read_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/sub_categories/'.$subCategory->id
        );

        $this->assertApiResponse($subCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_sub_category()
    {
        $subCategory = SubCategory::factory()->create();
        $editedSubCategory = SubCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sub_categories/'.$subCategory->id,
            $editedSubCategory
        );

        $this->assertApiResponse($editedSubCategory);
    }

    /**
     * @test
     */
    public function test_delete_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sub_categories/'.$subCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sub_categories/'.$subCategory->id
        );

        $this->response->assertStatus(404);
    }
}
