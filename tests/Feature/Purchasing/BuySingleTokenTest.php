<?php

namespace Tests\Feature\Purchasing;

use App\Purchasing\Purchase;
use App\Purchasing\TestTransaction;
use App\Purchasing\Transaction;
use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class BuySingleTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function purchase_a_single_token_for_a_school()
    {
        $this->withoutExceptionHandling();

        config([
            'packages' => [
                [
                    'id'    => 'single_token',
                    'name'  => 'Single Token',
                    'type'  => 'token',
                    'price' => 88,
                ],
            ]
        ]);

        $testTransaction = new TestTransaction();
        app()->instance(Transaction::class, $testTransaction);

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/purchases", [
            'package_id'     => 'single_token',
            'checkout_token' => 'test_token',
            'name'           => 'test name',
        ]);
        $response->assertSuccessful();

        //fixture data has US$10 paid by VISA with last four digits 1111 and ref no of 137043418

        $this->assertDatabaseHas('purchases', [
            'customer_id'    => $school->id,
            'customer_type'  => School::class,
            'user_id'        => $owner->id,
            'price'          => 1000,
            'currency'       => 'usd',
            'card_last_four' => '1111',
            'card_type'      => 'visa',
            'paid'           => true,
            'package_id'     => 'single_token',
            'gateway_ref_no' => '137043418',
            'gateway_status' => 'AUTHRECEIVED',
            'gateway_error'  => null,
        ]);

        $purchase = Purchase::latest()->first();
        $this->assertNotNull($purchase->ref_no);

        $this->assertDatabaseHas('tokens', [
            'school_id'   => $school->id,
            'purchase_id' => $purchase->id,
            'expires_on'  => Carbon::today()->addCentury()->format('Y-m-d'),
        ]);


    }

    /**
     * @test
     */
    public function failed_transaction_does_not_add_tokens()
    {
        $this->withoutExceptionHandling();

        config([
            'packages' => [
                [
                    'id'    => 'single_token',
                    'name'  => 'Single Token',
                    'type'  => 'token',
                    'price' => 88,
                ],
            ]
        ]);

        $testTransaction = new TestTransaction(['should_succeed' => false]);
        app()->instance(Transaction::class, $testTransaction);

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/purchases", [
            'package_id' => 'single_token',
        ]);
        $response->assertSuccessful();

        //fixture data has US$10 paid by MasterCard with last four digits 4444 and ref no of 136698398

        $this->assertDatabaseHas('purchases', [
            'customer_id'    => $school->id,
            'customer_type'  => School::class,
            'user_id'        => $owner->id,
            'price'          => 1000,
            'paid'           => false,
            'package_id'     => 'single_token',
            'currency'       => 'usd',
            'card_last_four' => '4444',
            'card_type'      => 'MasterCard',
            'gateway_ref_no' => '136698398',
            'gateway_error'  => "Couldn't complete the payment validation process: Error processing the credit card transaction. No such card. The transaction can be finalized only after entering a valid credit card.",
            'gateway_status' => 'PENDING',
        ]);

        $purchase = Purchase::latest()->first();

        $this->assertDatabaseMissing('tokens', [
            'purchase_id' => $purchase->id,
        ]);

        $this->assertSame($purchase->id, $response->json('id'));
    }
}
