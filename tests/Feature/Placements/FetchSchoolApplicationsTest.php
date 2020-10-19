<?php


namespace Tests\Feature\Placements;


use App\Placements\JobApplication;
use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchSchoolApplicationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_applications_belonging_to_school_directly()
    {
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $applicationA = factory(JobApplication::class)->create(['job_post_id' => $post->id]);
        $applicationB = factory(JobApplication::class)->create(['job_post_id' => $post->id]);

        $applicationC = factory(JobApplication::class)->create();

        $response = $this->actingAs($owner)->getJson("/api/schools/{$school->id}/applications");
        $response->assertSuccessful();

        $fetched = $response->decodeResponseJson();

        $this->assertCount(2, $fetched);
        $this->assertTrue(collect($fetched)->contains(
            fn ($app) => $app['id'] === $applicationA->id,
        ));
        $this->assertTrue(collect($fetched)->contains(
            fn ($app) => $app['id'] === $applicationB->id,
        ));
    }
}
