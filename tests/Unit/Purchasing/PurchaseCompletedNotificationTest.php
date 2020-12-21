<?php


namespace Tests\Unit\Purchasing;


use App\Notifications\PurchaseComplete;
use App\Purchasing\Package;
use App\Purchasing\TestTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PurchaseCompletedNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function school_owners_are_notified_of_complete_purchases()
    {
        Notification::fake();

        [$school, $owner] = $this->setUpSchool();
        $package = Package::find('single_token');

        $transactionResult = (new TestTransaction(['should_succeed' => true]))
            ->for($school)
            ->buy($package);

        $purchase = $school->completePurchase($transactionResult, $package, $owner);
        $this->assertTrue($purchase->paid);

        Notification::assertSentTo(
            $owner,
            PurchaseComplete::class,
            function($notification, $channels) use ($package, $purchase, $owner) {
                $this->assertTrue(in_array('mail', $channels));
                $this->assertTrue(in_array('database', $channels));
                $this->assertSame($notification->package->getId(), $notification->package->getId());
                $this->assertTrue($notification->purchase->is($purchase));
                $this->assertTrue($notification->buyer->is($owner));

                return true;
            }
        );

    }
}
