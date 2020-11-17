<?php


namespace Tests\Unit\Purchasing;


use App\Purchasing\Purchase;
use App\Purchasing\Token;
use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolTokensTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_grant_a_non_expiring_token_to_a_school()
    {
        $school = factory(School::class)->create();
        $purchase = factory(Purchase::class)->create();

        $school->grantTokens(1, $purchase->id, null);

        $this->assertCount(1, $school->fresh()->tokens);
        $token = $school->fresh()->tokens->first();

        $this->assertSame($purchase->id, $token->purchase_id);
        $this->assertTrue($token->expires_on->isSameDay(now()->addCentury()));

    }

    /**
     *@test
     */
    public function grant_an_expiring_token_to_school()
    {
        $school = factory(School::class)->create();
        $purchase = factory(Purchase::class)->create();

        $school->grantTokens(1, $purchase->id, now()->addDays(90));

        $this->assertCount(1, $school->fresh()->tokens);
        $token = $school->fresh()->tokens->first();

        $this->assertSame($purchase->id, $token->purchase_id);
        $this->assertTrue($token->expires_on->isSameDay(now()->addDays(90)));
    }

    /**
     *@test
     */
    public function grant_multiple_tokens()
    {
        $school = factory(School::class)->create();
        $purchase = factory(Purchase::class)->create();

        $school->grantTokens(10, $purchase->id, now()->addDays(90));

        $this->assertCount(10, $school->fresh()->tokens);

        $school->fresh()->tokens->each(function($token) use ($purchase) {
            $this->assertSame($purchase->id, $token->purchase_id);
            $this->assertTrue($token->expires_on->isSameDay(now()->addDays(90)));
        });
    }

    /**
     *@test
     */
    public function can_get_next_token_to_spend()
    {
        $school = factory(School::class)->create();
        $school->grantTokens(1, 1, now()->addCentury());
        $school->grantTokens(1, 2, now()->addDays(5));

        $short_lived = Token::where('purchase_id', 2)->first();

        $this->assertTrue($school->nextToken()->is($short_lived));
    }

    /**
     *@test
     */
    public function next_token_does_not_return_spent_tokens()
    {
        $school = factory(School::class)->create();
        $school->grantTokens(1, 1, now()->addCentury());
        $school->grantTokens(1, 2, now()->addDays(5));

        $long_lived = Token::where('purchase_id', 1)->first();
        $short_lived = Token::where('purchase_id', 2)->first();
        $short_lived->spend();

        $next = $school->fresh()->nextToken();

        $this->assertTrue($next->is($long_lived));

        $long_lived->spend();

        $next = $school->fresh()->nextToken();
        $this->assertNull($next);
    }
}
