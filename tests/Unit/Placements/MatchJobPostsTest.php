<?php


namespace Tests\Unit\Placements;


use App\Locations\Area;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchJobPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_match_on_location()
    {
        $area = factory(Area::class)->create();

        $should_match = $this->makeTestSearch(['area_ids' => [$area->id]]);
        $should_not__match = $this->makeTestSearch(['area_ids' => [99]]);

        $post = $this->makeTestPost(['area_id' => $area->id]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_student_ages()
    {
        $should_match = $this->makeTestSearch([
            'student_ages' => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_SENIOR_HIGH
            ]
        ]);

        $should_not_match = $this->makeTestSearch([
            'student_ages' => [
                JobPost::AGE_KINDERGARTEN,
                JobPost::AGE_JUNIOR_HIGH,
                JobPost::AGE_ADULT
            ]
        ]);

        $post = $this->makeTestPost([
            'student_ages' => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
            ]
        ]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_salary()
    {
        $should_match = $this->makeTestSearch([
            'salary' => JobSearch::SALARY_AVG
        ]);

        $should_not_match = $this->makeTestSearch([
            'salary' => JobSearch::SALARY_HIGH
        ]);

        $post = $this->makeTestPost([
            'salary_rate' => JobPost::SALARY_RATE_HOUR,
            'salary_max'  => 550,
            'salary_min'  => 550,
        ]);
        $post->setSalaryGrade();

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_weekend_work()
    {
        $should_match = $this->makeTestSearch([
            'weekends' => true
        ]);

        $should_not_match = $this->makeTestSearch([
            'weekends' => false
        ]);

        $post = $this->makeTestPost([
            'work_on_weekends' => true,
        ]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_benefits()
    {
        $should_match = $this->makeTestSearch([
            'benefits' => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ]
        ]);

        $should_not_match = $this->makeTestSearch([
            'benefits' => [
                JobPost::BENEFIT_RENEWAL_BONUS,
            ]
        ]);

        $post = $this->makeTestPost([
            'benefits' => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
            ]
        ]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_contract_length()
    {
        $should_match = $this->makeTestSearch([
            'contract_type' => [JobPost::CONTRACT_YEAR, JobPost::CONTRACT_OVER_YEAR],
        ]);

        $should_not_match = $this->makeTestSearch([
            'contract_type' => [JobPost::CONTRACT_SIX_MONTHS],
        ]);

        $post = $this->makeTestPost(['contract_length' => JobPost::CONTRACT_YEAR]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_hours_per_week()
    {
        $should_match = $this->makeTestSearch([
            'hours_per_week' => JobSearch::HOURS_LOW,
        ]);

        $should_not_match = $this->makeTestSearch([
            'hours_per_week' => JobSearch::HOURS_MAX,
        ]);

        $post = $this->makeTestPost(['hours_per_week' => 14]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_schedule()
    {
        $should_match = $this->makeTestSearch([
            'schedule' => [JobPost::SCHEDULE_AFTERNOONS, JobPost::SCHEDULE_EVENINGS],
        ]);

        $should_not_match = $this->makeTestSearch([
            'schedule' => [JobPost::SCHEDULE_MORNINGS],
        ]);

        $post = $this->makeTestPost([
            'schedule' => [JobPost::SCHEDULE_EVENINGS],
        ]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_match_on_engagement()
    {
        $should_match = $this->makeTestSearch(['engagement' => JobPost::FULL_TIME]);
        $should_not_match = $this->makeTestSearch(['engagement' => JobPost::PART_TIME]);

        $post = $this->makeTestPost(['engagement' => JobPost::FULL_TIME]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    /**
     * @test
     */
    public function can_make_a_complex_match()
    {
        $area = factory(Area::class)->create();

        $should_match = $this->makeTestSearch([
            'area_ids'       => [$area->id, 55],
            'student_ages'   => [JobPost::AGE_SENIOR_HIGH, JobPost::AGE_UNIVERSITY, JobPost::AGE_ADULT],
            'benefits'       => [JobPost::BENEFIT_ARC],
            'contract_type'  => [JobPost::CONTRACT_YEAR],
            'schedule'       => [],
            'engagement'     => JobPost::FULL_TIME,
            'weekends'       => false,
            'salary'         => null,
            'hours_per_week' => null,
        ]);

        //mismatch on location
        $should_not_match = $this->makeTestSearch([
            'area_ids'       => [55],
            'student_ages'   => [JobPost::AGE_UNIVERSITY, JobPost::AGE_ADULT],
            'benefits'       => [JobPost::BENEFIT_ARC],
            'contract_type'  => [JobPost::CONTRACT_YEAR],
            'schedule'       => [],
            'engagement'     => JobPost::FULL_TIME,
            'weekends'       => false,
            'salary'         => null,
            'hours_per_week' => null,
        ]);

        $post = $this->makeTestPost([
            'area_id'         => $area->id,
            'student_ages'    => [JobPost::AGE_UNIVERSITY, JobPost::AGE_ADULT],
            'benefits'        => [JobPost::BENEFIT_ARC, JobPost::BENEFIT_INSURANCE],
            'contract_length' => JobPost::CONTRACT_YEAR,
            'schedule'        => [JobPost::SCHEDULE_AFTERNOONS, JobPost::SCHEDULE_EVENINGS],
            'engagement'      => JobPost::FULL_TIME,
            'work_on_weekends' => false,
            'salary_rate'     => JobPost::SALARY_RATE_HOUR,
            'salary_min'      => 550,
            'salary_max'      => 700,
            'hours_per_week'  => 25,
        ]);

        $matches = JobSearch::matching($post)->get();

        $this->assertCount(1, $matches);
        $this->assertTrue($matches->first()->is($should_match));
    }

    private function makeTestSearch($criteria): JobSearch
    {
        $default = [
            'area_ids'       => [],
            'student_ages'   => [],
            'benefits'       => [],
            'contract_type'  => [],
            'schedule'       => [],
            'engagement'     => '',
            'weekends'       => null,
            'salary'         => null,
            'hours_per_week' => null,
        ];

        return factory(JobSearch::class)->create(array_merge($default, $criteria));
    }

    private function makeTestPost($attributes): JobPost
    {
        $post = factory(JobPost::class)->state('current')->create($attributes);
        $post->setSalaryGrade();

        return $post;
    }
}
