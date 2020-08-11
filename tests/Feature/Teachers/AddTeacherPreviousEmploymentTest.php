<?php


namespace Tests\Feature\Teachers;


use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AddTeacherPreviousEmploymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function add_a_previous_employment_to_teacher_profile()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/previous-employment", [
            'employer' => 'test employer',
            'start_month' => 1,
            'start_year' => 2010,
            'end_month' => 11,
            'end_year' => 2010,
            'job_title' => 'test job title',
            'description' => 'test description',
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('previous_employments', [
            'teacher_id' => $teacher->id,
            'employed_from' => Carbon::parse('2010-01-01'),
            'employed_to' => Carbon::parse('2010-11-01'),
            'employer' => 'test employer',
            'job_title' => 'test job title',
            'description' => 'test description',
        ]);
    }

    /**
     *@test
     */
    public function end_dates_and_description_can_be_empty()
    {
        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/previous-employment", [
            'employer' => 'test employer',
            'start_month' => 1,
            'start_year' => 2010,
            'end_month' => null,
            'end_year' => null,
            'job_title' => 'test job title',
            'description' => null,
        ]);
        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_employer_is_required()
    {
        $this->assertFieldIsInvalid(['employer' => null]);
    }

    /**
     *@test
     */
    public function the_job_title_is_required()
    {
        $this->assertFieldIsInvalid(['job_title' => null]);
    }

    /**
     *@test
     */
    public function the_start_month_is_required()
    {
        $this->assertFieldIsInvalid(['start_month' => null]);
    }

    /**
     *@test
     */
    public function the_start_month_must_be_a_valid_month_integer()
    {
        $this->assertFieldIsInvalid(['start_month' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['start_month' => 0]);
        $this->assertFieldIsInvalid(['start_month' => 13]);
        $this->assertFieldIsInvalid(['start_month' => -10]);
        $this->assertFieldIsInvalid(['start_month' => 1.5]);
    }

    /**
     *@test
     */
    public function the_start_year_is_required()
    {
        $this->assertFieldIsInvalid(['start_year' => null]);
    }

    /**
     *@test
     */
    public function the_start_tear_must_be_a_valid_year_integer()
    {
        $this->assertFieldIsInvalid(['start_year' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['start_year' => 1800]);
        $this->assertFieldIsInvalid(['start_year' => -1800]);
        $this->assertFieldIsInvalid(['start_year' => 1.25]);
        $this->assertFieldIsInvalid(['start_year' => 2500]);
    }

    /**
     *@test
     */
    public function the_end_month_is_required_with_the_end_year()
    {
        $this->assertFieldIsInvalid([
            'end_month' => null,
            'end_year' => 2010,
        ]);
    }

    /**
     *@test
     */
    public function the_end_year_is_required_with_the_end_month()
    {
        $this->assertFieldIsInvalid([
            'end_year' => null,
            'end_month' => 5,
        ]);
    }

    /**
     *@test
     */
    public function the_end_month_must_be_a_valid_month_integer()
    {
        $this->assertFieldIsInvalid(['end_month' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['end_month' => 0]);
        $this->assertFieldIsInvalid(['end_month' => 13]);
        $this->assertFieldIsInvalid(['end_month' => -10]);
        $this->assertFieldIsInvalid(['end_month' => 1.5]);
    }

    /**
     *@test
     */
    public function the_end_year_must_be_a_valid_year_integer()
    {
        $this->assertFieldIsInvalid(['end_year' => 'not-an-integer']);
        $this->assertFieldIsInvalid(['end_year' => 1800]);
        $this->assertFieldIsInvalid(['end_year' => -1800]);
        $this->assertFieldIsInvalid(['end_year' => 1.25]);
        $this->assertFieldIsInvalid(['end_year' => 2500]);
    }

    private function assertFieldIsInvalid($field)
    {
        $teacher = factory(Teacher::class)->create();
        $valid = [
            'employer' => 'test employer',
            'start_month' => 1,
            'start_year' => 2010,
            'end_month' => 11,
            'end_year' => 2010,
            'job_title' => 'test job title',
            'description' => 'test description',
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/previous-employment", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
