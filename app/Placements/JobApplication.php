<?php

namespace App\Placements;

use App\ContactPersonInfo;
use App\Exceptions\RecruitmentException;
use App\Teachers\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_post_id',
        'cover_letter',
        'email',
        'phone'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function showOfInterests()
    {
        return $this->hasMany(ShowOfInterest::class);
    }

    public function showInterest(ContactPersonInfo $contactPerson): ShowOfInterest
    {
        if($this->jobPost->school->isDisabled()) {
            throw RecruitmentException::schoolDisabled();
        }

        return $this->showOfInterests()->create($contactPerson->toArray());
    }

    public function hasShowOfInterest()
    {
        return !!$this->showOfInterests()->count();
    }

    public function presentForTeacher()
    {
        return JobApplicationPresenter::forTeacher($this);
    }


}
