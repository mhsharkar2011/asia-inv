@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome back, {{ Auth::user()->name ?? 'User' }}!</p>
            </div>
            <div>
                <a href="{{ route('reports.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg shadow-sm hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Generate Reports
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Customers Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-blue-500 p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Total Customers</p>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalCustomers ?? 0 }}</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            Active
                        </span>
                    </div>
                    <div class="ml-4 p-3 bg-blue-50 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('sales.companies.index') }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        View all customers
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Total Products Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-green-500 p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Total Products</p>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalProducts ?? 0 }}</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            In Stock
                        </span>
                    </div>
                    <div class="ml-4 p-3 bg-green-50 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('inventory.products.index') }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        Manage products
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Total Invoices Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-cyan-500 p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Total Invoices</p>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalInvoices ?? 0 }}</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Revenue
                        </span>
                    </div>
                    <div class="ml-4 p-3 bg-cyan-50 rounded-full">
                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('sales.invoices.index') }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        View all invoices
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Pending Invoices Card -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-amber-500 p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Pending Invoices</p>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $pendingInvoices ?? 0 }}</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Awaiting Payment
                        </span>
                    </div>
                    <div class="ml-4 p-3 bg-amber-50 rounded-full">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('sales.invoices.index', ['status' => 'pending']) }}"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                        View pending
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Charts and Quick Actions Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Monthly Revenue
                    </h2>
                    <div class="relative">
                        <select
                            class="appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1.5 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option>This Year</option>
                            <option>Last Year</option>
                            <option>Custom Range</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column (Quick Actions & Low Stock) -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('sales.sales-orders.create') }}"
                                class="group p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all text-center">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 group-hover:text-blue-700">New Order</span>
                            </a>

                            <a href="{{ route('sales.invoices.create') }}"
                                class="group p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all text-center">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200 transition-colors">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 group-hover:text-green-700">New
                                    Invoice</span>
                            </a>

                            <a href="{{ route('sales.companies.create') }}"
                                class="group p-4 border border-gray-200 rounded-lg hover:border-cyan-300 hover:bg-cyan-50 transition-all text-center">
                                <div
                                    class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-cyan-200 transition-colors">
                                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 group-hover:text-cyan-700">Add
                                    Customer</span>
                            </a>

                            <a href="{{ route('inventory.products.create') }}"
                                class="group p-4 border border-gray-200 rounded-lg hover:border-amber-300 hover:bg-amber-50 transition-all text-center">
                                <div
                                    class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-amber-200 transition-colors">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900 group-hover:text-amber-700">Add
                                    Product</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            Low Stock Alert
                        </h2>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            {{ $lowStockProducts->count() ?? 0 }}
                        </span>
                    </div>
                    <div class="p-4">
                        @if (isset($lowStockProducts) && $lowStockProducts->count() > 0)
                            <div class="space-y-3">
                                @foreach ($lowStockProducts->take(4) as $product)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900 truncate">{{ $product->product_name }}
                                            </h4>
                                            <p class="text-sm text-gray-500 truncate">{{ $product->product_code }}</p>
                                        </div>
                                        <div class="ml-4 text-right">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock_quantity <= 0 ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $product->stock_quantity }} in stock
                                            </span>
                                            <div class="mt-1">
                                                <a href="{{ route('inventory.products.edit', $product->id) }}"
                                                    class="inline-flex items-center p-1 text-gray-400 hover:text-blue-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($lowStockProducts->count() > 4)
                                <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                                    <a href="{{ route('inventory.products.index', ['low_stock' => true]) }}"
                                        class="text-sm font-medium text-blue-600 hover:text-blue-800 inline-flex items-center">
                                        View all {{ $lowStockProducts->count() }} low stock items
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <p class="text-gray-500">All products have sufficient stock</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Invoices -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Recent Invoices
                    </h2>
                    <a href="{{ route('sales.invoices.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800 inline-flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="p-6">
                    @if (isset($recentInvoices) && $recentInvoices->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Invoice #</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer</th>
                                        <th
                                            class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($recentInvoices as $invoice)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                                        class="hover:text-blue-600">{{ $invoice->invoice_number }}</a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $invoice->invoice_date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">
                                                    {{ $invoice->customer->customer_name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $invoice->customer->email ?? '' }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-right font-semibold text-gray-900">
                                                ৳{{ number_format($invoice->total_amount, 2) }}
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'paid' => 'green',
                                                        'overdue' => 'red',
                                                        'pending' => 'amber',
                                                        'draft' => 'gray',
                                                    ];
                                                    $color = $statusColors[$invoice->status] ?? 'gray';
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-4">No recent invoices</p>
                            <a href="{{ route('sales.invoices.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Sales Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Recent Sales Orders
                    </h2>
                    <a href="{{ route('sales.sales-orders.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800 inline-flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="p-6">
                    @if (isset($recentSalesOrders) && $recentSalesOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order #</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer</th>
                                        <th
                                            class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($recentSalesOrders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">
                                                    <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                        class="hover:text-blue-600">{{ $order->order_number }}</a>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->order_date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">
                                                    {{ $order->customer->customer_name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $order->customer->company_name ?? '' }}</div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-right font-semibold text-gray-900">
                                                ৳{{ number_format($order->total_amount, 2) }}
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'gray',
                                                        'pending' => 'amber',
                                                        'confirmed' => 'blue',
                                                        'processing' => 'cyan',
                                                        'completed' => 'green',
                                                        'cancelled' => 'red',
                                                    ];
                                                    $color = $statusColors[$order->status] ?? 'gray';
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-4">No recent sales orders</p>
                            <a href="{{ route('sales.sales-orders.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create Order
                            </a>
                        </div>
                    @endif
                </div>
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
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
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
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return `Revenue: ৳${context.parsed.y.toLocaleString()}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6b7280'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [2, 2]
                                },
                                ticks: {
                                    color: '#6b7280',
                                    callback: function(value) {
                                        return '৳' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            @endif

            // Card hover effects
            const cards = document.querySelectorAll('.bg-white.rounded-xl.shadow-sm');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('shadow-md');
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.classList.remove('shadow-md');
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
