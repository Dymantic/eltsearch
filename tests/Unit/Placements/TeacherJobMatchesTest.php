<?php


namespace Tests\Unit\Placements;


use App\Placements\JobMatch;
use App\Placements\JobSearch;
use App\Teachers\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherJobMatchesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function get_matches_for_a_given_teacher()
    {
        $teacher = factory(Teacher::class)->create();
        $job_search = factory(JobSearch::class)->create(['teacher_id' => $teacher->id]);

        $matching = factory(JobMatch::class, 2)->create([
            'job_search_id'=> $job_search->id
        ]);
        $dismissed = factory(JobMatch::class)->state('dismissed')->create([
        'job_search_id'=> $job_search->id
    ]);
        $not_matching = factory(JobMatch::class)->create();

        $matched = $teacher->jobMatches()->get();

        $this->assertCount(2, $matched);

        $matched->each(
            fn ($match) => $this->assertContains($match->id, $matching->pluck('id')->all())
        );
    }
}
