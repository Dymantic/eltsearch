<?php


namespace Tests\Feature\Teachers;


use App\Notifications\TeacherProfileDisabled;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DisableTeacherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function disable_a_teacher_profile()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $admin = factory(User::class)->state('admin')->create();

        $response = $this->actingAs($admin)->postJson("/api/admin/disabled-teachers", [
            'teacher_id' => $teacher->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('teachers', [
            'id'          => $teacher->id,
            'disabled_on' => now()->format('Y-m-d'),
        ]);

        Notification::assertSentTo(
            $teacher->user,
            TeacherProfileDisabled::class,
            function ($notification, $channels) use ($teacher) {
                $this->assertTrue($notification->teacher->is($teacher));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));

                return true;
            }
        );
    }

    /**
     * @test
     */
    public function can_only_be_disabled_by_an_admin_user()
    {
        Notification::fake();

        $teacher = factory(Teacher::class)->state('enabled')->create();
        $bad_guy = factory(User::class)->state('teacher')->create();

        $response = $this->actingAs($bad_guy)->postJson("/api/admin/disabled-teachers", [
            'teacher_id' => $teacher->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('teachers', [
            'id'          => $teacher->id,
            'disabled_on' => null,
        ]);
    }
}
