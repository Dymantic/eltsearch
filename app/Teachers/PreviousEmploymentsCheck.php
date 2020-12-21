<?php


namespace App\Teachers;


use App\StatusCheck;

class PreviousEmploymentsCheck implements StatusCheck
{

    public function __construct(private Teacher $teacher)
    {
    }

    public function check(): bool
    {
        return $this->teacher->previousEmployments()->count() === 0;
    }
}
