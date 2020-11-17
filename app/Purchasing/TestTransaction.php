<?php


namespace App\Purchasing;


use App\User;

class TestTransaction implements Transaction
{

    private $purchaser;
    private $buyer;
    private bool $should_succeed;

    public function __construct(array $config = [])
    {
        $this->should_succeed = $config['should_succeed'] ?? true;
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
