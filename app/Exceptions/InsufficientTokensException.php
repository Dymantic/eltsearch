<?php

namespace App\Exceptions;

use Exception;

class InsufficientTokensException extends Exception
{
    public static function tokenRequired()
    {
        return new self('A token is required for this action');
    }
}
