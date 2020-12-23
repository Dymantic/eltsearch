<?php


namespace App\Schools;


use App\StatusCheck;

class SchoolTokensCheck implements StatusCheck
{

    public function __construct(private School $school)
    {
    }

    public function check(): bool
    {
        return $this->school->availableTokens()->count() === 0;
    }
}
