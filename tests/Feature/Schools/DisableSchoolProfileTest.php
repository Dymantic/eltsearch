<?php


namespace Tests\Feature\Schools;


use App\Notifications\SchoolProfileDisabled;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DisableSchoolProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function disable_school_profile()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $admin = factory(User::class)->state('admin')->create();
        [$school, $owner] = $this->setUpSchool();

        $response = $this->actingAs($admin)->postJson("/api/admin/disabled-schools", [
            'school_id' => $school->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'disabled_on' => now()->format('Y-m-d'),
        ]);

        Notification::assertSentTo(
            $owner,
            SchoolProfileDisabled::class,
            function($notification, $channels) use ($school) {
                $this->assertTrue($notification->school->is($school));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));
                return true;
            }
        );
    }

    /**
     *@test
     */
    public function can_only_be_disabled_by_admin()
    {
        Notification::fake();

        $bad_guy = factory(User::class)->state('school')->create();
        [$school, $owner] = $this->setUpSchool();

        $response = $this->actingAs($bad_guy)->postJson("/api/admin/disabled-schools", [
            'school_id' => $school->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'disabled_on' => null,
        ]);
    }
}
