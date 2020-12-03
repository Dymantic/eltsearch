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

        $post = factory(JobPost::class)->state('current')->create();

        $response = $this->asGuest()->post("/guest-applications/", [
            'job_post_slug' => $post->slug,
            'cover_letter' => 'test cover letter',
            'email' => 'test@test.test',
            'phone' => 'test phone'
        ]);
        $response->assertRedirect('/guest-applications/create-profile');

        $this->assertSame('test cover letter', session('guest_application.cover_letter'));
        $this->assertSame($post->slug, session('guest_application.post_slug'));
        $this->assertSame('test@test.test', session('guest_application.contact_email'));
        $this->assertSame('test phone', session('guest_application.contact_phone'));
    }

    /**
     *@test
     */
    public function the_cover_letter_is_required()
    {
        $this->assertFieldIsInvalid(['cover_letter' => '']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_phone()
    {
        $this->assertFieldIsInvalid([
            'email' => '',
            'phone' => '',
        ]);
    }

    /**
     *@test
     */
    public function the_email_must_be_valid()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_post_slug_must_exist_for_a_post()
    {
        $this->assertNull(JobPost::where('slug', 'does-not-exist')->first());

        $this->assertFieldIsInvalid(['job_post_slug' => 'does-not-exist']);
    }

    /**
     *@test
     */
    public function phone_is_required_without_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => '',
            'email' => '',
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $post = factory(JobPost::class)->state('current')->create();

        $valid = [
            'job_post_slug' => $post->slug,
            'cover_letter' => 'test cover letter',
            'email' => 'test@test.test',
            'phone' => 'test phone'
        ];

        $response = $this
            ->asGuest()
            ->from("/job-posts/{$post->slug}/apply")
            ->post("/guest-applications/", array_merge($valid, $field));

        $response->assertRedirect("/job-posts/{$post->slug}/apply");
        $response->assertSessionHasErrors(array_key_first($field));
    }
}
