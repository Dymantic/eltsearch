<?php


namespace App\Purchasing;


use App\User;

interface Transaction
{
    public function for($buyer): self;

    public function withPaymentDetails($payment_details): self;

    public function buy(Package $package): TransactionResult;
}
