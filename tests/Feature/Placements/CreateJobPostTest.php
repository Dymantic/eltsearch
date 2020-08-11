<?php

namespace Tests\Feature\Placements;

use App\DateFormatter;
use App\Locations\Area;
use App\Placements\JobPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CreateJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_job_post()
    {
        $this->withoutExceptionHandling();

        list($school, $owner) = $this->setUpSchool();

        $area = factory(Area::class)->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/job-posts", [
            'school_name'            => 'test name',
            'description'            => 'test description',
            'area_id'                => $area->id,
            'position'               => 'test position',
            'engagement'             => JobPost::FULL_TIME,
            'hours_per_week'         => 25,
            'min_students_per_class' => 5,
            'max_students_per_class' => 25,
            'student_ages'           => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ],
            'work_on_weekends'       => true,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
                JobPost::REQUIRES_POLICE_CHECK,
                JobPost::REQUIRES_TEFL,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_HOUR,
            'salary_min'             => 500,
            'salary_max'             => 650,
            'start_date'             => Carbon::tomorrow()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
                JobPost::BENEFIT_RENEWAL_BONUS,
            ],
            'contract_length'        => JobPost::CONTRACT_YEAR
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'school_id'              => $school->id,
            'posted_by'              => $owner->id,
            'last_edited_by'         => $owner->id,
            'school_name'            => 'test name',
            'description'            => 'test description',
            'area_id'                => $area->id,
            'position'               => 'test position',
            'engagement'             => JobPost::FULL_TIME,
            'hours_per_week'         => 25,
            'min_students_per_class' => 5,
            'max_students_per_class' => 25,
            'student_ages'           => json_encode([
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ]),
            'work_on_weekends'       => true,
            'requirements'           => json_encode([
                JobPost::REQUIRES_DEGREE,
                JobPost::REQUIRES_POLICE_CHECK,
                JobPost::REQUIRES_TEFL,
            ]),
            'salary_rate'            => JobPost::SALARY_RATE_HOUR,
            'salary_min'             => 500,
            'salary_max'             => 650,
            'start_date'             => Carbon::tomorrow(),
            'benefits'               => json_encode([
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
                JobPost::BENEFIT_RENEWAL_BONUS,
            ]),
            'contract_length'        => JobPost::CONTRACT_YEAR
        ]);
    }

    /**
     *@test
     */
    public function fields_with_allowed_empty_or_null_states_are_valid()
    {
        $this->withoutExceptionHandling();
        list($school, $owner) = $this->setUpSchool();

        $area = factory(Area::class)->create();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/job-posts", [
            'school_name'            => 'test name',
            'description'            => null,
            'area_id'                => null,
            'position'               => null,
            'engagement'             => null,
            'hours_per_week'         => null,
            'min_students_per_class' => null,
            'max_students_per_class' => null,
            'student_ages'           => [],
            'work_on_weekends'       => null,
            'requirements'           => [],
            'salary_rate'            => null,
            'salary_min'             => null,
            'salary_max'             => null,
            'start_date'             => null,
            'benefits'               => [],
            'contract_length'        => null
        ]);

        $response->assertSuccessful();
    }

    /**
     *@test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['school_name' => null]);
    }

    /**
     *@test
     */
    public function the_area_id_must_exist_in_the_areas_table()
    {
        $this->assertNull(Area::find(99));

        $this->assertFieldIsInvalid(['area_id' => 99]);
    }

    /**
     *@test
     */
    public function the_engagement_type_must_be_valid()
    {
        $this->assertFieldIsInvalid(['engagement' => 'neither-full-time-nor-part-time']);
    }

    /**
     *@test
     */
    public function hours_per_week_must_be_an_integer_value()
    {
        $this->assertFieldIsInvalid(['hours_per_week' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_minimum_students_per_class_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['min_students_per_class' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_maximum_students_per_class_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['max_students_per_class' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_student_ages_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['student_ages' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_student_age_must_be_a_valid_age_group()
    {
        $this->assertFieldIsInvalid(['student_ages' => ['not-a-valid-age-group']], 'student_ages.0');
    }

    /**
     *@test
     */
    public function work_on_weekends_must_be_boolean()
    {
        $this->assertFieldIsInvalid(['work_on_weekends' => 'totally-not-a-boolean']);
    }

    /**
     *@test
     */
    public function requirements_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['requirements' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_requirement_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['requirements' => ['not-a-real-requirement']], 'requirements.0');
    }

    /**
     *@test
     */
    public function salary_rate_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['salary_rate' => 'not-monthly-nor-weekly-or-anything-allowed']);
    }

    /**
     *@test
     */
    public function the_minimum_salary_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['salary_min' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_maximum_salary_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['salary_max' => 'not-an-integer']);
    }

    /**
     *@test
     */
    public function the_start_date_must_be_a_date()
    {
        $this->assertFieldIsInvalid(['start_date' => 'not-valid-date']);
    }

    /**
     *@test
     */
    public function benefits_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['benefits' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_benefit_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['benefits' => ['not-a-real-benefit']], 'benefits.0');
    }

    /**
     *@test
     */
    public function the_contract_length_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['contract_length' => 'not-an-allowed-contract-length']);
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        list($school, $owner) = $this->setUpSchool();

        $area = factory(Area::class)->create();

        $valid = [
            'school_name'            => 'test name',
            'description'            => 'test description',
            'area_id'                => $area->id,
            'position'               => 'test position',
            'engagement'             => JobPost::FULL_TIME,
            'hours_per_week'         => 25,
            'min_students_per_class' => 5,
            'max_students_per_class' => 25,
            'student_ages'           => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ],
            'work_on_weekends'       => true,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
                JobPost::REQUIRES_POLICE_CHECK,
                JobPost::REQUIRES_TEFL,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_HOUR,
            'salary_min'             => 500,
            'salary_max'             => 650,
            'start_date'             => Carbon::tomorrow()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
                JobPost::BENEFIT_RENEWAL_BONUS,
            ],
            'contract_length'        => JobPost::CONTRACT_YEAR
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/{$school->id}/job-posts", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
