<?php


namespace App\Placements;


use App\DateFormatter;
use App\Teachers\TeacherProfilePresenter;

class JobApplicationPresenter
{

    public static function forTeacher(JobApplication $application): array
    {
        $application->load('jobPost', 'showOfInterests');

        return [
            'id'                   => $application->id,
            'cover_letter'         => strip_tags(nl2br($application->cover_letter), '<br>'),
            'email'                => $application->email,
            'phone'                => $application->phone,
            'application_date'     => DateFormatter::pretty($application->created_at),
            'application_date_ago' => $application->created_at->diffForHumans(),
            'post'                 => JobPostPresenter::forPublic($application->jobPost),
            'show_of_interest'     => $application->showOfInterests()->latest()->first(),
        ];
    }

    public static function forSchool(JobApplication $application)
    {
        $application->load('teacher', 'jobPost');

        return [
            'id'                   => $application->id,
            'school_name'          => $application->jobPost->school_name,
            'position'             => $application->jobPost->position,
            'cover_letter'         => strip_tags(nl2br($application->cover_letter), '<br>'),
            'email'                => $application->email,
            'phone'                => $application->phone,
            'application_date'     => DateFormatter::pretty($application->created_at),
            'application_date_ago' => $application->created_at->diffForHumans(),
            'teacher'              => TeacherProfilePresenter::forSchool($application->teacher),
            'shown_interest'       => $application->hasShowOfInterest(),
        ];
    }
}
