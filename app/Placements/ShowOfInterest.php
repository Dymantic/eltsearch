<?php

namespace App\Placements;

use Illuminate\Database\Eloquent\Model;

class ShowOfInterest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
