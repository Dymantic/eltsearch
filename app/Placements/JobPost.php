<?php

namespace App\Placements;

use App\Locations\Area;
use App\Schools\School;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JobPost extends Model implements HasMedia
{
    use InteractsWithMedia;

    const FULL_TIME = 'full_time';
    const PART_TIME = 'part_time';

    const ALLOWED_ENGAGEMENT = [
        self::FULL_TIME,
        self::PART_TIME,
    ];

    const AGE_KINDERGARTEN = 'kindergarten_age';
    const AGE_ELEMENTARY = 'elementary_school_age';
    const AGE_JUNIOR_HIGH = 'junior_high_age';
    const AGE_SENIOR_HIGH = 'senior_high_age';
    const AGE_UNIVERSITY = 'university_age';
    const AGE_ADULT = 'adult_age';

    const ALLOWED_AGES = [
        self::AGE_KINDERGARTEN,
        self::AGE_ELEMENTARY,
        self::AGE_JUNIOR_HIGH,
        self::AGE_SENIOR_HIGH,
        self::AGE_UNIVERSITY,
        self::AGE_ADULT,
    ];

    const REQUIRES_DEGREE = 'requires_degree';
    const REQUIRES_POLICE_CHECK = 'requires_police_check';
    const REQUIRES_TEFL = 'requires_tefl';

    const ALLOWED_REQUIREMENTS = [
        self::REQUIRES_DEGREE,
        self::REQUIRES_POLICE_CHECK,
        self::REQUIRES_TEFL,
    ];

    const SALARY_RATE_HOUR = 'salary_by_hour';
    const SALARY_RATE_WEEK = 'salary_by_week';
    const SALARY_RATE_MONTH = 'salary_by_month';

    const ALLOWED_SALARY_RATES = [
        self::SALARY_RATE_HOUR,
        self::SALARY_RATE_WEEK,
        self::SALARY_RATE_MONTH,
    ];

    const SALARY_GRADE_MIN = 1;
    const SALARY_GRADE_MID = 2;
    const SALARY_GRADE_MAX = 3;

    const BENEFIT_ARC = 'benefit_ARC';
    const BENEFIT_INSURANCE = 'benefit_health_insurance';
    const BENEFIT_RENEWAL_BONUS = 'benefit_renewal_bonus';

    const ALLOWED_BENEFITS = [
        self::BENEFIT_ARC,
        self::BENEFIT_INSURANCE,
        self::BENEFIT_RENEWAL_BONUS,
    ];

    const CONTRACT_NONE = 'no_contract';
    const CONTRACT_SIX_MONTHS = 'six_month_contract';
    const CONTRACT_YEAR = 'one_year_contract';
    const CONTRACT_OVER_YEAR = 'over_year_contract';

    const ALLOWED_CONTRACT_LENGTHS = [
        self::CONTRACT_NONE,
        self::CONTRACT_SIX_MONTHS,
        self::CONTRACT_YEAR,
        self::CONTRACT_OVER_YEAR,
    ];

    const SCHEDULE_MORNINGS = 'morning';
    const SCHEDULE_AFTERNOONS = 'afternoon';
    const SCHEDULE_EVENINGS = 'evening';

    const ALLOWED_SCHEDULE = [
        self::SCHEDULE_MORNINGS,
        self::SCHEDULE_AFTERNOONS,
        self::SCHEDULE_EVENINGS,
    ];

    const IMAGES = 'images';
    const MAX_IMAGES = 4;

    protected $guarded = [];

    protected $casts = [
        'student_ages'     => 'array',
        'requirements'     => 'array',
        'benefits'         => 'array',
        'schedule'         => 'array',
        'work_on_weekends' => 'boolean',
        'is_public'        => 'boolean',
        'start_date'       => 'datetime:Y-m-d',
    ];

    protected $dates = ['first_published_at'];



    public function scopeLive($query)
    {
        $query->where([
            ['is_public', true],
            ['first_published_at', '>', Carbon::today()->subDays(30)],
        ]);
    }

    public function matches()
    {
        return $this->hasMany(JobMatch::class);
    }

    public function scopeMatching($query, JobSearch $search)
    {
        $query->live()
            ->whereDoesntHave('matches', fn ($query) => $query->where('job_search_id', $search->id));
        if ($search->hasLocation()) {
            $query->whereIn('area_id', $search->area_ids);
        }

        if ($search->hasStudentAges()) {
            $query->where(function ($query) use ($search) {
                foreach ($search->excludeStudentAges() as $age) {
                    $query->whereJsonDoesntContain('job_posts.student_ages', $age);
                }
            });
        }

        if ($search->hasWeekends()) {
            $query->where('work_on_weekends', $search->weekends);
        }

        if ($search->hasBenefits()) {
            $query->where(function ($query) use ($search) {
                foreach ($search->benefits as $benefit) {
                    $query->whereJsonContains('job_posts.benefits', $benefit);
                }
            });
        }

        if ($search->hasContractTypes()) {
            $query->where(function ($query) use ($search) {
                foreach ($search->contract_type as $type) {
                    $query->orWhere('job_posts.contract_length', $type);
                }
            });
        }

        if ($search->hasHours()) {
            $operator = $search->hours_per_week === JobSearch::HOURS_MAX ? '>=' : '<';
            $query->where('hours_per_week', $operator, 20);
        }

        if ($search->hasSchedule()) {
            foreach ($search->schedule as $time) {
                $query->whereJsonContains('job_posts.schedule', $time);
            }
        }

        if ($search->hasEngagement()) {
            $query->where('engagement', $search->engagement);
        }

        if ($search->hasSalary()) {
            $query->where('salary_grade', '>=', $search->salary);
        }
    }

    public function setSalaryGrade()
    {
        $mean_salary = ($this->salary_min + $this->salary_max) / 2;
        switch ($this->salary_rate) {
            case self::SALARY_RATE_HOUR:
                $min_cutoff = 499;
                $mid_cutoff = 699;
                break;
            case self::SALARY_RATE_WEEK:
                $min_cutoff = 499 * 20;
                $mid_cutoff = 699 * 20;
                break;
            case self::SALARY_RATE_MONTH:
                $min_cutoff = 49999;
                $mid_cutoff = 69999;
                break;
        }

        $cutoffs = [
            self::SALARY_GRADE_MIN => $min_cutoff,
            self::SALARY_GRADE_MID => $mid_cutoff,
        ];


        if ($mean_salary > $cutoffs[self::SALARY_GRADE_MID]) {
            $this->salary_grade = self::SALARY_GRADE_MAX;

            return $this->save();
        }

        if (
            $mean_salary > $cutoffs[self::SALARY_GRADE_MIN] &&
            $mean_salary < $cutoffs[self::SALARY_GRADE_MID]
        ) {
            $this->salary_grade = self::SALARY_GRADE_MID;

            return $this->save();
        }

        $this->salary_grade = self::SALARY_GRADE_MIN;

        return $this->save();
    }

    public function excludedBenefits(): array
    {
        return collect(self::ALLOWED_BENEFITS)
            ->filter(fn ($benefit) => !in_array($benefit, $this->benefits ?? []))
            ->values()->all();
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function hasApplicationBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this
                ->jobApplications()
                ->whereHas('teacher', fn($query) => $query->where('user_id', $user->id))
                ->count() > 0;
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function lastEditedBy()
    {
        return $this->belongsTo(User::class, 'last_edited_by');
    }

    public function updateInfo(JobPostInfo $info, User $user)
    {
        $this->update($info->toArray());
        $this->last_edited_by = $user->id;
        $this->save();
    }

    public function publish()
    {
        if (!$this->first_published_at) {
            $this->first_published_at = Carbon::now();
        }
        $this->is_public = true;
        $this->save();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function addImage(UploadedFile $upload): Media
    {
        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::IMAGES);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 600, 400)
             ->optimize()
             ->performOnCollections(self::IMAGES);

        $this->addMediaConversion('web')
             ->fit(Manipulations::FIT_CROP, 900, 600)
             ->optimize()
             ->performOnCollections(self::IMAGES);
    }

    public function hasMaxImages()
    {
        return $this->getMedia(self::IMAGES)->count() >= self::MAX_IMAGES;
    }
}
