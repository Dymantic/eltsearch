<?php

namespace App\Placements;

use App\Locations\Region;
use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Builder;
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


    const HOURS_LOW = 2;
    const HOURS_MAX = 4;

    const ALLOWED_HOURS = [
        self::HOURS_LOW,
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
        'region_ids',
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
        'region_ids'      => 'array',
        'student_ages'  => 'array',
        'benefits'      => 'array',
        'contract_type' => 'array',
        'schedule'      => 'array',
        'weekends'      => 'boolean',
    ];

    public function scopeMatching(Builder $query, JobPost $post)
    {
        $query->whereDoesntHave('matches', fn($query) => $query->where('job_post_id', $post->id));
        if (!$post->salary_grade) {
            $post->setSalaryGrade();
        }

        $query->where(function ($query) use ($post) {
            $query->whereJsonContains('area_ids', "{$post->area_id}")
                  ->orWhereJsonLength('area_ids', 0)
                  ->orWhereNull('area_ids');
        });

        $query->where(function (Builder $query) use ($post) {
            foreach ($post->student_ages ?? [] as $age) {
                $query->whereJsonContains('student_ages', $age);
            }
            $query->orWhereJsonLength('student_ages', 0)
                  ->orWhereNull('student_ages');
        });

        $query->where(function (Builder $query) use ($post) {
            $query->where('salary', '<=', $post->salary_grade)
                  ->orWhereNull('salary');
        });

        if ($post->work_on_weekends) {
            $query->where(function (Builder $query) use ($post) {
                $query->where('weekends', true)
                      ->orWhereNull('weekends');
            });
        }

        $query->where(function (Builder $query) use ($post) {
            foreach ($post->excludedBenefits() as $benefit) {
                $query->whereJsonDoesntContain('benefits', $benefit);
            }
            $query->orWhereJsonLength('benefits', 0)
                  ->orWhereNull('benefits');
        });

        $query->where(function (Builder $query) use ($post) {
            $query->whereJsonContains('contract_type', $post->contract_length)
                  ->orWhereJsonLength('contract_type', 0)
                  ->orWhereNull('contract_type');
        });

        $query->where(function (Builder $query) use ($post) {
            $required_hours = $post->hours_per_week >= 20 ? self::HOURS_MAX : self::HOURS_LOW;
            $query->where('hours_per_week', $required_hours)
                  ->orWhereNull('hours_per_week');
        });

        $query->where(function (Builder $query) use ($post) {
            foreach ($post->schedule ?? [] as $time) {
                $query->whereJsonContains('schedule', $time);
            }
            $query->orWhereJsonLength('schedule', 0)
                  ->orWhereNull('schedule');
        });

        $query->where(function(Builder $query) use ($post) {
            $query->where('engagement', $post->engagement)
                ->orWhere('engagement', '')
                ->orWhereNull('engagement');
        });


    }

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
            ->filter(fn($age) => !in_array($age, $this->student_ages ?? []))
            ->values()->all();
    }

    public function matches()
    {
        return $this->hasMany(JobMatch::class);
    }

    public function findMatches()
    {
        return JobPost::matching($this)
                      ->get()
                      ->map(fn(JobPost $jobPost) => $this->createMatch($jobPost));
    }

    private function createMatch(JobPost $post)
    {
        return $this->matches()->create([
            'job_post_id' => $post->id,
        ]);
    }

    public function allAreas(): array
    {
        $regions = Region::with('areas')->find($this->region_ids ?? []);
        if($regions->count() === 0) {
            return $this->area_ids ?? [];
        }

        $region_areas = $regions->reduce(function($areas, $region) {
            return $areas->merge($region->areas->pluck('id')->values());
        }, collect([]));
        return $region_areas->merge(collect($this->area_ids ?? []))->unique()->values()->all();
    }


}
