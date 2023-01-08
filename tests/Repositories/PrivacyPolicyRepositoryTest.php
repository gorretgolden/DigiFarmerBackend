<?php namespace Tests\Repositories;

use App\Models\PrivacyPolicy;
use App\Repositories\PrivacyPolicyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PrivacyPolicyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PrivacyPolicyRepository
     */
    protected $privacyPolicyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->privacyPolicyRepo = \App::make(PrivacyPolicyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->make()->toArray();

        $createdPrivacyPolicy = $this->privacyPolicyRepo->create($privacyPolicy);

        $createdPrivacyPolicy = $createdPrivacyPolicy->toArray();
        $this->assertArrayHasKey('id', $createdPrivacyPolicy);
        $this->assertNotNull($createdPrivacyPolicy['id'], 'Created PrivacyPolicy must have id specified');
        $this->assertNotNull(PrivacyPolicy::find($createdPrivacyPolicy['id']), 'PrivacyPolicy with given id must be in DB');
        $this->assertModelData($privacyPolicy, $createdPrivacyPolicy);
    }

    /**
     * @test read
     */
    public function test_read_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();

        $dbPrivacyPolicy = $this->privacyPolicyRepo->find($privacyPolicy->id);

        $dbPrivacyPolicy = $dbPrivacyPolicy->toArray();
        $this->assertModelData($privacyPolicy->toArray(), $dbPrivacyPolicy);
    }

    /**
     * @test update
     */
    public function test_update_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();
        $fakePrivacyPolicy = PrivacyPolicy::factory()->make()->toArray();

        $updatedPrivacyPolicy = $this->privacyPolicyRepo->update($fakePrivacyPolicy, $privacyPolicy->id);

        $this->assertModelData($fakePrivacyPolicy, $updatedPrivacyPolicy->toArray());
        $dbPrivacyPolicy = $this->privacyPolicyRepo->find($privacyPolicy->id);
        $this->assertModelData($fakePrivacyPolicy, $dbPrivacyPolicy->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();

        $resp = $this->privacyPolicyRepo->delete($privacyPolicy->id);

        $this->assertTrue($resp);
        $this->assertNull(PrivacyPolicy::find($privacyPolicy->id), 'PrivacyPolicy should not exist in DB');
    }
}
