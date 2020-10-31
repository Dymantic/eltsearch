<?php


namespace Tests\Unit\Placements;


use App\ContactDetails;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherJobApplicationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function teacher_can_apply_for_job()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();
        $contact_details = new ContactDetails([
            'phone' => 'test phone',
            'email' => 'test@test.test',
        ]);

        $application = $teacher->applyForJob($job_post, 'test cover letter', $contact_details);

        $this->assertInstanceOf(JobApplication::class, $application);
        $this->assertTrue($application->teacher->is($teacher));
        $this->assertTrue($application->jobPost->is($job_post));
        $this->assertSame('test cover letter', $application->cover_letter);
        $this->assertSame('test phone', $application->phone);
        $this->assertSame('test@test.test', $application->email);
    }

    /**
     *@test
     */
    public function with_empty_phone_field()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();
        $contact_details = new ContactDetails([
            'phone' => '',
            'email' => 'test@test.test',
        ]);

        $application = $teacher->applyForJob($job_post, 'test cover letter', $contact_details);

        $this->assertInstanceOf(JobApplication::class, $application);
        $this->assertTrue($application->teacher->is($teacher));
        $this->assertTrue($application->jobPost->is($job_post));
        $this->assertSame('test cover letter', $application->cover_letter);
        $this->assertSame('', $application->phone);
        $this->assertSame('test@test.test', $application->email);
    }

    /**
     *@test
     */
    public function empty_email_gets_overwritten_with_teachers_email()
    {
        $teacher = factory(Teacher::class)->create();
        $teacher_email = $teacher->email;
        $job_post = factory(JobPost::class)->create();
        $contact_details = new ContactDetails([
            'phone' => 'test phone',
            'email' => '',
        ]);

        $application = $teacher->applyForJob($job_post, 'test cover letter', $contact_details);

        $this->assertInstanceOf(JobApplication::class, $application);
        $this->assertTrue($application->teacher->is($teacher));
        $this->assertTrue($application->jobPost->is($job_post));
        $this->assertSame('test cover letter', $application->cover_letter);
        $this->assertSame('test phone', $application->phone);
        $this->assertSame($teacher_email, $application->email);
    }

    /**
     *@test
     */
    public function teacher_can_check_if_already_applied_for_job_post()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();
        $contact_details = new ContactDetails([
            'phone' => 'test phone',
            'email' => '',
        ]);

        $this->assertFalse($teacher->fresh()->hasApplicationFor($job_post));

        $teacher->applyForJob($job_post, 'test cover letter', $contact_details);

        $this->assertTrue($teacher->fresh()->hasApplicationFor($job_post));
    }
}
