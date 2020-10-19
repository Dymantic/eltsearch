<?php


namespace Tests\Feature\Placements;


use App\Placements\JobApplication;
use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateShowOfInterestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_show_of_interest_for_an_application()
    {
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $application = factory(JobApplication::class)->create([
            'job_post_id' => $post->id,
        ]);

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/applications/{$application->id}/show-of-interest", [
                'contact_name' => 'test name',
                'email'        => 'test@test.test',
                'phone'        => 'test phone'
            ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('show_of_interests', [
            'job_application_id' => $application->id,
            'name'               => 'test name',
            'email'              => 'test@test.test',
            'phone'              => 'test phone'
        ]);
    }

    /**
     *@test
     */
    public function the_contact_name_is_required()
    {
        $this->assertFieldIsInvalid(['contact_name' => '']);
    }

    /**
     *@test
     */
    public function the_email_address_must_be_a_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_the_phone()
    {
        $this->assertFieldIsInvalid([
            'email' => '',
            'phone' => ''
        ]);
    }

    /**
     *@test
     */
    public function the_phone_is_required_without_the_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => '',
            'email' => '',
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $application = factory(JobApplication::class)->create([
            'job_post_id' => $post->id,
        ]);

        $valid = [
            'contact_name' => 'test name',
            'email'        => 'test@test.test',
            'phone'        => 'test phone'
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson(
                "/api/schools/applications/{$application->id}/show-of-interest",
                array_merge($valid, $field)
            );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
