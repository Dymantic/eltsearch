<?php


namespace Tests\Feature\Teachers;


use App\Notifications\RemindTeacherOfIncompleteProfile;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SendFirstReminderToCompleteProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function send_a_notification_to_prompt_completion_of_profile()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        Notification::fake();
        $this->withoutExceptionHandling();

        $complete = factory(Teacher::class)->create();
        $complete->setAvatar(UploadedFile::fake()->image('test.jpg'));

        $this->assertDatabaseHas('teachers', [
            'id' => $complete->id,
            'sent_incomplete_reminder_times' => 0,
            'last_sent_incomplete_reminder' => null,
        ]);

        $incomplete = factory(Teacher::class)->create(); // no avatar - incomplete

        $this->travel(Teacher::ALLOWED_INCOMPLETE_PERIOD)->days();
        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertSentTo(
            $incomplete->user,
            RemindTeacherOfIncompleteProfile::class,
            function($notification, $channels) use ($incomplete) {
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue($notification->teacher->is($incomplete));
                return true;
            }
        );

        Notification::assertNotSentTo($complete->user, RemindTeacherOfIncompleteProfile::class);

        $this->assertDatabaseHas('teachers', [
            'id' => $complete->id,
            'sent_incomplete_reminder_times' => 0,
            'last_sent_incomplete_reminder' => null,
        ]);

        $this->assertDatabaseHas('teachers', [
            'id' => $incomplete->id,
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->format('Y-m-d'),
        ]);



    }

    /**
     *@test
     */
    public function the_reminder_is_not_sent_to_teachers_already_reminded()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        Notification::fake();
        $this->withoutExceptionHandling();

        $incomplete = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD - 1),
            'created_at' => now()->subMonth(),
        ]); // no avatar - incomplete

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertNotSentTo($incomplete->user, RemindTeacherOfIncompleteProfile::class);
    }

    /**
     *@test
     */
    public function the_reminder_is_not_sent_in_the_first_week_of_signup()
    {
        Storage::fake('media', config('filesystems.disks.media'));
        Notification::fake();
        $this->withoutExceptionHandling();

        $incomplete = factory(Teacher::class)->create(); // no avatar - incomplete

        $this->travel(3)->days();

        Artisan::call('teachers:warn-incomplete-profiles');

        Notification::assertNotSentTo($incomplete->user, RemindTeacherOfIncompleteProfile::class);
    }
}
