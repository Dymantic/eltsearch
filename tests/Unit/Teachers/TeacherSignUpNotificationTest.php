<?php


namespace Tests\Unit\Teachers;


use App\Notifications\WelcomeTeacher;
use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TeacherSignUpNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_teacher_signing_up_receives_a_welcome_notification()
    {
        Notification::fake();

        $user = User::registerTeacher([
            'name'     => 'test name',
            'email'    => 'test@test.test',
            'password' => 'password'
        ]);

        Notification::assertSentTo(
            $user,
            WelcomeTeacher::class,
            function ($notification, $channels) use ($user) {
                $this->assertTrue($notification->user->is($user));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));

                return true;
            }
        );
    }

    /**
     * @test
     */
    public function a_facebook_signup_receives_welcome_email()
    {
        Notification::fake();

        $user = User::registerTeacherViaFacebook([
            'name'  => 'test name',
            'email' => 'test@test.test',
            'id'    => 'test_id'
        ]);

        Notification::assertSentTo(
            $user,
            WelcomeTeacher::class,
            function ($notification, $channels) use ($user) {
                $this->assertTrue($notification->user->is($user));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));

                return true;
            }
        );
    }

    /**
     *@test
     */
    public function a_guest_application_gets_a_welcome_email()
    {
        Notification::fake();

        $generalInfo = new TeacherGeneralInfo([
            'name'                    => 'test name',
            'email'                   => 'test@test.test',
            'nation_id'             => null,
            'date_of_birth'           => '1999-09-19',
            'native_language'         => 'English',
            'other_languages'         => 'Spanish',
            'years_experience'        => 3,
        ]);

        $education = new TeacherEducationInfo([
            'education_level'         => Teacher::EDUCATION_GRADUATE,
            'education_institution'   => 'test college',
            'education_qualification' => 'BTest',
        ]);

        $teacher = User::createTeacherFromGuestApplication($generalInfo, $education, 'password');
        $user = $teacher->user;

        Notification::assertSentTo(
            $user,
            WelcomeTeacher::class,
            function ($notification, $channels) use ($user) {
                $this->assertTrue($notification->delay->diffInMinutes(now()) >= 9);
                $this->assertTrue($notification->user->is($user));
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));

                return true;
            }
        );
    }
}
