<?php


namespace App\Purchasing;


use App\DateFormatter;

class PurchasePresenter
{
    public static function forAdmin(Purchase $purchase)
    {
        return [
            'id'             => $purchase->id,
            'user'           => $purchase->user,
            'package'        => Package::find($purchase->package_id)->present(),
            'price'          => $purchase->price,
            'pretty_price' => sprintf("$%.2f", $purchase->price / 100),
            'paid'           => $purchase->paid,
            'currency'       => $purchase->currency,
            'card_last_four' => $purchase->card_last_four,
            'card_type'      => $purchase->card_type,
            'gateway_ref_no' => $purchase->gateway_ref_no,
            'ref_no'         => $purchase->ref_no,
            'purchase_date'  => DateFormatter::PRETTY($purchase->created_at),
            'error'          => $purchase->gateway_error,
            'gateway_status' => $purchase->gateway_status,
            'customer_name' => $purchase->customer->name,
        ];
    }
}
