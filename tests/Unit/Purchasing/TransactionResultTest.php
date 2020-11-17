<?php


namespace Tests\Unit\Purchasing;


use App\Purchasing\TransactionResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionResultTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function make_result_from_two_checkout_response()
    {
        $response_data = json_decode(
            file_get_contents(storage_path('fixtures/2checkout_authreceived.json')), true
        );

        $result = TransactionResult::from2Checkout($response_data);

        $this->assertTrue($result->success());
        $this->assertSame('137043418', $result->refNo());
        $this->assertSame(1000, $result->pricePaidInCents());
        $this->assertSame('usd', $result->currency());
        $this->assertSame('1111', $result->cardLastFour());
        $this->assertSame('visa', $result->cardType());
    }
}
