<?php


namespace Tests\Unit\Placements;


use App\Locations\Area;
use App\Locations\Region;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherJobSearchesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function teacher_can_create_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $areaA = factory(Area::class)->create();
        $areaB = factory(Area::class)->create();

        $searchInfo = new JobSearchCriteria([
            'area_ids'       => [$areaA->id, $areaB->id],
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
        ]);

        $search = $teacher->setJobSearch($searchInfo);

        $this->assertInstanceOf(JobSearch::class, $search);
        $this->assertTrue($search->teacher->is($teacher));
        $this->assertEquals([$areaA->id, $areaB->id], $search->area_ids);
        $this->assertEquals([
            JobPost::AGE_SENIOR_HIGH,
            JobPost::AGE_UNIVERSITY,
            JobPost::AGE_ADULT,
        ], $search->student_ages);
        $this->assertEquals([
            JobPost::BENEFIT_ARC,
            JobPost::BENEFIT_INSURANCE,
        ], $search->benefits);
        $this->assertFalse($search->weekends);
        $this->assertEquals([
            JobPost::CONTRACT_SIX_MONTHS,
            JobPost::CONTRACT_YEAR,
        ], $search->contract_type);
        $this->assertSame(JobSearch::HOURS_MAX, $search->hours_per_week);
        $this->assertSame(JobSearch::SALARY_AVG, $search->salary);
    }

    /**
     * @test
     */
    public function can_get_used_fields_of_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $areaA = factory(Area::class)->create();
        $areaB = factory(Area::class)->create();

        $searchInfo = new JobSearchCriteria([
            'area_ids'     => [$areaA->id, $areaB->id],
            'student_ages' => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ],
            'weekends'     => false,
            'salary'       => JobSearch::SALARY_AVG,
        ]);

        $search = $teacher->setJobSearch($searchInfo);

        $expected = [
            JobSearch::CRITERIA_LOCATION,
            JobSearch::CRITERIA_STUDENTS,
            JobSearch::CRITERIA_SALARY,
            JobSearch::CRITERIA_WEEKENDS,
        ];

        $this->assertEquals($expected, $search->listCriteria());
    }

    /**
     *@test
     */
    public function can_get_student_ages_to_exclude()
    {
        $search = factory(JobSearch::class)->create([
            'student_ages' => [JobPost::AGE_JUNIOR_HIGH, JobPost::AGE_SENIOR_HIGH],
        ]);

        $expected = [
            JobPost::AGE_KINDERGARTEN,
            JobPost::AGE_ELEMENTARY,
            JobPost::AGE_UNIVERSITY,
            JobPost::AGE_ADULT,
        ];

        $this->assertSame($expected, $search->excludeStudentAges());
    }

    /**
     *@test
     */
    public function setting_a_new_job_search_does_not_change_the_id_of_the_search()
    {
        $teacher = factory(Teacher::class)->create();
        $original_search = factory(JobSearch::class)->create(['teacher_id' => $teacher->id]);

        $this->assertCount(1, $teacher->jobSearches);

        $searchInfo = new JobSearchCriteria([
            'area_ids'       => [],
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
        ]);

        $teacher->setJobSearch($searchInfo);

        $this->assertSame($original_search->id, $teacher->currentJobSearch()->id);
    }

    /**
     *@test
     */
    public function can_get_all_area_ids_for_job_search_including_regions()
    {
        $regionA = factory(Region::class)->create();
        $regionB = factory(Region::class)->create();

        $areaA = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaB = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaC = factory(Area::class)->create(['region_id' => $regionA->id]);
        $areaD = factory(Area::class)->create(['region_id' => $regionB->id]);
        $areaE = factory(Area::class)->create(['region_id' => $regionA->id]);

        $search = factory(JobSearch::class)->create([
            'area_ids' => [$areaD->id, $areaE->id],
            'region_ids' => [$regionA->id],
        ]);

        $expected = [$areaA->id, $areaB->id, $areaC->id, $areaE->id, $areaD->id];

        $this->assertSame($expected, $search->allAreas());
    }
}
