<?php


namespace App\Placements;


use App\DateFormatter;
use Illuminate\Support\Carbon;

class JobPostInfo
{
    public string $school_name;
    public string $description;
    public ?int $area_id;
    public string $position;
    public string $engagement;
    public ?int $hours_per_week;
    public ?int $min_students_per_class;
    public ?int $max_students_per_class;
    public array $student_ages;
    public bool $work_on_weekends;
    public array $requirements;
    public string $salary_rate;
    public ?int $salary_min;
    public ?int $salary_max;
    public Carbon $start_date;
    public array $benefits;
    public string $contract_length;
    public array $schedule;

    public function __construct($info)
    {
        $this->school_name = $info['school_name'] ?? '';
        $this->description = $info['description'] ?? '';
        $this->area_id = $info['area_id'] ? intval($info['area_id']) : null;
        $this->position = $info['position'] ?? '';
        $this->engagement = $info['engagement'] ?? '';
        $this->hours_per_week = $info['hours_per_week'];
        $this->min_students_per_class = $info['min_students_per_class'];
        $this->max_students_per_class = $info['max_students_per_class'];
        $this->student_ages = $info['student_ages'] ?? [];
        $this->work_on_weekends = $info['work_on_weekends'] ?? false;
        $this->requirements = $info['requirements'] ?? [];
        $this->salary_rate = $info['salary_rate'] ?? '';
        $this->salary_min = $info['salary_min'];
        $this->salary_max = $info['salary_max'];
        $this->start_date = Carbon::parse($info['start_date']);
        $this->benefits = $info['benefits'] ?? [];
        $this->contract_length = $info['contract_length'] ?? '';
        $this->schedule = $info['schedule'] ?? [];
    }

    public function toArray(): array
    {
        return [
            'school_name'            => $this->school_name,
            'description'            => $this->description,
            'area_id'                => $this->area_id,
            'position'               => $this->position,
            'engagement'             => $this->engagement,
            'hours_per_week'         => $this->hours_per_week,
            'min_students_per_class' => $this->min_students_per_class,
            'max_students_per_class' => $this->max_students_per_class,
            'student_ages'           => $this->student_ages,
            'work_on_weekends'       => $this->work_on_weekends,
            'requirements'           => $this->requirements,
            'salary_rate'            => $this->salary_rate,
            'salary_min'             => $this->salary_min,
            'salary_max'             => $this->salary_max,
            'start_date'             => $this->start_date,
            'benefits'               => $this->benefits,
            'contract_length'        => $this->contract_length,
            'schedule'               => $this->schedule,
        ];
    }

}
