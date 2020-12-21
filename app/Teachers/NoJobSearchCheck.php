<?php


namespace App\Teachers;


use App\StatusCheck;

class NoJobSearchCheck implements StatusCheck
{

    public function __construct(private Teacher $teacher)
    {
    }

    public function check(): bool
    {
        return $this->teacher->currentJobSearch() === null;
    }
}
