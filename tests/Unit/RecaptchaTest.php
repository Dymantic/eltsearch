<?php


namespace Tests\Unit;


use App\Recaptcha;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RecaptchaTest extends TestCase
{

    /**
     *@test
     */
    public function it_accepts_with_a_legit_response_with_a_score_over_threshold()
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response([
                'success' => true,
                'score' => Recaptcha::THRESHOLD + 0.1
            ]),
        ]);

        $result = Recaptcha::accepts('123456', '1.2.3.4');

        $this->assertTrue($result);

        Http::assertSent(function(Request $request) {
            $this->assertSame('123456', $request['response']);
            $this->assertSame('1.2.3.4', $request['remoteip']);
            return true;
        });
    }

    /**
     *@test
     */
    public function it_fails_with_a_score_under_the_threshold()
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response([
                'success' => true,
                'score' => Recaptcha::THRESHOLD - 0.1
            ]),
        ]);

        $result = Recaptcha::accepts('123456');

        $this->assertFalse($result);

        Http::assertSent(function(Request $request) {
            $this->assertSame('123456', $request['response']);
            $this->assertSame('not included', $request['remoteip'] ?? 'not included');
            return true;
        });
    }

    /**
     *@test
     */
    public function an_unsuccessful_response_is_not_accepted()
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response(['success' => false]),
        ]);

        $result = Recaptcha::accepts('123456');

        $this->assertFalse($result);
    }

    /**
     *@test
     */
    public function a_server_error_will_be_allowed_to_pass()
    {
        Http::fake([
            Recaptcha::VALIDATE_ENDPOINT => Http::response([], 500),
        ]);

        $result = Recaptcha::accepts('123456');

        $this->assertTrue($result);
    }
}
