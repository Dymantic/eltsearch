<?php

namespace App\Purchasing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id', 'expires_on'];

    protected $casts = [
        'expires_on' => 'date',
        'spent_on' => 'date',
    ];

    public function spend()
    {
        $this->spent_on = now();
        $this->save();
    }

    public function isSpent(): bool
    {
        return $this->spent_on !== null;
    }
}
