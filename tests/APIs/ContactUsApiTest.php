<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ContactUs;

class ContactUsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_contact_us()
    {
        $contactUs = ContactUs::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/contactuses', $contactUs
        );

        $this->assertApiResponse($contactUs);
    }

    /**
     * @test
     */
    public function test_read_contact_us()
    {
        $contactUs = ContactUs::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/contactuses/'.$contactUs->id
        );

        $this->assertApiResponse($contactUs->toArray());
    }

    /**
     * @test
     */
    public function test_update_contact_us()
    {
        $contactUs = ContactUs::factory()->create();
        $editedContactUs = ContactUs::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/contactuses/'.$contactUs->id,
            $editedContactUs
        );

        $this->assertApiResponse($editedContactUs);
    }

    /**
     * @test
     */
    public function test_delete_contact_us()
    {
        $contactUs = ContactUs::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/contactuses/'.$contactUs->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/contactuses/'.$contactUs->id
        );

        $this->response->assertStatus(404);
    }
}
