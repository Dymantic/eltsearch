<?php


namespace App\Schools;


use App\StatusCheck;

class IncompleteProfileCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        return $this->school->address === '' ||
            $this->school->introduction === '' ||
            $this->school->area_id === null;
    }
}
