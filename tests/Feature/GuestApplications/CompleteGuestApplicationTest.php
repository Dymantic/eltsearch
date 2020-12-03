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
            'guest_application.cover_letter'  => 'test cover letter',
            'guest_application.contact_email' => 'test@test.test',
            'guest_application.contact_phone' => 'test phone',

        ]);

        $response = $this->asGuest()->post("complete-guest-applications");
        $response->assertRedirect("/teachers#/applications");
        $this->assertTrue(Auth::user()->is($teacher->user));

        $this->assertDatabaseHas('job_applications', [
            'teacher_id'   => $teacher->id,
            'job_post_id'  => $job_post->id,
            'cover_letter' => 'test cover letter',
            'phone'        => 'test phone',
            'email'        => 'test@test.test',
        ]);

    }
}
