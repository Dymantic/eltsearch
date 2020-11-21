<?php


namespace Tests\Unit\Purchasing;


use App\Purchasing\Package;
use App\Purchasing\Purchase;
use App\Purchasing\ResumePass;
use App\Schools\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolResumePassTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function can_grant_resume_access_to_a_school()
    {
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

        $package = Package::find('resume_pass_month');
        $purchase = factory(Purchase::class)->create();
        $school = factory(School::class)->create();

        $pass = $school->grantResumeAccess($package, $purchase);

        $this->assertSame($school->id, $pass->school_id);
        $this->assertSame($purchase->id, $pass->purchase_id);
        $this->assertTrue($pass->expires_on->isSameDay(now()->addDays(30)));
    }

    /**
     *@test
     */
    public function granting_a_second_pass_accumulates_the_dates()
    {
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

        $package = Package::find('resume_pass_month');
        $purchaseA = factory(Purchase::class)->create();
        $purchaseB = factory(Purchase::class)->create();
        $school = factory(School::class)->create();

        $pass = $school->grantResumeAccess($package, $purchaseA);

        $this->assertSame($school->id, $pass->school_id);
        $this->assertSame($purchaseA->id, $pass->purchase_id);
        $this->assertTrue($pass->expires_on->isSameDay(now()->addDays(30)));

        $pass = $school->grantResumeAccess($package, $purchaseB);

        $this->assertSame($school->id, $pass->school_id);
        $this->assertSame($purchaseB->id, $pass->purchase_id);
        $this->assertTrue($pass->expires_on->isSameDay(now()->addDays(60)));
    }

    /**
     *@test
     */
    public function can_check_if_school_has_resume_access()
    {
        $school = factory(School::class)->create();

        $this->assertFalse($school->fresh()->hasResumeAccess());

        $pass = factory(ResumePass::class)->create([
            'school_id' => $school->id,
        ]);

        $this->assertTrue($school->fresh()->hasResumeAccess());

        $pass->expires_on = now()->subDays(7);
        $pass->save();

        $this->assertFalse($school->fresh()->hasResumeAccess());

    }
}
