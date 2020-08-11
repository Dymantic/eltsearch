<?php


namespace Tests\Feature\Placements;


use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetractJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function retract_a_published_job_post()
    {
        $this->withoutExceptionHandling();

        list($shcool, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->state('public')->create([
            'school_id' => $shcool->id,
        ]);

        $response = $this->actingAs($owner)->deleteJson("/api/published-job-posts/{$post->id}", [
            'job_post_id' => $post->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'id' => $post->id,
            'is_public' => false,
        ]);
    }

    /**
     *@test
     */
    public function another_user_cannot_retract_a_job_post()
    {
        list($shcool, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->state('public')->create([
            'school_id' => $shcool->id,
        ]);
        $another_user = factory(User::class)->state('school')->create();

        $response = $this->actingAs($another_user)->deleteJson("/api/published-job-posts/{$post->id}", [
            'job_post_id' => $post->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id' => $post->id,
            'is_public' => true,
        ]);
    }
}
