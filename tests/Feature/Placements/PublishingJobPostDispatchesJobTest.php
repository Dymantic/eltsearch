<?php


namespace Tests\Feature\Placements;


use App\Jobs\MatchJobPost;
use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PublishingJobPostDispatchesJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publishing_a_job_post_dispatches_a_job_to_match_searches()
    {
        Bus::fake();
        $this->withoutExceptionHandling();
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->state('draft')->create(['school_id' => $school->id]);
        $school->grantTokens(1, 1, now()->addCentury());

        $response = $this->actingAs($owner)->postJson("/api/schools/posts/published-job-posts", [
            'job_post_id' => $post->id
        ]);
        $response->assertSuccessful();

        Bus::assertDispatched(function(MatchJobPost $job) use ($post) {
            $this->assertTrue($job->jobPost->is($post));
            return true;
        });


    }
}
