<?php

namespace App\Placements;

use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
