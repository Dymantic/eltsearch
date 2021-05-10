<?php


namespace Tests\Feature\Purchasing;


use App\Purchasing\Purchase;
use App\Purchasing\TestTransaction;
use App\Purchasing\Transaction;
use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleSecure3dTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function redirect_client_if_requires_secure_3d()
    {
        $this->withoutExceptionHandling();

        config([
            'packages' => [
                [
                    'id' => 'resume_pass_month',
                    'price' => 50,
                    'quantity' => 1,
                    'expires' => 30,
                    'type' => 'resume_pass',
                    'trans_key' => 'pricing.resume_pass',
                ],
            ]
        ]);

        $testTransaction = new TestTransaction(['requires_secure3d' => true]);
        app()->instance(Transaction::class, $testTransaction);

        list($school, $owner) = $this->setUpSchool();

        $response = $this->actingAs($owner)->postJson("/api/schools/{$school->id}/purchases", [
            'package_id'     => 'resume_pass_month',
            'checkout_token' => 'test_token',
            'name'           => 'test name',
        ]);

        $response->assertSuccessful();
        $this->assertTrue($response->json('requires_secure3d_redirect'));
        $this->assertSame('http://secure3d-url.test?avng8apitoken=test-secure-3d-token', $response->json('redirect_secure3d_url'));

        $this->assertDatabaseHas('purchases', [
            'customer_id'    => $school->id,
            'customer_type'  => School::class,
            'user_id'        => $owner->id,
            'price'          => 1000,
            'currency'       => 'usd',
            'card_last_four' => '1111',
            'card_type'      => 'visa',
            'paid'           => false,
            'package_id'     => 'resume_pass_month',
            'gateway_ref_no' => '137043418',
            'gateway_status' => 'PENDING',
            'gateway_error'  => null,
        ]);

        $purchase = Purchase::where('gateway_ref_no', '137043418')->first();

        $this->assertNotNull($purchase->purchase_uuid);

    }
}
