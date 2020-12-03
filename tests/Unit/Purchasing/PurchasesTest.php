<?php


namespace Tests\Unit\Purchasing;


use App\Purchasing\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchasesTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_scope_purchases_to_after_a_given_date()
    {
        $old = factory(Purchase::class)->create(['created_at' => now()->subDays(10)]);
        $new = factory(Purchase::class)->create(['created_at' => now()->subDays(2)]);

        $scoped = Purchase::since(now()->subDays(5))->get();

        $this->assertCount(1, $scoped);
        $this->assertTrue($scoped->first()->is($new));

    }

    /**
     *@test
     */
    public function can_be_scoped_to_paid_purchases_only()
    {
        $failed = factory(Purchase::class)->create(['paid' => false]);
        $paid = factory(Purchase::class)->create(['paid' => true]);

        $scoped = Purchase::paid()->get();

        $this->assertCount(1, $scoped);
        $this->assertTrue($scoped->first()->is($paid));
    }
}
