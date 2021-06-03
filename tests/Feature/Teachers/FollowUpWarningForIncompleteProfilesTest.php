<?php


namespace Tests\Feature\Teachers;


use App\Notifications\FinalWarningForIncompleteProfiles;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FollowUpWarningForIncompleteProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function send_the_follow_up_warning_to_incomplete_profiles()
    {
        Notification::fake();
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $requires_warning = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->subDays(8),
            'created_at' => now()->subMonth(),
        ]);

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertSentTo(
            $requires_warning->user,
            FinalWarningForIncompleteProfiles::class,
            function($notification, $channels) use ($requires_warning) {
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue($notification->teacher->is($requires_warning));
                return true;
            }
        );

        $this->assertDatabaseHas('teachers', [
            'id' => $requires_warning->id,
            'sent_incomplete_reminder_times' => 2,
            'last_sent_incomplete_reminder' => now()->format('Y-m-d'),
        ]);
    }

    /**
     *@test
     */
    public function the_notification_is_not_sent_to_a_completed_profile()
    {
        Notification::fake();
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $complete = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->subDays(8),
            'created_at' => now()->subMonth(),
        ]);
        $complete->setAvatar(UploadedFile::fake()->image('test.jpg'));

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertNotSentTo($complete->user, FinalWarningForIncompleteProfiles::class);
    }

    /**
     *@test
     */
    public function the_notification_is_not_sent_too_soon_after_first_warning()
    {
        Notification::fake();
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $incomplete = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->subDays(5),
            'created_at' => now()->subMonth(),
        ]);

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertNotSentTo($incomplete->user, FinalWarningForIncompleteProfiles::class);
    }

    /**
     *@test
     */
    public function the_notification_is_not_sent_to_teachers_who_have_no_previous_warning()
    {
        Notification::fake();
        Storage::fake('media');
        $this->withoutExceptionHandling();

        $incomplete = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 0,
            'last_sent_incomplete_reminder' => null,
            'created_at' => now()->subMonth(),
        ]);

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertNotSentTo($incomplete->user, FinalWarningForIncompleteProfiles::class);
    }
}
