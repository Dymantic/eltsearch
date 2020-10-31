<?php


namespace App\Placements;


trait ListsCriteria
{
    public function listCriteria(): array
    {
        $criteria =  collect([]);

        if($this->hasLocation()) {
            $criteria->push(self::CRITERIA_LOCATION);
        }

        if($this->hasStudentAges()) {
            $criteria->push(self::CRITERIA_STUDENTS);
        }

        if($this->hasBenefits()) {
            $criteria->push(self::CRITERIA_BENEFITS);
        }

        if($this->hasContractTypes()) {
            $criteria->push(self::CRITERIA_CONTRACT);
        }

        if($this->hasSchedule()) {
            $criteria->push(self::CRITERIA_SCHEDULE);
        }

        if($this->hasSalary()) {
            $criteria->push(self::CRITERIA_SALARY);
        }

        if($this->hasHours()) {
            $criteria->push(self::CRITERIA_HOURS);
        }

        if($this->hasEngagement()) {
            $criteria->push(self::CRITERIA_ENGAGEMENT);
        }

        if($this->hasWeekends()) {
            $criteria->push(self::CRITERIA_WEEKENDS);
        }

        return $criteria->all();
    }

    public function hasLocation()
    {
        return $this->area_ids && count($this->area_ids);
    }

    public function hasStudentAges()
    {
        return $this->student_ages && count($this->student_ages);
    }

    public function hasBenefits()
    {
        return $this->benefits && count($this->benefits);
    }

    public function hasContractTypes()
    {
        return $this->contract_type && count($this->contract_type);
    }

    public function hasSchedule()
    {
        return $this->schedule && count($this->schedule);
    }

    public function hasSalary()
    {
        return $this->salary !== null;
    }

    public function hasHours()
    {
        return $this->hours_per_week !== null;
    }

    public function hasWeekends()
    {
        return $this->weekends !== null;
    }

    public function hasEngagement()
    {
        return $this->engagement !== null && $this->engagement;
    }
}
