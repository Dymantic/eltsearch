<?php


namespace Tests\Feature\Placements;


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

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-applications", [
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
    public function check_empty_or_null_fields_allowed()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-applications", [
            'job_post_id'  => $job_post->id,
            'cover_letter' => null,
            'phone'        => null,
            'email'        => null,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_applications', [
            'job_post_id'  => $job_post->id,
            'teacher_id'   => $teacher->id,
            'cover_letter' => '',
            'phone'        => '',
            'email'        => $teacher->email,
        ]);
    }

    /**
     *@test
     */
    public function the_job_post_id_must_be_for_a_valid_job_post()
    {
        $teacher = factory(Teacher::class)->create();
        $this->assertNull(JobPost::find(99));

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-applications", [
            'job_post_id'  => 99,
            'cover_letter' => null,
            'phone'        => null,
            'email'        => null,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
