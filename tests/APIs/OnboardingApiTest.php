<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Onboarding;

class OnboardingApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_onboarding()
    {
        $onboarding = Onboarding::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/onboardings', $onboarding
        );

        $this->assertApiResponse($onboarding);
    }

    /**
     * @test
     */
    public function test_read_onboarding()
    {
        $onboarding = Onboarding::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/onboardings/'.$onboarding->id
        );

        $this->assertApiResponse($onboarding->toArray());
    }

    /**
     * @test
     */
    public function test_update_onboarding()
    {
        $onboarding = Onboarding::factory()->create();
        $editedOnboarding = Onboarding::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/onboardings/'.$onboarding->id,
            $editedOnboarding
        );

        $this->assertApiResponse($editedOnboarding);
    }

    /**
     * @test
     */
    public function test_delete_onboarding()
    {
        $onboarding = Onboarding::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/onboardings/'.$onboarding->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/onboardings/'.$onboarding->id
        );

        $this->response->assertStatus(404);
    }
}
