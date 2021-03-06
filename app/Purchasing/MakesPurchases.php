<?php


namespace App\Purchasing;


use App\Notifications\PurchaseComplete;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

trait MakesPurchases
{

    public function purchases()
    {
        return $this->morphMany(Purchase::class, 'customer');
    }

    public function initiatePurchase(TransactionResult $result, Package $package, User $user)
    {
        $purchase = $this->purchases()
                         ->create([
                             'user_id'        => $user->id,
                             'package_id'     => $package->getId(),
                             'price'          => $result->pricePaidInCents(),
                             'currency'       => $result->currency(),
                             'card_last_four' => $result->cardLastFour(),
                             'card_type'      => $result->cardType(),
                             'paid'           => $result->success(),
                             'gateway_ref_no' => $result->refNo(),
                             'gateway_status' => $result->getGatewayStatus(),
                             'gateway_error' => $result->getError(),
                             'ref_no'         => Purchase::nextRefNumber(),
                             'purchase_uuid' => $result->getPurchaseUuid(),
                         ]);
    }

    public function completePurchase(TransactionResult $result, Package $package, User $user)
    {
        $purchase = $this->purchases()
                         ->create([
                             'user_id'        => $user->id,
                             'package_id'     => $package->getId(),
                             'price'          => $result->pricePaidInCents(),
                             'currency'       => $result->currency(),
                             'card_last_four' => $result->cardLastFour(),
                             'card_type'      => $result->cardType(),
                             'paid'           => $result->success(),
                             'gateway_ref_no' => $result->refNo(),
                             'gateway_status' => $result->getGatewayStatus(),
                             'gateway_error' => $result->getError(),
                             'ref_no'         => Purchase::nextRefNumber(),
                         ]);

        if ($result->success()) {
            $this->addPackage($package, $purchase);
            Notification::send($this->admins, new PurchaseComplete($package, $purchase, $user));
        }

        return $purchase;
    }

    public function addPackage(Package $package, Purchase $purchase)
    {
        if ($package->getType() === 'token') {
            $this->grantTokens($package->getQuantity(), $purchase->id, $package->getExpiry());
        }

        if($package->getType() === 'resume_pass') {
            $this->grantResumeAccess($package, $purchase);
        }
    }
}
