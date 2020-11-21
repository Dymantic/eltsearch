<?php

namespace App\Purchasing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumePass extends Model
{
    protected $fillable = ['purchase_id', 'expires_on'];

    protected $casts = [
        'expires_on' => 'date'
    ];
}
