<?php


namespace Tests\Feature\GuestApplications;


use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CompleteGuestApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function complete_the_guest_application()
    {
        $this->withoutExceptionHandling();

        $job_post = factory(JobPost::class)->state('current')->create();
        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id'    => $teacher->id,
            'guest_application.post_slug'     => $job_post->slug,
            'guest_application.user_id'       => $teacher->user_id,

        ]);

        $response = $this->asGuest()->post("guest-applications", [
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);
        $response->assertRedirect("/teachers/#applications");
        $this->assertTrue(Auth::user()->is($teacher->user));

        $this->assertDatabaseHas('job_applications', [
            'teacher_id'   => $teacher->id,
            'job_post_id'  => $job_post->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);

    }

    /**
     *@test
     */
    public function the_cover_letter_is_required()
    {
        $this->assertFieldIsInvalid(['cover_letter' => null]);
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_email()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-valid-email']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_the_phone_number()
    {
        $this->assertFieldIsInvalid([
            'email' => null,
            'phone' => null,
        ]);
    }

    /**
     *@test
     */
    public function the_phone_is_required_without_the_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => null,
            'email' => null,
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        $job_post = factory(JobPost::class)->state('current')->create();
        $teacher = factory(Teacher::class)->create();
        session([
            'guest_application.teacher_id'    => $teacher->id,
            'guest_application.post_slug'     => $job_post->slug,
            'guest_application.user_id'       => $teacher->user_id,

        ]);

        $valid = [
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ];

        $response = $this
            ->asGuest()
            ->from('/guest-applications')
            ->post("guest-applications", array_merge($valid, $field));
        $response->assertRedirect("/guest-applications");
        $response->assertSessionHasErrors(array_key_first($field));
    }
}
