<?php


namespace Tests\Feature\Schools;


use App\Notifications\SchoolProfileReinstated;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReinstateSchoolProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function reinstate_a_disabled_school_profile()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $admin = factory(User::class)->state('admin')->create();
        [$school, $owner] = $this->setUpSchool(['disabled_on' => now()]);

        $response = $this->actingAs($admin)->deleteJson("/api/admin/disabled-schools/{$school->id}");
        $response->assertSuccessful();

        $this->assertDatabaseHas('schools', [
            'id' => $school->id,
            'disabled_on' => null,
        ]);

        Notification::assertSentTo(
            $owner,
            SchoolProfileReinstated::class,
            function($notification, $channels) use ($school) {
                $this->assertTrue($notification->school->is($school));
                $this->assertTrue(in_array('database', $channels));
                $this->assertTrue(in_array('mail', $channels));
                return true;
            }
        );
    }
}
