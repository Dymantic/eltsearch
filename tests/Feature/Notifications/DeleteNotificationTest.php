<?php


namespace Tests\Feature\Notifications;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class DeleteNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_a_users_notification()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/notifications/{$notification->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }

    /**
     *@test
     */
    public function cannot_delete_another_users_notifications()
    {
        $innocent_user = factory(User::class)->create();
        $evil_user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id' => $innocent_user->id,
        ]);

        $response = $this->actingAs($evil_user)->deleteJson("/api/notifications/{$notification->id}");
        $response->assertForbidden();

        $this->assertDatabaseHas('notifications', ['id' => $notification->id]);
    }
}
