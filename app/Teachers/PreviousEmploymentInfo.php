<?php


namespace App\Teachers;


use Illuminate\Support\Carbon;

class PreviousEmploymentInfo
{
    public string $employer;
    public ?Carbon $employed_from;
    public ?Carbon $employed_to;
    public string $job_title;
    public string $description;

    public function __construct(array $info)
    {
        $this->employer = $info['employer'] ?? '';
        $this->employed_from = $this->getDate($info['start_month'] ?? null, $info['start_year'] ?? null);
        $this->employed_to = $this->getDate($info['end_month'] ?? null, $info['end_year'] ?? null);
        $this->job_title = $info['job_title'] ?? '';
        $this->description = $info['description'] ?? '';
    }

    private function getDate($month, $year)
    {
        if (!$month || !$year) {
            return null;
        }

        return Carbon::parse("{$year}-{$month}-01");
    }

    public function toArray(): array
    {
        return [
            'employer'      => $this->employer,
            'employed_from' => $this->employed_from,
            'employed_to'   => $this->employed_to,
            'job_title'     => $this->job_title,
            'description'   => $this->description,
        ];
    }
}
