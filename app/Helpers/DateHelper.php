<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function format($date = null, string $format = 'Y-m-d', string $timezone = null): ?string
    {
        if (is_null($date)) {
            $date = now();
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        if ($date instanceof Carbon) {
            if ($timezone) {
                $date = $date->setTimezone($timezone);
            }

            return $date->format($format);
        }

        return null;
    }

    public static function formatDatetime($date = null, string $format = 'Y-m-d H:i:s'): ?string
    {
        return self::format($date, $format);
    }

    public static function formatTime($date = null, string $format = 'H:i:s'): ?string
    {
        return self::format($date, $format);
    }
}
