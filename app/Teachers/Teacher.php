<?php

namespace App\Teachers;

use App\ContactDetails;
use App\Events\ApplicationReceived;
use App\Events\TeacherProfileDisabled;
use App\Events\TeacherProfileReinstated;
use App\Locations\Area;
use App\Nation;
use App\Placements\ApplicationApproval;
use App\Placements\JobApplication;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\Placements\RecruitmentAttempt;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Teacher extends Model implements HasMedia
{

    use InteractsWithMedia;

    const EDUCATION_POSTGRAD = 'postgrad';
    const EDUCATION_GRADUATE = 'graduate';
    const EDUCATION_OTHER = 'other';

    const ALLOWED_EDUCATION_LEVELS = [
        self::EDUCATION_POSTGRAD,
        self::EDUCATION_GRADUATE,
        self::EDUCATION_OTHER,
    ];

    const AVATAR = 'avatar';
    const DEFAULT_AVATAR = '/images/default_avatar.svg';

    protected $fillable = [
        'name',
        'slug',
        'nation_id',
        'date_of_birth',
        'email',
        'area_id',
        'native_language',
        'other_languages',
        'education_level',
        'education_institution',
        'education_qualification',
        'years_experience',
    ];

    protected $dates = ['date_of_birth'];

    protected $casts = [
        'is_public' => 'boolean',
        'disabled_on' => 'date'
    ];

    public function scopeNotDisabled(Builder $query)
    {
        return $query->whereNull('disabled_on');
    }

    public function scopeComplete(Builder $query)
    {
        return $query
            ->whereNotNull('date_of_birth')
            ->where('education_level', '<>', '')
            ->where('education_qualification', '<>', '')
            ->whereNotNull('nation_id')
            ->where('native_language', '<>', '')
            ->whereNotNull('years_experience');
    }

    public function scopeNearArea(Builder $query, ?Area $area)
    {
        if (!$area) {
            return $query;
        }

        $area_ids = $area->region->areas->pluck('id')->all();

        return $query->whereIn('area_id', $area_ids);
    }

    public function scopeWithNationality(Builder $query, int $nation_id)
    {
        if ($nation_id === 0) {
            return $query;
        }

        return $query->where('nation_id', $nation_id);
    }

    public function scopeWithExperienceLevel(Builder $query, int $exp_level)
    {
        if ($exp_level === 0) {
            return $query;
        }

        return $query->where('years_experience', '>=', $exp_level);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }

    public function scopeSignedUpSince(Builder $query, Carbon $cutoff)
    {
        return $query
            ->whereHas('user', fn($q) => $q->where('created_at', '>=', $cutoff));
    }

    public function updateGeneralInfo(TeacherGeneralInfo $generalInfo)
    {
        $this->update($generalInfo->toArray());
    }

    public function updateEducationInfo(TeacherEducationInfo $education_info)
    {
        $this->update($education_info->toArray());
    }

    public function addPreviousEmployment(PreviousEmploymentInfo $info): PreviousEmployment
    {
        return $this->previousEmployments()->create($info->toArray());
    }

    public function previousEmployments()
    {
        return $this->hasMany(PreviousEmployment::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function setLocation(int $area_id)
    {
        return $this->update(['area_id' => $area_id]);
    }

    public function publish()
    {
        $this->is_public = true;
        $this->save();
    }

    public function jobSearches()
    {
        return $this->hasMany(JobSearch::class);
    }

    public function setJobSearch(JobSearchCriteria $criteria): JobSearch
    {
        $search = $this->currentJobSearch();

        if ($search) {
            return tap($search, fn($job_search) => $job_search->update($criteria->toArray()));
        }

        return $this->jobSearches()->create($criteria->toArray());
    }

    public function currentJobSearch(): ?JobSearch
    {
        return $this->jobSearches()->latest()->first();
    }

    public function jobMatches()
    {
        $job_search_id = optional($this->currentJobSearch())->id;

        if (!$job_search_id) {
            return;
        }

        return JobMatch::with('jobPost')
                       ->where('job_search_id', $job_search_id)
                       ->where('dismissed', false);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function hasApplicationFor(JobPost $jobPost): bool
    {
        return $this->jobApplications()
                    ->whereHas('jobPost', fn($query) => $query->where('job_posts.id', $jobPost->id))
                    ->count();
    }

    public function applyForJob(
        JobPost $jobPost,
        string $cover_letter,
        ContactDetails $contactDetails
    ): JobApplication {

        $application = $this->jobApplications()->create([
            'job_post_id'  => $jobPost->id,
            'cover_letter' => $cover_letter,
            'phone'        => $contactDetails->phone,
            'email'        => $contactDetails->emailOr($this->email),
        ]);

        if ($this->hasBeenMatchedWithPost($jobPost)) {
            $this->dismissMatchForPost($jobPost);
        }

        event(new ApplicationReceived($application));

        return $application;
    }

    private function hasBeenMatchedWithPost(JobPost $post): bool
    {
        if (!$this->jobMatches()) {
            return false;
        }

        return $this->jobMatches()->where('job_post_id', $post->id)->count() > 0;
    }

    private function dismissMatchForPost(JobPost $post)
    {
        $this->jobMatches()->where('job_post_id', $post->id)->get()->each->dismiss();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function getAvatar()
    {
        $image = $this->getFirstMedia(self::AVATAR);

        return $image ? $image->getUrl('thumb') : self::DEFAULT_AVATAR;
    }

    public function setAvatar(UploadedFile $upload): Media
    {
        $this->clearMediaCollection(self::AVATAR);

        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::AVATAR);
    }

    public function setAvatarFromUrl($url)
    {
        $this->clearMediaCollection(self::AVATAR);

        return $this->addMediaFromUrl($url)
                    ->usingFileName(Str::random(10))
                    ->toMediaCollection(self::AVATAR);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_MAX, 400, 400)
             ->optimize()
             ->performOnCollections(self::AVATAR);
    }

    public function recruitmentAttempts()
    {
        return $this->hasMany(RecruitmentAttempt::class);
    }

    public function hasCompleteProfile(): bool
    {
        return $this->education_level !== '' &&
            $this->education_qualification !== '' &&
            $this->native_language !== '' &&
            $this->nation_id !== null &&
            $this->years_experience !== null &&
            $this->date_of_birth !== null;
    }

    public function checkStatus()
    {
        $checks = [
            'incomplete_profile'  => CompleteProfileCheck::class,
            'no_experience'       => PreviousEmploymentsCheck::class,
            'has_unread_messages' => UnreadMessagesCheck::class,
            'no_job_search'       => NoJobSearchCheck::class,
            'no_location'         => NoSetLocationCheck::class,
            'recent_job_matches' => RecentJobMatchesCheck::class,
        ];

        return collect($checks)
            ->map(fn($c, $key) => (new $c($this))->check() ? $key : null)
            ->filter(fn($s) => $s !== null);
    }

    public function disable()
    {
        if(!$this->isDisabled()) {
            TeacherProfileDisabled::dispatch($this);
        }

        $this->disabled_on = now();
        $this->save();
    }

    public function reinstate()
    {
        if($this->isDisabled()) {
            TeacherProfileReinstated::dispatch($this);
        }

        $this->disabled_on = null;
        $this->save();
    }

    public function isDisabled(): bool
    {
        return $this->disabled_on !== null;
    }

    public function applicationApprovalFor(JobPost $post): ApplicationApproval
    {
        if($this->isDisabled()) {
            return ApplicationApproval::disabled($this, $post);
        }

        if($this->hasApplicationFor($post)) {
            return ApplicationApproval::appliedAlready($this, $post);
        }

        if(!$this->hasCompleteProfile()) {
            return ApplicationApproval::incomplete($this, $post);
        }

        return ApplicationApproval::okay($this, $post);
    }
}
