<?php


namespace Tests\Feature\Placements;


use App\Locations\Area;
use App\Locations\Region;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateJobSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_new_job_search()
    {
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();
        $area = factory(Area::class)->create();
        $region = factory(Region::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-searches", [
            'area_ids'       => [$area->id],
            'region_ids'     => [$region->id],
            'student_ages'   => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ],
            'benefits'       => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'weekends'       => false,
            'contract_type'  => [
                JobPost::CONTRACT_SIX_MONTHS,
                JobPost::CONTRACT_YEAR
            ],
            'hours_per_week' => JobSearch::HOURS_MAX,
            'salary'         => JobSearch::SALARY_AVG,
            'engagement'     => JobPost::FULL_TIME,
            'schedule'       => [JobPost::SCHEDULE_AFTERNOONS, JobPost::SCHEDULE_EVENINGS],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_searches', [
            'teacher_id'     => $teacher->id,
            'area_ids'       => $this->asJson([$area->id], 'area_ids'),
            'region_ids'       => $this->asJson([$region->id], 'region_ids'),
            'student_ages'   => $this->asJson([
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ], 'student_ages'),
            'benefits'       => $this->asJson([
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ], 'benefits'),
            'weekends'       => false,
            'contract_type'  => $this->asJson([
                JobPost::CONTRACT_SIX_MONTHS,
                JobPost::CONTRACT_YEAR
            ], 'contract_type'),
            'hours_per_week' => JobSearch::HOURS_MAX,
            'salary'         => JobSearch::SALARY_AVG,
            'engagement'     => JobPost::FULL_TIME,
            'schedule'       => $this->asJson([
                JobPost::SCHEDULE_AFTERNOONS,
                JobPost::SCHEDULE_EVENINGS
            ], 'schedule'),
        ]);
    }

    /**
     * @test
     */
    public function empty_fields_are_allowed()
    {
        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-searches", [
            'area_ids'       => [],
            'region_ids'       => [],
            'student_ages'   => [],
            'benefits'       => [],
            'weekends'       => null,
            'contract_type'  => [],
            'hours_per_week' => null,
            'salary'         => null,
            'engagement'     => null,
            'schedule'       => [],
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_searches', [
            'teacher_id'     => $teacher->id,
            'area_ids'       => $this->asJson([], 'area_ids'),
            'student_ages'   => $this->asJson([], 'student_ages'),
            'benefits'       => $this->asJson([], 'benefits'),
            'weekends'       => null,
            'contract_type'  => $this->asJson([], 'contract_type'),
            'hours_per_week' => null,
            'salary'         => null,
        ]);
    }

    /**
     * @test
     */
    public function the_area_ids_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['area_ids' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_area_id_must_exist_in_areas_table()
    {
        $this->assertNull(Area::find(99));
        $this->assertFieldIsInvalid(['area_ids' => [99]], 'area_ids.0');
    }

    /**
     *@test
     */
    public function the_region_ids_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['region_ids' => 'not-an-array']);
    }

    /**
     *@test
     */
    public function each_region_id_must_exist_in_regions_table()
    {
        $this->assertFieldIsInvalid(['region_ids' => [99]], 'region_ids.0');
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
    public function each_student_age_must_be_in_the_allowed_list()
    {
        $this->assertFieldIsInvalid(['student_ages' => ['not-a-valid-age']], 'student_ages.0');
    }

    /**
     * @test
     */
    public function the_benefits_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['benefits' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_benefit_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['benefits' => ['not-a-valid-benefit']], 'benefits.0');
    }

    /**
     * @test
     */
    public function the_contract_type_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['contract_type' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_contract_type_must_be_a_valid_type()
    {
        $this->assertFieldIsInvalid(['contract_type' => ['not-a-valid-type']], 'contract_type.0');
    }

    /**
     * @test
     */
    public function the_salary_must_exist_in_allowed_range()
    {
        $this->assertFieldIsInvalid(['salary' => 99999]);
    }

    /**
     * @test
     */
    public function the_hours_per_week_must_be_an_allowed_value()
    {
        $this->assertFieldIsInvalid(['hours_per_week' => 'not-valid-value']);
    }

    /**
     * @test
     */
    public function weekends_must_be_boolean()
    {
        $this->assertFieldIsInvalid(['weekends' => 'not-a-bool']);
        $this->assertFieldIsInvalid(['weekends' => 999]);
    }

    /**
     * @test
     */
    public function the_engagement_must_be_part_or_full_time()
    {
        $this->assertFieldIsInvalid(['engagement' => 'not-a-valid-engagement']);
    }

    /**
     * @test
     */
    public function the_schedule_must_be_an_array()
    {
        $this->assertFieldIsInvalid(['schedule' => 'not-an-array']);
    }

    /**
     * @test
     */
    public function each_schedule_value_must_be_an_allowed_schedule_time()
    {
        $this->assertFieldIsInvalid(['schedule' => ['not-a-valid-schedule-time']], 'schedule.0');
    }

    private function assertFieldIsInvalid($field, $error_key = null)
    {
        $teacher = factory(Teacher::class)->create();
        $area = factory(Area::class)->create();

        $valid = [
            'area_ids'       => [$area->id],
            'student_ages'   => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ],
            'benefits'       => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'weekends'       => false,
            'contract_type'  => [
                JobPost::CONTRACT_SIX_MONTHS,
                JobPost::CONTRACT_YEAR
            ],
            'hours_per_week' => JobSearch::HOURS_MAX,
            'salary'         => JobSearch::SALARY_AVG,
            'engagement'     => JobPost::FULL_TIME,
            'schedule'       => [JobPost::SCHEDULE_AFTERNOONS, JobPost::SCHEDULE_EVENINGS],
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/job-searches", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
