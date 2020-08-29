<?php

namespace App\Placements;

use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobSearch extends Model
{
    const HOURS_MIN = 1;
    const HOURS_LOW = 2;
    const HOURS_MID = 3;
    const HOURS_MAX = 4;

    const ALLOWED_HOURS = [
        self::HOURS_MIN,
        self::HOURS_LOW,
        self::HOURS_MID,
        self::HOURS_MAX,
    ];

    const SALARY_LOW = 2;
    const SALARY_MID = 3;
    const SALARY_HIGH = 4;

    const ALLOWED_SALARIES = [
        self::SALARY_LOW,
        self::SALARY_MID,
        self::SALARY_HIGH,
    ];

    protected $fillable = [
        'area_ids',
        'student_ages',
        'benefits',
        'contract_type',
        'salary',
        'hours_per_week',
        'weekends',
        'engagement',
        'schedule',
    ];

    protected $casts = [
        'area_ids' => 'array',
        'student_ages' => 'array',
        'benefits' => 'array',
        'contract_type' => 'array',
        'schedule' => 'array',
        'weekends' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
