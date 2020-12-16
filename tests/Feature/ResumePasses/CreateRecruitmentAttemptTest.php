<?php


namespace Tests\Feature\ResumePasses;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateRecruitmentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function school_can_reach_out_to_a_teacher()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        [$school, $owner] = $this->setUpSchool();
        $teacher = factory(Teacher::class)->state('public')->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/recruitment-attempts", [
            'teacher_slug'   => $teacher->slug,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('recruitment_attempts', [
            'school_id'      => $school->id,
            'teacher_id'     => $teacher->id,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);

        Notification::assertSentTo(
            $teacher->user,
            RecruitmentAttempt::class,
            function($notification,  $channels) use ($school, $teacher) {
                $this->assertTrue($notification->school->is($school));
                $this->assertTrue($notification->teacher->is($teacher));
                $this->assertTrue(in_array('email', $channels));
                $this->assertTrue(in_array('database', $channels));
            });

    }
}
