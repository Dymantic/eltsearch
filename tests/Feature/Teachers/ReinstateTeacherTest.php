<?php


namespace Tests\Feature\Teachers;


use App\Notifications\TeacherProfileDisabled;
use App\Notifications\TeacherProfileReinstated;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReinstateTeacherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function reinstate_a_disabled_teachers_profile()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->state('disabled')->create();
        $admin = factory(User::class)->state('admin')->create();

        $response = $this
            ->actingAs($admin)
            ->deleteJson("/api/admin/disabled-teachers/{$teacher->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'          => $teacher->id,
            'disabled_on' => null,
        ]);

        Notification::assertSentTo(
            $teacher->user,
            TeacherProfileReinstated::class,
            function ($notification, $channels) use ($teacher) {
                $this->assertTrue($notification->teacher->is($teacher));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));

                return true;
            }
        );
    }
}
