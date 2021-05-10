<?php


namespace App\Purchasing;


use App\User;
use Illuminate\Support\Str;

class TestTransaction implements Transaction
{

    private $purchaser;
    private $buyer;
    private bool $should_succeed;
    private bool $requires_secure3d;

    public function __construct(array $config = [])
    {
        $this->should_succeed = $config['should_succeed'] ?? true;
        $this->requires_secure3d = $config['requires_secure3d'] ?? false;
    }

    public function for($buyer): Transaction
    {
        $this->$buyer = $buyer;
        return $this;
    }

    public function withPaymentDetails($payment_details): Transaction
    {
        return $this;
    }

    public function buy(Package $package): TransactionResult
    {
        $uuid = Str::uuid()->toString();
        if($this->requires_secure3d) {
            $response_data = json_decode(
                file_get_contents(storage_path('fixtures/2checkout_requires_secure_3d.json')), true
            );
            $response_data['PaymentDetails']['PaymentMethod']['Vendor3DSReturnURL'] = "/secure3d-orders/{$uuid}/return";
            $response_data['PaymentDetails']['PaymentMethod']['Vendor3DSReturnURL'] = "/secure3d-orders/{$uuid}/cancel";
            return TransactionResult::from2Checkout($response_data, $uuid);
        }

        if($this->should_succeed) {
            $response_data = json_decode(
                file_get_contents(storage_path('fixtures/2checkout_authreceived.json')), true
            );
            return TransactionResult::from2Checkout($response_data);
        }
        $response_data = json_decode(
            file_get_contents(storage_path('fixtures/2checkout_pending_invalid.json')), true
        );
        return TransactionResult::from2Checkout($response_data);
    }
}
