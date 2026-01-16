<?php

if (!function_exists('format_date')) {
    /**
     * Format a date string
     *
     * @param  string|Carbon|null  $date
     * @param  string  $format
     * @param  string  $timezone
     * @return string|null
     */
    function format_date($date = null, string $format = 'd-m-Y', string $timezone = null): ?string
    {
        if (is_null($date)) {
            $date = now();
        }

        if (is_string($date)) {
            $date = Carbon\Carbon::parse($date);
        }

        if ($date instanceof \Carbon\Carbon) {
            if ($timezone) {
                $date = $date->setTimezone($timezone);
            }

            return $date->format($format);
        }

        return null;
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format a datetime string
     *
     * @param  string|Carbon|null  $date
     * @param  string  $format
     * @return string|null
     */
    function format_datetime($date = null, string $format = 'd-m-Y H:i:s'): ?string
    {
        return format_date($date, $format);
    }
}

if (!function_exists('format_time')) {
    /**
     * Format a time string
     *
     * @param  string|Carbon|null  $date
     * @param  string  $format
     * @return string|null
     */
    function format_time($date = null, string $format = 'H:i:s'): ?string
    {
        return format_date($date, $format);
    }
}


