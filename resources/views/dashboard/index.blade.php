@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="space-y-2">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                        <p class="text-gray-600 mt-1">Welcome back, {{ Auth::user()->name ?? 'User' }}! Here's what's
                            happening today.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>System is running smoothly</span>
                    </div>
                    <span>•</span>
                    <span>Last updated: {{ now()->format('M d, H:i') }}</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Generate Report
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl shadow-blue-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Dashboard
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    [
                        'title' => 'Total Customers',
                        'value' => $customerCount ?? 0,
                        'icon' =>
                            'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01',
                        'color' => 'blue',
                        'trend' => '+12.5%',
                        'trendColor' => 'green',
                        'link' => route('admin.companies.index'),
                    ],
                    [
                        'title' => 'Total Products',
                        'value' => $productCount ?? 0,
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'color' => 'green',
                        'trend' => '+8.2%',
                        'trendColor' => 'green',
                        'link' => route('inventory.products.index'),
                    ],
                    [
                        'title' => 'Total Revenue',
                        'value' => '৳' . number_format($totalRevenue ?? 0),
                        'icon' =>
                            'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'color' => 'purple',
                        'trend' => '+23.1%',
                        'trendColor' => 'green',
                        'link' => route('sales.invoices.index'),
                    ],
                    [
                        'title' => 'Pending Invoices',
                        'value' => $pendingInvoices ?? 0,
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                        'color' => 'amber',
                        'trend' => '-5.3%',
                        'trendColor' => 'red',
                        'link' => route('sales.invoices.index', ['status' => 'pending']),
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div
                    class="group relative bg-white rounded-2xl p-6 border border-gray-100 hover:border-transparent transition-all duration-300 hover:shadow-xl overflow-hidden">
                    <!-- Animated background gradient -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">
                                    {{ $stat['title'] }}</p>
                                <h3 class="text-3xl font-bold text-gray-900 mb-3">{{ $stat['value'] }}</h3>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $stat['trendColor'] === 'green' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                        @if ($stat['trendColor'] === 'green')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        @endif
                                        {{ $stat['trend'] }}
                                    </span>
                                    <span class="text-xs text-gray-500">from last month</span>
                                </div>
                            </div>
                            <div
                                class="ml-4 p-3 rounded-xl bg-gradient-to-br from-{{ $stat['color'] }}-100 to-{{ $stat['color'] }}-50 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $stat['icon'] }}" />
                                </svg>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <a href="{{ $stat['link'] }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-{{ $stat['color'] }}-600 transition-colors group/link">
                                View Details
                                <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Charts & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Revenue Chart -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="space-y-1">
                            <h2 class="text-xl font-bold text-gray-900">Revenue Overview</h2>
                            <p class="text-gray-600">Monthly revenue performance and trends</p>
                        </div>
                        <div class="relative">
                            <select
                                class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Last 12 Months</option>
                                <option>Last 6 Months</option>
                                <option>Last 30 Days</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="revenueChart"></canvas>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Average Monthly Revenue</p>
                                <p class="text-lg font-semibold text-gray-900">৳{{ number_format($averageRevenue ?? 0) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Growth Rate</p>
                                <div class="flex items-center gap-1">
                                    <p class="text-lg font-semibold {{ $growthColor ?? 'text-green-600' }}">
                                        {{ $growthRate ?? 0 }}%
                                    </p>
                                    @if (isset($growthRate) && $growthRate != 0)
                                        <span class="text-sm {{ $growthColor ?? 'text-green-600' }}">
                                            {{ $growthIcon ?? '↑' }}
                                        </span>
                                    @endif
                                </div>
                                @if (isset($growthRate) && $growthRate > 0)
                                    <p class="text-xs text-green-600 mt-1">vs previous month</p>
                                @elseif(isset($growthRate) && $growthRate < 0)
                                    <p class="text-xs text-red-600 mt-1">vs previous month</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total This Month</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    ৳{{ number_format($currentMonthRevenue ?? 0) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Projected</p>
                                <p class="text-lg font-semibold text-blue-600">
                                    ৳{{ number_format($projectedRevenue ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $actions = [
                                [
                                    'route' => 'sales.sales-orders.create',
                                    'icon' => 'plus',
                                    'color' => 'blue',
                                    'label' => 'New Order',
                                ],
                                [
                                    'route' => 'sales.invoices.create',
                                    'icon' => 'file',
                                    'color' => 'green',
                                    'label' => 'New Invoice',
                                ],
                                [
                                    'route' => 'admin.companies.create',
                                    'icon' => 'user-plus',
                                    'color' => 'purple',
                                    'label' => 'Add Customer',
                                ],
                                [
                                    'route' => 'inventory.products.create',
                                    'icon' => 'package-plus',
                                    'color' => 'amber',
                                    'label' => 'Add Product',
                                ],
                            ];
                        @endphp

                        @foreach ($actions as $action)
                            <a href="{{ route($action['route']) }}"
                                class="group flex flex-col items-center justify-center p-4 border border-gray-100 rounded-xl hover:border-{{ $action['color'] }}-200 hover:shadow-lg transition-all duration-200">
                                <div
                                    class="p-3 rounded-lg bg-{{ $action['color'] }}-50 group-hover:bg-{{ $action['color'] }}-100 transition-colors mb-3">
                                    <svg class="w-6 h-6 text-{{ $action['color'] }}-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($action['icon'] == 'plus')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        @elseif($action['icon'] == 'file')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        @elseif($action['icon'] == 'user-plus')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        @endif
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-medium text-gray-700 group-hover:text-{{ $action['color'] }}-700">{{ $action['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-amber-100 rounded-lg">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Low Stock Alert</h2>
                                <p class="text-gray-600">{{ $lowStockProducts->count() ?? 0 }} products need attention</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 text-sm font-semibold rounded-full">
                            {{ $lowStockProducts->count() ?? 0 }}
                        </span>
                    </div>

                    @if (isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach ($lowStockProducts->take(4) as $product)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $product->product_name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $product->product_code }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $product->stock_quantity <= 0 ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $product->stock_quantity }} left
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($lowStockProducts->count() > 4)
                            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                                <a href="{{ route('inventory.products.index', ['low_stock' => true]) }}"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                                    View all {{ $lowStockProducts->count() }} items
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-gray-600">All products have sufficient stock</p>
                            <p class="text-sm text-gray-500 mt-1">Great job managing inventory!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Invoices -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Recent Invoices</h2>
                            <p class="text-gray-600">Latest invoice transactions</p>
                        </div>
                    </div>
                    <a href="{{ route('sales.invoices.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                @if (isset($recentInvoices) && $recentInvoices->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentInvoices as $invoice)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @php
                                            $statusColors = [
                                                'paid' => 'bg-green-100 text-green-800',
                                                'overdue' => 'bg-red-100 text-red-800',
                                                'pending' => 'bg-amber-100 text-amber-800',
                                                'draft' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $color = $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="inline-flex items-center justify-center w-12 h-12 rounded-lg {{ $color }}">
                                            <span
                                                class="text-xs font-semibold">#{{ substr($invoice->invoice_number, -4) }}</span>
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                            class="font-medium text-gray-900 hover:text-blue-600">{{ $invoice->invoice_number }}</a>
                                        <p class="text-sm text-gray-500">{{ $invoice->customer->customer_name ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $invoice->invoice_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-semibold text-gray-900">
                                        ৳{{ number_format($invoice->total_amount, 2) }}</div>
                                    <div
                                        class="text-xs {{ $invoice->status === 'overdue' ? 'text-red-600' : 'text-gray-500' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 mb-3">No recent invoices</p>
                        <a href="{{ route('sales.invoices.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700">
                            Create your first invoice
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recent Sales Orders -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                            <p class="text-gray-600">Latest sales orders</p>
                        </div>
                    </div>
                    <a href="{{ route('sales.sales-orders.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-700 inline-flex items-center gap-1">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                @if (isset($recentSalesOrders) && $recentSalesOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentSalesOrders as $order)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @php
                                            $statusColors = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'pending' => 'bg-amber-100 text-amber-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
                                                'processing' => 'bg-cyan-100 text-cyan-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="inline-flex items-center justify-center w-12 h-12 rounded-lg {{ $color }}">
                                            <span
                                                class="text-xs font-semibold">#{{ substr($order->order_number, -4) }}</span>
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                            class="font-medium text-gray-900 hover:text-blue-600">{{ $order->order_number }}</a>
                                        <p class="text-sm text-gray-500">{{ $order->customer->customer_name ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $order->order_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-semibold text-gray-900">
                                        ৳{{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($order->status) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 mb-3">No recent orders</p>
                        <a href="{{ route('sales.sales-orders.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700">
                            Create new order
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            @if (isset($monthlyRevenue))
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueChart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: @json(array_column($monthlyRevenue, 'month')),
                        datasets: [{
                            label: 'Revenue (BDT)',
                            data: @json(array_column($monthlyRevenue, 'revenue')),
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                titleColor: '#f8fafc',
                                bodyColor: '#f8fafc',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return `৳${context.parsed.y.toLocaleString()}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.5)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 12
                                    },
                                    callback: function(value) {
                                        return '৳' + (value / 1000).toFixed(0) + 'K';
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        elements: {
                            line: {
                                tension: 0.4
                            }
                        }
                    }
                });
            @endif

            // Card hover effects
            const cards = document.querySelectorAll('.bg-white.rounded-2xl');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow =
                        '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Status indicator
            const statusIndicator = document.querySelector('.w-2.h-2.bg-green-500');
            if (statusIndicator) {
                setInterval(() => {
                    statusIndicator.classList.toggle('opacity-75');
                }, 2000);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart with error handling
            const revenueCanvas = document.getElementById('revenueChart');

            @if (isset($monthlyRevenue) && count($monthlyRevenue) > 0)
                if (revenueCanvas && typeof Chart !== 'undefined') {
                    const revenueCtx = revenueCanvas.getContext('2d');
                    const revenueChart = new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: @json(array_column($monthlyRevenue, 'month')),
                            datasets: [{
                                label: 'Revenue (BDT)',
                                data: @json(array_column($monthlyRevenue, 'revenue')),
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#f8fafc',
                                    bodyColor: '#f8fafc',
                                    borderColor: 'rgba(59, 130, 246, 1)',
                                    borderWidth: 1,
                                    padding: 12,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(context) {
                                            return `৳${context.parsed.y.toLocaleString()}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: '#64748b',
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.5)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: '#64748b',
                                        font: {
                                            size: 12
                                        },
                                        callback: function(value) {
                                            return '৳' + (value / 1000).toFixed(0) + 'K';
                                        }
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            elements: {
                                line: {
                                    tension: 0.4
                                }
                            }
                        }
                    });
                } else if (revenueCanvas) {
                    console.error('Chart.js not loaded or revenueCanvas not found');
                    revenueCanvas.parentElement.innerHTML =
                        '<div class="text-center text-gray-500 py-20">Unable to load chart. Please check Chart.js library.</div>';
                }
            @else
                // Display message when no data is available
                if (revenueCanvas) {
                    revenueCanvas.parentElement.innerHTML =
                        '<div class="text-center text-gray-500 py-20">No revenue data available.</div>';
                }
            @endif

            // Card hover effects with better performance
            const cards = document.querySelectorAll('.bg-white.rounded-2xl');
            cards.forEach(card => {
                card.style.transition = 'all 0.3s ease';
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow =
                        '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Status indicator animation
            const statusIndicator = document.querySelector('.w-2.h-2.bg-green-500');
            if (statusIndicator) {
                setInterval(() => {
                    statusIndicator.classList.toggle('opacity-75');
                }, 2000);
            }
        });
    </script>
@endpush
