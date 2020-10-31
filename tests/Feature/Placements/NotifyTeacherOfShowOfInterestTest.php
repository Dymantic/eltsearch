<?php


namespace Tests\Feature\Placements;


use App\Notifications\InterestShown;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Placements\ShowOfInterest;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotifyTeacherOfShowOfInterestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function teacher_is_notified_of_schools_show_of_interest()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $teacher = factory(Teacher::class)->create();
        $application = factory(JobApplication::class)->create([
            'job_post_id' => $post->id,
            'teacher_id'  => $teacher->id,
        ]);

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/applications/{$application->id}/show-of-interest", [
                'contact_name' => 'test name',
                'email'        => 'test@test.test',
                'phone'        => 'test phone'
            ]);
        $response->assertSuccessful();

        Notification::assertSentTo(
            $teacher->user,
            InterestShown::class,
            function ($notification, $channels) {
                $this->assertNotNull(ShowOfInterest::find($notification->showOfInterest->id));
                $this->assertContains('mail', $channels);
                $this->assertContains('database', $channels);
                return true;
            });
    }
}
