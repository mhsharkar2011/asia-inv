<?php

// ============================================================================
// Date Helper Functions
// ============================================================================

if (!function_exists('format_date')) {
    /**
     * Format a date
     */
    function format_date(mixed $date = null, string $format = 'Y-m-d', ?string $timezone = null): ?string
    {
        return App\Helpers\DateHelper::format($date, $format, $timezone);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format datetime
     */
    function format_datetime(mixed $date = null, string $format = 'Y-m-d H:i:s'): ?string
    {
        return App\Helpers\DateHelper::formatDatetime($date, $format);
    }
}

if (!function_exists('format_time')) {
    /**
     * Format time only
     */
    function format_time(mixed $date = null, string $format = 'H:i:s'): ?string
    {
        return App\Helpers\DateHelper::formatTime($date, $format);
    }
}

if (!function_exists('parse_date')) {
    /**
     * Parse a date string to Carbon instance
     */
    function parse_date(mixed $date, ?string $timezone = null): ?Carbon
    {
        return App\Helpers\DateHelper::parse($date, $timezone);
    }
}

if (!function_exists('date_diff')) {
    /**
     * Get difference between two dates
     */
    function date_diff(mixed $from, mixed $to = null, string $unit = 'days'): ?int
    {
        return App\Helpers\DateHelper::diff($from, $to, $unit);
    }
}

// ============================================================================
// Number Helper Functions
// ============================================================================

if (!function_exists('number_to_words')) {
    /**
     * Convert number to words
     */
    function number_to_words($number): string
    {
        $number = (int) round($number);

        $words = [
            0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        if ($number < 21) {
            return $words[$number];
        }

        if ($number < 100) {
            $tens = floor($number / 10) * 10;
            $units = $number % 10;
            return $words[$tens] . ($units ? ' ' . $words[$units] : '');
        }

        if ($number < 1000) {
            $hundreds = floor($number / 100);
            $remainder = $number % 100;
            return $words[$hundreds] . ' Hundred' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        if ($number < 100000) {
            $thousands = floor($number / 1000);
            $remainder = $number % 1000;
            return number_to_words($thousands) . ' Thousand' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        if ($number < 10000000) {
            $lakhs = floor($number / 100000);
            $remainder = $number % 100000;
            return number_to_words($lakhs) . ' Lakh' . ($remainder ? ' ' . number_to_words($remainder) : '');
        }

        $crores = floor($number / 10000000);
        $remainder = $number % 10000000;
        return number_to_words($crores) . ' Crore' . ($remainder ? ' ' . number_to_words($remainder) : '');
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency
     */
    function format_currency($amount, string $currency = 'BDT', int $decimals = 2): string
    {
        $symbols = [
            'BDT' => '৳',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
        ];

        $symbol = $symbols[$currency] ?? $currency . ' ';

        return $symbol . number_format($amount, $decimals);
    }
}

// ============================================================================
// String Helper Functions
// ============================================================================

if (!function_exists('generate_order_number')) {
    /**
     * Generate a unique order number
     */
    function generate_order_number(string $prefix = 'SO', int $length = 6): string
    {
        $number = str_pad(rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        return $prefix . '-' . date('Ymd') . '-' . $number;
    }
}

if (!function_exists('sanitize_slug')) {
    /**
     * Sanitize a string to be used as a slug
     */
    function sanitize_slug(string $string): string
    {
        // Convert to lowercase
        $string = strtolower($string);

        // Replace spaces with hyphens
        $string = str_replace(' ', '-', $string);

        // Remove special characters
        $string = preg_replace('/[^a-z0-9\-]/', '', $string);

        // Remove multiple hyphens
        $string = preg_replace('/-+/', '-', $string);

        return trim($string, '-');
    }
}

// ============================================================================
// Validation Helper Functions
// ============================================================================

if (!function_exists('is_valid_bangladeshi_phone')) {
    /**
     * Check if a phone number is a valid Bangladeshi phone number
     */
    function is_valid_bangladeshi_phone(string $phone): bool
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Check if it starts with 01 and has 11 digits
        if (preg_match('/^01[3-9]\d{8}$/', $phone)) {
            return true;
        }

        // Check if it starts with 8801 and has 13 digits
        if (preg_match('/^8801[3-9]\d{8}$/', $phone)) {
            return true;
        }

        return false;
    }
}

// ============================================================================
// JSON Helper Functions
// ============================================================================

if (!function_exists('json_response')) {
    /**
     * Return a JSON response with consistent structure
     */
    function json_response(bool $success, string $message, mixed $data = null, int $code = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('json_success')) {
    /**
     * Return a success JSON response
     */
    function json_success(string $message, mixed $data = null, int $code = 200): \Illuminate\Http\JsonResponse
    {
        return json_response(true, $message, $data, $code);
    }
}

if (!function_exists('json_error')) {
    /**
     * Return an error JSON response
     */
    function json_error(string $message, mixed $data = null, int $code = 400): \Illuminate\Http\JsonResponse
    {
        return json_response(false, $message, $data, $code);
    }
}
