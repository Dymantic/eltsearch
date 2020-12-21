<?php


namespace Tests\Unit\Schools;


use App\Notifications\WelcomeSchool;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SchoolWelcomeNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function the_school_owner_receives_a_welcome_email_on_sign_up()
    {
        Notification::fake();

        $schoolOwner = User::registerSchool([
            'name' => 'test name',
            'email' => 'test@test.test',
            'password' => 'password',
            'school_name' => 'test school'
        ]);

        Notification::assertSentTo(
            $schoolOwner,
            WelcomeSchool::class,
            function($notification, $channels) use ($schoolOwner) {
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue($notification->owner->is($schoolOwner));
                $this->assertTrue($notification->school->is($schoolOwner->schools->first()));

                return true;
            }
        );
    }
}
