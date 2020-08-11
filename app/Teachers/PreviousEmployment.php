<?php

namespace App\Teachers;

use Illuminate\Database\Eloquent\Model;

class PreviousEmployment extends Model
{
    protected $fillable = [
        'employer',
        'employed_from',
        'employed_to',
        'job_title',
        'description',
    ];

    protected $dates = ['employed_from', 'employed_to'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
