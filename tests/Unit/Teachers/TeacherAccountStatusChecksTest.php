<?php


namespace Tests\Unit\Teachers;


use App\Placements\JobMatch;
use App\Placements\JobSearchCriteria;
use App\Teachers\Teacher;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class TeacherAccountStatusChecksTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function checks_for_incomplete_profile()
    {
        $teacher = factory(Teacher::class)->state('incomplete')->create();

        $this->assertContains('incomplete_profile', $teacher->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_no_experience()
    {
        $teacher = factory(Teacher::class)->create();
        $this->assertCount(0, $teacher->previousEmployments);

        $this->assertContains('no_experience', $teacher->checkStatus());
    }

    /**
     *@test
     */
    public function unread_messages_check()
    {
        $teacher = factory(Teacher::class)->create();
        factory(DatabaseNotification::class)->create([
            'notifiable_id' => $teacher->user->id,
            'notifiable_type' => User::class,
        ]);
        $this->assertContains('has_unread_messages', $teacher->checkStatus());
    }

    /**
     *@test
     */
    public function check_for_no_job_search()
    {
        $teacher = factory(Teacher::class)->create();
        $this->assertContains('no_job_search', $teacher->checkStatus());

        $teacher->setJobSearch(new JobSearchCriteria(['area_ids' => [1]]));
        $this->assertNotContains('no_job_search', $teacher->checkStatus());
    }

    /**
     *@test
     */
    public function check_if_home_base_is_not_set()
    {
        $teacher = factory(Teacher::class)->state('homeless')->create();
        $this->assertContains('no_location', $teacher->checkStatus());

        $teacher->area_id = 1;
        $teacher->save();

        $this->assertNotContains('no_location', $teacher->checkStatus());
    }

    /**
     *@test
     */
    public function checks_for_recent_job_matches()
    {
        $teacher = factory(Teacher::class)->create();
        $this->assertNotContains('recent_job_matches', $teacher->checkStatus());

        $search = $teacher->setJobSearch(new JobSearchCriteria(['area_ids' => [1]]));
        factory(JobMatch::class)->create(['job_search_id' => $search->id]);

        $this->assertContains('recent_job_matches', $teacher->checkStatus());

        $this->travel(10)->days();

        $this->assertNotContains('recent_job_matches', $teacher->checkStatus());
    }
}
