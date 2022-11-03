<?php namespace Tests\Repositories;

use App\Models\SubCategory;
use App\Repositories\SubCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SubCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubCategoryRepository
     */
    protected $subCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->subCategoryRepo = \App::make(SubCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sub_category()
    {
        $subCategory = SubCategory::factory()->make()->toArray();

        $createdSubCategory = $this->subCategoryRepo->create($subCategory);

        $createdSubCategory = $createdSubCategory->toArray();
        $this->assertArrayHasKey('id', $createdSubCategory);
        $this->assertNotNull($createdSubCategory['id'], 'Created SubCategory must have id specified');
        $this->assertNotNull(SubCategory::find($createdSubCategory['id']), 'SubCategory with given id must be in DB');
        $this->assertModelData($subCategory, $createdSubCategory);
    }

    /**
     * @test read
     */
    public function test_read_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $dbSubCategory = $this->subCategoryRepo->find($subCategory->id);

        $dbSubCategory = $dbSubCategory->toArray();
        $this->assertModelData($subCategory->toArray(), $dbSubCategory);
    }

    /**
     * @test update
     */
    public function test_update_sub_category()
    {
        $subCategory = SubCategory::factory()->create();
        $fakeSubCategory = SubCategory::factory()->make()->toArray();

        $updatedSubCategory = $this->subCategoryRepo->update($fakeSubCategory, $subCategory->id);

        $this->assertModelData($fakeSubCategory, $updatedSubCategory->toArray());
        $dbSubCategory = $this->subCategoryRepo->find($subCategory->id);
        $this->assertModelData($fakeSubCategory, $dbSubCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $resp = $this->subCategoryRepo->delete($subCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(SubCategory::find($subCategory->id), 'SubCategory should not exist in DB');
    }
}
