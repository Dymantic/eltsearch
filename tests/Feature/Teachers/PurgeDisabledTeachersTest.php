<?php


namespace Tests\Feature\Teachers;


use App\Placements\JobApplication;
use App\Placements\JobSearch;
use App\Placements\RecruitmentAttempt;
use App\Teachers\PreviousEmployment;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PurgeDisabledTeachersTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function disabled_teachers_are_purged_after_a_certain_amount_of_time()
    {
        Event::fake();
        $this->withoutExceptionHandling();

        $disabled = factory(Teacher::class)->create();
        $employment = factory(PreviousEmployment::class)->create(['teacher_id' => $disabled->id]);
        $recruitment = factory(RecruitmentAttempt::class)->create(['teacher_id' => $disabled->id]);
        $search = factory(JobSearch::class)->create(['teacher_id' => $disabled->id]);
        $application = factory(JobApplication::class)->create(['teacher_id' => $disabled->id]);

        $disabled->disable();
        $user_id = $disabled->user->id;

        $this->travel(10)->days();

        Artisan::call('teachers:purge-disabled');


        $this->assertModelMissing($disabled);
        $this->assertModelMissing($employment);
        $this->assertModelMissing($recruitment);
        $this->assertModelMissing($search);
        $this->assertModelMissing($application);

        $this->assertDatabaseMissing('users', ['id' => $user_id]);

    }

    /**
     *@test
     */
    public function non_disabled_profiles_are_not_deleted()
    {
        Event::fake();
        $this->withoutExceptionHandling();

        $enabled = factory(Teacher::class)->create();
        $employment = factory(PreviousEmployment::class)->create(['teacher_id' => $enabled->id]);
        $recruitment = factory(RecruitmentAttempt::class)->create(['teacher_id' => $enabled->id]);
        $search = factory(JobSearch::class)->create(['teacher_id' => $enabled->id]);
        $application = factory(JobApplication::class)->create(['teacher_id' => $enabled->id]);


        Artisan::call('teachers:purge-disabled');

        $this->assertDatabaseHas('teachers', ['id' => $enabled->id]);
        $this->assertDatabaseHas('previous_employments', ['teacher_id' => $enabled->id]);
        $this->assertDatabaseHas('job_searches', ['teacher_id' => $enabled->id]);
        $this->assertDatabaseHas('recruitment_attempts', ['teacher_id' => $enabled->id]);
    }

    /**
     *@test
     */
    public function disabled_teachers_are_not_purged_too_soon()
    {
        Event::fake();
        $this->withoutExceptionHandling();

        $disabled = factory(Teacher::class)->create();
        $employment = factory(PreviousEmployment::class)->create(['teacher_id' => $disabled->id]);
        $recruitment = factory(RecruitmentAttempt::class)->create(['teacher_id' => $disabled->id]);
        $search = factory(JobSearch::class)->create(['teacher_id' => $disabled->id]);
        $application = factory(JobApplication::class)->create(['teacher_id' => $disabled->id]);

        $disabled->disable();
        $this->travel(5)->days();

        Artisan::call('teachers:purge-disabled');

        $this->assertDatabaseHas('teachers', ['id' => $disabled->id]);
        $this->assertDatabaseHas('previous_employments', ['teacher_id' => $disabled->id]);
        $this->assertDatabaseHas('job_searches', ['teacher_id' => $disabled->id]);
        $this->assertDatabaseHas('recruitment_attempts', ['teacher_id' => $disabled->id]);
    }
}
