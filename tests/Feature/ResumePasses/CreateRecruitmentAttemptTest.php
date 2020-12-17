<?php


namespace Tests\Feature\ResumePasses;


use App\Placements\RecruitmentAttempt;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CreateRecruitmentAttemptTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function school_can_reach_out_to_a_teacher()
    {
        $this->withoutExceptionHandling();

        [$school, $owner] = $this->setUpSchool();
        $teacher = factory(Teacher::class)->state('public')->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/recruitment-attempts", [
            'teacher_slug'   => $teacher->slug,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('recruitment_attempts', [
            'school_id'      => $school->id,
            'teacher_id'     => $teacher->id,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);
    }

    /**
     *@test
     */
    public function cannot_attempt_to_recruit_more_than_three_times_within_two_months()
    {

        [$school, $owner] = $this->setUpSchool();
        $teacher = factory(Teacher::class)->state('public')->create();

        factory(RecruitmentAttempt::class)->times(3)->create([
            'school_id' => $school->id,
            'teacher_id' => $teacher->id,
        ]);


        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/recruitment-attempts", [
            'teacher_slug'   => $teacher->slug,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);
        $response->assertForbidden();

        $this->travel(65)->days();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/recruitment-attempts", [
            'teacher_slug'   => $teacher->slug,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_teacher_slug_is_required()
    {
        $this->assertFieldIsInvalid(['teacher_slug' => null]);
    }

    /**
     *@test
     */
    public function the_teacher_slug_must_exists_in_the_teachers_table()
    {
        $this->assertFieldIsInvalid(['teacher_slug' => 'AINTNOSLUGOFMINE']);
    }

    /**
     *@test
     */
    public function the_message_is_required()
    {
        $this->assertFieldIsInvalid(['message' => null]);
    }

    /**
     *@test
     */
    public function the_contact_persons_name_is_required()
    {
        $this->assertFieldIsInvalid(['contact_person' => null]);
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_format()
    {
        $this->assertFieldIsInvalid(['email' => 'not-a-real-email']);
    }

    /**
     *@test
     */
    public function the_email_is_required_without_the_phone_number()
    {
        $this->assertFieldIsInvalid([
            'email' => '',
            'phone' => '',
        ]);
    }

    /**
     *@test
     */
    public function the_phone_number_is_required_without_the_email()
    {
        $this->assertFieldIsInvalid([
            'phone' => '',
            'email' => '',
        ]);
    }

    private function assertFieldIsInvalid($field)
    {
        [$school, $owner] = $this->setUpSchool();
        $teacher = factory(Teacher::class)->state('public')->create();

        $valid = [
            'teacher_slug'   => $teacher->slug,
            'message'        => 'test message',
            'contact_person' => 'test person',
            'email'          => 'test@test.test',
            'phone'          => 'test phone'
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/{$school->id}/recruitment-attempts", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
