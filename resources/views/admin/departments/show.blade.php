@extends('layouts.admin')

@section('title', 'Department Details - ' . $department->name)

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <nav class="flex items-center mb-4" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('admin.departments.index') }}"
                                    class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                    Departments
                                </a>
                            </li>
                            <li>
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </li>
                            <li>
                                <span class="text-sm font-medium text-gray-900 truncate">
                                    {{ $department->name }}
                                </span>
                            </li>
                        </ol>
                    </nav>

                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            {{ $department->name }}
                        </h1>
                        <div class="ml-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $department->is_active
                                    ? 'bg-green-100 text-green-800 border border-green-200'
                                    : 'bg-red-100 text-red-800 border border-red-200' }}">
                                @if ($department->is_active)
                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                @else
                                    <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                @endif
                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $department->description ?: 'Department details and overview' }}
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('admin.departments.index') }}"
                        class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <button onclick="editDepartment()"
                        class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Department
                    </button>
                </div>
            </div>

            <!-- Department Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Left Column: Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Company and Hierarchy Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-semibold text-gray-900">Department Information</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Company</dt>
                                    <dd class="text-sm text-gray-900">
                                        <div class="flex items-center">
                                            @if ($department->company)
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-3">
                                                    <span class="text-xs font-semibold text-blue-600">
                                                        {{ substr($department->company->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $department->company->name }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $department->company->code ?? 'N/A' }}</div>
                                                </div>
                                            @else
                                                <span class="text-gray-400">No company assigned</span>
                                            @endif
                                        </div>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Department Code</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $department->code ?? 'N/A' }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Parent Department</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if ($department->parent)
                                            <a href="{{ route('admin.departments.show', $department->parent) }}"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 hover:underline">
                                                <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                </svg>
                                                {{ $department->parent->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Top-level department</span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Hierarchy Level</dt>
                                    <dd class="text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Level {{ $department->getLevel() }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Location</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if ($department->location)
                                            <div class="flex items-center">
                                                <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $department->location }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">Not specified</span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Sort Order</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $department->sort_order ?? '0' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-semibold text-gray-900">Contact Information</h3>
                        </div>
                        <div class="p-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Department Email</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if ($department->email)
                                            <a href="mailto:{{ $department->email }}"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 hover:underline">
                                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $department->email }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Not specified</span>
                                        @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 mb-1">Phone Number</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if ($department->phone)
                                            <a href="tel:{{ $department->phone }}"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 hover:underline">
                                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $department->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Not specified</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Manager Information Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-semibold text-gray-900">Department Manager</h3>
                        </div>
                        <div class="p-6">
                            @if ($department->manager)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                            <span class="text-xl font-semibold text-green-600">
                                                {{ substr($department->manager->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $department->manager->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $department->manager->position ?? 'Manager' }}
                                        </p>
                                        <div class="mt-2 space-y-1">
                                            <p class="text-sm text-gray-600">
                                                <a href="mailto:{{ $department->manager->email }}"
                                                    class="hover:text-indigo-600 hover:underline">
                                                    {{ $department->manager->email }}
                                                </a>
                                            </p>
                                            @if ($department->manager->phone)
                                                <p class="text-sm text-gray-600">
                                                    <a href="tel:{{ $department->manager->phone }}"
                                                        class="hover:text-indigo-600 hover:underline">
                                                        {{ $department->manager->phone }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No manager assigned</h3>
                                    <p class="mt-1 text-sm text-gray-500">Assign a manager to this department.</p>
                                    <div class="mt-6">
                                        <button onclick="assignManager()"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                            Assign Manager
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Stats and Actions -->
                <div class="space-y-6">
                    <!-- Stats Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-semibold text-gray-900">Department Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-600">Staff Members</span>
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ $department->active_staff_count }}/{{ $department->staff_count }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        @php
                                            $percentage =
                                                $department->staff_count > 0
                                                    ? ($department->active_staff_count / $department->staff_count) * 100
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
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ number_format($percentage, 1) }}% active staff
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Annual Budget</span>
                                        <span class="text-lg font-bold text-gray-900">
                                            ${{ number_format($department->budget, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Child Departments</span>
                                        <span class="text-lg font-bold text-gray-900">
                                            {{ $department->children->count() }}
                                        </span>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-600">Created</span>
                                        <span class="text-sm text-gray-900">
                                            {{ $department->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('admin.users.index', ['department' => $department->id]) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    View Staff Members
                                </a>

                                <button onclick="addChildDepartment()"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Child Department
                                </button>

                                <button onclick="updateBudget()"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Update Budget
                                </button>

                                @if ($department->canBeDeleted())
                                    <button onclick="confirmDelete()"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Department
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Child Departments Section -->
            @if ($department->children->isNotEmpty())
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Child Departments</h3>
                                <p class="mt-1 text-sm text-gray-600">Departments under {{ $department->name }}</p>
                            </div>
                            <button onclick="addChildDepartment()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Child Department
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Department Name
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
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($department->children as $child)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="flex items-center">
                                                        <a href="{{ route('admin.departments.show', $child) }}"
                                                            class="text-sm font-semibold text-gray-900 hover:text-indigo-600 hover:underline">
                                                            {{ $child->name }}
                                                        </a>
                                                        <span
                                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            {{ $child->code }}
                                                        </span>
                                                    </div>
                                                    @if ($child->description)
                                                        <p class="mt-1 text-xs text-gray-500 truncate max-w-xs">
                                                            {{ $child->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($child->manager)
                                                <div class="flex items-center">
                                                    <div class="text-sm text-gray-900">{{ $child->manager->name }}</div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $child->active_staff_count }}/{{ $child->staff_count }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $child->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.departments.show', $child) }}"
                                                    class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-50 transition-colors duration-150"
                                                    title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <button onclick="editChildDepartment({{ $child->id }})"
                                                    class="text-indigo-600 hover:text-indigo-800 p-1.5 rounded-lg hover:bg-indigo-50 transition-colors duration-150"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Recent Activity Section -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- Example activity items - you should replace with real data from your system -->
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex items-start space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div
                                                    class="h-8 w-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-indigo-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900">Department created</span>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500">
                                                    Created {{ $department->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @if ($department->updated_at != $department->created_at)
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex items-start space-x-3">
                                            <div>
                                                <div class="relative px-1">
                                                    <div
                                                        class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                                        <svg class="h-5 w-5 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <span class="font-medium text-gray-900">Department updated</span>
                                                    </div>
                                                    <p class="mt-0.5 text-sm text-gray-500">
                                                        Last updated {{ $department->updated_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
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
                                    Are you sure you want to delete "{{ $department->name }}"?
                                    This action cannot be undone.
                                    @if ($department->children->isNotEmpty())
                                        <br><br>
                                        <strong>Warning:</strong> This department has {{ $department->children->count() }}
                                        child department(s).
                                        They will need to be reassigned or deleted separately.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
                    <div class="sm:flex sm:flex-row-reverse">
                        <form id="deleteForm" action="{{ route('admin.departments.destroy', $department) }}"
                            method="POST" style="display: inline;">
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
        .notification {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Custom scrollbar for tables */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Smooth hover transitions */
        tr,
        button,
        a {
            transition: all 0.2s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function editDepartment() {
            window.location.href = "{{ route('admin.departments.edit', $department) }}";
        }

        function addChildDepartment() {
            window.location.href = "{{ route('admin.departments.create', ['parent_id' => $department->id]) }}";
        }

        function editChildDepartment(id) {
            window.location.href = `/admin/departments/${id}/edit`;
        }

        function assignManager() {
            alert('This would open a manager assignment modal in a real implementation');
        }

        function updateBudget() {
            const newBudget = prompt('Enter new budget amount:', "{{ $department->budget }}");
            if (newBudget !== null) {
                // In a real application, make an AJAX request to update the budget
                fetch("{{ route('admin.departments.update', $department) }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            budget: newBudget,
                            _method: 'PUT'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Budget updated successfully!', 'success');
                            setTimeout(() => location.reload(), 1500);
                        }
                    })
                    .catch(error => {
                        showNotification('Error updating budget', 'error');
                    });
            }
        }

        function confirmDelete() {
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeDeleteModal() {
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.classList.add('hidden');
            }
            document.body.style.overflow = 'auto';
        }

        function showNotification(message, type = 'success') {
            // Remove existing notifications
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

        // Add click outside to close modal
        document.addEventListener('click', function(event) {
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal && !deleteModal.classList.contains('hidden')) {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                editDepartment();
            }
        });

        // Initialize tooltips if using a tooltip library
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any tooltips or other UI enhancements
            const tooltips = document.querySelectorAll('[title]');
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseenter', function() {
                    // Add your tooltip implementation here
                });
            });
        });
    </script>
@endpush
