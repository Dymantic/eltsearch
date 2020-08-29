<?php


namespace App;


use Illuminate\Support\Carbon;

class DateFormatter
{
    const STANDARD = 'Y-m-d';

    public static function standard(?Carbon $date): string
    {
        if(!$date) {
            return '';
        }

        return $date->format(self::STANDARD);
    }

    public static function monthAsIntegerString(?Carbon $date): string
    {
        if(!$date) {
            return "";
        }

        return sprintf("%s", intval($date->format('m')));
    }

    public static function yearAsIntegerString(?Carbon $date): string
    {
        if(!$date) {
            return "";
        }

        return $date->format('Y');
    }

    public static function monthAndYear(?Carbon $date, $default = ''): string
    {
        if(!$date) {
            return $default;
        }

        return $date->format('M, Y');
    }
}
