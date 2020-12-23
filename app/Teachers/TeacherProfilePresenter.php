<?php


namespace App\Teachers;


use App\DateFormatter;

class TeacherProfilePresenter
{

    public static function generalInfo(Teacher $teacher): array
    {
        return [
            'name'             => $teacher->name,
            'slug'             => $teacher->slug,
            'nation_id'        => $teacher->nation_id,
            'nationality'      => optional($teacher->nation)->nationality,
            'date_of_birth'    => DateFormatter::standard($teacher->date_of_birth),
            'age'              => now()->diffInYears($teacher->date_of_birth),
            'email'            => $teacher->email,
            'native_language'  => $teacher->native_language,
            'other_languages'  => $teacher->other_languages,
            'avatar'           => $teacher->getAvatar(),
            'years_experience' => $teacher->years_experience,
            'signed_up'        => $teacher->created_at->diffForHumans(),
            'location'         => optional($teacher->area)->fullName('en'),
        ];
    }

    public static function educationInfo(Teacher $teacher, $lang = 'en'): array
    {
        $level = $teacher->education_level ? trans("teachers.education_levels.{$teacher->education_level}", [], $lang) : '';
        return [
            'education_level'         => $level,
            'education_institution'   => $teacher->education_institution,
            'education_qualification' => $teacher->education_qualification,
        ];
    }

    public static function previousEmployment(Teacher $teacher): array
    {
        return $teacher
            ->previousEmployments()->orderBy('employed_from', 'desc')->get()
            ->map(fn(PreviousEmployment $employment) => [
                'id'          => $employment->id,
                'employer'    => $employment->employer,
                'job_title'   => $employment->job_title,
                'start_month' => DateFormatter::monthAsIntegerString($employment->employed_from),
                'start_year'  => DateFormatter::yearAsIntegerString($employment->employed_from),
                'end_month'   => DateFormatter::monthAsIntegerString($employment->employed_to),
                'end_year'    => DateFormatter::yearAsIntegerString($employment->employed_to),
                'description' => $employment->description,
                'duration'    => sprintf("%s - %s", DateFormatter::monthAndYear($employment->employed_from, "unknown"),
                    DateFormatter::monthAndYear($employment->employed_to, "current")),
            ])->values()->all();
    }

    public static function forSchool(?Teacher $teacher, $lang = 'en')
    {
        if(!$teacher) {
            return [];
        }
        $teacher->load('previousEmployments');
        $general = self::generalInfo($teacher);
        $education = self::educationInfo($teacher, $lang);
        $employment = ['previous_employment' => self::previousEmployment($teacher)];

        return array_merge($general, $education, $employment);
    }

    public static function forTeacher(Teacher $teacher)
    {
        return self::generalInfo($teacher);
    }

    public static function forAdmin(?Teacher $teacher)
    {
        if(!$teacher) {
            return [];
        }
        $general = self::generalInfo($teacher);
        $education = self::educationInfo($teacher);
        $employment = ['previous_employment' => self::previousEmployment($teacher)];

        return array_merge($general, $education, $employment, ['id' => $teacher->id]);
    }
}
