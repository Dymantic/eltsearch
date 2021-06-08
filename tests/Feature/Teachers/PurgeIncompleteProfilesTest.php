<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PurgeIncompleteProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function purge_profiles_that_remain_incomplete_after_final_warning()
    {
        $this->withoutExceptionHandling();
        Event::fake();
        Storage::fake('media');

        $should_purge = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 2,
            'last_sent_incomplete_reminder' => now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD + 1),
        ]);

        $complete = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 2,
            'last_sent_incomplete_reminder' => now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD + 1),
        ]);
        $complete->setAvatar(UploadedFile::fake()->image('test.jpg'));

        $too_soon = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 2,
            'last_sent_incomplete_reminder' => now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD - 1),
        ]);

        $no_final_warning = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 1,
            'last_sent_incomplete_reminder' => now()->subDays(Teacher::ALLOWED_INCOMPLETE_PERIOD + 1),
        ]);

        $no_warning = factory(Teacher::class)->create([
            'sent_incomplete_reminder_times' => 0,
            'last_sent_incomplete_reminder' => null,
        ]);

        Artisan::call('teachers:purge-incomplete');

        $this->assertDeleted($should_purge);
        $this->assertDatabaseHas('teachers', ['id' => $complete->id]);
        $this->assertDatabaseHas('teachers', ['id' => $too_soon->id]);
        $this->assertDatabaseHas('teachers', ['id' => $no_final_warning->id]);
        $this->assertDatabaseHas('teachers', ['id' => $no_warning->id]);
    }
}
