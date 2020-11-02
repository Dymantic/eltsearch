<?php


namespace Tests\Unit\Placements;


use App\Jobs\MatchJobSearch;
use App\Locations\Area;
use App\Notifications\SearchMatchesFound;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MatchJobSearchesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function match_job_search_creates_expected_matches()
    {
        Notification::fake();

        $area = factory(Area::class)->create();
        $jobPost = factory(JobPost::class)->state('current')->create([
            'area_id' => $area->id,
        ]);

        $jobSearch = factory(JobSearch::class)->create([
            'area_ids' => [$area->id],
            'student_ages'   => [],
            'benefits'       => [],
            'contract_type'  => [],
            'schedule'       => [],
            'engagement'     => '',
            'weekends'       => null,
            'salary'         => null,
            'hours_per_week' => null,
        ]);


        $job = new MatchJobSearch($jobSearch);
        $job->handle();

        $match = JobMatch::latest()->first();
        $this->assertSame($jobSearch->id, $match->job_search_id);
        $this->assertSame($jobPost->id, $match->job_post_id);

        Notification::assertSentTo(
            $jobSearch->teacher->user,
            SearchMatchesFound::class,
            function ( $notification, $channels) use ($jobSearch, $jobPost) {
                $this->assertContains('mail', $channels);
                $this->assertContains('database', $channels);
                $this->assertTrue($notification->matches->contains(
                    fn($match) => $match->job_post_id === $jobPost->id && $match->job_search_id === $jobSearch->id
                ));
                return true;
            });
    }
}
