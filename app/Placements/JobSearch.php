<?php

namespace App\Placements;

use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobSearch extends Model
{

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

    public function listCriteria(): array
    {
        $criteria =  collect([]);

        if($this->hasLocation()) {
            $criteria->push(self::CRITERIA_LOCATION);
        }

        if($this->hasStudentAges()) {
            $criteria->push(self::CRITERIA_STUDENTS);
        }

        if($this->hasBenefits()) {
            $criteria->push(self::CRITERIA_BENEFITS);
        }

        if($this->hasContractTypes()) {
            $criteria->push(self::CRITERIA_CONTRACT);
        }

        if($this->hasSchedule()) {
            $criteria->push(self::CRITERIA_SCHEDULE);
        }

        if($this->hasSalary()) {
            $criteria->push(self::CRITERIA_SALARY);
        }

        if($this->hasHours()) {
            $criteria->push(self::CRITERIA_HOURS);
        }

        if($this->hasEngagement()) {
            $criteria->push(self::CRITERIA_ENGAGEMENT);
        }

        if($this->hasWeekends()) {
            $criteria->push(self::CRITERIA_WEEKENDS);
        }

        return $criteria->all();
    }

    public function hasLocation()
    {
        return $this->area_ids && count($this->area_ids);
    }

    public function hasStudentAges()
    {
        return $this->student_ages && count($this->student_ages);
    }

    public function hasBenefits()
    {
        return $this->benefits && count($this->benefits);
    }

    public function hasContractTypes()
    {
        return $this->contract_type && count($this->contract_type);
    }

    public function hasSchedule()
    {
        return $this->schedule && count($this->schedule);
    }

    public function hasSalary()
    {
        return $this->salary !== null;
    }

    public function hasHours()
    {
        return $this->hours_per_week !== null;
    }

    public function hasWeekends()
    {
        return $this->weekends !== null;
    }

    public function hasEngagement()
    {
        return $this->engagement !== null && $this->engagement;
    }
}
