<?php


namespace Tests\Feature\Placements;


use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteJobSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function delete_an_existing_search()
    {
        $this->withoutExceptionHandling();

        $search = factory(JobSearch::class)->create();

        $response = $this
            ->actingAs($search->teacher->user)
            ->deleteJson("/api/teachers/job-searches/{$search->id}");
        $response->assertSuccessful();

        $this->assertDatabaseMissing('job_searches', ['id' => $search->id]);
    }
}
