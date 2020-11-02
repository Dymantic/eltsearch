<?php


namespace Tests\Feature\Placements;


use App\Jobs\MatchJobSearch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class UpdatingJobSearchDispatchesMatchJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function dispatches_job_when_teacher_updates_job_search()
    {
        Bus::fake();
        $this->withoutExceptionHandling();

        $teacher = factory(Teacher::class)->create();

        $response = $this->actingAs($teacher->user)->postJson("/api/teachers/job-searches", [
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
            'engagement'     => JobPost::FULL_TIME,
            'schedule'       => [JobPost::SCHEDULE_AFTERNOONS, JobPost::SCHEDULE_EVENINGS],
        ]);
        $response->assertSuccessful();

        Bus::assertDispatched(function (MatchJobSearch $job) use ($teacher) {
            $this->assertTrue($job->jobSearch->teacher->is($teacher));
            return true;
        });


    }
}
