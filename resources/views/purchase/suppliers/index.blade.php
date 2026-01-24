@extends('layouts.admin')

@section('title', 'Suppliers - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-6">
                    <div>
                        <div class="flex items-center">
                            <div class="h-10 w-1.5 bg-blue-600 rounded-full mr-3"></div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Suppliers Management</h1>
                                <p class="text-sm text-gray-600 mt-1">Manage your suppliers and create purchase orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <a href="{{ route('purchases.create') }}"
                            class="inline-flex items-center px-4 py-3 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            New Purchase Order
                        </a>
                        <a href="{{ route('admin.companies.create') }}"
                            class="inline-flex items-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Add Supplier
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Suppliers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $suppliers->total() }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Active Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activePurchaseOrders ?? 0 }}</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ $pendingDeliveryCount ?? 0 }} pending delivery</span>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">This Month Purchase</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                ৳{{ number_format($monthlyPurchaseAmount ?? 0, 2) }}</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ $thisMonthOrders ?? 0 }} orders</span>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Avg Lead Time</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $averageLeadTime ?? 0 }} days</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ $topSuppliersCount ?? 0 }} top rated</span>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <form action="{{ route('admin.companies.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                            <div class="lg:col-span-8">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ $search }}"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Search suppliers by name, code, phone, email...">
                                </div>
                            </div>
                            <div class="lg:col-span-3">
                                <select name="status" onchange="this.form.submit()"
                                    class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Suppliers</option>
                                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only
                                    </option>
                                    <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only
                                    </option>
                                    <option value="with_orders" {{ $status == 'with_orders' ? 'selected' : '' }}>Has
                                        Orders</option>
                                </select>
                            </div>
                            <div class="lg:col-span-1">
                                <a href="{{ route('admin.companies.index') }}"
                                    class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Suppliers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Supplier List</h2>
                            <p class="text-sm text-gray-600">{{ $suppliers->total() }} suppliers found</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-500">
                                Showing {{ $suppliers->firstItem() ?? 0 }} to {{ $suppliers->lastItem() ?? 0 }} of
                                {{ $suppliers->total() }}
                            </div>
                        </div>
                    </div>
                </div>

                @if ($suppliers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Supplier Details
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact Info
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Purchase Activity
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($suppliers as $supplier)
                                    @php
                                        $supplierData = $supplier->supplierData ?? null;
                                        $lastOrder = $supplierData->lastOrder ?? null;
                                        $orderCount = $supplierData->orderCount ?? 0;
                                        $totalSpent = $supplierData->totalSpent ?? 0;
                                        $performance = $supplierData->performance ?? 'Good';
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Supplier Details -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-start">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $supplier->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">Code:
                                                                {{ $supplier->code ?? 'N/A' }}</div>
                                                        </div>
                                                        <div class="ml-2">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $performance == 'Excellent' ? 'bg-green-100 text-green-800' : ($performance == 'Good' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                                {{ $performance }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if ($supplier->address)
                                                        <div class="mt-2 text-xs text-gray-500">
                                                            <i
                                                                class="fas fa-map-marker-alt mr-1"></i>{{ Str::limit($supplier->address, 50) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Contact Info -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                @if ($supplier->phone)
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        {{ $supplier->phone }}
                                                    </div>
                                                @endif
                                                @if ($supplier->email)
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        {{ $supplier->email }}
                                                    </div>
                                                @endif
                                                @if ($supplier->contact_person)
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        {{ $supplier->contact_person }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Purchase Activity -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-3">
                                                <div>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="text-sm font-medium text-gray-700">Total Orders</span>
                                                        <span
                                                            class="text-sm font-bold text-blue-600">{{ $orderCount }}</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        <div class="bg-blue-600 h-1.5 rounded-full"
                                                            style="width: {{ min($orderCount * 10, 100) }}%"></div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="text-sm font-medium text-gray-700">Total Spent</span>
                                                        <span
                                                            class="text-sm font-bold text-green-600">৳{{ number_format($totalSpent, 2) }}</span>
                                                    </div>
                                                </div>

                                                @if ($lastOrder)
                                                    <div class="pt-2 border-t border-gray-100">
                                                        <div class="text-xs text-gray-500">
                                                            Last Order: {{ $lastOrder->order_date->format('M d, Y') }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            Amount: ৳{{ number_format($lastOrder->total_amount, 2) }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            <div class="space-y-2">
                                                @if ($supplier->is_active)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Inactive
                                                    </span>
                                                @endif

                                                @if ($orderCount > 0)
                                                    <div>
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Has Orders
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($supplier->is_preferred_vendor)
                                                    <div>
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                            Preferred
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col space-y-2">
                                                <!-- Quick Create Purchase Order -->
                                                <a href="{{ route('purchases.create', ['supplier_id' => $supplier->id]) }}"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                    New PO
                                                </a>

                                                <div class="flex items-center space-x-1">
                                                    <a href="{{ route('admin.companies.show', $supplier->id) }}"
                                                        class="inline-flex items-center p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                        title="View Details">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('admin.companies.edit', $supplier->id) }}"
                                                        class="inline-flex items-center p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                        title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('purchases.index', ['supplier_id' => $supplier->id]) }}"
                                                        class="inline-flex items-center p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200"
                                                        title="View Orders">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.companies.destroy', $supplier->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            onclick="return confirm('Are you sure you want to delete this supplier?')"
                                                            title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of
                                {{ $suppliers->total() }} suppliers
                            </div>
                            <div class="mt-2 sm:mt-0">
                                {{ $suppliers->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No suppliers found</h3>
                        <p class="text-gray-500 mb-6">Get started by adding your first supplier to the system.</p>
                        <a href="{{ route('admin.companies.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Your First Supplier
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit filter on status change
            const statusSelect = document.querySelector('select[name="status"]');
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }

            // Add animation to progress bars
            setTimeout(() => {
                document.querySelectorAll('[class*="bg-"]').forEach(bar => {
                    if (bar.style.width) {
                        const width = bar.style.width;
                        bar.style.width = '0';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    }
                });
            }, 500);

            // Quick purchase order creation
            const quickPOButtons = document.querySelectorAll('[href*="purchases/create"]');
            quickPOButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Optional: Add confirmation or pre-fill logic
                    console.log('Creating purchase order for supplier...');
                });
            });
        });
    </script>
@endpush
