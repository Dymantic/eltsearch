<?php


namespace Tests\Unit\Placements;


use App\ContactDetails;
use App\Placements\JobPost;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function posts_can_be_scoped_to_live_posts()
    {
        $liveA = factory(JobPost::class)->state('current')->create();
        $liveB = factory(JobPost::class)->state('current')->create();
        $private = factory(JobPost::class)->state('private')->create();
        $expired = factory(JobPost::class)->state('expired')->create();

        $scoped = JobPost::live()->get();

//        $this->assertCount(2, $scoped);

        $this->assertTrue($scoped->contains($liveA));
        $this->assertTrue($scoped->contains($liveB));
        $this->assertFalse($scoped->contains($private));
        $this->assertFalse($scoped->contains($expired));
    }

    /**
     *@test
     */
    public function checks_if_has_application_by_user()
    {
        $applied = factory(User::class)->state('teacher')->create();
        $not_applied = factory(User::class)->state('teacher')->create();
        $guest = null;
        $teacher = factory(Teacher::class)->create(['user_id' => $applied]);
        $post = factory(JobPost::class)->state('current')->create();

        $teacher->applyForJob($post, 'cover letter', ContactDetails::fake());

        $this->assertTrue($post->hasApplicationBy($applied));
        $this->assertFalse($post->hasApplicationBy($not_applied));
        $this->assertFalse($post->hasApplicationBy($guest));


    }

    /**
     *@test
     */
    public function can_set_salary_grade_for_mid()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => JobPost::SALARY_RATE_HOUR,
            'salary_min' => 500,
            'salary_max' => 600,
        ]);

        $post->setSalaryGrade();

        $this->assertSame(JobPost::SALARY_GRADE_MID, $post->salary_grade);
    }

    /**
     *@test
     */
    public function can_set_salary_grade_for_min()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => JobPost::SALARY_RATE_MONTH,
            'salary_min' => 30000,
            'salary_max' => 40000,
        ]);

        $post->setSalaryGrade();

        $this->assertSame(JobPost::SALARY_GRADE_MIN, $post->salary_grade);
    }

    /**
     *@test
     */
    public function can_grade_a_max_salary()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => JobPost::SALARY_RATE_WEEK,
            'salary_min' => 14000,
            'salary_max' => 16000,
        ]);

        $post->setSalaryGrade();

        $this->assertSame(JobPost::SALARY_GRADE_MAX, $post->salary_grade);
    }

    /**
     *@test
     */
    public function doesnt_grade_salary_without_salary_rate()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => '',
            'salary_min' => 14000,
            'salary_max' => 16000,
        ]);

        $post->setSalaryGrade();

        $this->assertNull($post->salary_grade);
    }

    /**
     *@test
     */
    public function doesnt_grade_salary_without_minimum()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => JobPost::SALARY_RATE_HOUR,
            'salary_min' => null,
            'salary_max' => 16000,
        ]);

        $post->setSalaryGrade();

        $this->assertNull($post->salary_grade);
    }

    /**
     *@test
     */
    public function doesnt_grade_salary_without_maximum()
    {
        $post = factory(JobPost::class)->create([
            'salary_rate' => JobPost::SALARY_RATE_HOUR,
            'salary_min' => 500,
            'salary_max' => null,
        ]);

        $post->setSalaryGrade();

        $this->assertNull($post->salary_grade);
    }

    /**
     *@test
     */
    public function job_posts_have_a_status()
    {
        $live = factory(JobPost::class)->state('public')->create();
        $expired = factory(JobPost::class)->state('expired')->create();
        $draft = factory(JobPost::class)->state('draft')->create();
        $private = factory(JobPost::class)->state('private')->create();

        $this->assertSame(['text' => 'Live', 'colour' => 'green'], $live->status('en'));
        $this->assertSame(['text' => 'Expired', 'colour' => 'purple'], $expired->status('en'));
        $this->assertSame(['text' => 'Private', 'colour' => 'red'], $private->status('en'));
        $this->assertSame(['text' => 'Draft', 'colour' => 'orange'], $draft->status('en'));
    }

    /**
     *@test
     */
    public function can_get_count_of_recently_published_in_last_days()
    {
        factory(JobPost::class)->state('current')->create([
            'first_published_at' => now()->subDay(),
        ]);
        factory(JobPost::class)->state('current')->create([
            'first_published_at' => now()->subDays(3),
        ]);
        factory(JobPost::class)->state('current')->create([
            'first_published_at' => now()->subDays(10),
        ]);
        factory(JobPost::class)->state('draft')->create();
        factory(JobPost::class)->state('expired')->create();

        $this->assertSame(2, JobPost::publishedSince(now()->subDays(5))->count());
    }
}
