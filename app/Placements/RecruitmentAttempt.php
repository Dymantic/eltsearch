<?php

namespace App\Placements;

use App\DateFormatter;
use App\Schools\School;
use App\Schools\SchoolPresenter;
use App\Teachers\Teacher;
use App\Teachers\TeacherProfilePresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentAttempt extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function dismiss()
    {
        $this->dismissed = true;
        $this->save();
    }

    public function presentForSchool(): array
    {
        return [
            'id' => $this->id,
            'created_at' => DateFormatter::pretty($this->created_at),
            'message' => $this->message,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'school' => SchoolPresenter::forSchools($this->school),
            'teacher' => TeacherProfilePresenter::forSchool($this->teacher),
        ];

    }

    public function presentForTeacher()
    {
        return [
            'id' => $this->id,
            'created_at' => DateFormatter::pretty($this->created_at),
            'message' => $this->message,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'school' => SchoolPresenter::forTeacher($this->school),
            'teacher' => TeacherProfilePresenter::forTeacher($this->teacher),
        ];
    }
}
