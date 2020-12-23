<?php


namespace Tests\Feature\Schools;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSchoolStatusChecksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function fetch_the_status_checks_for_a_school()
    {
        $this->withoutExceptionHandling();

        [$school, $owner] = $this->setUpSchool([
            'introduction' => '',
            'billing_zip'  => '',
        ]);

        $response = $this->actingAs($owner)->getJson("/api/schools/{$school->id}/dashboard-status");
        $response->assertSuccessful();

        $this->assertContains("incomplete_profile", $response->json("statuses"));
        $this->assertContains("incomplete_billing", $response->json("statuses"));


    }
}
