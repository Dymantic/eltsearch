<?php


namespace App\Purchasing;


use App\User;
use Illuminate\Support\Str;

class TwoCheckoutTransaction implements Transaction
{

    private $buyer;
    private $payment_details;
    private Package $package;
    private TwoCheckoutClient $client;

    public function __construct(TwoCheckoutClient $client)
    {
        $this->client = $client;
    }

    public function for($buyer): self
    {
        $this->buyer = $buyer;
        return $this;
    }

    public function withPaymentDetails($payment_details): self
    {
        $this->payment_details = $payment_details;
        return $this;
    }

    public function buy(Package $package): TransactionResult
    {
        $this->package = $package;
        $uuid = Str::uuid()->toString();

        $payload = [
            'Language' => 'zh',
            'BillingDetails' => [
                'FirstName' => $this->payment_details['name'],
                'LastName' => $this->buyer->name,
                'CountryCode' => $this->buyer->billing_country,
                'State' => $this->buyer->billing_state,
                'City' => $this->buyer->billing_city,
                'Address1' => $this->buyer->billing_address,
                'Zip' => $this->buyer->billing_zip,
                'Email' => $this->payment_details['email'],
            ],
            'PaymentDetails' => [
                "Type" => config('two-checkout.environment') === 'live' ? "EES_TOKEN_PAYMENT" : "TEST",
                "Currency" => "USD",
                "PaymentMethod" => [
                    "EesToken" => $this->payment_details['token'],
                    "Vendor3DSReturnURL" => url("secure3d-orders/{$uuid}/return"),
                    "Vendor3DSCancelURL" => url("secure3d-orders/{$uuid}/cancel"),
                ],

            ],
            "Items" => [
                [
                    "Code" => null,
                    "IsDynamic" => true,
                    "PurchaseType" => "PRODUCT",
                    "Tangible" => false,
                    "Name" => $package->getName(),
                    "Price" => [
                        "Amount" => $package->getPrice(),
                        "Type" => "CUSTOM"
                    ]
                ]
            ]
        ];

        $response = $this->client->requestPurchase($payload);

        return TransactionResult::from2Checkout($response->json());
    }
}
