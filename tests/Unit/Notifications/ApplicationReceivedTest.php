<?php

namespace Tests\Unit\Notifications;

use App\ContactDetails;
use App\Notifications\ApplicationReceived;
use App\Placements\JobPost;
use App\Schools\School;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApplicationReceivedTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function application_received_notification_has_correct_subject_and_message()
    {
        Event::fake();

        $school = factory(School::class)->create();
        $school_admin = factory(User::class)->state('school')->create(['preferred_lang' => 'zh']);
        $school->admins()->attach($school_admin);
        $job_post = factory(JobPost::class)->create([
            'school_id'      => $school->id,
            'posted_by'      => $school_admin->id,
            'last_edited_by' => $school_admin->id,
        ]);
        $teacher = factory(Teacher::class)->create();
        $contact_details = new ContactDetails([
            'phone' => 'test phone',
            'email' => 'test@test.test',
        ]);

        $application = $teacher->applyForJob($job_post, 'cover letter', $contact_details);

        $notification = new ApplicationReceived($application);

        $expected_subject = Lang::get(
            'notifications.application_received.subject',
            [
                'position' => $job_post->position
            ],
            'zh'
        );
        $expected_message = Lang::get(
            'notifications.application_received.message',
            [
                'teacher'  => $teacher->name,
                'position' => $job_post->position,
                'school'   => $job_post->school_name,
            ],
            'zh');
        $expected_action = Lang::get('notifications.application_received.action', [], 'zh');

        $expected_data = [
            'requires_translation' => true,
            'subject'              => [
                'text'   => 'notifications.application_received.subject',
                'params' => ['position' => $job_post->position],
            ],
            'message'              => [
                'text'   => 'notifications.application_received.message',
                'params' => [
                    'teacher'  => $teacher->name,
                    'position' => $job_post->position,
                    'school'   => $job_post->school_name,
                ]
            ],
            'action'               => [
                'text' => 'notifications.application_received.action',
                'params' => [],
            ],
            'action_url'           => url("/schools#/applications/{$application->id}"),
        ];

        $this->assertSame($expected_subject, $notification->getSubjectFor($school_admin));
        $this->assertSame($expected_message, $notification->getMessageFor($school_admin));
        $this->assertSame(url("/schools#/applications/{$application->id}"), $notification->actionUrl($school_admin));
        $this->assertSame($expected_action, $notification->actionTextFor($school_admin));
        $this->assertEquals($expected_data, $notification->toDatabase($school_admin));
    }
}
