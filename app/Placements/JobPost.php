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
        'student_ages' => 'array',
        'requirements' => 'array',
        'benefits'     => 'array',
        'schedule'     => 'array',
        'is_public'    => 'boolean',
    ];

    protected $dates = ['start_date', 'first_published_at'];

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
