<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function format($date, $format = 'M d, Y')
    {
        if (!$date) {
            return 'N/A';
        }

        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format($format);
    }
}
