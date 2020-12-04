<?php


namespace App\Teachers;


use Illuminate\Support\Carbon;

class TeacherGeneralInfo
{
    public string $name;
    public ?int $nation_id;
    public string $email;
    public string $native_language;
    public string $other_languages;
    public ?Carbon $date_of_birth;
    public ?int $years_experience;

    public function __construct($info)
    {
        $this->name = $info['name'] ?? '';
        $this->nation_id = $info['nation_id'] ?? null;
        $this->email = $info['email'] ?? '';
        $this->native_language = $info['native_language'] ?? '';
        $this->other_languages = $info['other_languages'] ?? '';
        $this->date_of_birth = $info['date_of_birth'] ?? false ? Carbon::parse($info['date_of_birth']) : null;
        $this->years_experience = $info['years_experience'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'name'             => $this->name,
            'nation_id'        => $this->nation_id,
            'email'            => $this->email,
            'native_language'  => $this->native_language,
            'other_languages'  => $this->other_languages,
            'date_of_birth'    => $this->date_of_birth,
            'years_experience' => $this->years_experience,
        ];
    }

}
