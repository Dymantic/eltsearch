<?php

namespace App;

use App\Notifications\WelcomeSchool;
use App\Notifications\WelcomeTeacher;
use App\Schools\School;
use App\Schools\SchoolUser;
use App\Teachers\Teacher;
use App\Teachers\TeacherEducationInfo;
use App\Teachers\TeacherGeneralInfo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;

    const ACCOUNT_TEACHER = 1;
    const ACCOUNT_SCHOOL = 2;
    const ACCOUNT_ADMIN = 3;

    const PLATFORM_FACEBOOK = 'facebook';


    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'platform',
        'provider_user_id',
        'preferred_lang'
    ];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime', 'account_type' => 'integer'];

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public static function findFacebookUser($creds): ?self
    {
        return self::where([
            ['email', $creds['email']],
            ['platform', self::PLATFORM_FACEBOOK],
            ['provider_user_id', $creds['id']],
        ])->first();
    }

    public static function registerTeacherViaFacebook($user_data)
    {
        $user = self::create([
            'name'             => $user_data['name'],
            'email'            => $user_data['email'],
            'provider_user_id' => $user_data['id'],
            'platform'         => self::PLATFORM_FACEBOOK,
            'account_type'     => self::ACCOUNT_TEACHER
        ]);

        $user->createTeacherProfile($user_data);

        $user->notify(new WelcomeTeacher($user));

        return $user;
    }

    public static function registerTeacher($teacher_data)
    {
        $user = static::create([
            'name'         => $teacher_data['name'],
            'email'        => $teacher_data['email'],
            'password'     => Hash::make($teacher_data['password']),
            'account_type' => self::ACCOUNT_TEACHER
        ]);

        $user->createTeacherProfile($teacher_data);

        $user->notify(new WelcomeTeacher($user));

        return $user;
    }

    public static function createTeacherFromGuestApplication(
        TeacherGeneralInfo $generalInfo,
        TeacherEducationInfo $educationInfo,
        string $password
    ) {
        $user = static::create([
            'name'         => $generalInfo->name,
            'email'        => $generalInfo->email,
            'password'     => Hash::make($password),
            'account_type' => self::ACCOUNT_TEACHER
        ]);

        $user->notify((new WelcomeTeacher($user))->delay(now()->addMinutes(10)));

        $teacher = $user->createTeacherProfile(array_merge($generalInfo->toArray(), $educationInfo->toArray()));


        return $teacher;
    }

    protected function createTeacherProfile($teacher_data)
    {
        $defaults = [
            'name'                    => $teacher_data['name'],
            'email'                   => $teacher_data['email'],
            'nation_id'               => null,
            'native_language'         => '',
            'other_languages'         => '',
            'education_level'         => '',
            'education_institution'   => '',
            'education_qualification' => '',
            'slug'                    => UniqueKey::for('teachers:slug'),
        ];
        $teacher = $this->teacher()->create(array_merge($defaults, $teacher_data));
        Log::info(json_encode($teacher_data));
        if ($teacher_data['avatar'] ?? false) {
            $teacher->setAvatarFromUrl($teacher_data['avatar']);
        }

        return $teacher;
    }

    public static function registerSchool($school_data)
    {
        $user = static::create([
            'name'           => $school_data['name'],
            'email'          => $school_data['email'],
            'password'       => Hash::make($school_data['password']),
            'account_type'   => self::ACCOUNT_SCHOOL,
            'preferred_lang' => $school_data['preferred_lang'] ?? 'en',
        ]);

        $school = School::new($school_data['school_name']);

        $school->setOwner($user);

        $user->notify(new WelcomeSchool($user, $school));

        return $user;
    }

    public function resetPassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    public function setLanguagePreference(string $lang)
    {
        $this->preferred_lang = $lang;
        $this->save();
    }

    public function schools()
    {
        return $this->belongsToMany(School::class)
                    ->withPivot(['owner'])
                    ->as('team')
                    ->using(SchoolUser::class);
    }

    public function isTeacher()
    {
        return $this->account_type === self::ACCOUNT_TEACHER;
    }

    public function isSchool()
    {
        return $this->account_type === self::ACCOUNT_SCHOOL;
    }

    public function isAdmin()
    {
        return $this->account_type === self::ACCOUNT_ADMIN;
    }

    public function redirectHome($path = '')
    {
        $paths = [
            self::ACCOUNT_TEACHER => "/teachers",
            self::ACCOUNT_SCHOOL  => "/schools",
            self::ACCOUNT_ADMIN   => "/admin",
        ];

        return $paths[$this->account_type] . $path ?? "/";
    }

    public function getNotifications()
    {
        return $this->notifications->map(fn($notification) => $this->presentNotification($notification));
    }

    private function presentNotification(DatabaseNotification $notification): array
    {

        return [
            'id'        => $notification->id,
            'is_read'   => $notification->read(),
            'sender'    => $notification->data['sender'] ?? '',
            'subject'   => $this->translatedNotificationField($notification, 'subject'),
            'message'   => $this->translatedNotificationField($notification, 'message'),
            'action'    => $this->translatedNotificationField($notification, 'action'),
            'url'       => $notification->data['action_url'],
            'date_sent' => DateFormatter::pretty($notification->created_at),
            'date_read' => DateFormatter::pretty($notification->read_at),
        ];

    }

    private function translatedNotificationField($notification, $field)
    {
        if (!$notification->data['requires_translation'] ?? false) {
            return $notification->data[$field]['text'];
        }

        return Lang::get(
            $notification->data[$field]['text'],
            $notification->data[$field]['params'],
            $this->preferred_lang
        );
    }
}
