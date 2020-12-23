<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTeacherDashboardStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_the_dashboard_statuses_for_a_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->state('incomplete')->create();

        $response = $this->actingAs($teacher->user)->getJson("/api/teachers/dashboard-status");
        $response->assertSuccessful();

        $this->assertContains('incomplete_profile', $response->json('statuses'));
    }
}
