<?php namespace Tests\Repositories;

use App\Models\Onboarding;
use App\Repositories\OnboardingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OnboardingRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OnboardingRepository
     */
    protected $onboardingRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->onboardingRepo = \App::make(OnboardingRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_onboarding()
    {
        $onboarding = Onboarding::factory()->make()->toArray();

        $createdOnboarding = $this->onboardingRepo->create($onboarding);

        $createdOnboarding = $createdOnboarding->toArray();
        $this->assertArrayHasKey('id', $createdOnboarding);
        $this->assertNotNull($createdOnboarding['id'], 'Created Onboarding must have id specified');
        $this->assertNotNull(Onboarding::find($createdOnboarding['id']), 'Onboarding with given id must be in DB');
        $this->assertModelData($onboarding, $createdOnboarding);
    }

    /**
     * @test read
     */
    public function test_read_onboarding()
    {
        $onboarding = Onboarding::factory()->create();

        $dbOnboarding = $this->onboardingRepo->find($onboarding->id);

        $dbOnboarding = $dbOnboarding->toArray();
        $this->assertModelData($onboarding->toArray(), $dbOnboarding);
    }

    /**
     * @test update
     */
    public function test_update_onboarding()
    {
        $onboarding = Onboarding::factory()->create();
        $fakeOnboarding = Onboarding::factory()->make()->toArray();

        $updatedOnboarding = $this->onboardingRepo->update($fakeOnboarding, $onboarding->id);

        $this->assertModelData($fakeOnboarding, $updatedOnboarding->toArray());
        $dbOnboarding = $this->onboardingRepo->find($onboarding->id);
        $this->assertModelData($fakeOnboarding, $dbOnboarding->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_onboarding()
    {
        $onboarding = Onboarding::factory()->create();

        $resp = $this->onboardingRepo->delete($onboarding->id);

        $this->assertTrue($resp);
        $this->assertNull(Onboarding::find($onboarding->id), 'Onboarding should not exist in DB');
    }
}
