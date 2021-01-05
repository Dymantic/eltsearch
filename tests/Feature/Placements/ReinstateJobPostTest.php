<?php


namespace Tests\Feature\Placements;


use App\Notifications\JobPostReinstated;
use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReinstateJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function reinstate_a_disabled_job_post()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->state('admin')->create();
        [$school, $owner] = $this->setUpSchool();
        $job_post = factory(JobPost::class)->state('disabled')->create([
            'school_id' => $school->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->deleteJson("/api/admin/disabled-job-posts/{$job_post->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'id' => $job_post->id,
            'disabled_on' => null,
        ]);

        Notification::assertSentTo(
            $owner,
            JobPostReinstated::class,
            function ($notification, $channels) use ($job_post) {
                $this->assertTrue($notification->jobPost->is($job_post));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));

                return true;
            }
        );
    }
}
