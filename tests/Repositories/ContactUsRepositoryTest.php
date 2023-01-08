<?php namespace Tests\Repositories;

use App\Models\ContactUs;
use App\Repositories\ContactUsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ContactUsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ContactUsRepository
     */
    protected $contactUsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->contactUsRepo = \App::make(ContactUsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_contact_us()
    {
        $contactUs = ContactUs::factory()->make()->toArray();

        $createdContactUs = $this->contactUsRepo->create($contactUs);

        $createdContactUs = $createdContactUs->toArray();
        $this->assertArrayHasKey('id', $createdContactUs);
        $this->assertNotNull($createdContactUs['id'], 'Created ContactUs must have id specified');
        $this->assertNotNull(ContactUs::find($createdContactUs['id']), 'ContactUs with given id must be in DB');
        $this->assertModelData($contactUs, $createdContactUs);
    }

    /**
     * @test read
     */
    public function test_read_contact_us()
    {
        $contactUs = ContactUs::factory()->create();

        $dbContactUs = $this->contactUsRepo->find($contactUs->id);

        $dbContactUs = $dbContactUs->toArray();
        $this->assertModelData($contactUs->toArray(), $dbContactUs);
    }

    /**
     * @test update
     */
    public function test_update_contact_us()
    {
        $contactUs = ContactUs::factory()->create();
        $fakeContactUs = ContactUs::factory()->make()->toArray();

        $updatedContactUs = $this->contactUsRepo->update($fakeContactUs, $contactUs->id);

        $this->assertModelData($fakeContactUs, $updatedContactUs->toArray());
        $dbContactUs = $this->contactUsRepo->find($contactUs->id);
        $this->assertModelData($fakeContactUs, $dbContactUs->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_contact_us()
    {
        $contactUs = ContactUs::factory()->create();

        $resp = $this->contactUsRepo->delete($contactUs->id);

        $this->assertTrue($resp);
        $this->assertNull(ContactUs::find($contactUs->id), 'ContactUs should not exist in DB');
    }
}
