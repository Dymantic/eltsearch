<?php


namespace Tests\Feature\Placements;


use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function publish_a_job_post()
    {
        $this->withoutExceptionHandling();

        list($shcool, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->state('draft')->create([
            'school_id' => $shcool->id,
        ]);

        $response = $this->actingAs($owner)->postJson("/api/published-job-posts", [
            'job_post_id' => $post->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'id' => $post->id,
            'is_public' => true,
            'first_published_at' => now(),
        ]);
    }

    /**
     *@test
     */
    public function post_cannot_be_published_by_another_user()
    {
        list($shcool, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->state('draft')->create([
            'school_id' => $shcool->id,
        ]);
        $another_user = factory(User::class)->state('school')->create();

        $response = $this->actingAs($another_user)->postJson("/api/published-job-posts", [
            'job_post_id' => $post->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('job_posts', [
            'id' => $post->id,
            'is_public' => false,
            'first_published_at' => null,
        ]);
    }


}
