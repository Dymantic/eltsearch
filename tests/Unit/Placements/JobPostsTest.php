<?php


namespace Tests\Unit\Placements;


use App\Placements\JobPost;
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
}
