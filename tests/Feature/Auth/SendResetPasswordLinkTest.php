<?php


namespace Tests\Feature\Auth;


use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendResetPasswordLinkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function send_a_reset_password_link()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this->asGuest()
                         ->from("/password/reset")
                         ->post("/password/request", ['email' => $user->email]);
        $response->assertRedirect("/password/reset");

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            fn($n) => $this->assertNotificationHasToken($n));
    }

    private function assertNotificationHasToken($notification)
    {
        return !!$notification->token;
    }
}
