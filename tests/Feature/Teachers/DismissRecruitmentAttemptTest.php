<?php


namespace Tests\Feature\Teachers;


use App\Placements\RecruitmentAttempt;
use App\Schools\School;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DismissRecruitmentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function dismiss_a_recruitment_attempt()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $school = factory(School::class)->create();
        $recruitment_attempt = factory(RecruitmentAttempt::class)->create([
            'teacher_id' => $teacher->id,
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/dismissed-recruitment-attempts", [
            'recruitment_attempt_id' => $recruitment_attempt->id,
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('recruitment_attempts', [
            'id' => $recruitment_attempt->id,
            'dismissed' => true,
        ]);

    }

    /**
     *@test
     */
    public function cannot_be_dismissed_by_another_teacher()
    {
        $teacherA = factory(Teacher::class)->create();
        $teacherB = factory(Teacher::class)->create();
        $school = factory(School::class)->create();
        $recruitment_attempt = factory(RecruitmentAttempt::class)->create([
            'teacher_id' => $teacherA->id,
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($teacherB->user)->postJson("/api/teachers/dismissed-recruitment-attempts", [
            'recruitment_attempt_id' => $recruitment_attempt->id,
        ]);
        $response->assertForbidden();

        $this->assertDatabaseHas('recruitment_attempts', [
            'id' => $recruitment_attempt->id,
            'dismissed' => false,
        ]);
    }
}
