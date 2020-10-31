<?php


namespace Tests\Feature\Placements;


use App\Notifications\ApplicationReceived;
use App\Placements\JobPost;
use App\Schools\School;
use App\Schools\SchoolUser;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifySchoolOfApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_school_is_notified_of_a_new_application()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $school = factory(School::class)->create();
        $school_admin = factory(User::class)->state('school')->create();
        $school->admins()->attach($school_admin);
        $job_post = factory(JobPost::class)->create([
            'school_id'      => $school->id,
            'posted_by'      => $school_admin->id,
            'last_edited_by' => $school_admin->id,
        ]);


        $teacher = factory(Teacher::class)->create();

        $response = $this
            ->actingAs($teacher->user)->post("/job-posts/{$job_post->slug}/apply", [
                'job_post_id'  => $job_post->id,
                'cover_letter' => 'test cover letter',
                'phone'        => 'test phone',
                'email'        => 'test@test.test',
            ]);

        Notification::assertSentTo(
            $school_admin,
            function(ApplicationReceived $notification, $channels) use ($job_post, $teacher) {
                $this->assertSame($notification->jobPost()->id, $job_post->id);
                $this->assertSame($notification->teacher()->id, $teacher->id);
                $this->assertContains('mail', $channels);
                $this->assertContains('database', $channels);
                return true;
        });
    }
}
