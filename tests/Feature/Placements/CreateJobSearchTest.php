<?php


namespace Tests\Feature\Placements;


use App\Locations\Area;
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

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-searches", [
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
            'salary'         => JobSearch::SALARY_MID,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_searches', [
            'teacher_id'     => $teacher->id,
            'area_ids'       => json_encode([$area->id]),
            'student_ages'   => json_encode([
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ]),
            'benefits'       => json_encode([
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ]),
            'weekends'       => false,
            'contract_type'  => json_encode([
                JobPost::CONTRACT_SIX_MONTHS,
                JobPost::CONTRACT_YEAR
            ]),
            'hours_per_week' => JobSearch::HOURS_MAX,
            'salary'         => JobSearch::SALARY_MID,
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
            'student_ages'   => [],
            'benefits'       => [],
            'weekends'       => null,
            'contract_type'  => [],
            'hours_per_week' => null,
            'salary'         => null,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('job_searches', [
            'teacher_id'     => $teacher->id,
            'area_ids'       => json_encode([]),
            'student_ages'   => json_encode([]),
            'benefits'       => json_encode([]),
            'weekends'       => true,
            'contract_type'  => json_encode([]),
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
            'salary'         => JobSearch::SALARY_MID,
        ];

        $response = $this
            ->actingAs($teacher->user)
            ->postJson("/api/teachers/job-searches", array_merge($valid, $field));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($error_key ?? array_key_first($field));
    }
}
