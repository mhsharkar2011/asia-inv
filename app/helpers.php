<?php

use Carbon\Carbon;

if (!function_exists('format_date')) {
    function format_date($date, $format = 'M d, Y')
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
