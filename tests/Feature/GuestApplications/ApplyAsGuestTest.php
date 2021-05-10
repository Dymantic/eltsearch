<?php


namespace Tests\Feature\GuestApplications;


use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertFalse;

class ApplyAsGuestTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function start_application_for_post_as_a_guest()
    {
        $this->withoutExceptionHandling();
        $this->refreshApplicationWithLocale('en');

        $post = factory(JobPost::class)->state('current')->create();

        $response = $this->asGuest()->get("/en/job-posts/{$post->slug}/apply");
        $response ->assertViewIs('front.guest-applications.create-profile');

        $this->assertSame($post->slug, session('guest_application.post_slug'));
    }


}
