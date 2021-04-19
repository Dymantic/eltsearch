<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $fillable = ['iso_code', 'name', 'nationality'];

    protected $casts = [
        'nationality' => Translation::class,
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'nationality' => $this->nationality->toArray(),
            'iso_code' => $this->iso_code,
            'name' => $this->name,
        ];
    }
}
