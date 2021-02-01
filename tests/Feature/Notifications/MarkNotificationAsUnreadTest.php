<?php


namespace Tests\Feature\Notifications;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class MarkNotificationAsUnreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function mark_a_notification_as_unread()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id'   => $user->id,
            'read_at'         => now()->subDay(),
        ]);

        $this->assertTrue($notification->fresh()->read());


        $response = $this
            ->actingAs($user)
            ->deleteJson("/api/read-notifications/{$notification->id}");
        $response->assertSuccessful();

        $this->assertFalse($notification->fresh()->read());
    }

    /**
     *@test
     */
    public function cannot_unread_another_users_notification()
    {
        $innocent_user = factory(User::class)->create();
        $evil_user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id' => $innocent_user->id,
            'read_at' => now()->subDay(),
        ]);

        $response = $this
            ->actingAs($evil_user)
            ->deleteJson("/api/read-notifications/{$notification->id}");
        $response->assertForbidden();

        $this->assertTrue($notification->fresh()->read());
    }
}
