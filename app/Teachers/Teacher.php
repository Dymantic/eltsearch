<?php

namespace App\Teachers;

use App\ContactDetails;
use App\Events\ApplicationReceived;
use App\Locations\Area;
use App\Placements\JobApplication;
use App\Placements\JobMatch;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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
    const DEFAULT_AVATAR = '/images/default_avatar.jpg';

    protected $fillable = [
        'name',
        'nationality',
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
        'is_public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

        if($this->hasBeenMatchedWithPost($jobPost)) {
            $this->dismissMatchForPost($jobPost);
        }

        event(new ApplicationReceived($application));

        return $application;
    }

    private function hasBeenMatchedWithPost(JobPost $post): bool
    {
        if(!$this->jobMatches()) {
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
}
