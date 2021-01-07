<?php


namespace Tests\Unit\Teachers;


use App\ContactDetails;
use App\Placements\ApplicationApproval;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherApplicationApprovalsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_approval_to_apply_for_a_job_post()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();

        $approval = $teacher->applicationApprovalFor($job_post);

        $this->assertTrue($approval->can_apply);
        $this->assertSame('', $approval->message);
        $this->assertSame($teacher->id, $approval->teacher_id);
        $this->assertSame($job_post->id, $approval->job_post_id);

        $expected_array = [
            'can_apply'   => true,
            'message'     => '',
            'teacher_id'  => $teacher->id,
            'job_post_id' => $job_post->id,
        ];

        $this->assertSame($expected_array, $approval->toArray());
    }

    /**
     *@test
     */
    public function disabled_teacher_cannot_apply_to_jobs()
    {
        $teacher = factory(Teacher::class)->state('disabled')->create();
        $job_post = factory(JobPost::class)->create();

        $approval = $teacher->applicationApprovalFor($job_post);

        $this->assertFalse($approval->can_apply);
        $this->assertSame(ApplicationApproval::DISABLED, $approval->message);
        $this->assertSame($teacher->id, $approval->teacher_id);
        $this->assertSame($job_post->id, $approval->job_post_id);

    }

    /**
     *@test
     */
    public function teacher_with_incomplete_profile_cannot_apply()
    {
        $teacher = factory(Teacher::class)->state('incomplete')->create();
        $job_post = factory(JobPost::class)->create();

        $approval = $teacher->applicationApprovalFor($job_post);

        $this->assertFalse($approval->can_apply);
        $this->assertSame(ApplicationApproval::INCOMPLETE_PROFILE, $approval->message);
        $this->assertSame($teacher->id, $approval->teacher_id);
        $this->assertSame($job_post->id, $approval->job_post_id);
    }

    /**
     *@test
     */
    public function teacher_cannot_apply_again_for_the_same_job_post()
    {
        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->create();
        $teacher->applyForJob($job_post, 'test cover letter', ContactDetails::fake());

        $approval = $teacher->applicationApprovalFor($job_post);

        $this->assertFalse($approval->can_apply);
        $this->assertSame(ApplicationApproval::ALREADY_APPLIED, $approval->message);
        $this->assertSame($teacher->id, $approval->teacher_id);
        $this->assertSame($job_post->id, $approval->job_post_id);
    }
}
