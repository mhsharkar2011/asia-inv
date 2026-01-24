@extends('layouts.admin')

@section('title', 'Department Management')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Department Management
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage organizational departments, their hierarchy and settings
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button type="button" onclick="toggleFilters()"
                        class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </button>
                    <button type="button" onclick="openCreateModal()"
                        class="ml-3 inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Department
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div id="filterSection" class="hidden mb-6 bg-white shadow-lg rounded-xl p-6 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search"
                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2.5 border-gray-300 rounded-lg transition duration-150 ease-in-out"
                                placeholder="Search departments...">
                        </div>
                    </div>
                    <div>
                        <label for="company_filter" class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                        <select id="company_filter" name="company_filter"
                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2.5 border-gray-300 rounded-lg shadow-sm transition duration-150 ease-in-out">
                            <option value="">All Companies</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2.5 border-gray-300 rounded-lg shadow-sm transition duration-150 ease-in-out">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Hierarchy Level</label>
                        <select id="level" name="level"
                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2.5 border-gray-300 rounded-lg shadow-sm transition duration-150 ease-in-out">
                            <option value="">All Levels</option>
                            <option value="top">Top Level</option>
                            <option value="child">Child Departments</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="button" onclick="applyFilters()"
                        class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        Apply Filters
                    </button>
                    <button type="button" onclick="resetFilters()"
                        class="ml-3 inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Departments</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $allDepartments->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $allDepartments->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Staff</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $allDepartments->sum('staff_count') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Budget</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                ${{ number_format($allDepartments->sum('budget'), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments Table (Grid View) -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8 border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Departments</h3>
                            <p class="mt-1 text-sm text-gray-600">Complete list of departments in grid format</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <select id="perPage" onchange="changePerPage(this.value)"
                                    class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none">
                                    <option value="10">10 per page</option>
                                    <option value="25">25 per page</option>
                                    <option value="50">50 per page</option>
                                    <option value="100">100 per page</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <button onclick="exportToCSV()"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Company
                                        <button onclick="sortTable('company')" class="ml-1 focus:outline-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        Department
                                        <button onclick="sortTable('name')" class="ml-1 focus:outline-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Manager
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Staff
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Budget
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($allDepartments as $dept)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($dept->company)
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-3">
                                                    <span
                                                        class="text-xs font-semibold text-blue-600">{{ substr($dept->company->name, 0, 2) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $dept->company->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $dept->company->code ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">No Company</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="flex items-center">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $dept->name }}
                                                    </div>
                                                    <span
                                                        class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $dept->code }}
                                                    </span>
                                                </div>
                                                @if ($dept->parent)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <span class="inline-flex items-center">
                                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 12h14M5 12l4-4m-4 4l4 4" />
                                                            </svg>
                                                            Parent: {{ $dept->parent->name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($dept->manager)
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center mr-3">
                                                    <span
                                                        class="text-xs font-semibold text-green-600">{{ substr($dept->manager->name, 0, 2) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $dept->manager->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $dept->manager->email }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="mr-1 w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                </svg>
                                                Not assigned
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $dept->active_staff_count }}/{{ $dept->staff_count }}</div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    @php
                                                        $percentage =
                                                            $dept->staff_count > 0
                                                                ? ($dept->active_staff_count / $dept->staff_count) * 100
                                                                : 0;
                                                        $color =
                                                            $percentage >= 80
                                                                ? 'from-green-500 to-green-600'
                                                                : ($percentage >= 50
                                                                    ? 'from-yellow-500 to-yellow-600'
                                                                    : 'from-red-500 to-red-600');
                                                    @endphp
                                                    <div class="h-2 rounded-full bg-gradient-to-r {{ $color }}"
                                                        style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            ${{ number_format($dept->budget, 2) }}
                                        </div>
                                        @if ($dept->budget > 0)
                                            <div class="text-xs text-gray-500">Annual budget</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $dept->is_active
                                                ? 'bg-green-100 text-green-800 border border-green-200'
                                                : 'bg-red-100 text-red-800 border border-red-200' }}">
                                            @if ($dept->is_active)
                                                <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @else
                                                <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                            @endif
                                            {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewDepartment({{ $dept->id }})"
                                                class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-50 transition-colors duration-150"
                                                title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button onclick="editDepartment({{ $dept->id }})"
                                                class="text-indigo-600 hover:text-indigo-800 p-1.5 rounded-lg hover:bg-indigo-50 transition-colors duration-150"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            @if ($dept->canBeDeleted())
                                                <button onclick="confirmDelete({{ $dept->id }})"
                                                    class="text-red-600 hover:text-red-800 p-1.5 rounded-lg hover:bg-red-50 transition-colors duration-150"
                                                    title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @else
                                                <button disabled class="text-gray-400 p-1.5 rounded-lg cursor-not-allowed"
                                                    title="Cannot delete (has users or children)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($allDepartments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $allDepartments->onEachSide(1)->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>

            <!-- Departments Tree View -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8 border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900">Department Hierarchy</h3>
                    <p class="mt-1 text-sm text-gray-600">Tree view showing parent-child relationships</p>
                </div>
                <div class="p-6">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($departments as $department)
                            @include('admin.departments.partials.department-item', [
                                'department' => $department,
                                'level' => 0,
                            ])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="departmentModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold leading-6 text-gray-900" id="modalTitle">
                            Add New Department
                        </h3>
                        <button type="button" onclick="closeModal()"
                            class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form id="departmentForm" method="POST">
                    @csrf
                    <div id="formMethod"></div>
                    <div class="bg-white px-6 pb-8">
                        <div class="space-y-6">
                            <!-- Company and Name -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Company *
                                    </label>
                                    <div class="relative">
                                        <select id="company_id" name="company_id" required
                                            class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Department Name *
                                    </label>
                                    <input type="text" name="name" id="name" required
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="Enter department name">
                                </div>
                            </div>

                            <!-- Code and Parent -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Department Code
                                    </label>
                                    <input type="text" name="code" id="code"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="e.g., DEPT001">
                                    <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate</p>
                                </div>
                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Parent Department
                                    </label>
                                    <div class="relative">
                                        <select id="parent_id" name="parent_id"
                                            class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                            <option value="">Select Parent Department</option>
                                            @foreach ($allDepartments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->full_path }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manager and Contact Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="manager_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Manager
                                    </label>
                                    <div class="relative">
                                        <select id="manager_id" name="manager_id"
                                            class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                            <option value="">Select Manager</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}">{{ $manager->name }}
                                                    ({{ $manager->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Department Email
                                    </label>
                                    <input type="email" name="email" id="email"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="department@company.com">
                                </div>
                            </div>

                            <!-- Contact Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="text" name="phone" id="phone"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="+1 (555) 123-4567">
                                </div>
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                        Location
                                    </label>
                                    <input type="text" name="location" id="location"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="Building, Floor, Room">
                                </div>
                            </div>

                            <!-- Budget and Staff -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                                        Annual Budget ($)
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="budget" id="budget" min="0"
                                            step="0.01"
                                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-3 py-3 border-gray-300 rounded-lg placeholder-gray-400 transition duration-150 ease-in-out"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label for="staff_count" class="block text-sm font-medium text-gray-700 mb-2">
                                        Staff Count
                                    </label>
                                    <input type="number" name="staff_count" id="staff_count" min="0"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="0">
                                </div>
                            </div>

                            <!-- Sort Order and Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" id="sort_order" min="0"
                                        class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                                class="focus:ring-2 focus:ring-indigo-500 h-6 w-6 text-indigo-600 border-gray-300 rounded transition duration-150 ease-in-out">
                                        </div>
                                        <div class="ml-3">
                                            <label for="is_active" class="text-sm text-gray-900 font-medium">
                                                Department is active
                                            </label>
                                            <p class="text-xs text-gray-500">Department will be visible and operational</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                    placeholder="Enter department description..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                Cancel
                            </button>
                            <button type="button" onclick="submitForm()"
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                Save Department
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                Delete Department
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this department? This action cannot be undone.
                                    All child departments and associated users will need to be reassigned.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
                    <div class="sm:flex sm:flex-row-reverse">
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                Delete Department
                            </button>
                        </form>
                        <button type="button" onclick="closeDeleteModal()"
                            class="mt-3 sm:mt-0 sm:ml-3 inline-flex items-center px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .department-item {
            transition: all 0.2s ease;
        }

        .department-item:hover {
            background-color: #f9fafb;
        }

        .expand-btn {
            transition: transform 0.2s ease;
        }

        .expand-btn.expanded {
            transform: rotate(90deg);
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
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        /* Ensure modals appear on top */
        #departmentModal,
        #deleteModal {
            z-index: 9999;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentDepartmentId = null;
        let currentSortField = null;
        let currentSortDirection = 'asc';

        function toggleFilters() {
            const filterSection = document.getElementById('filterSection');
            filterSection.classList.toggle('hidden');
        }

        function applyFilters() {
            const search = document.getElementById('search').value;
            const company = document.getElementById('company_filter').value;
            const status = document.getElementById('status').value;
            const level = document.getElementById('level').value;

            let url = '{{ route('admin.departments.index') }}?';
            if (search) url += `search=${encodeURIComponent(search)}&`;
            if (company) url += `company=${company}&`;
            if (status) url += `status=${status}&`;
            if (level) url += `level=${level}`;

            window.location.href = url;
        }

        function resetFilters() {
            document.getElementById('search').value = '';
            document.getElementById('company_filter').value = '';
            document.getElementById('status').value = '';
            document.getElementById('level').value = '';
            window.location.href = '{{ route('admin.departments.index') }}';
        }

        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }

        function sortTable(field) {
            const url = new URL(window.location.href);
            if (currentSortField === field) {
                currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSortField = field;
                currentSortDirection = 'asc';
            }
            url.searchParams.set('sort', field);
            url.searchParams.set('direction', currentSortDirection);
            window.location.href = url.toString();
        }

        function exportToCSV() {
            alert('Export functionality would be implemented here');
            // In a real application, this would make an AJAX call to generate a CSV file
        }

        function openCreateModal() {
            console.log('Opening create modal');
            document.getElementById('modalTitle').textContent = 'Add New Department';
            document.getElementById('departmentForm').action = '{{ route('admin.departments.store') }}';
            document.getElementById('formMethod').innerHTML = '';

            // Reset form
            const form = document.getElementById('departmentForm');
            if (form) {
                form.reset();
            }

            // Ensure checkbox is unchecked by default
            const isActiveCheckbox = document.getElementById('is_active');
            if (isActiveCheckbox) {
                isActiveCheckbox.checked = false;
            }

            // Show modal
            const modal = document.getElementById('departmentModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function editDepartment(id) {
            console.log('Editing department:', id);
            fetch(`/admin/departments/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Department data:', data);
                    document.getElementById('modalTitle').textContent = 'Edit Department';
                    document.getElementById('departmentForm').action = `/admin/departments/${id}`;
                    document.getElementById('formMethod').innerHTML = '@method('PUT')';

                    // Fill form with data
                    const fields = ['company_id', 'name', 'code', 'parent_id', 'manager_id',
                        'email', 'phone', 'staff_count', 'budget', 'location',
                        'sort_order', 'description'
                    ];

                    fields.forEach(field => {
                        const element = document.getElementById(field);
                        if (element && data[field] !== undefined) {
                            element.value = data[field];
                        }
                    });

                    // Handle checkbox
                    const isActiveCheckbox = document.getElementById('is_active');
                    if (isActiveCheckbox) {
                        isActiveCheckbox.checked = Boolean(data.is_active);
                    }

                    // Show modal
                    const modal = document.getElementById('departmentModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading department data. Please try again.');
                });
        }

        function viewDepartment(id) {
            window.location.href = `/admin/departments/${id}`;
        }

        function confirmDelete(id) {
            currentDepartmentId = id;
            document.getElementById('deleteForm').action = `/admin/departments/${id}`;
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal() {
            const modal = document.getElementById('departmentModal');
            if (modal) {
                modal.classList.add('hidden');
            }
            document.body.style.overflow = 'auto';
        }

        function closeDeleteModal() {
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.classList.add('hidden');
            }
            document.body.style.overflow = 'auto';
            currentDepartmentId = null;
        }

        function submitForm() {
            const form = document.getElementById('departmentForm');
            if (!form) {
                console.error('Form not found');
                return;
            }

            const formData = new FormData(form);

            // Add a hidden field for is_active if checkbox is not checked
            if (!formData.has('is_active')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'is_active';
                hiddenInput.value = '0';
                form.appendChild(hiddenInput);
            }

            // Determine if it's an edit or create
            const isEdit = form.action.includes('/admin/departments/') &&
                !form.action.endsWith('/store') &&
                !form.action.endsWith('/create');

            // Use traditional form submission instead of AJAX for now
            if (isEdit) {
                // For PUT method, we need to add method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            // Submit the form
            console.log('Submitting form to:', form.action);
            form.submit();
        }

        function toggleChildren(departmentId) {
            const childrenRow = document.getElementById(`children-${departmentId}`);
            const expandBtn = document.getElementById(`expand-${departmentId}`);

            if (childrenRow && expandBtn) {
                if (childrenRow.classList.contains('hidden')) {
                    childrenRow.classList.remove('hidden');
                    expandBtn.classList.add('expanded');
                } else {
                    childrenRow.classList.add('hidden');
                    expandBtn.classList.remove('expanded');
                }
            }
        }

        function showNotification(message, type = 'success') {
            // Remove any existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
                type === 'success'
                    ? 'bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200'
                    : 'bg-gradient-to-r from-red-50 to-pink-50 border border-red-200'
            }`;

            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 ${type === 'success' ? 'text-green-400' : 'text-red-400'}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                            }
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium ${type === 'success' ? 'text-green-800' : 'text-red-800'}">
                            ${message}
                        </p>
                    </div>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('search').focus();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                openCreateModal();
            }
        });

        // Initialize per page selector
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const perPage = urlParams.get('per_page') || '10';
            const perPageSelect = document.getElementById('perPage');
            if (perPageSelect) {
                perPageSelect.value = perPage;
            }

            // Add click outside to close modals
            document.addEventListener('click', function(event) {
                const departmentModal = document.getElementById('departmentModal');
                const deleteModal = document.getElementById('deleteModal');

                if (departmentModal && !departmentModal.classList.contains('hidden')) {
                    if (event.target === departmentModal) {
                        closeModal();
                    }
                }

                if (deleteModal && !deleteModal.classList.contains('hidden')) {
                    if (event.target === deleteModal) {
                        closeDeleteModal();
                    }
                }
            });
        });
    </script>
@endpush
