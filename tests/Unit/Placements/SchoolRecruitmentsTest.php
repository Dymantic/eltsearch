<?php


namespace Tests\Unit\Placements;


use App\Notifications\AttemptToRecruit;
use App\Placements\RecruitmentMessage;
use App\Schools\School;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SchoolRecruitmentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function school_can_attempt_to_recruit_a_teacher()
    {
        Notification::fake();
        $school = factory(School::class)->create();
        $teacher = factory(Teacher::class)->create();

        $recruitmentMessage = new RecruitmentMessage([
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);

        $attempt = $school->attemptToRecruit($teacher, $recruitmentMessage);

        $this->assertTrue($attempt->school->is($school));
        $this->assertTrue($attempt->teacher->is($teacher));
        $this->assertSame('test message', $attempt->message);
        $this->assertSame('test person', $attempt->contact_person);
        $this->assertSame('test phone', $attempt->phone);
        $this->assertSame('test@test.test', $attempt->email);

        Notification::assertSentTo(
            $teacher->user,
            AttemptToRecruit::class,
            function($notification,  $channels) use ($attempt) {
                $this->assertTrue($notification->recruitmentAttempt->is($attempt));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));

                return true;
            });
    }
}
