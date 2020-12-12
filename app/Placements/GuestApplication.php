<?php


namespace App\Placements;


use App\ContactDetails;
use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use App\User;

class GuestApplication
{
    public static function storeInitialApplication(array $applicationInfo)
    {
        session()->put('guest_application', $applicationInfo);
    }

    public static function startProcess(JobPost $post)
    {
        session()->put('guest_application.post_slug', $post->slug);
    }

    public static function createProfileForApplicant(
        TeacherGeneralInfo $generalInfo,
        TeacherEducationInfo $educationInfo,
        string $password
    ) {
        $teacher = User::createTeacherFromGuestApplication($generalInfo, $educationInfo, $password);

        session()->put('guest_application.teacher_id', $teacher->id);
        session()->put('guest_application.user_id', $teacher->user_id);
    }

    public static function teacherProfile(): ?Teacher
    {
        return Teacher::find(session()->get('guest_application.teacher_id'));
    }

    public static function jobPost(): ?JobPost
    {
        return JobPost::where('slug', session()->get('guest_application.post_slug'))->first();
    }

    public static function coverLetter(): string
    {
        return session()->get('guest_application.cover_letter', '');
    }

    public static function contactDetails(): ContactDetails
    {
        return new ContactDetails([
            'email' => session()->get('guest_application.contact_email', ''),
            'phone' => session()->get('guest_application.contact_phone', ''),
        ]);
    }

    public static function complete()
    {
        $post = static::jobPost();
        $teacher = static::teacherProfile();

        $teacher->applyForJob($post, static::coverLetter(), static::contactDetails());
    }
}
