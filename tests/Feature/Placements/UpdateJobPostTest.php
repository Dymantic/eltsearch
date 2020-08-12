<?php


namespace Tests\Feature\Placements;


use App\DateFormatter;
use App\Locations\Area;
use App\Placements\JobPost;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UpdateJobPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function update_an_existing_job_post()
    {
        $this->withoutExceptionHandling();

        $area = factory(Area::class)->create();
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($owner)->postJson("/api/schools/job-posts/{$post->id}", [
            'school_name'            => 'new name',
            'description'            => 'new description',
            'area_id'                => $area->id,
            'position'               => 'new position',
            'engagement'             => JobPost::PART_TIME,
            'hours_per_week'         => 21,
            'min_students_per_class' => 12,
            'max_students_per_class' => 16,
            'student_ages'           => [
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ],
            'work_on_weekends'       => false,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_MONTH,
            'salary_min'             => 50000,
            'salary_max'             => 65000,
            'start_date'             => Carbon::tomorrow()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'contract_length'        => JobPost::CONTRACT_SIX_MONTHS,
            'schedule'               => [
                JobPost::SCHEDULE_MORNINGS,
            ]
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_posts', [
            'school_id'              => $school->id,
            'posted_by'              => $post->posted_by,
            'last_edited_by'         => $owner->id,
            'school_name'            => 'new name',
            'description'            => 'new description',
            'area_id'                => $area->id,
            'position'               => 'new position',
            'engagement'             => JobPost::PART_TIME,
            'hours_per_week'         => 21,
            'min_students_per_class' => 12,
            'max_students_per_class' => 16,
            'student_ages'           => json_encode([
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ]),
            'work_on_weekends'       => false,
            'requirements'           => json_encode([
                JobPost::REQUIRES_DEGREE,
            ]),
            'salary_rate'            => JobPost::SALARY_RATE_MONTH,
            'salary_min'             => 50000,
            'salary_max'             => 65000,
            'start_date'             => Carbon::tomorrow(),
            'benefits'               => json_encode([
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ]),
            'schedule'               => json_encode([JobPost::SCHEDULE_MORNINGS]),
            'contract_length'        => JobPost::CONTRACT_SIX_MONTHS
        ]);

    }

    /**
     * @test
     */
    public function only_members_of_school_team_can_update_posts()
    {
        $area = factory(Area::class)->create();
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);
        $another_user = factory(User::class)->state('school')->create();

        $response = $this->actingAs($another_user)->postJson("/api/schools/job-posts/{$post->id}", [
            'school_name'            => 'new name',
            'description'            => 'new description',
            'area_id'                => $area->id,
            'position'               => 'new position',
            'engagement'             => JobPost::PART_TIME,
            'hours_per_week'         => 21,
            'min_students_per_class' => 12,
            'max_students_per_class' => 16,
            'student_ages'           => [
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ],
            'work_on_weekends'       => false,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_MONTH,
            'salary_min'             => 50000,
            'salary_max'             => 65000,
            'start_date'             => Carbon::tomorrow()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'contract_length'        => JobPost::CONTRACT_SIX_MONTHS
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function can_be_updated_with_certain_empty_states()
    {
        $this->withoutExceptionHandling();

        $area = factory(Area::class)->create();
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $response = $this->actingAs($owner)->postJson("/api/schools/job-posts/{$post->id}", [
            'school_name'            => 'new name',
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

        $this->assertDatabaseHas('job_posts', [
            'school_id'              => $school->id,
            'posted_by'              => $post->posted_by,
            'last_edited_by'         => $owner->id,
            'school_name'            => 'new name',
            'description'            => '',
            'area_id'                => null,
            'position'               => '',
            'engagement'             => '',
            'hours_per_week'         => null,
            'min_students_per_class' => null,
            'max_students_per_class' => null,
            'student_ages'           => json_encode([]),
            'work_on_weekends'       => false,
            'requirements'           => json_encode([]),
            'salary_rate'            => '',
            'salary_min'             => null,
            'salary_max'             => null,
            'start_date'             => Carbon::now(),
            'benefits'               => json_encode([]),
            'contract_length'        => ''
        ]);
    }

    /**
     * @test
     */
    public function the_name_is_required()
    {
        $this->assertFieldIsInvalid(['school_name' => null]);
    }

    /**
     * @test
     */
    public function the_area_id_must_exist_in_the_areas_table()
    {
        $this->assertNull(Area::find(99));

        $this->assertFieldIsInvalid(['area_id' => 99]);
    }

    /**
     * @test
     */
    public function the_engagement_type_must_be_valid()
    {
        $this->assertFieldIsInvalid(['engagement' => 'neither-full-time-nor-part-time']);
    }

    /**
     * @test
     */
    public function hours_per_week_must_be_an_integer_value()
    {
        $this->assertFieldIsInvalid(['hours_per_week' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_minimum_students_per_class_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['min_students_per_class' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_maximum_students_per_class_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['max_students_per_class' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_student_ages_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['student_ages' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_student_age_must_be_a_valid_age_group()
    {
        $this->assertFieldIsInvalid(['student_ages' => ['not-a-valid-age-group']], 'student_ages.0');
    }

    /**
     * @test
     */
    public function work_on_weekends_must_be_boolean()
    {
        $this->assertFieldIsInvalid(['work_on_weekends' => 'totally-not-a-boolean']);
    }

    /**
     * @test
     */
    public function requirements_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['requirements' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_requirement_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['requirements' => ['not-a-real-requirement']], 'requirements.0');
    }

    /**
     * @test
     */
    public function salary_rate_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['salary_rate' => 'not-monthly-nor-weekly-or-anything-allowed']);
    }

    /**
     * @test
     */
    public function the_minimum_salary_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['salary_min' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_maximum_salary_must_be_an_integer()
    {
        $this->assertFieldIsInvalid(['salary_max' => 'not-an-integer']);
    }

    /**
     * @test
     */
    public function the_start_date_must_be_a_date()
    {
        $this->assertFieldIsInvalid(['start_date' => 'not-valid-date']);
    }

    /**
     * @test
     */
    public function benefits_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['benefits' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_benefit_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['benefits' => ['not-a-real-benefit']], 'benefits.0');
    }

    /**
     * @test
     */
    public function the_contract_length_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['contract_length' => 'not-an-allowed-contract-length']);
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $area = factory(Area::class)->create();
        list($school, $owner) = $this->setUpSchool();
        $post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $valid = [
            'school_name'            => 'new name',
            'description'            => 'new description',
            'area_id'                => $area->id,
            'position'               => 'new position',
            'engagement'             => JobPost::PART_TIME,
            'hours_per_week'         => 21,
            'min_students_per_class' => 12,
            'max_students_per_class' => 16,
            'student_ages'           => [
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ],
            'work_on_weekends'       => false,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_MONTH,
            'salary_min'             => 50000,
            'salary_max'             => 65000,
            'start_date'             => Carbon::tomorrow()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'schedule'               => [
                JobPost::SCHEDULE_MORNINGS,
            ],
            'contract_length'        => JobPost::CONTRACT_SIX_MONTHS
        ];

        $response = $this
            ->actingAs($owner)
            ->postJson("/api/schools/job-posts/{$post->id}", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
