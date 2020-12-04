<?php

namespace Tests\Feature\Polling;

use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class CheckForNewNotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function check_for_new_notifications()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $current = now()->timestamp;
        $this->travel(5)->minutes();

        factory(DatabaseNotification::class)->create([
            'notifiable_id' => $teacher->user->id,
            'notifiable_type' => User::class,
        ]);

        $response = $this
            ->actingAs($teacher->user)
            ->getJson("/api/new-notifications-status?t={$current}");
        $response->assertSuccessful();

        $this->assertTrue($response->json('has_new'));

        $current = now()->timestamp;

        $response = $this
            ->actingAs($teacher->user)
            ->getJson("/api/new-notifications-status?t={$current}");
        $response->assertSuccessful();

        $this->assertFalse($response->json('has_new'));
    }

}
