<?php


namespace Tests\Unit\Placements;


use App\Jobs\MatchJobPost;
use App\Notifications\JobPostMatchesFound;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MatchJobPostJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function job_post_matches_on_expected_searches_and_sends_notifications()
    {
        Notification::fake();

        $post = $this->makeTestPost(['student_ages' => [JobPost::AGE_ADULT]]);
        //create two searches that match
        $shouldMatchA = $this->makeTestSearch(['student_ages' => [JobPost::AGE_UNIVERSITY, JobPost::AGE_ADULT]]);
        $shouldMatchB = $this->makeTestSearch(['student_ages' => [JobPost::AGE_ADULT]]);
        $shouldntMatch = $this->makeTestSearch(['student_ages' => [JobPost::AGE_KINDERGARTEN]]);

        (new MatchJobPost($post))->handle();

        $this->assertDatabaseHas('job_matches', [
            'job_post_id'   => $post->id,
            'job_search_id' => $shouldMatchA->id,
        ]);
        $this->assertDatabaseHas('job_matches', [
            'job_post_id'   => $post->id,
            'job_search_id' => $shouldMatchB->id,
        ]);
        $this->assertDatabaseMissing('job_matches', [
            'job_post_id'   => $post->id,
            'job_search_id' => $shouldntMatch->id,
        ]);

        Notification::assertSentTo(
            [$shouldMatchA->teacher->user, $shouldMatchB->teacher->user],
            JobPostMatchesFound::class,
            function($notification, $channels) use ($post) {
                $this->assertContains('mail', $channels);
                $this->assertContains('database', $channels);
                $this->assertTrue($notification->jobPost->is($post));
                return true;
            }
        );


    }

    private function makeTestSearch($criteria): JobSearch
    {
        $default = [
            'area_ids'       => [],
            'student_ages'   => [],
            'benefits'       => [],
            'contract_type'  => [],
            'schedule'       => [],
            'engagement'     => '',
            'weekends'       => null,
            'salary'         => null,
            'hours_per_week' => null,
        ];

        return factory(JobSearch::class)->create(array_merge($default, $criteria));
    }

    private function makeTestPost($attributes): JobPost
    {
        $post = factory(JobPost::class)->state('current')->create($attributes);
        $post->setSalaryGrade();

        return $post;
    }
}
