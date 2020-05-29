<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetsPasswordFromLinkTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function reset_password_from_link()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $teacher = factory(User::class)->state('teacher')->create();
        $this->asGuest()->post("/password/request", ['email' => $teacher->email]);

        $token = Notification::sent($teacher, ResetPassword::class)->first()->token;

        $response = $this->asGuest()->post("/password/reset", [
            'token' => $token,
            'email' => $teacher->email,
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);
        $response->assertRedirect("/teachers");

        $this->assertTrue(Auth::user()->is($teacher));
        $this->assertTrue(Hash::check('new_password', $teacher->fresh()->password));
    }
}
