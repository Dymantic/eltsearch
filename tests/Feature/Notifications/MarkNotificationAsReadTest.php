<?php

namespace Tests\Feature\Notifications;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class MarkNotificationAsReadTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function mark_a_notification_as_read()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson("/api/read-notifications", [
            'notification_id' => $notification->id,
        ]);
        $response->assertSuccessful();

        $this->assertTrue($notification->fresh()->read());
    }

    /**
     *@test
     */
    public function cannot_mark_another_users_notifications_as_read()
    {
        $innocent_user = factory(User::class)->create();
        $evil_user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_type' => User::class,
            'notifiable_id' => $innocent_user->id,
        ]);

        $response = $this->actingAs($evil_user)->postJson("/api/read-notifications", [
            'notification_id' => $notification->id,
        ]);
        $response->assertForbidden();

        $this->assertFalse($notification->fresh()->read());
    }
}
