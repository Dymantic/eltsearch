<?php

namespace App\Exceptions;

use Exception;

class RecruitmentException extends Exception
{
    public static function tooManyAttempts()
    {
        return new self('You have already contacted this teacher three times in the last 2 months.');
    }
}
