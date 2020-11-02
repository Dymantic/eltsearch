<?php


namespace Tests\Unit\Placements;


use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobMatchesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_create_matches_for_a_job_search()
    {
        $matchA = $this->makeCurrentTestPost([
            'student_ages' => [JobPost::AGE_ADULT, JobPost::AGE_UNIVERSITY],
        ]);

        $matchB = $this->makeCurrentTestPost([
            'student_ages' => [JobPost::AGE_ADULT, JobPost::AGE_UNIVERSITY, JobPost::AGE_SENIOR_HIGH],
        ]);

        $no_match = $this->makeCurrentTestPost([
            'student_ages' => [JobPost::AGE_KINDERGARTEN, JobPost::AGE_ELEMENTARY],
        ]);

        $search = $this->makeTestSearch([
            'student_ages' => [
                JobPost::AGE_SENIOR_HIGH,
                JobPost::AGE_UNIVERSITY,
                JobPost::AGE_ADULT
            ]
        ]);

        $matches = $search->findMatches();

        $this->assertCount(2, $matches);

        $matches->each(function($match) use ($matchA, $matchB, $no_match, $search) {
            $this->assertInstanceOf(JobMatch::class, $match);
            $this->assertSame($search->id, $match->job_search_id);
            $this->assertNotSame($no_match->id, $match->job_post_id);
            $this->assertContains($match->job_post_id, [$matchA->id, $matchB->id]);
        });
    }


    private function makeTestSearch($criteria)
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

        return $search = factory(JobSearch::class)
            ->create(array_merge($default, $criteria));
    }

    private function makeCurrentTestPost($attributes)
    {
        return factory(JobPost::class)->state('current')->create($attributes);
    }
}
