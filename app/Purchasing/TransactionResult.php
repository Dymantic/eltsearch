<?php


namespace App\Purchasing;


use App\User;

class TransactionResult
{
    private bool $success;
    private $amount_paid;
    private $reference_number;
    private string $currency;
    private string $card_last_four;
    private string $card_type;
    private string $gateway_status;
    private ?string $gateway_error;
    private string $secure3d_url;
    private array $secure3d_params;
    private string $uuid;

    public function __construct($attributes = [])
    {
        $this->success = $attributes['success'] ?? false;
        $this->amount_paid = $attributes['amount_paid'] ?? false;
        $this->reference_number = $attributes['ref_no'] ?? null;
        $this->currency = $attributes['currency'] ?? '';
        $this->card_last_four = $attributes['card_last_four'] ?? '';
        $this->card_type = $attributes['card_type'] ?? '';
        $this->gateway_error = $attributes['error_message'] ?? null;
        $this->gateway_status = $attributes['gateway_status'] ?? 'null';
        $this->secure3d_url = $attributes['secure_3ds_url'] ?? '';
        $this->secure3d_params = $attributes['secure_3ds_params'] ?? [];
        $this->uuid = $attributes['purchase_uuid'] ?? '';

    }

    public static function from2Checkout(array $response_data, string $uuid = ''): self
    {
        return new self([
            'success' => ($response_data['Status'] ?? '') === 'AUTHRECEIVED',
            'ref_no' => $response_data['RefNo'] ?? '',
            'amount_paid' => $response_data['NetPrice'] ?? 0,
            'currency' => $response_data['Currency'] ?? '',
            'card_last_four' => $response_data['PaymentDetails']['PaymentMethod']['LastDigits'] ?? '',
            'card_type' => $response_data['PaymentDetails']['PaymentMethod']['CardType'] ?? '',
            'error_message' => $response_data['Errors'] ? $response_data['Errors'][array_key_first($response_data['Errors'])] : null,
            'gateway_status' => $response_data['Status'] ?? '',
            'secure_3ds_url' => $response_data['PaymentDetails']['PaymentMethod']['Authorize3DS']['Href'] ?? '',
            'secure_3ds_params' => $response_data['PaymentDetails']['PaymentMethod']['Authorize3DS']['Params'] ?? [],
            'purchase_uuid' => $uuid,
        ]);
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function refNo()
    {
        return $this->reference_number;
    }

    public function userId(): ?int
    {
        return $this->user->id ?? null;
    }

    public function pricePaidInCents(): int
    {
        return intval(floor($this->amount_paid * 100));
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function cardLastFour(): string
    {
        return $this->card_last_four;
    }

    public function cardType(): string
    {
        return $this->card_type;
    }

    public function getGatewayStatus(): string
    {
        return $this->gateway_status;
    }

    public function getError(): ?string
    {
        return $this->gateway_error;
    }

    public function requiresSecure3D(): bool
    {
        return $this->getGatewayStatus() === 'PENDING' && $this->secure3d_url !== '';
    }

    public function secure3DRedirectUrl(): string
    {
        return sprintf("%s?%s", $this->secure3d_url, http_build_query($this->secure3d_params));
    }

    public function getPurchaseUuid(): string
    {
        return $this->uuid;
    }

}
