<?php


namespace Tests\Unit\Notifications;


use App\ContactDetails;
use App\ContactPersonInfo;
use App\Notifications\InterestShown;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterestShownTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_interest_shown_notification_has_correct_attributes()
    {
        $job_post = factory(JobPost::class)->state('current')->create();
        $teacher = factory(Teacher::class)->create();
        $application = $teacher->applyForJob($job_post, 'cover letter', ContactDetails::fake());
        $school_contact = new ContactPersonInfo(
            array_merge(['name' => 'test name'], ContactDetails::fake()->toArray())
        );
        $show_of_interest = $application->showInterest($school_contact);

        $notification = new InterestShown($show_of_interest);

        $expected_subject = 'Response from Job Application';
        $expected_message = sprintf("%s from %s has read your application for %s and would like you to get in touch to take the next steps.", $school_contact->name, $job_post->school->name, $job_post->position);
        $expected_action = 'See details';
        $expected_url = url("teachers#/applications/{$application->id}/show-of-interest");

        $expected_data = [
            'requires_translation' => false,
            'subject' => [
                'text' => 'Response from Job Application',
            ],
            'message' => [
                'text' => sprintf("%s from %s has read your application for %s and would like you to get in touch to take the next steps.", $school_contact->name, $job_post->school->name, $job_post->position)
            ],
            'action' => ['text' => 'See details'],
            'action_url' => url("teachers#/applications/{$application->id}/show-of-interest"),
            'sender' => $job_post->school->name,
            'extra_fields' => [
                'email' => ContactDetails::fake()->email,
                'phone' => ContactDetails::fake()->phone,
            ]
        ];

        $this->assertSame($expected_subject, $notification->getSubjectFor($teacher->user));
        $this->assertSame($expected_message, $notification->getMessageFor($teacher->user));
        $this->assertSame($expected_action, $notification->actionTextFor($teacher->user));
        $this->assertSame($expected_url, $notification->actionUrl($teacher->user));

        $this->assertEquals($expected_data, $notification->toDatabase($teacher->user));

    }
}
