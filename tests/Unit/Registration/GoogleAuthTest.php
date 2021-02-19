<?php

namespace Tests\Unit\Registration;

use App\Notifications\WelcomeTeacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_register_a_google_user()
    {
        Notification::fake();

        $user_data = [
            'name' => 'test user',
            'id' => '123456',
            'email' => 'test@test.test',
        ];

        $user = User::registerTeacherViaGoogle($user_data);

        $this->assertSame('test user', $user->name);
        $this->assertSame('test@test.test', $user->email);
        $this->assertSame('123456', $user->provider_user_id);
        $this->assertSame(User::PLATFORM_GOOGLE, $user->platform);
        $this->assertTrue($user->isTeacher());
        $this->assertNotNull($user->teacher);

        Notification::assertSentTo($user, WelcomeTeacher::class);
    }

    /**
     *@test
     */
    public function can_find_user_registered_via_google()
    {
        $user_data = [
            'name' => 'test user',
            'id' => '123456',
            'email' => 'test@test.test',
        ];

        $google_user = User::registerTeacherViaGoogle($user_data);
        $other_user = factory(User::class)->state('teacher')->create();

        $found = User::findGoogleUser($user_data);
        $attempt_other = User::findGoogleUser([
            'name' => $other_user->name,
            'email' => $other_user->email,
        ]);

        $this->assertTrue($found->is($google_user));
        $this->assertNull($attempt_other);
    }
}
