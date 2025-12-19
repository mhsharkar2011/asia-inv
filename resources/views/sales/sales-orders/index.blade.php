@extends('layouts.app')

@section('title', 'Sales Orders')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center space-x-4">
                            <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Sales Orders</h1>
                                <p class="mt-2 text-lg text-gray-600">Manage customer sales orders and transactions</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('sales.sales-orders.create') }}"
                            class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Sales Order
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Summary -->
            @if ($salesOrders->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-100">Total Orders</p>
                                <p class="text-3xl font-bold mt-2">{{ $salesOrders->total() }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-400/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-100">Total Amount</p>
                                <p class="text-3xl font-bold mt-2">
                                    ৳{{ number_format($salesOrders->sum('total_amount'), 2) }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-green-400/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-cyan-100">Confirmed Orders</p>
                                <p class="text-3xl font-bold mt-2">{{ $salesOrders->where('status', 'confirmed')->count() }}
                                </p>
                            </div>
                            <div class="p-3 rounded-xl bg-cyan-400/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-amber-100">Draft Orders</p>
                                <p class="text-3xl font-bold mt-2">{{ $salesOrders->where('status', 'draft')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-400/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8">
                <div class="p-6">
                    <form action="{{ route('sales.sales-orders.index') }}" method="GET">
                        <div class="space-y-6">
                            <!-- Search and Quick Filters -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        placeholder="Search orders..." value="{{ request('search') }}">
                                </div>

                                <select name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="all">All Status</option>
                                    @foreach (['draft', 'pending', 'confirmed', 'processing', 'completed', 'cancelled'] as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="customer_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <option value="">All Customers</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit"
                                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter Orders
                                </button>
                            </div>

                            <!-- Date Range Filters -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" name="start_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" name="end_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="flex items-end">
                                    <a href="{{ route('sales.sales-orders.index') }}"
                                        class="w-full px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 text-center">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Reset Filters
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sales Orders List -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Sales Orders</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Showing {{ $salesOrders->firstItem() ?? 0 }}-{{ $salesOrders->lastItem() ?? 0 }} of
                                {{ $salesOrders->total() }} orders
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            @if ($salesOrders->count() > 0)
                                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                    <button @click="open = !open"
                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 font-semibold rounded-xl hover:from-blue-100 hover:to-blue-200 hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Export
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-48 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-2">
                                            <a href="{{ route('sales.sales-orders.export') }}?{{ http_build_query(request()->query()) }}"
                                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Export to Excel
                                            </a>
                                            <a href="#"
                                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-3 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                Export to PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="overflow-x-auto">
                    @forelse($salesOrders as $order)
                        <div
                            class="group px-6 py-5 border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Order Info -->
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- Status Indicator -->
                                        <div class="flex-shrink-0">
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-gray-100 text-gray-800',
                                                    'pending' => 'bg-amber-100 text-amber-800',
                                                    'confirmed' => 'bg-green-100 text-green-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-indigo-100 text-indigo-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $paymentColors = [
                                                    'pending' => 'bg-amber-100 text-amber-800',
                                                    'partial' => 'bg-cyan-100 text-cyan-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'overdue' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusClass =
                                                    $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                $paymentClass =
                                                    $paymentColors[$order->payment_status] ??
                                                    'bg-gray-100 text-gray-800';
                                            @endphp
                                            <div class="relative">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                                <span
                                                    class="absolute -top-2 -right-2 px-2 py-1 text-xs font-bold rounded-full {{ $statusClass }}">
                                                    {{ substr(ucfirst($order->status), 0, 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Order Details -->
                                        <div class="flex-1">
                                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                                <div>
                                                    <div class="flex items-center space-x-3 mb-2">
                                                        <h4
                                                            class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                            {{ $order->order_number }}
                                                        </h4>
                                                        @if ($order->reference_number)
                                                            <span
                                                                class="text-sm text-gray-500">({{ $order->reference_number }})</span>
                                                        @endif
                                                    </div>

                                                    <!-- Customer Info -->
                                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                                        @if ($order->customer)
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                                <a href="{{ route('sales.customers.show', $order->customer_id) }}"
                                                                    class="hover:text-blue-600 transition-colors duration-200">
                                                                    {{ $order->customer->customer_name }}
                                                                </a>
                                                            </div>
                                                        @else
                                                            <span class="text-red-500">Customer Deleted</span>
                                                        @endif

                                                        @if ($order->customer && $order->customer->company_name)
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                                </svg>
                                                                <span>{{ $order->customer->company_name }}</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Dates -->
                                                    <div class="flex flex-wrap gap-4 text-sm">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="font-medium">Order:</span>
                                                            <span
                                                                class="ml-1">{{ $order->order_date->format('d M, Y') }}</span>
                                                            <span
                                                                class="text-gray-500 ml-1">{{ $order->created_at->format('h:i A') }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="font-medium">Delivery:</span>
                                                            <span
                                                                class="ml-1">{{ $order->delivery_date->format('d M, Y') }}</span>
                                                        </div>
                                                        @if ($order->due_date)
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <span class="font-medium">Due:</span>
                                                                <span
                                                                    class="ml-1">{{ \Carbon\Carbon::parse($order->due_date)->format('d M, Y') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Amount and Status -->
                                                <div class="mt-4 md:mt-0 md:text-right">
                                                    <div class="text-2xl font-bold text-gray-900 mb-2">
                                                        ৳{{ number_format($order->total_amount, 2) }}
                                                    </div>
                                                    <div class="flex flex-wrap gap-2 justify-start md:justify-end">
                                                        <span
                                                            class="px-3 py-1 text-sm font-bold rounded-full {{ $statusClass }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                        <span
                                                            class="px-3 py-1 text-sm font-bold rounded-full {{ $paymentClass }}">
                                                            {{ ucfirst($order->payment_status) }}
                                                        </span>
                                                    </div>
                                                    @if ($order->confirmed_at)
                                                        <div class="text-xs text-gray-500 mt-2">
                                                            Confirmed:
                                                            {{ \Carbon\Carbon::parse($order->confirmed_at)->format('d M, Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-4 lg:mt-0 lg:ml-6">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                            class="p-2.5 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 hover:shadow transition-all duration-200"
                                            title="View Order">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        @if ($order->status == 'draft')
                                            <a href="{{ route('sales.sales-orders.edit', $order->id) }}"
                                                class="p-2.5 rounded-lg bg-gradient-to-r from-amber-50 to-amber-100 text-amber-600 hover:from-amber-100 hover:to-amber-200 hover:shadow transition-all duration-200"
                                                title="Edit Order">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('sales.sales-orders.destroy', $order->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2.5 rounded-lg bg-gradient-to-r from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 hover:shadow transition-all duration-200"
                                                    onclick="return confirm('Are you sure you want to delete this order?')"
                                                    title="Delete Order">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('sales.sales-orders.edit', $order->id) }}"
                                                class="p-2.5 rounded-lg bg-gradient-to-r from-cyan-50 to-cyan-100 text-cyan-600 hover:from-cyan-100 hover:to-cyan-200 hover:shadow transition-all duration-200"
                                                title="Edit Details">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($order->status == 'confirmed')
                                            <a href="{{ route('sales.invoices.create', ['order_id' => $order->id]) }}"
                                                class="p-2.5 rounded-lg bg-gradient-to-r from-green-50 to-green-100 text-green-600 hover:from-green-100 hover:to-green-200 hover:shadow transition-all duration-200"
                                                title="Create Invoice">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        @endif

                                        <a href="{{ route('sales.sales-orders.print', $order->id) }}" target="_blank"
                                            class="p-2.5 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 hover:from-gray-100 hover:to-gray-200 hover:shadow transition-all duration-200"
                                            title="Print Order">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>

                                        <!-- More Actions Dropdown -->
                                        <div class="relative inline-block text-left" x-data="{ open: false }"
                                            @click.away="open = false">
                                            <button @click="open = !open"
                                                class="p-2.5 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 hover:from-gray-100 hover:to-gray-200 hover:shadow transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>

                                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute right-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                <div class="py-2">
                                                    @if ($order->status != 'draft')
                                                        <form
                                                            action="{{ route('sales.sales-orders.change-status', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit"
                                                                onclick="return confirm('Are you sure you want to cancel this order?')"
                                                                class="w-full text-left flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                                Cancel Order
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <button type="button" onclick="duplicateOrder({{ $order->id }})"
                                                        class="w-full text-left flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                        Duplicate Order
                                                    </button>

                                                    <div class="border-t border-gray-100 my-1"></div>

                                                    <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                        class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                        View Full Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="inline-block p-6 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 mb-6">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Sales Orders Found</h3>
                            <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                                Start managing your sales orders by creating your first order.
                            </p>
                            <a href="{{ route('sales.sales-orders.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create First Sales Order
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($salesOrders->hasPages())
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                                Showing <span class="font-bold">{{ $salesOrders->firstItem() }}</span> to
                                <span class="font-bold">{{ $salesOrders->lastItem() }}</span> of
                                <span class="font-bold">{{ $salesOrders->total() }}</span> results
                            </div>
                            <div class="flex space-x-2">
                                {{ $salesOrders->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function duplicateOrder(orderId) {
            if (confirm('Are you sure you want to duplicate this order?')) {
                // Show loading
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = `
                <svg class="w-4 h-4 mr-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Duplicating...
            `;
                button.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    alert('Order duplication feature coming soon!');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 1000);
            }
        }

        // Quick status change confirmation
        document.addEventListener('DOMContentLoaded', function() {
            // Add any additional JavaScript functionality here
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom animations */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Smooth transitions */
        .transition-all {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card hover effects */
        .group:hover {
            transform: translateY(-2px);
        }

        .group {
            transition: transform 0.2s ease-out;
        }
    </style>
@endpush
