<?php


namespace Tests\Feature\Placements;


use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DismissJobMatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_teacher_can_dismiss_one_of_their_job_matches()
    {
        $this->withoutExceptionHandling();

        $job_post = factory(JobPost::class)->create();
        $teacher = factory(Teacher::class)->create();
        $job_search = factory(JobSearch::class)->create([
            'teacher_id' => $teacher->id,
        ]);
        $intended_job_match = factory(JobMatch::class)->create([
            'job_post_id'   => $job_post->id,
            'job_search_id' => $job_search->id,
        ]);
        $other_job_match = factory(JobMatch::class)->create([
            'job_post_id' => $job_post->id,
        ]);

        $response = $this
            ->actingAs($teacher->user)
            ->deleteJson("/api/teachers/job-matches/{$intended_job_match->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('job_matches', [
            'id' => $intended_job_match->id,
            'dismissed' => true,
        ]);

        $this->assertDatabaseHas('job_matches', [
            'id' => $other_job_match->id,
            'dismissed' => false,
        ]);
    }

    /**
     *@test
     */
    public function a_teacher_cannot_dismiss_another_teachers_match()
    {
        $job_post = factory(JobPost::class)->create();
        $teacher = factory(Teacher::class)->create();
        $job_search = factory(JobSearch::class)->create([
            'teacher_id' => $teacher->id,
        ]);
        $intended_job_match = factory(JobMatch::class)->create([
            'job_post_id'   => $job_post->id,
            'job_search_id' => $job_search->id,
        ]);
        $other_job_match = factory(JobMatch::class)->create([
            'job_post_id' => $job_post->id,
        ]);

        $response = $this
            ->actingAs($teacher->user)
            ->deleteJson("/api/teachers/job-matches/{$other_job_match->id}");
        $response->assertForbidden();

        $this->assertDatabaseHas('job_matches', [
            'id' => $intended_job_match->id,
            'dismissed' => false,
        ]);

        $this->assertDatabaseHas('job_matches', [
            'id' => $other_job_match->id,
            'dismissed' => false,
        ]);
    }
}
