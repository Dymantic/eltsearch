<?php


namespace Tests\Feature\Placements;


use App\DateFormatter;
use App\Notifications\JobPostDisabled;
use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DisableJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function disable_a_job_post()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->state('admin')->create();
        [$school, $owner] = $this->setUpSchool();
        $job_post = factory(JobPost::class)->state('current')->create([
            'school_id' => $school->id
        ]);

        $response = $this->actingAs($admin)->postJson("/api/admin/disabled-job-posts", [
            'job_post_id' => $job_post->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'id'          => $job_post->id,
            'disabled_on' => now()->format(DateFormatter::STANDARD),
        ]);

        Notification::assertSentTo(
            $owner,
            JobPostDisabled::class,
            function ($notification, $channels) use ($job_post) {
                $this->assertTrue($notification->jobPost->is($job_post));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));

                return true;
            }
        );
    }

    /**
     * @test
     */
    public function can_only_be_disabled_by_an_admin()
    {
        Notification::fake();

        $bad_guy = factory(User::class)->state('school')->create();
        [$school, $owner] = $this->setUpSchool();
        $job_post = factory(JobPost::class)->state('current')->create([
            'school_id' => $school->id
        ]);

        $response = $this->actingAs($bad_guy)->postJson("/api/admin/disabled-job-posts", [
            'job_post_id' => $job_post->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id'          => $job_post->id,
            'disabled_on' => null,
        ]);
    }
}
