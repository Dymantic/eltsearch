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

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
