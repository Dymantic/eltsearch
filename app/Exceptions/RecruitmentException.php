<?php

namespace App\Exceptions;

use Exception;

class RecruitmentException extends Exception
{

    const SCHOOL_DISABLED = 'school cannot recruit while profile is disabled';

    public static function tooManyAttempts()
    {
        return new self('You have already contacted this teacher three times in the last 2 months.');
    }

    public static function schoolDisabled(): self
    {
        return new self(self::SCHOOL_DISABLED);
    }
}
