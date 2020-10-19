<?php


namespace Tests\Feature\Placements;


use App\Placements\JobApplication;
use App\Placements\ShowOfInterest;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTeacherShowOfInterestsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function fetch_the_shows_of_interests_for_a_given_teacher()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $applicationA = factory(JobApplication::class)->create([
            'teacher_id' => $teacher->id,
        ]);
        $applicationB = factory(JobApplication::class)->create([
            'teacher_id' => $teacher->id,
        ]);
        $show_of_interestA = factory(ShowOfInterest::class)->create([
            'job_application_id' => $applicationA->id,
        ]);
        $show_of_interestB = factory(ShowOfInterest::class)->create([
            'job_application_id' => $applicationB->id,
        ]);
        $show_of_interestC = factory(ShowOfInterest::class)->create();

        $response = $this->actingAs($teacher->user)->getJson("/api/teachers/show-of-interests");
        $response->assertSuccessful();

        $fetched = $response->json();

        $this->assertCount(2, $fetched);

        $this->assertTrue(collect($fetched)->contains(
            fn ($show) => $show['id'] === $show_of_interestA->id
        ));
        $this->assertTrue(collect($fetched)->contains(
            fn ($show) => $show['id'] === $show_of_interestB->id
        ));
    }
}
