<?php


namespace Tests\Feature\Purchasing;


use App\Purchasing\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HandleSecure3DSCancelTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function secure_3ds_cancel_will_cancel_order()
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
        list($school, $owner) = $this->setUpSchool();
        $purchase = factory(Purchase::class)->state('requires3ds')->create([
            'package_id' => 'resume_pass_month',
            'customer_id' => $school->id,
        ]);

        $response = $this
            ->actingAs($owner)
            ->get("/secure3d-orders/{$purchase->purchase_uuid}/cancel");

        $response->assertRedirect("/schools/#purchases");

        $this->assertDatabaseHas('purchases', [
            'id' => $purchase->id,
            'paid' => false,
            'gateway_status' => Purchase::SECURE_3DS_CANCELLED,
        ]);

        $this->assertDatabaseMissing('resume_passes', [
            'school_id'   => $school->id,
            'purchase_id' => $purchase->id,
        ]);
    }
}
