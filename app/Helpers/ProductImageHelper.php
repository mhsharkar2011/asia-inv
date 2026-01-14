<?php

use App\Models\Inventory\Product;
use Illuminate\Support\Str;

function generateProductCode()
{
    $prefix = 'PROD-';
    $year = date('y');
    $month = date('m');
    $random = strtoupper(Str::random(3));
    $sequence = Product::whereYear('created_at', date('Y'))
        ->whereMonth('created_at', date('m'))
        ->count() + 1;

    return sprintf('%s%s%s%s%03d', $prefix, $year, $month, $random, $sequence);
}
