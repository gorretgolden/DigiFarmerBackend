<?php namespace Tests\Repositories;

use App\Models\FaqCategory;
use App\Repositories\FaqCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FaqCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FaqCategoryRepository
     */
    protected $faqCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->faqCategoryRepo = \App::make(FaqCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_faq_category()
    {
        $faqCategory = FaqCategory::factory()->make()->toArray();

        $createdFaqCategory = $this->faqCategoryRepo->create($faqCategory);

        $createdFaqCategory = $createdFaqCategory->toArray();
        $this->assertArrayHasKey('id', $createdFaqCategory);
        $this->assertNotNull($createdFaqCategory['id'], 'Created FaqCategory must have id specified');
        $this->assertNotNull(FaqCategory::find($createdFaqCategory['id']), 'FaqCategory with given id must be in DB');
        $this->assertModelData($faqCategory, $createdFaqCategory);
    }

    /**
     * @test read
     */
    public function test_read_faq_category()
    {
        $faqCategory = FaqCategory::factory()->create();

        $dbFaqCategory = $this->faqCategoryRepo->find($faqCategory->id);

        $dbFaqCategory = $dbFaqCategory->toArray();
        $this->assertModelData($faqCategory->toArray(), $dbFaqCategory);
    }

    /**
     * @test update
     */
    public function test_update_faq_category()
    {
        $faqCategory = FaqCategory::factory()->create();
        $fakeFaqCategory = FaqCategory::factory()->make()->toArray();

        $updatedFaqCategory = $this->faqCategoryRepo->update($fakeFaqCategory, $faqCategory->id);

        $this->assertModelData($fakeFaqCategory, $updatedFaqCategory->toArray());
        $dbFaqCategory = $this->faqCategoryRepo->find($faqCategory->id);
        $this->assertModelData($fakeFaqCategory, $dbFaqCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_faq_category()
    {
        $faqCategory = FaqCategory::factory()->create();

        $resp = $this->faqCategoryRepo->delete($faqCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(FaqCategory::find($faqCategory->id), 'FaqCategory should not exist in DB');
    }
}
