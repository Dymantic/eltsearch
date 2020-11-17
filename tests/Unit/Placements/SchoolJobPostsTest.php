<?php

namespace Tests\Unit\Placements;

use App\DateFormatter;
use App\Exceptions\InsufficientTokensException;
use App\Locations\Area;
use App\Placements\JobPost;
use App\Placements\JobPostInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SchoolJobPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function school_can_post_a_job()
    {
        list($school, $owner) = $this->setUpSchool();
        $area = factory(Area::class)->create();

        $postInfo = new JobPostInfo([
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
            'contract_length'        => JobPost::CONTRACT_YEAR,
            'schedule'               => [
                JobPost::SCHEDULE_MORNINGS,
                JobPost::SCHEDULE_AFTERNOONS,
            ]
        ]);

        $job_post = $school->postJob($postInfo, $owner);

        $this->assertInstanceOf(JobPost::class, $job_post);
        $this->assertSame('test name', $job_post->school_name);
        $this->assertSame('test description', $job_post->description);
        $this->assertTrue($job_post->area->is($area));
        $this->assertSame('test position', $job_post->position);
        $this->assertSame(25, $job_post->hours_per_week);
        $this->assertSame(5, $job_post->min_students_per_class);
        $this->assertSame(25, $job_post->max_students_per_class);
        $this->assertEquals([
            JobPost::AGE_ELEMENTARY,
            JobPost::AGE_JUNIOR_HIGH,
            JobPost::AGE_SENIOR_HIGH,
        ], $job_post->student_ages);
        $this->assertTrue($job_post->work_on_weekends);
        $this->assertEquals([
            JobPost::REQUIRES_DEGREE,
            JobPost::REQUIRES_POLICE_CHECK,
            JobPost::REQUIRES_TEFL,
        ], $job_post->requirements);
        $this->assertSame(JobPost::SALARY_RATE_HOUR, $job_post->salary_rate);
        $this->assertSame(500, $job_post->salary_min);
        $this->assertSame(650, $job_post->salary_max);
        $this->assertTrue(Carbon::tomorrow()->isSameDay($job_post->start_date));
        $this->assertEquals([
            JobPost::BENEFIT_ARC,
            JobPost::BENEFIT_INSURANCE,
            JobPost::BENEFIT_RENEWAL_BONUS,
        ], $job_post->benefits);
        $this->assertSame(JobPost::CONTRACT_YEAR, $job_post->contract_length);
        $this->assertEquals([
            JobPost::SCHEDULE_MORNINGS,
            JobPost::SCHEDULE_AFTERNOONS,
        ], $job_post->schedule);

        $this->assertTrue($job_post->school->is($school));
        $this->assertTrue($job_post->postedBy->is($owner));
        $this->assertTrue($job_post->lastEditedBy->is($owner));

    }

    /**
     * @test
     */
    public function can_update_job_info()
    {
        list($school, $owner) = $this->setUpSchool();
        $area = factory(Area::class)->create();
        $job_post = factory(JobPost::class)->create([
            'school_id' => $school->id,
        ]);

        $postInfo = new JobPostInfo([
            'school_name'            => 'new name',
            'description'            => 'new description',
            'area_id'                => $area->id,
            'position'               => 'new position',
            'engagement'             => JobPost::PART_TIME,
            'hours_per_week'         => 20,
            'min_students_per_class' => 6,
            'max_students_per_class' => 23,
            'student_ages'           => [
                JobPost::AGE_ELEMENTARY,
                JobPost::AGE_JUNIOR_HIGH,
            ],
            'work_on_weekends'       => false,
            'requirements'           => [
                JobPost::REQUIRES_DEGREE,
                JobPost::REQUIRES_POLICE_CHECK,
            ],
            'salary_rate'            => JobPost::SALARY_RATE_WEEK,
            'salary_min'             => 10000,
            'salary_max'             => 15000,
            'start_date'             => Carbon::today()->format(DateFormatter::STANDARD),
            'benefits'               => [
                JobPost::BENEFIT_ARC,
                JobPost::BENEFIT_INSURANCE,
                JobPost::BENEFIT_RENEWAL_BONUS,
            ],
            'contract_length'        => JobPost::CONTRACT_OVER_YEAR,
            'schedule'               => [
                JobPost::SCHEDULE_MORNINGS,
                JobPost::SCHEDULE_AFTERNOONS,
            ]
        ]);

        $job_post->updateInfo($postInfo, $owner);

        $this->assertInstanceOf(JobPost::class, $job_post);
        $this->assertSame('new name', $job_post->school_name);
        $this->assertSame('new description', $job_post->description);
        $this->assertTrue($job_post->area->is($area));
        $this->assertSame('new position', $job_post->position);
        $this->assertSame(20, $job_post->hours_per_week);
        $this->assertSame(6, $job_post->min_students_per_class);
        $this->assertSame(23, $job_post->max_students_per_class);
        $this->assertEquals([
            JobPost::AGE_ELEMENTARY,
            JobPost::AGE_JUNIOR_HIGH,
        ], $job_post->student_ages);
        $this->assertFalse($job_post->work_on_weekends);
        $this->assertEquals([
            JobPost::REQUIRES_DEGREE,
            JobPost::REQUIRES_POLICE_CHECK,
        ], $job_post->requirements);
        $this->assertSame(JobPost::SALARY_RATE_WEEK, $job_post->salary_rate);
        $this->assertSame(10000, $job_post->salary_min);
        $this->assertSame(15000, $job_post->salary_max);
        $this->assertTrue(Carbon::today()->isSameDay($job_post->start_date));
        $this->assertEquals([
            JobPost::BENEFIT_ARC,
            JobPost::BENEFIT_INSURANCE,
            JobPost::BENEFIT_RENEWAL_BONUS,
        ], $job_post->benefits);
        $this->assertSame(JobPost::CONTRACT_OVER_YEAR, $job_post->contract_length);
        $this->assertEquals([
            JobPost::SCHEDULE_MORNINGS,
            JobPost::SCHEDULE_AFTERNOONS,
        ], $job_post->schedule);
        $this->assertTrue($job_post->school->is($school));
        $this->assertTrue($job_post->lastEditedBy->is($owner));
    }

    /**
     * @test
     */
    public function can_make_a_job_post_public()
    {
        $post = factory(JobPost::class)->state('draft')->create();
        $post->school->grantTokens(1, 1, now()->addCentury());
        $token = $post->school->fresh()->nextToken();

        $post->publish($token);

        $this->assertTrue($post->fresh()->first_published_at->isSameDay(Carbon::today()));
        $this->assertTrue($post->fresh()->is_public);
        $this->assertTrue($token->isSpent());
    }

    /**
     *@test
     */
    public function publishing_for_first_time_requires_a_token()
    {
        $post = factory(JobPost::class)->state('draft')->create();
        $post->school->grantTokens(1, 1, now()->addCentury());

        try {
            $post->publish();
            $this->fail('Expected exception not thrown');
        } catch(\Exception $e) {
            $this->assertInstanceOf(InsufficientTokensException::class, $e);
        }


        $this->assertNull($post->fresh()->first_published_at);
        $this->assertFalse($post->fresh()->is_public);
    }

    /**
     * @test
     */
    public function making_a_previously_public_post_public_does_not_change_the_published_date()
    {
        $publish_date = Carbon::today()->subWeek();
        $post = factory(JobPost::class)->state('private')->create([
            'first_published_at' => $publish_date,
        ]);

        $post->publish();

        $this->assertTrue($post->fresh()->first_published_at->eq($publish_date));
        $this->assertTrue($post->fresh()->is_public);
    }

    /**
     *@test
     */
    public function republishing_does_not_spend_token_if_given()
    {
        $publish_date = Carbon::today()->subWeek();
        $post = factory(JobPost::class)->state('private')->create([
            'first_published_at' => $publish_date,
        ]);
        $post->school->grantTokens(1, 1, now()->addCentury());
        $token = $post->school->fresh()->nextToken();

        $post->publish($token);

        $this->assertTrue($post->fresh()->first_published_at->eq($publish_date));
        $this->assertTrue($post->fresh()->is_public);
        $this->assertFalse($token->isSpent());
    }

    /**
     *@test
     */
    public function republishing_does_not_require_a_token()
    {
        $publish_date = Carbon::today()->subWeek();
        $post = factory(JobPost::class)->state('private')->create([
            'first_published_at' => $publish_date,
        ]);


        $post->publish();

        $this->assertTrue($post->fresh()->first_published_at->eq($publish_date));
        $this->assertTrue($post->fresh()->is_public);
    }

    /**
     * @test
     */
    public function can_retract_a_post()
    {
        $publish_date = Carbon::today()->subWeek();
        $post = factory(JobPost::class)->state('public')->create([
            'first_published_at' => $publish_date,
        ]);

        $post->retract();

        $this->assertTrue($post->fresh()->first_published_at->eq($publish_date));
        $this->assertFalse($post->fresh()->is_public);
    }
}
