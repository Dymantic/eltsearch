<?php


namespace Tests\Feature\Purchasing;


use App\Purchasing\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HandleSecure3DSReturnTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function secure_3ds_return_will_complete_purchase()
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
            ->get("/secure3d-orders/{$purchase->purchase_uuid}/return");

        $response->assertRedirect("/schools/#purchases");

        $this->assertDatabaseHas('purchases', [
            'id' => $purchase->id,
            'paid' => true,
            'gateway_status' => Purchase::SECURE_3DS_APPROVED,
        ]);

        $this->assertDatabaseHas('resume_passes', [
            'school_id'   => $school->id,
            'purchase_id' => $purchase->id,
            'expires_on'  => Carbon::today()->addDays(30)->format('Y-m-d'),
        ]);
    }
}
