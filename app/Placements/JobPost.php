<?php

namespace App\Placements;

use App\Exceptions\InsufficientTokensException;
use App\Locations\Area;
use App\Purchasing\Token;
use App\Schools\School;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class JobPost extends Model implements HasMedia
{
    use InteractsWithMedia, GradesSalary;

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
    const REQUIRES_HEALTH_CHECK = 'requires_health_check';

    const ALLOWED_REQUIREMENTS = [
        self::REQUIRES_DEGREE,
        self::REQUIRES_POLICE_CHECK,
        self::REQUIRES_TEFL,
        self::REQUIRES_HEALTH_CHECK,
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
    const BENEFIT_ANNUAL_BONUS = 'benefit_annual_bonus';

    const ALLOWED_BENEFITS = [
        self::BENEFIT_ARC,
        self::BENEFIT_INSURANCE,
        self::BENEFIT_RENEWAL_BONUS,
        self::BENEFIT_ANNUAL_BONUS,
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

    const REQUIRED_FIELDS = [
        'area_id'                => 'string',
        'school_name'            => 'string',
        'position'               => 'string',
        'description'            => 'string',
        'student_ages'           => 'array',
        'schedule'               => 'array',
        'salary_rate'            => 'salary',
        'min_students_per_class' => 'integer',
        'max_students_per_class' => 'integer',
        'contract_length'        => 'string',
        'engagement'             => 'string',
        'hours_per_week'         => 'integer',
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

    public function scopePublishedSince($query, \Carbon\Carbon $cutoff)
    {
        return $query->live()
            ->where('first_published_at', '>=', $cutoff);
    }

    public function scopeMatching($query, JobSearch $search)
    {
        $query->live()
              ->whereDoesntHave(
                  'matches',
                  fn($query) => $query->where('job_search_id', $search->id)
              );

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


    public function findMatches()
    {
        return JobSearch::matching($this)
                        ->get()
                        ->map(fn(JobSearch $search) => $this->saveMatch($search));
    }

    private function saveMatch(JobSearch $search)
    {
        return $this->matches()->create([
            'job_search_id' => $search->id,
        ]);
    }


    public function excludedBenefits(): array
    {
        return collect(self::ALLOWED_BENEFITS)
            ->filter(fn($benefit) => !in_array($benefit, $this->benefits ?? []))
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
        $this->setSalaryGrade();
    }

    public function publish(?Token $token = null)
    {
        if (!$this->first_published_at) {

            if ($token === null || $token->isSpent()) {
                throw InsufficientTokensException::tokenRequired();
            }
            $this->first_published_at = Carbon::now();
            $token->spend();
        }
        $this->is_public = true;
        $this->save();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function status($lang)
    {
        if ($this->isDraft()) {
            return [
                'text'   => trans('job_posts.status.draft', [], $lang),
                'colour' => 'orange'
            ];
        }

        if ($this->expired()) {
            return [
                'text'   => trans('job_posts.status.expired', [], $lang),
                'colour' => 'purple'
            ];
        }

        if ($this->is_public) {
            return [
                'text'   => trans('job_posts.status.live', [], $lang),
                'colour' => 'green'
            ];
        }

        return [
            'text'   => trans('job_posts.status.private', [], $lang),
            'colour' => 'red'
        ];

    }

    private function isDraft(): bool
    {
        return $this->first_published_at === null;
    }

    private function hasBeenPublished(): bool
    {
        return $this->first_published_at !== null;
    }

    public function expired(): bool
    {
        return $this->hasBeenPublished() &&
            $this->first_published_at->isBefore(now()->subDays(30));
    }

    public function readyForPublication(): bool
    {
        return collect($this->requiredFieldsStatus())
            ->every(fn($field) => !!$field['complete']);
    }

    public function requiredFieldsStatus()
    {
        return collect(self::REQUIRED_FIELDS)
            ->map(fn($type, $field) => $this->fieldStatus($field, $type))->values()->all();
    }

    public function fieldStatus($field, $type)
    {
        switch ($type) {
            case 'string':
                $status = !!$this->{$field};
                break;
            case 'array':
                $status = ($this->{$field} && count($this->{$field}));
                break;
            case 'salary':
                $status = !$this->missingSalaryInfo();
                break;
            case 'integer':
                $status = $this->{$field} !== null;
                break;
            default:
                $status = false;
        }

        return [
            'label'    => "job_posts.required.{$field}",
            'complete' => $status,
        ];
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
