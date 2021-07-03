<?php


namespace App;


use Illuminate\Support\Facades\Http;

class Recaptcha
{
    const VALIDATE_ENDPOINT = 'https://www.google.com/recaptcha/api/siteverify';
    const THRESHOLD = 0.65;

    public static function accepts(string $token, ?string $ip = null): bool
    {

        $data = [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
        ];

        if($ip) {
            $data['remoteip'] = $ip;
        }

        $response = Http::asForm()->post(self::VALIDATE_ENDPOINT, $data);

        if($response->status() >= 500) {
            return true;
        }

        if(!$response->json('success')) {
            return false;
        }

        return $response->json('score') >= self::THRESHOLD;
    }
}
