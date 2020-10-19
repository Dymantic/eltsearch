<?php

namespace App;

use App\Schools\School;
use App\Schools\SchoolUser;
use App\Teachers\Teacher;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    const ACCOUNT_TEACHER = 1;
    const ACCOUNT_SCHOOL = 2;
    const ACCOUNT_ADMIN = 3;

    const PLATFORM_FACEBOOK = 'facebook';


    protected $fillable = ['name', 'email', 'password', 'account_type', 'platform', 'provider_user_id', 'preferred_lang'];

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
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'provider_user_id' => $user_data['id'],
            'platform' => self::PLATFORM_FACEBOOK,
            'account_type' => self::ACCOUNT_TEACHER
        ]);

        $user->createTeacherProfile($user_data);

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

        return $user;
    }

    protected function createTeacherProfile($teacher_data)
    {
        $teacher = $this->teacher()->create([
            'name'                    => $teacher_data['name'],
            'email'                   => $teacher_data['email'],
            'nationality'             => '',
            'native_language'         => '',
            'other_languages'         => '',
            'education_level'         => '',
            'education_institution'   => '',
            'education_qualification' => '',
        ]);

        if($teacher_data['avatar'] ?? false) {
            $teacher->setAvatarFromUrl($teacher_data['avatar']);
        }
    }

    public static function registerSchool($school_data)
    {
        $user = static::create([
            'name'         => $school_data['name'],
            'email'        => $school_data['email'],
            'password'     => Hash::make($school_data['password']),
            'account_type' => self::ACCOUNT_SCHOOL,
            'preferred_lang' => $school_data['preferred_lang'] ?? 'en',
        ]);

        $school = School::new($school_data['school_name']);

        $school->setOwner($user);

        return $user;
    }

    public function resetPassword(string $password)
    {
        $this->password = Hash::make($password);
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

    public function redirectHome()
    {
        $paths = [
            self::ACCOUNT_TEACHER => "/teachers",
            self::ACCOUNT_SCHOOL  => "/schools",
            self::ACCOUNT_ADMIN   => "/admin",
        ];

        return $paths[$this->account_type] ?? "/";
    }
}
