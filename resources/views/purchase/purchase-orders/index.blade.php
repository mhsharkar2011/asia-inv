@extends('layouts.admin')

@section('title', 'Purchase Orders Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <div class="p-3 rounded-2xl bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg mr-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                                Purchase Orders
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                Manage and track your purchase orders efficiently
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Import
                    </button>
                    <a href="{{ route('purchase.purchase-orders.export', request()->query()) }}"
                       class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                    </a>
                    <a href="{{ route('purchase.purchase-orders.create') }}"
                       class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create PO
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $purchaseOrders->total() }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                        <span>{{ $stats['pending'] ?? 0 }} pending</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? $pendingCount ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-yellow-50 to-yellow-100">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['completed'] ?? $completedCount ?? 0 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-50 to-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Value</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">${{ number_format($stats['total_value'] ?? $totalValue ?? 0, 2) }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('purchase.purchase-orders.create') }}"
                               class="group flex items-center justify-between p-4 rounded-xl border border-indigo-200 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-indigo-100 transition-all duration-200 hover:scale-[1.02]">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 mr-3 group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-700">New Purchase Order</span>
                                </div>
                                <svg class="w-5 h-5 text-indigo-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Filter by Status</h3>
                        <div class="space-y-2">
                            @php
                                $statusOptions = [
                                    ['value' => '', 'label' => 'All Orders', 'color' => 'gray', 'count' => $purchaseOrders->total()],
                                    ['value' => 'draft', 'label' => 'Draft', 'color' => 'gray', 'count' => $stats['draft'] ?? 0],
                                    ['value' => 'pending', 'label' => 'Pending', 'color' => 'yellow', 'count' => $stats['pending'] ?? 0],
                                    ['value' => 'partial', 'label' => 'Partial', 'color' => 'blue', 'count' => $stats['partial'] ?? 0],
                                    ['value' => 'completed', 'label' => 'Completed', 'color' => 'green', 'count' => $stats['completed'] ?? 0],
                                    ['value' => 'cancelled', 'label' => 'Cancelled', 'color' => 'red', 'count' => $stats['cancelled'] ?? 0],
                                ];
                            @endphp
                            @foreach($statusOptions as $option)
                                <a href="{{ request()->fullUrlWithQuery(['status' => $option['value']]) }}"
                                   class="flex items-center justify-between px-4 py-3 rounded-xl
                                          {{ request('status') == $option['value'] ?
                                             'bg-gradient-to-r from-' . $option['color'] . '-50 to-' . $option['color'] . '-100 border border-' . $option['color'] . '-200 text-' . $option['color'] . '-700' :
                                             'bg-gray-50 hover:bg-gray-100 text-gray-700' }}
                                          transition-all duration-200 hover:scale-[1.02]">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-{{ $option['color'] }}-500 mr-3"></span>
                                        <span>{{ $option['label'] }}</span>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-{{ $option['color'] }}-500 text-white">
                                        {{ $option['count'] }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Date Range</h3>
                        <form method="GET" action="{{ route('purchase.purchase-orders.index') }}" class="space-y-4">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="start_date"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                       value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="end_date"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                       value="{{ request('end_date') }}">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                                    Apply
                                </button>
                                @if(request()->has('start_date') || request()->has('end_date'))
                                    <a href="{{ route('purchase.purchase-orders.index', array_merge(request()->except(['start_date', 'end_date']), ['per_page' => request('per_page', 10)])) }}"
                                       class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:w-3/4">
                <!-- Search Bar -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-6">
                    <form method="GET" action="{{ route('purchase.purchase-orders.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex-grow">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search"
                                       class="pl-12 w-full px-5 py-3 border-0 bg-gray-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200"
                                       placeholder="Search by PO number, supplier, or description..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <select name="per_page" class="px-4 py-3 border-0 bg-gray-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                            </select>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Search
                            </button>
                            @if (request()->hasAny(['search', 'status', 'start_date', 'end_date']))
                                <a href="{{ route('purchase.purchase-orders.index') }}"
                                   class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Purchase Orders Grid -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-auto">
                    <!-- Table Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" id="selectAll"
                                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200">
                                <h3 class="text-lg font-bold text-gray-900">
                                    Purchase Orders ({{ $purchaseOrders->total() }})
                                </h3>
                            </div>
                            <div class="text-sm text-gray-500">
                                Showing {{ $purchaseOrders->firstItem() ?? 0 }}-{{ $purchaseOrders->lastItem() ?? 0 }} of {{ $purchaseOrders->total() }}
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Orders List -->
                    <div class="divide-y divide-gray-100">
                        @forelse($purchaseOrders as $po)
                            <div class="group p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                                <div class="flex items-start space-x-4">
                                    <!-- Checkbox -->
                                    <div class="pt-1">
                                        <input type="checkbox"
                                               class="po-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                               value="{{ $po->id }}">
                                    </div>

                                    <!-- PO Info -->
                                    <div class="flex-grow">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                            {{ $po->po_number }}
                                                        </h4>
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            {{ $po->company->name ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2 md:mt-0">
                                                @php
                                                    $statusColors = [
                                                        'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'bi-file-earmark'],
                                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'bi-clock'],
                                                        'partial' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'bi-hourglass-split'],
                                                        'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'bi-check-circle'],
                                                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'bi-x-circle'],
                                                    ];
                                                    $statusConfig = $statusColors[$po->status] ?? $statusColors['draft'];
                                                @endphp
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                                    {{ ucfirst($po->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                            <!-- Supplier Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Supplier</h5>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <span>{{ $po->supplier->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <!-- Warehouse Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Warehouse</h5>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    <span>{{ $po->warehouse->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <!-- Dates Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Dates</h5>
                                                <div class="space-y-1">
                                                    <div class="text-sm text-gray-600">
                                                        Order: {{ $po->order_date->format('M d, Y') }}
                                                    </div>
                                                    @if($po->expected_delivery_date)
                                                        <div class="text-sm {{ $po->expected_delivery_date < now() && !in_array($po->status, ['completed', 'cancelled']) ? 'text-red-600' : 'text-gray-600' }}">
                                                            Delivery: {{ $po->expected_delivery_date->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Financial Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Amount</h5>
                                                <div class="space-y-1">
                                                    <div class="text-lg font-bold text-gray-900">
                                                        ${{ number_format($po->final_amount, 2) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Tax: ${{ number_format($po->tax_amount, 2) }} |
                                                        Disc: ${{ number_format($po->discount, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex-shrink-0">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('purchase.purchase-orders.show', $po) }}"
                                               class="p-2 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 hover:shadow transition-all duration-200"
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('purchase.purchase-orders.edit', $po) }}"
                                               class="p-2 rounded-lg bg-gradient-to-r from-amber-50 to-amber-100 text-amber-600 hover:from-amber-100 hover:to-amber-200 hover:shadow transition-all duration-200"
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <div class="relative">
                                                <button type="button"
                                                        class="p-2 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 hover:from-gray-100 hover:to-gray-200 hover:shadow transition-all duration-200"
                                                        id="menu-button-{{ $po->id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>
                                                <div class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                                     id="menu-{{ $po->id }}">
                                                    <div class="py-2">
                                                        <a href="{{ route('purchase.purchase-orders.show', $po) }}"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            View Details
                                                        </a>
                                                        <a href="{{ route('purchase.purchase-orders.edit', $po) }}"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit Purchase Order
                                                        </a>
                                                        <a href="#"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                            </svg>
                                                            Print PO
                                                        </a>
                                                        <a href="#"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            Send to Supplier
                                                        </a>
                                                        <div class="border-t border-gray-100 my-1"></div>
                                                        @if($po->status == 'draft')
                                                            <a href="#"
                                                               class="flex items-center px-4 py-3 text-sm text-green-700 hover:bg-green-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Mark as Pending
                                                            </a>
                                                        @endif
                                                        @if($po->status == 'pending' || $po->status == 'partial')
                                                            <a href="#"
                                                               class="flex items-center px-4 py-3 text-sm text-green-700 hover:bg-green-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Mark as Completed
                                                            </a>
                                                        @endif
                                                        @if($po->status != 'cancelled')
                                                            <a href="#"
                                                               class="flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Cancel Order
                                                            </a>
                                                        @endif
                                                        <div class="border-t border-gray-100 my-1"></div>
                                                        <form action="{{ route('purchase.purchase-orders.destroy', $po) }}" method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this purchase order?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="w-full flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Delete Purchase Order
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="inline-block p-6 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 mb-6">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">No purchase orders found</h3>
                                <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                                    Start by creating your first purchase order to manage your procurement process.
                                </p>
                                <a href="{{ route('purchase.purchase-orders.create') }}"
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Your First Purchase Order
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($purchaseOrders->hasPages())
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                                    Showing <span class="font-bold">{{ $purchaseOrders->firstItem() }}</span> to
                                    <span class="font-bold">{{ $purchaseOrders->lastItem() }}</span> of
                                    <span class="font-bold">{{ $purchaseOrders->total() }}</span> results
                                </div>
                                <div class="flex space-x-2">
                                    {{ $purchaseOrders->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bulk Actions -->
                <div id="bulkActions" class="hidden mt-6">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl shadow-xl border border-blue-200">
                        <div class="px-6 py-4">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="mb-4 sm:mb-0">
                                    <span class="font-bold text-blue-800" id="selectedCount">0 selected</span>
                                    <p class="text-sm text-blue-600 mt-1">Perform actions on selected purchase orders</p>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <div class="relative">
                                        <button type="button"
                                                class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Update Status
                                        </button>
                                        <div class="hidden absolute top-full left-0 mt-2 w-48 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                             id="statusMenu">
                                            <div class="py-2">
                                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                    Pending
                                                </a>
                                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                    Completed
                                                </a>
                                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                    Cancelled
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="bulkPrint"
                                            class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-purple-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        Print Selected
                                    </button>
                                    <button type="button" id="bulkDelete"
                                            class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Selected
                                    </button>
                                    <button type="button" id="clearSelection"
                                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                        Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-xl p-6">
                <h5 class="modal-title text-xl font-bold">Import Purchase Orders</h5>
                <button type="button" class="btn-close text-white opacity-80 hover:opacity-100" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-6">
                <form action="{{ route('purchase.purchase-orders.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="space-y-6">
                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Upload File</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-blue-500 transition-colors duration-200">
                                <div class="space-y-3 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file" type="file" class="sr-only" accept=".csv,.xlsx,.xls">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">CSV, XLSX up to 10MB</p>
                                    <div id="file-name" class="text-sm font-medium text-gray-900 hidden"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Import Options -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Default Status</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            name="status">
                                        <option value="draft">Draft</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Import Mode</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            name="import_mode">
                                        <option value="create">Create New Only</option>
                                        <option value="update">Update Existing</option>
                                        <option value="both">Create & Update</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Template Info -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-5">
                                <div class="flex">
                                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-bold text-blue-800">Need help with formatting?</p>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Download our
                                            <a href="{{ asset('templates/purchase-order-template.csv') }}"
                                               class="font-bold underline hover:text-blue-900 transition-colors duration-200">
                                                template file
                                            </a>
                                            to ensure your data is formatted correctly.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="button"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                                        data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import Purchase Orders
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File upload preview
        const fileInput = document.getElementById('file-upload');
        const fileName = document.getElementById('file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    fileName.classList.remove('hidden');
                } else {
                    fileName.classList.add('hidden');
                }
            });
        }

        // Drag and drop file upload
        const dropArea = fileInput?.closest('.border-dashed');
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight(e) {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                if (files.length > 0) {
                    fileName.textContent = files[0].name;
                    fileName.classList.remove('hidden');
                }
            }
        }

        // Search functionality
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }

        // Per page select
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }

        // Dropdown menus
        document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
            const menuId = button.id.replace('menu-button-', 'menu-');
            const menu = document.getElementById(menuId);

            button.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('[id^="menu-"]').forEach(m => {
                    if (m.id !== menuId) m.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        // Bulk selection
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.po-checkbox');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAll && checkboxes.length > 0) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    checkbox.closest('.group')?.classList.toggle('bg-blue-50', this.checked);
                });
                updateBulkActions();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    this.closest('.group')?.classList.toggle('bg-blue-50', this.checked);
                    updateBulkActions();
                });
            });

            function updateBulkActions() {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                const count = selected.length;

                if (count > 0) {
                    bulkActions.classList.remove('hidden');
                    selectedCount.textContent = `${count} purchase order${count > 1 ? 's' : ''} selected`;
                    selectAll.indeterminate = count > 0 && count < checkboxes.length;
                    selectAll.checked = count === checkboxes.length;
                } else {
                    bulkActions.classList.add('hidden');
                    selectAll.indeterminate = false;
                    selectAll.checked = false;
                }
            }

            // Bulk actions
            const bulkPrintBtn = document.getElementById('bulkPrint');
            const bulkDeleteBtn = document.getElementById('bulkDelete');
            const clearSelectionBtn = document.getElementById('clearSelection');

            if (bulkPrintBtn) {
                bulkPrintBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0) {
                        console.log('Printing:', ids);
                        // Implement bulk print functionality
                    }
                });
            }

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Delete ${ids.length} selected purchase order${ids.length > 1 ? 's' : ''}? This action cannot be undone.`)) {
                        bulkAction('/purchase/purchase-orders/bulk-delete', ids);
                    }
                });
            }

            if (clearSelectionBtn) {
                clearSelectionBtn.addEventListener('click', () => {
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                        cb.closest('.group')?.classList.remove('bg-blue-50');
                    });
                    updateBulkActions();
                });
            }

            function getSelectedIds() {
                return Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
            }

            function bulkAction(url, ids) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error performing bulk action');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error performing bulk action');
                });
            }
        }

        // Status update dropdown
        const statusUpdateBtn = document.querySelector('[id^="statusMenu"]')?.previousElementSibling;
        const statusMenu = document.getElementById('statusMenu');

        if (statusUpdateBtn && statusMenu) {
            statusUpdateBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                statusMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                statusMenu.classList.add('hidden');
            });
        }

        // Auto-refresh for pending orders
        @if(($pendingCount ?? 0) > 0)
            setTimeout(() => {
                location.reload();
            }, 30000); // Refresh every 30 seconds if there are pending orders
        @endif
    });
</script>
@endpush

@push('styles')
<style>
    .group:hover .group-hover\:bg-blue-50 {
        background-color: rgba(239, 246, 255, 1);
    }

    input[type="checkbox"]:indeterminate {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 16'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 8h8'/%3e%3c/svg%3e");
        background-color: #2563eb;
        border-color: #2563eb;
    }

    /* Smooth transitions */
    .transition-all {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Status badge styles */
    .bg-yellow-100 { background-color: #fef9c3; }
    .text-yellow-800 { color: #92400e; }
    .bg-blue-100 { background-color: #dbeafe; }
    .text-blue-800 { color: #1e40af; }
    .bg-green-100 { background-color: #dcfce7; }
    .text-green-800 { color: #166534; }
    .bg-red-100 { background-color: #fee2e2; }
    .text-red-800 { color: #991b1b; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .text-gray-800 { color: #1f2937; }
</style>
@endpush
