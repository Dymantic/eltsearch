<?php


namespace App\Placements;


class JobSearchCriteria
{

    public array $area_ids;
    public array $student_ages;
    public array $benefits;
    public array $contract_type;
    public ?int $salary;
    public ?int $hours_per_week;
    public bool $weekends;
    public string $engagement;
    public array $schedule;

    public function __construct($info)
    {
        $this->area_ids = $info['area_ids'] ?? [];
        $this->student_ages = $info['student_ages'] ?? [];
        $this->benefits = $info['benefits'] ?? [];
        $this->contract_type = $info['contract_type'] ?? [];
        $this->salary = $info['salary'] ?? null;
        $this->hours_per_week = $info['hours_per_week'] ?? null;
        $this->weekends = $info['weekends'] ?? true;
        $this->engagement = $info['engagement'] ?? '';
        $this->schedule = $info['schedule'] ?? [];
    }

    public function toArray(): array
    {
        return [
            'area_ids'       => $this->area_ids,
            'student_ages'   => $this->student_ages,
            'benefits'       => $this->benefits,
            'contract_type'  => $this->contract_type,
            'salary'         => $this->salary,
            'hours_per_week' => $this->hours_per_week,
            'weekends'       => $this->weekends,
            'engagement'     => $this->engagement,
            'schedule'       => $this->schedule,
        ];
    }
}
