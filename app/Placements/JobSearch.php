<?php

namespace App\Placements;

use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobSearch extends Model
{

    use ListsCriteria;

    const CRITERIA_LOCATION = 'location';
    const CRITERIA_STUDENTS = "students";
    const CRITERIA_BENEFITS = "benefits";
    const CRITERIA_CONTRACT = "contract";
    const CRITERIA_WEEKENDS = "weekends";
    const CRITERIA_HOURS = "hours";
    const CRITERIA_SALARY = "salary";
    const CRITERIA_SCHEDULE = "schedule";
    const CRITERIA_ENGAGEMENT = "engagement";


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

    const SALARY_AVG = 2;
    const SALARY_HIGH = 3;

    const ALLOWED_SALARIES = [
        self::SALARY_AVG,
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
        'area_ids'      => 'array',
        'student_ages'  => 'array',
        'benefits'      => 'array',
        'contract_type' => 'array',
        'schedule'      => 'array',
        'weekends'      => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function minHours(): int
    {
        $table = [
            self::HOURS_MIN => 0,
            self::HOURS_LOW => 10,
            self::HOURS_MID => 20,
            self::HOURS_MAX => 30,
        ];

        return $table[$this->hours_per_week] ?? 0;
    }

    public function excludeStudentAges()
    {
        return collect(JobPost::ALLOWED_AGES)
            ->filter(fn ($age) => !in_array($age, $this->student_ages ?? []))
            ->values()->all();
    }


}
