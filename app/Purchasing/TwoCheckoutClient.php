<?php


namespace App\Purchasing;


use Illuminate\Support\Facades\Http;

class TwoCheckoutClient
{

    private string $merchantCode;
    private string $secret;

    public function __construct(string $merchantCode, string $secret)
    {
        $this->merchantCode = $merchantCode;
        $this->secret = $secret;
    }

    public function requestPurchase($payload)
    {
        return Http::withHeaders([
            'X-Avangate-Authentication' => $this->createAuthHeader()
        ])->post("https://api.2checkout.com/rest/6.0/orders/", $payload);

    }

    private function createAuthHeader()
    {
        $date = now()->format('Y-m-d H:i:s');
        $code =  sprintf("%s%s%s%s", strlen($this->merchantCode), $this->merchantCode, strlen($date), $date);

        $hash = hash_hmac('md5', $code, $this->secret);

        return sprintf('code="%s" date="%s" hash="%s"', $this->merchantCode, $date, $hash);
    }
}
