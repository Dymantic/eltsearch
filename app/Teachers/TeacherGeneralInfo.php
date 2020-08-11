<?php


namespace App\Teachers;


use Illuminate\Support\Carbon;

class TeacherGeneralInfo
{
    public string $name;
    public string $nationality;
    public string $email;
    public string $native_language;
    public string $other_languages;
    public ?Carbon $date_of_birth;
    public ?int $area_id;

    public function __construct($info)
    {
        $this->name = $info['name'] ?? '';
        $this->nationality = $info['nationality'] ?? '';
        $this->email = $info['email'] ?? '';
        $this->native_language = $info['native_language'] ?? '';
        $this->other_languages = $info['other_languages'] ?? '';
        $this->date_of_birth = $info['date_of_birth'] ?? false ? Carbon::parse($info['date_of_birth']) : null;
        $this->area_id = $info['area_id'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'name'            => $this->name,
            'nationality'     => $this->nationality,
            'email'           => $this->email,
            'native_language' => $this->native_language,
            'other_languages' => $this->other_languages,
            'date_of_birth'   => $this->date_of_birth,
            'area_id'         => $this->area_id,
        ];
    }

}
