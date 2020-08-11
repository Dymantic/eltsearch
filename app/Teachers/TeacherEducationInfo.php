<?php


namespace App\Teachers;


class TeacherEducationInfo
{
    public string $level;
    public string $institution;
    public string $qualification;

    public function __construct(array $info)
    {
        $this->level = $info['education_level'] ?? '';
        $this->institution = $info['education_institution'] ?? '';
        $this->qualification = $info['education_qualification'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'education_level'         => $this->level,
            'education_institution'   => $this->institution,
            'education_qualification' => $this->qualification,
        ];
    }
}
