@extends('layouts.admin')

@section('title', 'Warehouse Management')

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
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Warehouse Management</h1>
                                <p class="text-sm text-gray-600 mt-1">Manage your inventory storage locations efficiently</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <button onclick="openCreateModal()"
                            class="inline-flex items-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Warehouse
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Warehouses -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Warehouses</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalWarehouses }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Warehouses -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Active Warehouses</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeWarehouses }}</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">{{ $activePercentage }}% of total</span>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Capacity -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Capacity</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalCapacity) }} sqft</p>
                            <div class="mt-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $capacityUtilization }}%">
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 mt-1">{{ $capacityUtilization }}% utilized</div>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Staff Count -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Staff Count</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStaff }}</p>
                            <div class="mt-3">
                                <span class="text-sm text-gray-600">Average: {{ $avgStaffPerWarehouse }} per
                                    warehouse</span>
                            </div>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-4.201V21M4.5 10.201V21">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Warehouse List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Warehouse List</h2>
                                    <p class="text-sm text-gray-600">{{ $warehouses->total() }} warehouses found</p>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" id="searchWarehouses" placeholder="Search warehouses..."
                                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                                    </div>
                                    <div class="relative">
                                        <button id="filterDropdownButton"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                                </path>
                                            </svg>
                                            Filter
                                        </button>
                                        <div id="filterDropdown"
                                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                            <div class="py-2">
                                                <a href="#" data-filter="all"
                                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All
                                                    Warehouses</a>
                                                <a href="#" data-filter="1"
                                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Active
                                                    Only</a>
                                                <a href="#" data-filter="0"
                                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Inactive
                                                    Only</a>
                                                <div class="border-t border-gray-200 my-1"></div>
                                                <a href="#" data-filter="high-capacity"
                                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">High
                                                    Capacity</a>
                                                <a href="#" data-filter="low-capacity"
                                                    class="filter-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Low
                                                    Capacity</a>
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
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Warehouse</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Address</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Capacity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Staff</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($warehouses as $warehouse)
                                        <tr class="warehouse-row hover:bg-gray-50 transition-colors duration-150"
                                            data-status="{{ $warehouse->status ? '1' : '0' }}"
                                            data-capacity="{{ $warehouse->capacity > 5000 ? 'high-capacity' : 'low-capacity' }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                        <svg class="w-5 h-5 text-blue-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $warehouse->name }}</div>
                                                        <div class="text-sm text-gray-500">Code: {{ $warehouse->code }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <div class="max-w-xs">
                                                        <div class="text-sm text-gray-900 truncate">
                                                            {{ $warehouse->address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
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
                                                    <div class="w-24 bg-gray-200 rounded-full h-2">
                                                        <div class="bg-{{ $color }}-500 h-2 rounded-full"
                                                            style="width: {{ $utilization }}%"></div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ number_format($warehouse->current_occupancy ?? 0) }} sqft used
                                                        ({{ number_format($utilization, 1) }}%)
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($warehouse->status)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex -space-x-2 overflow-hidden">
                                                        @for ($i = 0; $i < min(3, $warehouse->staff_count); $i++)
                                                            <div
                                                                class="inline-block h-8 w-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-gray-500" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                                    </path>
                                                                </svg>
                                                            </div>
                                                        @endfor
                                                        @if ($warehouse->staff_count > 3)
                                                            <div
                                                                class="inline-block h-8 w-8 rounded-full bg-gray-400 border-2 border-white flex items-center justify-center">
                                                                <span
                                                                    class="text-xs font-medium text-white">+{{ $warehouse->staff_count - 3 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <span class="text-sm text-gray-600 ml-3">{{ $warehouse->staff_count }}
                                                        staff</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="viewWarehouse({{ $warehouse->id }})"
                                                        class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <button onclick="editWarehouse({{ $warehouse->id }})"
                                                        class="inline-flex items-center p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <a href="{{ route('admin.warehouses.products', $warehouse->id) }}"
                                                        class="inline-flex items-center p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                    <div class="relative">
                                                        <button id="actionMenuButton{{ $warehouse->id }}"
                                                            class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <div id="actionMenu{{ $warehouse->id }}"
                                                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                                            <div class="py-1">
                                                                @if ($warehouse->status)
                                                                    <a href="#"
                                                                        onclick="toggleStatus({{ $warehouse->id }})"
                                                                        class="block px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-50">Deactivate</a>
                                                                @else
                                                                    <a href="#"
                                                                        onclick="toggleStatus({{ $warehouse->id }})"
                                                                        class="block px-4 py-2 text-sm text-green-700 hover:bg-green-50">Activate</a>
                                                                @endif
                                                                <a href="#"
                                                                    onclick="deleteWarehouse({{ $warehouse->id }})"
                                                                    class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50">Delete</a>
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
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                        </path>
                                                    </svg>
                                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No warehouses found
                                                    </h3>
                                                    <p class="mt-2 text-gray-500">Create your first warehouse to get
                                                        started</p>
                                                    <div class="mt-6">
                                                        <button onclick="openCreateModal()"
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                            <svg class="w-4 h-4 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
                            <div class="px-6 py-4 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="text-sm text-gray-700">
                                        Showing {{ $warehouses->firstItem() }} to {{ $warehouses->lastItem() }} of
                                        {{ $warehouses->total() }} warehouses
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        {{ $warehouses->links('pagination::tailwind') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Warehouse Locations -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Warehouse Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Active vs Inactive -->
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Active Warehouses</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $activeWarehouses }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full"
                                            style="width: {{ $activePercentage }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $activePercentage }}% of total</div>
                                </div>

                                <!-- Capacity Utilization -->
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Capacity Utilization</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $capacityUtilization }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full"
                                            style="width: {{ $capacityUtilization }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ number_format($totalOccupancy ?? 0) }} sqft
                                        used</div>
                                </div>

                                <!-- Staff Distribution -->
                                <div>
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Staff Distribution</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $totalStaff }} total</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-500 h-2 rounded-full"
                                            style="width: {{ $avgStaffPerWarehouse > 0 ? min($avgStaffPerWarehouse * 10, 100) : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">Avg: {{ $avgStaffPerWarehouse }} per warehouse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-3">
                                <button onclick="openCreateModal()"
                                    class="flex items-center justify-center p-3 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg border border-blue-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add New Warehouse
                                </button>
                                <a href="{{ route('admin.warehouses.export') }}"
                                    class="flex items-center justify-center p-3 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg border border-green-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Export to Excel
                                </a>
                                <button onclick="printWarehouseList()"
                                    class="flex items-center justify-center p-3 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg border border-purple-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Print List
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Warehouse Modal -->
    <div id="createWarehouseModal"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Create New Warehouse</h3>
            </div>
            <form id="createWarehouseForm" action="{{ route('admin.warehouses.store') }}" method="POST"
                class="p-6">
                @csrf
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Warehouse Name *</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Warehouse Code *</label>
                            <input type="text" name="code" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Capacity (sqft)</label>
                            <input type="number" name="capacity" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Staff Count</label>
                            <input type="number" name="staff_count"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Occupancy (sqft)</label>
                            <input type="number" name="current_occupancy" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manager</label>
                            <select name="manager_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Active Status - Using radio buttons -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Active Status *</label>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="1" checked
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="status" value="0"
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('createWarehouseModal')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Warehouse
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Confirm Delete</h3>
                        <p class="text-sm text-gray-500">This action cannot be undone</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Are you sure you want to delete this warehouse? This action cannot be undone.
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-yellow-700">All inventory and associated data will be permanently removed.
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeModal('deleteConfirmationModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <form id="deleteWarehouseForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Warehouse
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal functions
        function openCreateModal() {
            document.getElementById('createWarehouseModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // View warehouse (placeholder)
        function viewWarehouse(id) {
            window.location.href = `/admin/warehouses/${id}`;
        }

        // Edit warehouse (placeholder)
        function editWarehouse(id) {
            window.location.href = `/admin/warehouses/${id}/edit`;
        }

        // Delete warehouse
        function deleteWarehouse(id) {
            const form = document.getElementById('deleteWarehouseForm');
            form.action = `/admin/warehouses/${id}`;
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
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
                            location.reload();
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
            const searchInput = document.getElementById('searchWarehouses');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.warehouse-row');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Filter functionality
            document.querySelectorAll('.filter-option').forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    const rows = document.querySelectorAll('.warehouse-row');
                    const filterButton = document.getElementById('filterDropdownButton');

                    // Update button text
                    filterButton.innerHTML = this.innerHTML +
                        '<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';

                    rows.forEach(row => {
                        if (filterType === 'all') {
                            row.style.display = '';
                        } else if (filterType === 'active') {
                            row.style.display = row.getAttribute('data-status') === '1' ?
                                '' : 'none';
                        } else if (filterType === 'inactive') {
                            row.style.display = row.getAttribute('data-status') === '0' ?
                                '' : 'none';
                        } else if (filterType === 'high-capacity') {
                            row.style.display = row.getAttribute('data-capacity') ===
                                'high-capacity' ? '' : 'none';
                        } else if (filterType === 'low-capacity') {
                            row.style.display = row.getAttribute('data-capacity') ===
                                'low-capacity' ? '' : 'none';
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
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('#filterDropdownButton') && !event.target.closest(
                        '#filterDropdown')) {
                    document.getElementById('filterDropdown').classList.add('hidden');
                }
            });

            // Action menu toggles
            document.querySelectorAll('[id^="actionMenuButton"]').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.id.replace('actionMenuButton', '');
                    const menu = document.getElementById('actionMenu' + id);
                    menu.classList.toggle('hidden');
                });
            });

            // Close action menus when clicking outside
            document.addEventListener('click', function(event) {
                document.querySelectorAll('[id^="actionMenu"]').forEach(menu => {
                    if (!event.target.closest('[id^="actionMenuButton"]') && !event.target.closest(
                            '[id^="actionMenu"]')) {
                        menu.classList.add('hidden');
                    }
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
                        }
                    }
                });
            }
        });

        // Print warehouse list
        function printWarehouseList() {
            window.print();
        }

        // Close modals on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
            }
        });
    </script>

    <style>
        .warehouse-row:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
@endpush
