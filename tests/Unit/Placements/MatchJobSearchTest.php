<?php


namespace Tests\Unit\Placements;


use App\Locations\Area;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchJobSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_match_on_area()
    {
        $area = factory(Area::class)->create();
        $should_match = factory(JobPost::class)
            ->state('current')->create(['area_id' => $area->id]);
        $should_not_match = factory(JobPost::class)->state('current')->create();
        $not_live = factory(JobPost::class)->state('expired')->create();

        $search = $this->makeTestSearch(['area_ids' => [$area->id, 23, 12]]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_region()
    {
        $area = factory(Area::class)->create();
        $should_match = factory(JobPost::class)
            ->state('current')->create(['area_id' => $area->id]);
        $should_not_match = factory(JobPost::class)->state('current')->create();
        $not_live = factory(JobPost::class)->state('expired')->create();

        $search = $this->makeTestSearch(['region_ids' => [$area->region->id]]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_student_ages()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'student_ages' => [
                    JobPost::AGE_ELEMENTARY,
                    JobPost::AGE_JUNIOR_HIGH,
                ]
            ]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create(['student_ages' => [JobPost::AGE_SENIOR_HIGH, JobPost::AGE_UNIVERSITY]]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create(['student_ages' => [JobPost::AGE_ELEMENTARY, JobPost::AGE_JUNIOR_HIGH]]);

        $search = $this->makeTestSearch([
            'student_ages' => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH,
            ]
        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_weekends()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create(['work_on_weekends' => false]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create(['work_on_weekends' => true]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create(['work_on_weekends' => false]);

        $search = $this->makeTestSearch(['weekends' => false]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_benefits()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'benefits' => [
                    JobPost::BENEFIT_RENEWAL_BONUS,
                    JobPost::BENEFIT_INSURANCE,
                    JobPost::BENEFIT_ARC,
                ]
            ]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'benefits' => [
                    JobPost::BENEFIT_RENEWAL_BONUS,
                    JobPost::BENEFIT_INSURANCE,
                ]
            ]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create([
                'benefits' => [
                    JobPost::BENEFIT_ARC,
                ]
            ]);

        $search = $this->makeTestSearch([
            'benefits' => [
                JobPost::BENEFIT_INSURANCE,
                JobPost::BENEFIT_ARC,
            ],
        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_contract_length()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create(['contract_length' => JobPost::CONTRACT_YEAR]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create(['contract_length' => JobPost::CONTRACT_SIX_MONTHS]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create(['contract_length' => JobPost::CONTRACT_YEAR]);

        $search = $this->makeTestSearch([
            'contract_type' => [
                JobPost::CONTRACT_YEAR,
                JobPost::CONTRACT_OVER_YEAR,
            ]
        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_hours_per_week()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create(['hours_per_week' => 25]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create(['hours_per_week' => 14]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create(['hours_per_week' => 26]);

        $search = $this->makeTestSearch(['hours_per_week' => JobSearch::HOURS_MAX]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_schedule()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'schedule' => [
                    JobPost::SCHEDULE_AFTERNOONS,
                    JobPost::SCHEDULE_EVENINGS,
                ]
            ]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'schedule' => [
                    JobPost::SCHEDULE_MORNINGS,
                    JobPost::SCHEDULE_AFTERNOONS,
                ]
            ]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create([
                'schedule' => [
                    JobPost::SCHEDULE_AFTERNOONS,
                    JobPost::SCHEDULE_EVENINGS,
                ]
            ]);

        $search = $this->makeTestSearch([
            'schedule' => [
                JobPost::SCHEDULE_AFTERNOONS,
                JobPost::SCHEDULE_EVENINGS
            ]
        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_engagement()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create(['engagement' => JobPost::PART_TIME]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create(['engagement' => JobPost::FULL_TIME]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create(['engagement' => JobPost::PART_TIME]);

        $search = $this->makeTestSearch(['engagement' => JobPost::PART_TIME]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_salary()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'salary_rate' => JobPost::SALARY_RATE_HOUR,
                'salary_min'  => 550,
                'salary_max'  => 700,
            ]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'salary_rate' => JobPost::SALARY_RATE_HOUR,
                'salary_min'  => 350,
                'salary_max'  => 450,
            ]);

        $too_old = factory(JobPost::class)
            ->state('expired')
            ->create([
                'salary_rate' => JobPost::SALARY_RATE_HOUR,
                'salary_min'  => 550,
                'salary_max'  => 700,
            ]);

        $should_match->setSalaryGrade();
        $should_not_match->setSalaryGrade();
        $too_old->setSalaryGrade();

        $search = $this->makeTestSearch(['salary' => JobSearch::SALARY_AVG]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_make_more_complex_match()
    {
        $area = factory(Area::class)->create();
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'area_id'          => $area->id,
                'student_ages'     => [JobPost::AGE_UNIVERSITY, JobPost::AGE_ADULT],
                'work_on_weekends' => false,
                'benefits'         => [JobPost::BENEFIT_ARC, JobPost::BENEFIT_INSURANCE],
                'contract_length'  => JobPost::CONTRACT_YEAR,
                'salary_rate'      => JobPost::SALARY_RATE_HOUR,
                'salary_min'       => 550,
                'salary_max'       => 700,
            ]);

        $should_not_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'area_id'          => $area->id,
                'student_ages'     => [JobPost::AGE_ELEMENTARY, JobPost::AGE_JUNIOR_HIGH],
                'work_on_weekends' => false,
                'benefits'         => [JobPost::BENEFIT_ARC, JobPost::BENEFIT_INSURANCE],
                'contract_length'  => JobPost::CONTRACT_YEAR,
                'salary_rate'      => JobPost::SALARY_RATE_HOUR,
                'salary_min'       => 550,
                'salary_max'       => 700,
            ]);

        $should_match->setSalaryGrade();
        $should_not_match->setSalaryGrade();

        $search = $this->makeTestSearch([
            'area_ids'      => [$area->id, 22, 33],
            'student_ages'  => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT
            ],
            'weekends'      => false,
            'benefits'      => [JobPost::BENEFIT_ARC],
            'contract_type' => [JobPost::CONTRACT_YEAR, JobPost::CONTRACT_OVER_YEAR],
            'salary'        => JobSearch::SALARY_AVG,
        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function does_not_match_on_posts_already_matched()
    {
        $should_match = factory(JobPost::class)
            ->state('current')
            ->create([
                'schedule' => [
                    JobPost::SCHEDULE_AFTERNOONS,
                    JobPost::SCHEDULE_EVENINGS,
                ]
            ]);


        $search = $this->makeTestSearch([
            'schedule' => [
                JobPost::SCHEDULE_AFTERNOONS,
                JobPost::SCHEDULE_EVENINGS
            ]
        ]);

        factory(JobMatch::class)->create([
            'job_post_id'   => $should_match->id,
            'job_search_id' => $search->id,

        ]);

        $matches = JobPost::matching($search)->get();

        $this->assertCount(0, $matches);
    }

    private function makeTestSearch($criteria)
    {
        $default = [
            'area_ids'       => [],
            'region_ids'     => [],
            'student_ages'   => [],
            'benefits'       => [],
            'contract_type'  => [],
            'schedule'       => [],
            'engagement'     => '',
            'weekends'       => null,
            'salary'         => null,
            'hours_per_week' => null,
        ];

        return $search = factory(JobSearch::class)
            ->create(array_merge($default, $criteria));
    }
}
