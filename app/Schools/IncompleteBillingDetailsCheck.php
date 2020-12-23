<?php


namespace App\Schools;


use App\StatusCheck;

class IncompleteBillingDetailsCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        return (!$this->school->billing_address) ||
            (!$this->school->billing_city) ||
            (!$this->school->billing_country) ||
            (!$this->school->billing_zip);
    }
}
