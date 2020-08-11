<?php


namespace Tests\Feature\Placements;


use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_job_post()
    {
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id
        ]);

        $response = $this->actingAs($owner)->deleteJson("/api/schools/job-posts/{$post->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('job_posts', ['id' => $post->id]);
    }

    /**
     *@test
     */
    public function can_only_be_deleted_by_school_member()
    {

        $post = factory(JobPost::class)->create();
        $other_user = factory(User::class)->state('school')->create();

        $response = $this->actingAs($other_user)->deleteJson("/api/schools/job-posts/{$post->id}");
        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', ['id' => $post->id]);
    }
}
