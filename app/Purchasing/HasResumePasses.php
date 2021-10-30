<?php


namespace App\Purchasing;


use App\Schools\School;
use Illuminate\Support\Carbon;

trait HasResumePasses
{

    public function resumePasses()
    {
        return $this->hasMany(ResumePass::class);
    }

    public function daysRemaining()
    {
        $current = $this
            ->resumePasses()
            ->where('expires_on', '>=', now())
            ->orderBy('expires_on', 'desc')
            ->first();

        if(!$current) {
            return 0;
        }

        return $current->expires_on->diffInDays(now()) + 1;
    }

    public function grantResumeAccess(Package $package, Purchase $purchase)
    {
        return $this->resumePasses()->create([
            'purchase_id' => $purchase->id,
            'expires_on' => $package->getExpiry()->addDays($this->daysRemaining()),
        ]);
    }

    public function awardFreeResumePass(Carbon $expiry)
    {
        return $this->resumePasses()->create([
            'purchase_id' => null,
            'expires_on' => $expiry,
        ]);
    }

    public function hasResumeAccess(): bool
    {
        return $this
            ->resumePasses()
            ->where('expires_on', '>=', now())
            ->count() > 0;
    }
}
