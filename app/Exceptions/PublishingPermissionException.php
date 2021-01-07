<?php

namespace App\Exceptions;

use Exception;

class PublishingPermissionException extends Exception
{

    const POST_DISABLED = 'disabled job posts may not be published';
    const SCHOOL_DISABLED = 'job posts may not be published whilst your profile is disabled';

    public static function postDisabled(): self
    {
        return new self(self::POST_DISABLED);
    }

    public static function schoolDisabled(): self
    {
        return new self(self::SCHOOL_DISABLED);
    }
}
