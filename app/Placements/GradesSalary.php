<?php


namespace App\Placements;


trait GradesSalary
{
    public function setSalaryGrade()
    {
        if($this->missingSalaryInfo()) {
            return null;
        }

        $cutoffs = $this->limitsPerRate();

        $mean_salary = ($this->salary_min + $this->salary_max) / 2;

        if ($mean_salary > $cutoffs[JobPost::SALARY_GRADE_MID]) {
            $this->salary_grade = JobPost::SALARY_GRADE_MAX;

            return $this->save();
        }

        if (
            $mean_salary > $cutoffs[JobPost::SALARY_GRADE_MIN] &&
            $mean_salary < $cutoffs[JobPost::SALARY_GRADE_MID]
        ) {
            $this->salary_grade = JobPost::SALARY_GRADE_MID;

            return $this->save();
        }

        $this->salary_grade = JobPost::SALARY_GRADE_MIN;

        return $this->save();
    }

    private function missingSalaryInfo(): bool
    {
        if(!in_array($this->salary_rate, JobPost::ALLOWED_SALARY_RATES)) {
            return true;
        }

        if(!$this->salary_min || !$this->salary_max) {
            return true;
        }

        return false;
    }

    private function limitsPerRate(): array
    {
        switch ($this->salary_rate) {
            case JobPost::SALARY_RATE_HOUR:
                $min_cutoff = 499;
                $mid_cutoff = 699;
                break;
            case JobPost::SALARY_RATE_WEEK:
                $min_cutoff = 499 * 20;
                $mid_cutoff = 699 * 20;
                break;
            case JobPost::SALARY_RATE_MONTH:
                $min_cutoff = 49999;
                $mid_cutoff = 69999;
                break;
        }

        return [
            JobPost::SALARY_GRADE_MIN => $min_cutoff,
            JobPost::SALARY_GRADE_MID => $mid_cutoff,
        ];
    }

}
