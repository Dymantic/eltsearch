<?php


namespace Tests\Unit\Placements;


use App\Locations\Area;
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
     *@test
     */
    public function teacher_can_create_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $areaA = factory(Area::class)->create();
        $areaB = factory(Area::class)->create();

        $searchInfo = new JobSearchCriteria([
            'area_ids' => [$areaA->id, $areaB->id],
            'student_ages' => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT,
            ],
            'benefits' => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ],
            'weekends' => false,
            'contract_type' => [
                JobPost::CONTRACT_SIX_MONTHS,
                JobPost::CONTRACT_YEAR
            ],
            'hours_per_week' => JobSearch::HOURS_MAX,
            'salary' => JobSearch::SALARY_MID,
        ]);

        $search = $teacher->createJobSearch($searchInfo);

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
        $this->assertSame(JobSearch::SALARY_MID, $search->salary);
    }
}
