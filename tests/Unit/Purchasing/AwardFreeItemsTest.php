<?php

namespace Tests\Unit\Purchasing;

use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AwardFreeItemsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_award_free_resume_pass_to_a_school()
    {
        $school = factory(School::class)->create();
        $expiry = now()->addMonth();

        $school->awardFreeResumePass($expiry);

        $this->assertTrue($school->fresh()->hasResumeAccess());

        $this->assertCount(1, $school->resumePasses);
        $pass = $school->resumePasses->first();

        $this->assertTrue($pass->expires_on->isSameDay($expiry));
    }

    /**
     *@test
     */
    public function can_award_free_tokens_to_a_school()
    {
        $school = factory(School::class)->create();
        $expiry = now()->addMonth();
        $this->assertCount(0, $school->tokens);

        $school->awardFreeTokens(5, $expiry);

        $this->assertCount(5, $school->fresh()->tokens);

        $school
            ->fresh()
            ->tokens
            ->each(fn ($t) => $this->assertTrue($t->expires_on->isSameDay($expiry)))
            ->each(fn ($t) => $this->assertFalse($t->isSpent()));
    }
}
