@extends('layouts.admin')

@section('title', 'Warehouse Management')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Warehouse Management</h1>
                                <p class="text-sm text-gray-600 mt-1">Manage your inventory storage locations efficiently
                                </p>
                            </div>
                        </div>
                        <div>
                            <button onclick="openCreateModal()"
                                class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Warehouse
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Warehouses -->
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-200 p-6 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Warehouses</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalWarehouses }}</p>
                        </div>
                        <div
                            class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Warehouses -->
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-200 p-6 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Active Warehouses</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeWarehouses }}</p>
                            <div class="mt-3 flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-400 to-green-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $activePercentage }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-3">{{ $activePercentage }}%</span>
                            </div>
                        </div>
                        <div
                            class="h-14 w-14 rounded-xl bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Capacity -->
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-amber-200 p-6 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Capacity</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalCapacity) }} sqft</p>
                            <div class="mt-3 flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-2 rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $capacityUtilization }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-3">{{ $capacityUtilization }}%</span>
                            </div>
                        </div>
                        <div
                            class="h-14 w-14 rounded-xl bg-gradient-to-br from-amber-100 to-amber-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Staff Count -->
                <div
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-200 p-6 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Staff Count</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStaff }}</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">Avg: {{ $avgStaffPerWarehouse }} per warehouse</span>
                            </div>
                        </div>
                        <div
                            class="h-14 w-14 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-4.201V21M4.5 10.201V21" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <button onclick="openCreateModal()"
                                class="group flex items-center justify-center p-5 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 text-blue-700 rounded-xl border border-blue-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-6 h-6 mr-3 group-hover:rotate-90 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <div class="text-left">
                                    <div class="font-semibold">Add New Warehouse</div>
                                    <div class="text-sm text-blue-600">Create a new storage location</div>
                                </div>
                            </button>
                            <button onclick="exportToExcel()"
                                class="group flex items-center justify-center p-5 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 text-green-700 rounded-xl border border-green-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="text-left">
                                    <div class="font-semibold">Export to Excel</div>
                                    <div class="text-sm text-green-600">Download warehouse data</div>
                                </div>
                            </button>
                            <button onclick="printWarehouseList()"
                                class="group flex items-center justify-center p-5 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 text-purple-700 rounded-xl border border-purple-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                <div class="text-left">
                                    <div class="font-semibold">Print List</div>
                                    <div class="text-sm text-purple-600">Generate printable report</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warehouse List -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                    <!-- Table Header -->
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Warehouse List</h2>
                                <p class="text-sm text-gray-600 mt-1">{{ $warehouses->total() }} warehouses found</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Search -->
                                <div class="relative flex-1 sm:w-64">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="searchWarehouses" placeholder="Search warehouses..."
                                        class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full bg-white shadow-sm">
                                </div>

                                <!-- Filter -->
                                <div class="relative">
                                    <button id="filterDropdownButton"
                                        class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 bg-white shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Filter
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div id="filterDropdown"
                                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-10">
                                        <div class="py-2">
                                            <a href="#" data-filter="all"
                                                class="filter-option flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 6h16M4 12h16M4 18h16" />
                                                </svg>
                                                All Warehouses
                                            </a>
                                            <a href="#" data-filter="1"
                                                class="filter-option flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-green-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Active Only
                                            </a>
                                            <a href="#" data-filter="0"
                                                class="filter-option flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Inactive Only
                                            </a>
                                            <div class="border-t border-gray-200 my-1"></div>
                                            <a href="#" data-filter="high-capacity"
                                                class="filter-option flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-amber-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                </svg>
                                                High Capacity
                                            </a>
                                            <a href="#" data-filter="low-capacity"
                                                class="filter-option flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Low Capacity
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Warehouse
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden md:table-cell">
                                        Address
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Capacity
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden sm:table-cell">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden lg:table-cell">
                                        Staff
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($warehouses as $warehouse)
                                    <tr class="warehouse-row hover:bg-blue-50/50 transition-colors duration-200"
                                        data-status="{{ $warehouse->status ? '1' : '0' }}"
                                        data-capacity="{{ $warehouse->capacity > 5000 ? 'high-capacity' : 'low-capacity' }}"
                                        data-warehouse-id="{{ $warehouse->id }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-11 w-11 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900 warehouse-name">
                                                        {{ $warehouse->name }}</div>
                                                    <div class="text-sm text-gray-500 warehouse-code">Code:
                                                        {{ $warehouse->code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <div class="max-w-xs">
                                                    <div class="text-sm text-gray-900 truncate warehouse-address">
                                                        {{ $warehouse->address ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-gray-900 warehouse-capacity">
                                                {{ number_format($warehouse->capacity) }} sqft</div>
                                            <div class="mt-1">
                                                @php
                                                    $utilization = 0;
                                                    if ($warehouse->capacity > 0 && $warehouse->current_occupancy) {
                                                        $utilization = min(
                                                            ($warehouse->current_occupancy / $warehouse->capacity) *
                                                                100,
                                                            100,
                                                        );
                                                    }
                                                    $color =
                                                        $utilization > 80
                                                            ? 'red'
                                                            : ($utilization > 60
                                                                ? 'yellow'
                                                                : 'green');
                                                @endphp
                                                <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-gradient-to-r from-{{ $color }}-400 to-{{ $color }}-500 h-1.5 rounded-full transition-all duration-1000 ease-out"
                                                        style="width: {{ $utilization }}%"></div>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 warehouse-utilization">
                                                    {{ number_format($utilization, 1) }}% utilized</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            @if ($warehouse->status)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200 warehouse-status">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200 warehouse-status">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            <div class="flex items-center">
                                                <div class="flex -space-x-2 overflow-hidden">
                                                    @for ($i = 0; $i < min(3, $warehouse->staff_count); $i++)
                                                        <div
                                                            class="inline-block h-8 w-8 rounded-full bg-gradient-to-br from-gray-200 to-gray-100 border-2 border-white flex items-center justify-center shadow-sm">
                                                            <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                        </div>
                                                    @endfor
                                                    @if ($warehouse->staff_count > 3)
                                                        <div
                                                            class="inline-block h-8 w-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-300 border-2 border-white flex items-center justify-center shadow-sm">
                                                            <span
                                                                class="text-xs font-semibold text-white">+{{ $warehouse->staff_count - 3 }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm text-gray-600 ml-3 warehouse-staff">{{ $warehouse->staff_count }}
                                                    staff</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-1">
                                                <button onclick="viewWarehouse({{ $warehouse->id }})"
                                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                    title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>
                                                <button onclick="editWarehouse({{ $warehouse->id }})"
                                                    class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <div class="relative">
                                                    <button id="actionMenuButton{{ $warehouse->id }}"
                                                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                                        title="More Actions">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                        </svg>
                                                    </button>
                                                    <div id="actionMenu{{ $warehouse->id }}"
                                                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-10">
                                                        <div class="py-2">
                                                            @if ($warehouse->status)
                                                                <a href="#"
                                                                    onclick="toggleStatus({{ $warehouse->id }})"
                                                                    class="flex items-center px-4 py-2.5 text-sm text-yellow-700 hover:bg-yellow-50 transition-colors">
                                                                    <svg class="w-4 h-4 mr-2" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                    </svg>
                                                                    Deactivate
                                                                </a>
                                                            @else
                                                                <a href="#"
                                                                    onclick="toggleStatus({{ $warehouse->id }})"
                                                                    class="flex items-center px-4 py-2.5 text-sm text-green-700 hover:bg-green-50 transition-colors">
                                                                    <svg class="w-4 h-4 mr-2" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    Activate
                                                                </a>
                                                            @endif
                                                            <a href="#"
                                                                onclick="deleteWarehouse({{ $warehouse->id }})"
                                                                class="flex items-center px-4 py-2.5 text-sm text-red-700 hover:bg-red-50 transition-colors">
                                                                <svg class="w-4 h-4 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="text-gray-500">
                                                <svg class="mx-auto h-16 w-16 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <h3 class="mt-4 text-lg font-semibold text-gray-900">No warehouses found
                                                </h3>
                                                <p class="mt-2 text-gray-500">Create your first warehouse to get started
                                                </p>
                                                <div class="mt-6">
                                                    <button onclick="openCreateModal()"
                                                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        Add Warehouse
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($warehouses->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                                    Showing {{ $warehouses->firstItem() }} to {{ $warehouses->lastItem() }} of
                                    {{ $warehouses->total() }} warehouses
                                </div>
                                <div>
                                    {{ $warehouses->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Create Warehouse Modal -->
        <div id="createWarehouseModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0"
                id="modalContent">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-gradient-to-r from-blue-100 to-blue-50">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Create New Warehouse</h3>
                        </div>
                        <button onclick="closeModal('createWarehouseModal')"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form id="createWarehouseForm" action="{{ route('admin.warehouses.store') }}" method="POST"
                    class="p-6">
                    @csrf
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Warehouse Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Warehouse Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Capacity (sqft)</label>
                                <input type="number" name="capacity" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Staff Count</label>
                                <input type="number" name="staff_count"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Occupancy
                                    (sqft)</label>
                                <input type="number" name="current_occupancy" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Manager</label>
                                <select name="manager_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                                    <option value="">Select Manager</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Active Status <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="1" checked
                                        class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-colors duration-200">
                                    <span class="ml-2.5 text-sm font-medium text-gray-700">Active</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="0"
                                        class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-colors duration-200">
                                    <span class="ml-2.5 text-sm font-medium text-gray-700">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('createWarehouseModal')"
                            class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-xl text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md hover:shadow-lg">
                            Create Warehouse
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Warehouse Modal -->
        <div id="viewWarehouseModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0"
                id="viewModalContent">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-gradient-to-r from-blue-100 to-blue-50">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900" id="viewWarehouseName">Warehouse Details</h3>
                                <p class="text-sm text-gray-500" id="viewWarehouseCode"></p>
                            </div>
                        </div>
                        <button onclick="closeModal('viewWarehouseModal')"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Warehouse Information -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Basic Info -->
                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200 p-5">
                                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Basic
                                    Information</h4>
                                <div class="space-y-4">
                                    <div class="flex items-start">
                                        <div class="w-32 text-sm font-medium text-gray-500">Name</div>
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold text-gray-900" id="viewName"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-32 text-sm font-medium text-gray-500">Code</div>
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold text-gray-900" id="viewCode"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-32 text-sm font-medium text-gray-500">Address</div>
                                        <div class="flex-1">
                                            <div class="text-sm text-gray-900" id="viewAddress"></div>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="w-32 text-sm font-medium text-gray-500">Manager</div>
                                        <div class="flex-1">
                                            <div class="text-sm text-gray-900" id="viewManager"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl border border-blue-200 p-5">
                                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Capacity
                                    </h4>
                                    <div class="space-y-3">
                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">Total Capacity</span>
                                                <span class="text-sm font-semibold text-gray-900"
                                                    id="viewCapacity"></span>
                                            </div>
                                            <div class="w-full bg-blue-100 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-2 rounded-full"
                                                    id="viewCapacityBar"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">Current Occupancy</span>
                                                <span class="text-sm font-semibold text-gray-900"
                                                    id="viewOccupancy"></span>
                                            </div>
                                            <div class="w-full bg-amber-100 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-2 rounded-full"
                                                    id="viewOccupancyBar"></div>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500" id="viewUtilization"></div>
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-green-50 to-green-100/50 rounded-xl border border-green-200 p-5">
                                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Status &
                                        Staff</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-700 mb-1">Status</div>
                                            <div id="viewStatus"></div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-700 mb-1">Staff Count</div>
                                            <div class="flex items-center">
                                                <div class="flex -space-x-2 mr-3">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-200 to-gray-100 border-2 border-white flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900"
                                                    id="viewStaffCount"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200 p-5">
                                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Additional
                                    Notes</h4>
                                <div class="text-sm text-gray-700" id="viewNotes"></div>
                            </div>
                        </div>

                        <!-- Quick Stats & Actions -->
                        <div class="space-y-6">
                            <!-- Quick Stats -->
                            <div
                                class="bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-xl border border-purple-200 p-5">
                                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Quick Stats
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Created
                                        </div>
                                        <div class="text-sm font-semibold text-gray-900" id="viewCreatedAt"></div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Last
                                            Updated</div>
                                        <div class="text-sm font-semibold text-gray-900" id="viewUpdatedAt"></div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">Warehouse
                                            ID</div>
                                        <div class="text-sm font-semibold text-gray-900" id="viewWarehouseId"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-200 p-5">
                                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Quick Actions
                                </h4>
                                <div class="space-y-3">
                                    <button onclick="editCurrentWarehouse()"
                                        class="w-full flex items-center justify-center p-3 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 text-green-700 rounded-lg border border-green-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Warehouse
                                    </button>
                                    <button onclick="toggleCurrentStatus()"
                                        class="w-full flex items-center justify-center p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 hover:from-yellow-100 hover:to-yellow-200 text-yellow-700 rounded-lg border border-yellow-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Toggle Status
                                    </button>
                                    <button onclick="deleteCurrentWarehouse()"
                                        class="w-full flex items-center justify-center p-3 bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 text-red-700 rounded-lg border border-red-200 transition-all duration-300 transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Warehouse
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Warehouse Modal -->
        <div id="editWarehouseModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0"
                id="editModalContent">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg bg-gradient-to-r from-green-100 to-green-50">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Edit Warehouse</h3>
                        </div>
                        <button onclick="closeModal('editWarehouseModal')"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form id="editWarehouseForm" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Warehouse Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="editName" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Warehouse Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="code" id="editCode" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address" id="editAddress" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Capacity (sqft)</label>
                                <input type="number" name="capacity" id="editCapacity" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Staff Count</label>
                                <input type="number" name="staff_count" id="editStaffCount"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Occupancy
                                    (sqft)</label>
                                <input type="number" name="current_occupancy" id="editCurrentOccupancy" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Manager</label>
                                <select name="manager_id" id="editManagerId"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200">
                                    <option value="">Select Manager</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" id="editNotes" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm transition-colors duration-200"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Active Status <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" id="editStatusActive" value="1"
                                        class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-colors duration-200">
                                    <span class="ml-2.5 text-sm font-medium text-gray-700">Active</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="status" id="editStatusInactive" value="0"
                                        class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-colors duration-200">
                                    <span class="ml-2.5 text-sm font-medium text-gray-700">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('editWarehouseModal')"
                            class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-xl text-sm font-medium text-white hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-md hover:shadow-lg">
                            Update Warehouse
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmationModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0"
                id="deleteModalContent">
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center">
                        <div
                            class="flex-shrink-0 h-12 w-12 rounded-xl bg-gradient-to-br from-red-100 to-red-50 flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Confirm Delete</h3>
                            <p class="text-sm text-gray-500">This action cannot be undone</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 mb-4">Are you sure you want to delete this warehouse? This action cannot be
                        undone.</p>
                    <div class="bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-amber-700">All inventory and associated data will be permanently
                                removed.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteConfirmationModal')"
                        class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Cancel
                    </button>
                    <form id="deleteWarehouseForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-xl text-sm font-medium text-white hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-md hover:shadow-lg">
                            Delete Warehouse
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global variable to store current warehouse ID
        let currentWarehouseId = null;

        // Enhanced Modal functions
        function openCreateModal() {
            const modal = document.getElementById('createWarehouseModal');
            const content = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('.scale-95, .scale-100');
            if (content) {
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            } else {
                modal.classList.add('hidden');
            }
        }

        // View warehouse modal - Simplified version without API calls
        async function viewWarehouse(id) {
            currentWarehouseId = id;

            // Show loading state
            const modal = document.getElementById('viewWarehouseModal');
            const content = document.getElementById('viewModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            await loadWarehouseFromTable(id);
        }

        // Function to load warehouse data from table row
        async function loadWarehouseFromTable(id) {
            const row = document.querySelector(`[data-warehouse-id="${id}"]`);
            if (!row) {
                alert('Warehouse data not found. Please refresh the page and try again.');
                closeModal('viewWarehouseModal');
                return;
            }

            // Extract data from table row
            const warehouse = {
                id: id,
                name: row.querySelector('.warehouse-name')?.textContent || '',
                code: row.querySelector('.warehouse-code')?.textContent.replace('Code: ', '') || '',
                address: row.querySelector('.warehouse-address')?.textContent || 'N/A',
                capacity: parseInt(row.querySelector('.warehouse-capacity')?.textContent.replace(' sqft', '')
                    .replace(/,/g, '') || 0),
                staff_count: parseInt(row.querySelector('.warehouse-staff')?.textContent.replace(' staff', '') ||
                    0),
                status: row.querySelector('.warehouse-status')?.textContent === 'Active',
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString(),
                notes: 'No additional notes available',
                manager: {
                    name: 'Not Assigned'
                },
                current_occupancy: 0 // Default value
            };

            // Try to get occupancy from utilization percentage
            const utilizationText = row.querySelector('.warehouse-utilization')?.textContent;
            if (utilizationText) {
                const utilization = parseFloat(utilizationText.replace('% utilized', ''));
                if (!isNaN(utilization) && warehouse.capacity > 0) {
                    warehouse.current_occupancy = (warehouse.capacity * utilization) / 100;
                }
            }

            populateViewModal(warehouse);
        }

        // Function to populate view modal with data
        function populateViewModal(warehouse) {
            document.getElementById('viewWarehouseName').textContent = warehouse.name;
            document.getElementById('viewWarehouseCode').textContent = `Code: ${warehouse.code}`;
            document.getElementById('viewName').textContent = warehouse.name;
            document.getElementById('viewCode').textContent = warehouse.code;
            document.getElementById('viewAddress').textContent = warehouse.address;
            document.getElementById('viewManager').textContent = warehouse.manager ? warehouse.manager.name :
                'Not Assigned';
            document.getElementById('viewCapacity').textContent = `${parseInt(warehouse.capacity).toLocaleString()} sqft`;
            document.getElementById('viewOccupancy').textContent =
                `${parseInt(warehouse.current_occupancy || 0).toLocaleString()} sqft`;
            document.getElementById('viewStaffCount').textContent = `${warehouse.staff_count} staff`;
            document.getElementById('viewNotes').textContent = warehouse.notes || 'No notes available';
            document.getElementById('viewCreatedAt').textContent = new Date(warehouse.created_at).toLocaleDateString();
            document.getElementById('viewUpdatedAt').textContent = new Date(warehouse.updated_at).toLocaleDateString();
            document.getElementById('viewWarehouseId').textContent = warehouse.id;

            // Calculate and set utilization
            const capacity = parseFloat(warehouse.capacity) || 1;
            const occupancy = parseFloat(warehouse.current_occupancy) || 0;
            const utilization = Math.min((occupancy / capacity) * 100, 100);
            document.getElementById('viewUtilization').textContent = `${utilization.toFixed(1)}% utilized`;

            // Set capacity bar
            const capacityBar = document.getElementById('viewCapacityBar');
            capacityBar.style.width = '100%';
            capacityBar.className = 'bg-gradient-to-r from-blue-400 to-blue-500 h-2 rounded-full';

            // Set occupancy bar with color based on utilization
            const occupancyBar = document.getElementById('viewOccupancyBar');
            occupancyBar.style.width = `${utilization}%`;
            let barColor = 'from-green-400 to-green-500';
            if (utilization > 80) barColor = 'from-red-400 to-red-500';
            else if (utilization > 60) barColor = 'from-yellow-400 to-yellow-500';
            occupancyBar.className = `bg-gradient-to-r ${barColor} h-2 rounded-full`;

            // Set status badge
            const statusDiv = document.getElementById('viewStatus');
            if (warehouse.status) {
                statusDiv.innerHTML = `
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Active
                    </span>
                `;
            } else {
                statusDiv.innerHTML = `
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Inactive
                    </span>
                `;
            }
        }

        // Edit warehouse modal - Simplified version without API calls
        async function editWarehouse(id) {
            currentWarehouseId = id;

            // Show loading state
            const modal = document.getElementById('editWarehouseModal');
            const content = document.getElementById('editModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            await loadEditDataFromTable(id);
        }

        // Function to load edit data from table row
        async function loadEditDataFromTable(id) {
            const row = document.querySelector(`[data-warehouse-id="${id}"]`);
            if (!row) {
                alert('Warehouse data not found. Please refresh the page and try again.');
                closeModal('editWarehouseModal');
                return;
            }

            // Extract data from table row
            const warehouse = {
                id: id,
                name: row.querySelector('.warehouse-name')?.textContent || '',
                code: row.querySelector('.warehouse-code')?.textContent.replace('Code: ', '') || '',
                address: row.querySelector('.warehouse-address')?.textContent || '',
                capacity: parseInt(row.querySelector('.warehouse-capacity')?.textContent.replace(' sqft', '')
                    .replace(/,/g, '') || 0),
                staff_count: parseInt(row.querySelector('.warehouse-staff')?.textContent.replace(' staff', '') ||
                    0),
                status: row.querySelector('.warehouse-status')?.textContent === 'Active',
                notes: '', // Default empty for edit
                manager_id: '', // Default empty
                current_occupancy: 0 // Default value
            };

            // Try to get occupancy from utilization percentage
            const utilizationText = row.querySelector('.warehouse-utilization')?.textContent;
            if (utilizationText) {
                const utilization = parseFloat(utilizationText.replace('% utilized', ''));
                if (!isNaN(utilization) && warehouse.capacity > 0) {
                    warehouse.current_occupancy = (warehouse.capacity * utilization) / 100;
                }
            }

            populateEditForm(warehouse);
        }

        // Function to populate edit form with data
        function populateEditForm(warehouse) {
            document.getElementById('editName').value = warehouse.name;
            document.getElementById('editCode').value = warehouse.code;
            document.getElementById('editAddress').value = warehouse.address || '';
            document.getElementById('editCapacity').value = warehouse.capacity || '';
            document.getElementById('editStaffCount').value = warehouse.staff_count || '';
            document.getElementById('editCurrentOccupancy').value = warehouse.current_occupancy || '';
            document.getElementById('editManagerId').value = warehouse.manager_id || '';
            document.getElementById('editNotes').value = warehouse.notes || '';

            // Set status radio buttons
            if (warehouse.status) {
                document.getElementById('editStatusActive').checked = true;
                document.getElementById('editStatusInactive').checked = false;
            } else {
                document.getElementById('editStatusActive').checked = false;
                document.getElementById('editStatusInactive').checked = true;
            }

            // Set form action
            document.getElementById('editWarehouseForm').action = `/admin/warehouses/${warehouse.id}`;
        }

        // Helper functions for view modal actions
        function editCurrentWarehouse() {
            closeModal('viewWarehouseModal');
            setTimeout(() => editWarehouse(currentWarehouseId), 300);
        }

        function toggleCurrentStatus() {
            closeModal('viewWarehouseModal');
            setTimeout(() => toggleStatus(currentWarehouseId), 300);
        }

        function deleteCurrentWarehouse() {
            closeModal('viewWarehouseModal');
            setTimeout(() => deleteWarehouse(currentWarehouseId), 300);
        }

        // Delete warehouse
        function deleteWarehouse(id) {
            currentWarehouseId = id;
            const form = document.getElementById('deleteWarehouseForm');
            form.action = `/admin/warehouses/${id}`;
            const modal = document.getElementById('deleteConfirmationModal');
            const content = document.getElementById('deleteModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Toggle warehouse status
        function toggleStatus(id) {
            if (confirm('Are you sure you want to change the warehouse status?')) {
                fetch(`/admin/warehouses/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Add a success animation
                            const row = document.querySelector(`[data-warehouse-id="${id}"]`);
                            if (row) {
                                row.style.backgroundColor = '#d1fae5';
                                setTimeout(() => {
                                    row.style.backgroundColor = '';
                                    location.reload();
                                }, 500);
                            } else {
                                location.reload();
                            }
                        } else {
                            alert('Error updating status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error updating status');
                    });
            }
        }

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchWarehouses');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.warehouse-row');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const name = row.querySelector('.warehouse-name')?.textContent
                            .toLowerCase() || '';
                        const code = row.querySelector('.warehouse-code')?.textContent
                            .toLowerCase() || '';
                        const address = row.querySelector('.warehouse-address')?.textContent
                            .toLowerCase() || '';

                        if (name.includes(searchTerm) || code.includes(searchTerm) || address
                            .includes(searchTerm)) {
                            row.style.display = '';
                            visibleCount++;
                            // Add highlight effect
                            row.style.animation = 'highlight 0.3s ease';
                            setTimeout(() => row.style.animation = '', 300);
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update counter if exists
                    const counter = document.querySelector('.warehouses-count');
                    if (counter) {
                        counter.textContent = `${visibleCount} warehouses found`;
                    }
                });
            }

            // Filter functionality
            document.querySelectorAll('.filter-option').forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    const rows = document.querySelectorAll('.warehouse-row');
                    const filterButton = document.getElementById('filterDropdownButton');

                    // Update button text with icon
                    const icon = this.querySelector('svg')?.cloneNode(true) ||
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>';
                    const text = this.textContent.trim();
                    filterButton.innerHTML = icon.outerHTML ?
                        `${icon.outerHTML}<span class="ml-2">${text}</span>` :
                        `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>${text}`;

                    let visibleCount = 0;
                    rows.forEach(row => {
                        let shouldShow = false;

                        if (filterType === 'all') {
                            shouldShow = true;
                        } else if (filterType === '1') {
                            shouldShow = row.getAttribute('data-status') === '1';
                        } else if (filterType === '0') {
                            shouldShow = row.getAttribute('data-status') === '0';
                        } else if (filterType === 'high-capacity') {
                            shouldShow = row.getAttribute('data-capacity') ===
                                'high-capacity';
                        } else if (filterType === 'low-capacity') {
                            shouldShow = row.getAttribute('data-capacity') ===
                                'low-capacity';
                        }

                        if (shouldShow) {
                            row.style.display = '';
                            visibleCount++;
                            row.style.animation = 'highlight 0.3s ease';
                            setTimeout(() => row.style.animation = '', 300);
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Close dropdown
                    document.getElementById('filterDropdown').classList.add('hidden');
                });
            });

            // Filter dropdown toggle
            document.getElementById('filterDropdownButton').addEventListener('click', function() {
                const dropdown = document.getElementById('filterDropdown');
                dropdown.classList.toggle('hidden');
                this.classList.toggle('bg-gray-50');
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                // Close filter dropdown
                if (!event.target.closest('#filterDropdownButton') && !event.target.closest(
                        '#filterDropdown')) {
                    document.getElementById('filterDropdown').classList.add('hidden');
                    document.getElementById('filterDropdownButton').classList.remove('bg-gray-50');
                }

                // Close action menus
                document.querySelectorAll('[id^="actionMenu"]').forEach(menu => {
                    if (!event.target.closest('[id^="actionMenuButton"]') && !event.target.closest(
                            '[id^="actionMenu"]')) {
                        menu.classList.add('hidden');
                    }
                });
            });

            // Action menu toggles
            document.querySelectorAll('[id^="actionMenuButton"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const id = this.id.replace('actionMenuButton', '');
                    const menu = document.getElementById('actionMenu' + id);
                    menu.classList.toggle('hidden');

                    // Close other open menus
                    document.querySelectorAll('[id^="actionMenu"]').forEach(otherMenu => {
                        if (otherMenu.id !== menu.id) {
                            otherMenu.classList.add('hidden');
                        }
                    });
                });
            });

            // Auto-generate warehouse code from name
            const nameInput = document.querySelector('input[name="name"]');
            const codeInput = document.querySelector('input[name="code"]');

            if (nameInput && codeInput) {
                nameInput.addEventListener('blur', function() {
                    if (!codeInput.value.trim()) {
                        const name = this.value.trim();
                        if (name.length >= 3) {
                            const code = 'WH-' + name.substring(0, 3).toUpperCase() +
                                Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                            codeInput.value = code;
                            codeInput.classList.add('border-green-500');
                            setTimeout(() => codeInput.classList.remove('border-green-500'), 1000);
                        }
                    }
                });
            }

            // Animate progress bars on load
            setTimeout(() => {
                document.querySelectorAll('[style*="width"]').forEach(bar => {
                    if (bar.style.width && bar.style.width !== '0%') {
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    }
                });
            }, 500);

            // Export to Excel
            window.exportToExcel = function() {
                alert(
                    'Export functionality would be implemented here. In a real app, this would download an Excel file.'
                );
            };

            // Print warehouse list
            window.printWarehouseList = function() {
                window.print();
            };

            // Close modals on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            closeModal(modal.id);
                        }
                    });
                }
            });

            // Add form validation
            const createForm = document.getElementById('createWarehouseForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const requiredFields = this.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                            setTimeout(() => {
                                field.classList.remove('border-red-500', 'ring-2',
                                    'ring-red-200');
                            }, 2000);
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields (*)');
                    }
                });
            }

            // Edit form validation and submission
            const editForm = document.getElementById('editWarehouseForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    const requiredFields = this.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                            setTimeout(() => {
                                field.classList.remove('border-red-500', 'ring-2',
                                    'ring-red-200');
                            }, 2000);
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields (*)');
                    } else {
                        // Show loading state
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalText = submitBtn.textContent;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Updating...
                        `;
                        submitBtn.disabled = true;
                    }
                });
            }
        });
    </script>

    <style>
        /* Fix for form alignment */
        .modal-form .form-group {
            margin-bottom: 1.25rem;
        }

        .modal-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .modal-form input,
        .modal-form select,
        .modal-form textarea {
            width: 100%;
            box-sizing: border-box;
        }

        /* Ensure consistent input heights */
        .px-4.py-3 {
            min-height: 44px;
        }

        /* Grid gap consistency */
        .gap-5>* {
            margin-bottom: 0;
        }

        /* Fix for Bu and Code fields alignment */
        .relative input {
            padding-left: 3.5rem !important;
        }

        /* Ensure labels align properly */
        .block.text-sm.font-medium {
            display: flex;
            align-items: center;
            height: 1.5rem;
            margin-bottom: 0.375rem;
        }

        /* Fix for radio buttons alignment */
        .inline-flex.items-center {
            align-items: center;
            height: 1.75rem;
        }




        /* Make sure all form elements have same width */
        .max-w-2xl .space-y-6>* {
            width: 100%;
        }

        /* Fix for textarea alignment */
        textarea {
            vertical-align: top;
        }

        /* Ensure consistent vertical spacing */
        .space-y-6>*+* {
            margin-top: 1.5rem;
        }

        .space-y-2>*+* {
            margin-top: 0.5rem;
        }




        @keyframes highlight {
            0% {
                background-color: rgba(59, 130, 246, 0.1);
            }

            100% {
                background-color: transparent;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .warehouse-row {
            animation: slideIn 0.3s ease-out;
        }

        .warehouse-row:nth-child(even) {
            animation-delay: 0.05s;
        }

        .warehouse-row:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .stat-card {
            animation: fadeIn 0.5s ease-out;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-table {
                font-size: 12px;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Smooth transitions */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
        }

        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
@endpush
