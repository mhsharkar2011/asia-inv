<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PerformanceBadge extends Component
{
    public $performance;

    public function __construct($performance)
    {
        $this->performance = $performance;
    }

    public function render(): View|Closure|string
    {
        return view('components.performance-badge');
    }

    public function colorClass()
    {
        $classes = [
            'Excellent' => 'bg-green-100 text-green-800',
            'Good' => 'bg-blue-100 text-blue-800',
            'Average' => 'bg-yellow-100 text-yellow-800',
            'Poor' => 'bg-red-100 text-red-800',
        ];

        return $classes[$this->performance] ?? 'bg-red-100 text-gray-800';
    }
}
