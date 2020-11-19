<?php


namespace Tests\Feature\Placements;


use App\ContactDetails;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateJobApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_an_application_for_a_post_as_a_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();

        $response = $this
            ->actingAs($teacher->user)->post("/job-posts/{$job_post->slug}/apply", [
            'job_post_id'  => $job_post->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);

        $response->assertRedirect("/");

        $this->assertDatabaseHas('job_applications', [
            'job_post_id'  => $job_post->id,
            'teacher_id'   => $teacher->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);
    }

    /**
     *@test
     */
    public function apply_via_api()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();

        $response = $this
            ->actingAs($teacher->user)->postJson("/api/teachers/job-applications", [
                'job_post_id'  => $job_post->id,
                'cover_letter' => 'test cover letter',
                'phone'        => 'test phone',
                'email'        => 'test@test.test',
            ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_applications', [
            'job_post_id'  => $job_post->id,
            'teacher_id'   => $teacher->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);
    }

    /**
     *@test
     */
    public function can_not_apply_for_a_job_more_than_once()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();
        $contact_details = new ContactDetails([
            'phone' => 'test phone',
            'email' => 'test@test.test',
        ]);

        $teacher->applyForJob($job_post, 'test letter', $contact_details);

        $response = $this
            ->actingAs($teacher->user)->post("/job-posts/{$job_post->slug}/apply", [
                'job_post_id'  => $job_post->id,
                'cover_letter' => 'test cover letter',
                'phone'        => 'test phone',
                'email'        => 'test@test.test',
            ]);

        $response->assertRedirect('');
        $response->assertSessionHasErrors('job_post');
    }

    /**
     *@test
     */
    public function the_cover_letter_is_required()
    {
        $this->assertFieldIsInvalid(['cover_letter' => null]);
    }

    private function assertFieldIsInvalid($field)
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();

        $valid = [
            'job_post_id'  => $job_post->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/job-applications", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }


}
