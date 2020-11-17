<?php


namespace App;


class BillingDetails
{
    public string $address;
    public string $city;
    public string $zip;
    public string $state;
    public string $country;

    public function __construct($details)
    {
        $this->address = $details['address'] ?? '';
        $this->city = $details['city'] ?? '';
        $this->zip = $details['zip'] ?? '';
        $this->state = $details['state'] ?? '';
        $this->country = $details['country'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'billing_address' => $this->address,
            'billing_city' => $this->city,
            'billing_zip' => $this->zip,
            'billing_state' => $this->state,
            'billing_country' => $this->country,
        ];
    }

}
