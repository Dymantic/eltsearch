<?php


namespace Tests\Feature\Teachers;


use App\Placements\JobPost;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherApplicationApprovalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function check_if_a_teacher_can_apply_for_a_given_job()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $job_post = factory(JobPost::class)->state('current')->create();

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/application-approvals", [
                'job_post_slug' => $job_post->slug,
            ]);
        $response->assertSuccessful();

        $expected = [
            'can_apply' => true,
            'message'   => '',
            'teacher_id' => $teacher->id,
            'job_post_id' => $job_post->id,
        ];

        $this->assertSame($expected, $response->json());
    }
}
