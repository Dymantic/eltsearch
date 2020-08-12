<?php

namespace App\Teachers;

use App\ContactDetails;
use App\Locations\Area;
use App\Placements\JobApplication;
use App\Placements\JobPost;
use App\Placements\JobSearch;
use App\Placements\JobSearchCriteria;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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

    public function createJobSearch(JobSearchCriteria $criteria): JobSearch
    {
        return $this->jobSearches()->create($criteria->toArray());
    }

    public function jobApplications()
    {
        return $this->belongsToMany(JobPost::class, 'job_applications');
    }

    public function applyForJob(
        JobPost $jobPost,
        string $cover_letter,
        ContactDetails $contactDetails
    ): JobApplication {

        $this->jobApplications()->attach($jobPost->id, [
            'cover_letter' => $cover_letter,
            'phone'        => $contactDetails->phone,
            'email'        => $contactDetails->emailOr($this->email),
        ]);

        return JobApplication::where([
            ['teacher_id', $this->id],
            ['job_post_id', $jobPost->id],
        ])->latest()->first();
    }

    public function retract()
    {
        $this->is_public = false;
        $this->save();
    }

    public function setAvatar(UploadedFile $upload): Media
    {
        return $this->addMedia($upload)
                    ->usingFileName($upload->hashName())
                    ->toMediaCollection(self::AVATAR);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 400, 300)
             ->optimize()
             ->performOnCollections(self::AVATAR);

    }
}
