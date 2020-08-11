<?php


namespace Tests\Feature\Teachers;


use App\Teachers\PreviousEmployment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdatePreviousEmploymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function update_existing_previous_employment()
    {
        $this->withoutExceptionHandling();

        $employment = factory(PreviousEmployment::class)->create();

        $response = $this
            ->actingAs($employment->teacher->user)
            ->postJson("/api/teachers/previous-employments/{$employment->id}", [
                'employer' => 'new employer',
                'start_month' => 5,
                'start_year' => 2018,
                'end_month' => 11,
                'end_year' => 2019,
                'job_title' => 'new job title',
                'description' => 'new description',
            ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('previous_employments', [
            'teacher_id' => $employment->teacher->id,
            'employed_from' => Carbon::parse('2018-05-01'),
            'employed_to' => Carbon::parse('2019-11-01'),
            'employer' => 'new employer',
            'job_title' => 'new job title',
            'description' => 'new description',
        ]);
    }

    /**
     *@test
     */
    public function cannot_update_another_teachers_previous_employment()
    {
        $employment = factory(PreviousEmployment::class)->create();
        $other_teacher = factory(User::class)->state('teacher')->create();

        $response = $this
            ->actingAs($other_teacher)
            ->postJson("/api/teachers/previous-employments/{$employment->id}", [
                'employer' => 'new employer',
                'start_month' => 5,
                'start_year' => 2018,
                'end_month' => 11,
                'end_year' => 2019,
                'job_title' => 'new job title',
                'description' => 'new description',
            ]);
        $response->assertForbidden();
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
        $employment = factory(PreviousEmployment::class)->create();
        $valid = [
            'employer' => 'new employer',
            'start_month' => 5,
            'start_year' => 2018,
            'end_month' => 11,
            'end_year' => 2019,
            'job_title' => 'new job title',
            'description' => 'new description',
        ];

        $response = $this
            ->actingAs($employment->teacher->user)
            ->postJson("/api/teachers/previous-employments/{$employment->id}", array_merge($valid, $field));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(array_key_first($field));
    }
}
