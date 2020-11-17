<?php


namespace App\Purchasing;


use Illuminate\Support\Carbon;

trait UsesTokens
{
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function availableTokens()
    {
        return $this->hasMany(Token::class)->whereNull('spent_on');
    }

    public function grantTokens(int $quantity, int $purchase_id, ?Carbon $expires_on = null)
    {
        foreach(range(1, $quantity) as $index) {
            $this->tokens()->create([
                'purchase_id' => $purchase_id,
                'expires_on' => $expires_on ?? now()->addCentury(),
            ]);
        }
    }

    public function nextToken(): ?Token
    {
        return $this->availableTokens()->orderBy('expires_on')->first();
    }
}
