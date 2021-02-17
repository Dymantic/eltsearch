<?php


namespace Tests\Unit\Notifications;


use App\ContactDetails;
use App\ContactPersonInfo;
use App\Notifications\InterestShown;
use App\Notifications\SearchMatchesFound;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchMatchesFoundTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_search_matches_found_notification_has_expected_attributes()
    {

        $jobSearch = factory(JobSearch::class)->create();

        $matches = factory(JobMatch::class, 2)->create(['job_search_id' => $jobSearch->id]);

        $notification = new SearchMatchesFound($matches);

        $expected_subject = 'New Jobs Found';
        $expected_message = 'We have matched 2 new jobs with your latest job search. Visit your dashboard to see more details.';
        $expected_action = 'See Matches';
        $expected_url = url("teachers#/job-matches");

        $expected_data = [
            'requires_translation' => false,
            'subject'              => [
                'text' => 'New Jobs Found',
            ],
            'message'              => [
                'text' => 'We have matched 2 new jobs with your latest job search. Visit your dashboard to see more details.'
            ],
            'action'               => ['text' => 'See Matches'],
            'action_url'           => $expected_url,
            'sender'               => 'ELT Search',
        ];

        $notifiable = $jobSearch->teacher->user;

        $this->assertSame($expected_subject, $notification->getSubjectFor($notifiable));
        $this->assertSame($expected_message, $notification->getMessageFor($notifiable));
        $this->assertSame($expected_action, $notification->actionTextFor($notifiable));
        $this->assertSame($expected_url, $notification->actionUrl($notifiable));

        $this->assertEquals($expected_data, $notification->toDatabase($notifiable));
    }
}
