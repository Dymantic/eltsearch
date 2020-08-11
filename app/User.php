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


    protected $fillable = ['name', 'email', 'password', 'account_type'];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime', 'account_type' => 'integer'];

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public static function registerTeacher($teacher_data)
    {
        return static::create([
            'name' => $teacher_data['name'],
            'email' => $teacher_data['email'],
            'password' => Hash::make($teacher_data['password']),
            'account_type' => self::ACCOUNT_TEACHER
        ]);
    }

    public static function registerSchool($school_data)
    {
        $user = static::create([
            'name' => $school_data['name'],
            'email' => $school_data['email'],
            'password' => Hash::make($school_data['password']),
            'account_type' => self::ACCOUNT_SCHOOL
        ]);

        $school = School::new($school_data['school_name']);

        $school->setOwner($user);

        return $user;
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
            self::ACCOUNT_SCHOOL => "/schools",
            self::ACCOUNT_ADMIN => "/admin",
        ];

        return $paths[$this->account_type] ?? "/";
    }
}
