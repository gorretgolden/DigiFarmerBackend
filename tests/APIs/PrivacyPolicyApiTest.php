<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PrivacyPolicy;

class PrivacyPolicyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/privacy_policies', $privacyPolicy
        );

        $this->assertApiResponse($privacyPolicy);
    }

    /**
     * @test
     */
    public function test_read_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/privacy_policies/'.$privacyPolicy->id
        );

        $this->assertApiResponse($privacyPolicy->toArray());
    }

    /**
     * @test
     */
    public function test_update_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();
        $editedPrivacyPolicy = PrivacyPolicy::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/privacy_policies/'.$privacyPolicy->id,
            $editedPrivacyPolicy
        );

        $this->assertApiResponse($editedPrivacyPolicy);
    }

    /**
     * @test
     */
    public function test_delete_privacy_policy()
    {
        $privacyPolicy = PrivacyPolicy::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/privacy_policies/'.$privacyPolicy->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/privacy_policies/'.$privacyPolicy->id
        );

        $this->response->assertStatus(404);
    }
}
