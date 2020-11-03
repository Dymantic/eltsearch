<?php


namespace Tests\Unit\Notifications;


use App\Notifications\JobPostMatchesFound;
use App\Notifications\SearchMatchesFound;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPostMatchesFoundTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_job_post_matches_found_notification_has_the_correct_attributes()
    {
        $jobPost = factory(JobPost::class)->state('current')->create();

        factory(JobMatch::class)->create(['job_post_id' => $jobPost->id]);

        $notification = new JobPostMatchesFound($jobPost);

        $expected_subject = 'A Job Matches Your Search';
        $expected_message = sprintf('We have found a job that you may be interested in, based on your current job search. The job advertised is for the position of %s with %s, located in %s. See the job post for more details.', $jobPost->position, $jobPost->school_name, $jobPost->area->fullName('en'));
        $expected_action = 'View Job Post';
        $expected_url = url("teachers#/job-posts/{$jobPost->slug}");

        $expected_data = [
            'requires_translation' => false,
            'subject' => [
                'text' => $expected_subject,
            ],
            'message' => [
                'text' => $expected_message
            ],
            'action' => ['text' => $expected_action],
            'action_url' => $expected_url,

        ];


        $this->assertSame($expected_subject, $notification->getSubjectFor(null));
        $this->assertSame($expected_message, $notification->getMessageFor(null));
        $this->assertSame($expected_action, $notification->actionTextFor(null));
        $this->assertSame($expected_url, $notification->actionUrl());

        $this->assertEquals($expected_data, $notification->toDatabase(null));
    }
}
