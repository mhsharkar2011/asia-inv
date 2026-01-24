@extends('layouts.admin')

@section('title', 'Add New Department')

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
                                    Add New Department
                                </span>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Add New Department
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Create a new organizational department and configure its settings
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <a href="{{ route('admin.departments.index') }}"
                        class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('admin.departments.store') }}" method="POST" id="departmentForm">
                        @csrf

                        <!-- Basic Information Card -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mb-8">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                                <p class="mt-1 text-sm text-gray-600">Essential details about the department</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <!-- Company Selection -->
                                    <div>
                                        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Company *
                                        </label>
                                        <div class="relative">
                                            <select id="company_id" name="company_id" required
                                                class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
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
                                        @error('company_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Department Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Department Name *
                                        </label>
                                        <input type="text" name="name" id="name" required
                                            value="{{ old('name') }}"
                                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                            placeholder="e.g., Human Resources, Information Technology">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Department Code -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                                Department Code
                                            </label>
                                            <input type="text" name="code" id="code" value="{{ old('code') }}"
                                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                                placeholder="e.g., HR, IT, SALES">
                                            <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate</p>
                                            @error('code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Parent Department -->
                                        <div>
                                            <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                Parent Department
                                            </label>
                                            <div class="relative">
                                                <select id="parent_id" name="parent_id"
                                                    class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                                    <option value="">Select Parent Department</option>
                                                    @foreach ($departments as $dept)
                                                        <option value="{{ $dept->id }}"
                                                            {{ old('parent_id') == $dept->id ? 'selected' : '' }}>
                                                            {{ $dept->name }}
                                                            @if ($dept->company)
                                                                ({{ $dept->company->name }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            @error('parent_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                            Description
                                        </label>
                                        <textarea id="description" name="description" rows="4"
                                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                            placeholder="Describe the department's purpose, responsibilities, and objectives...">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Management Card -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mb-8">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h3 class="text-lg font-semibold text-gray-900">Contact & Management</h3>
                                <p class="mt-1 text-sm text-gray-600">Contact details and department management</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <!-- Manager Selection -->
                                    <div>
                                        <label for="manager_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Department Manager
                                        </label>
                                        <div class="relative">
                                            <select id="manager_id" name="manager_id"
                                                class="block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out appearance-none bg-white">
                                                <option value="">Select Manager</option>
                                                @foreach ($managers as $manager)
                                                    <option value="{{ $manager->id }}"
                                                        {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                                        {{ $manager->name }} ({{ $manager->email }})
                                                        @if ($manager->position)
                                                            - {{ $manager->position }}
                                                        @endif
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
                                        @error('manager_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                                Department Email
                                            </label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email') }}"
                                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                                placeholder="department@company.com">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                                Phone Number
                                            </label>
                                            <input type="text" name="phone" id="phone"
                                                value="{{ old('phone') }}"
                                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                                placeholder="+1 (555) 123-4567">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <div>
                                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                            Location
                                        </label>
                                        <input type="text" name="location" id="location"
                                            value="{{ old('location') }}"
                                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                            placeholder="e.g., Building A, 3rd Floor, Room 305">
                                        @error('location')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Budget & Resources Card -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mb-8">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h3 class="text-lg font-semibold text-gray-900">Budget & Resources</h3>
                                <p class="mt-1 text-sm text-gray-600">Financial and staffing information</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Budget -->
                                        <div>
                                            <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                                                Annual Budget ($)
                                            </label>
                                            <div class="relative rounded-lg shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">$</span>
                                                </div>
                                                <input type="number" name="budget" id="budget" min="0"
                                                    step="0.01" value="{{ old('budget', 0) }}"
                                                    class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-3 py-3 border-gray-300 rounded-lg placeholder-gray-400 transition duration-150 ease-in-out"
                                                    placeholder="0.00">
                                            </div>
                                            @error('budget')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Staff Count -->
                                        <div>
                                            <label for="staff_count" class="block text-sm font-medium text-gray-700 mb-2">
                                                Staff Count
                                            </label>
                                            <input type="number" name="staff_count" id="staff_count" min="0"
                                                value="{{ old('staff_count', 0) }}"
                                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                                placeholder="0">
                                            @error('staff_count')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Active Staff Count -->
                                    <div>
                                        <label for="active_staff_count"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Active Staff Count
                                        </label>
                                        <input type="number" name="active_staff_count" id="active_staff_count"
                                            min="0" value="{{ old('active_staff_count', 0) }}"
                                            class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                            placeholder="0">
                                        <p class="mt-1 text-xs text-gray-500">Number of currently active staff members</p>
                                        @error('active_staff_count')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings & Configuration Card -->
                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mb-8">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                <h3 class="text-lg font-semibold text-gray-900">Settings & Configuration</h3>
                                <p class="mt-1 text-sm text-gray-600">Additional department settings</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Sort Order -->
                                        <div>
                                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                                Sort Order
                                            </label>
                                            <input type="number" name="sort_order" id="sort_order" min="0"
                                                value="{{ old('sort_order', 0) }}"
                                                class="focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border-gray-300 rounded-lg shadow-sm placeholder-gray-400 transition duration-150 ease-in-out"
                                                placeholder="0">
                                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first in lists</p>
                                            @error('sort_order')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                                            <div class="space-y-4">
                                                <div class="relative flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="is_active" name="is_active" type="checkbox"
                                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                                            class="focus:ring-2 focus:ring-indigo-500 h-6 w-6 text-indigo-600 border-gray-300 rounded transition duration-150 ease-in-out">
                                                    </div>
                                                    <div class="ml-3">
                                                        <label for="is_active" class="text-sm text-gray-900 font-medium">
                                                            Department is active
                                                        </label>
                                                        <p class="text-xs text-gray-500">Active departments are visible and
                                                            operational</p>
                                                    </div>
                                                </div>
                                                @error('is_active')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pb-8">
                            <a href="{{ route('admin.departments.index') }}"
                                class="inline-flex items-center px-5 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create Department
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Help & Information -->
                <div class="space-y-6">
                    <!-- Help Card -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <h3 class="text-lg font-semibold text-gray-900">Creating a Department</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Required Fields</h4>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span><strong>Company:</strong> Select the company this department belongs
                                                to</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span><strong>Department Name:</strong> Enter a clear, descriptive name</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Best Practices</h4>
                                    <ul class="text-sm text-gray-600 space-y-2">
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Use clear, consistent naming conventions</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Set realistic budget and staff counts</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Assign a manager for accountability</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Auto-generated Code Info -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                            <h3 class="text-lg font-semibold text-gray-900">Department Codes</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <p class="text-sm text-gray-600">
                                    Department codes are automatically generated if left empty. The system uses a
                                    combination of company code and department name initials.
                                </p>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 mb-1">Examples:</p>
                                    <ul class="text-xs text-gray-600 space-y-1">
                                        <li>Company: "Tech Corp" (TC) + Department: "Human Resources" → <code
                                                class="text-purple-600">TC-HR</code></li>
                                        <li>Company: "Sales Inc" (SI) + Department: "Information Technology" → <code
                                                class="text-purple-600">SI-IT</code></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hierarchy Info -->
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                            <h3 class="text-lg font-semibold text-gray-900">Department Hierarchy</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <p class="text-sm text-gray-600">
                                    Departments can be organized in a hierarchical structure with parent-child
                                    relationships.
                                </p>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs text-gray-500 mb-2">Example Structure:</p>
                                    <div class="text-xs text-gray-600 space-y-1">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            <span>Operations (Level 1)</span>
                                        </div>
                                        <div class="flex items-center ml-4">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                            <span>Manufacturing (Level 2)</span>
                                        </div>
                                        <div class="flex items-center ml-8">
                                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                                            <span>Production (Level 3)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">Department Created Successfully!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    The department has been created successfully. You'll be redirected to the department
                                    list shortly.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 rounded-b-2xl">
                    <div class="sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="redirectToList()"
                            class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            Go to Department List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom form styling */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Smooth transitions */
        select,
        input,
        textarea {
            transition: all 0.2s ease;
        }

        /* Focus states */
        .focus-within\:ring-2:focus-within {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Custom scrollbar for selects */
        select {
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }

        select::-webkit-scrollbar {
            width: 8px;
        }

        select::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        select::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('departmentForm');
            const nameInput = document.getElementById('name');
            const companySelect = document.getElementById('company_id');
            const codeInput = document.getElementById('code');

            // Auto-generate code based on name if empty
            nameInput.addEventListener('blur', function() {
                if (nameInput.value && !codeInput.value) {
                    const words = nameInput.value.split(' ');
                    let code = '';

                    if (words.length === 1) {
                        // Single word: take first 4 characters
                        code = words[0].substring(0, 4).toUpperCase();
                    } else {
                        // Multiple words: take first letters
                        words.forEach(word => {
                            if (word.length > 0) {
                                code += word[0].toUpperCase();
                            }
                        });
                    }

                    // Limit to 6 characters max
                    code = code.substring(0, 6);
                    codeInput.value = code;
                }
            });

            // Form submission with validation
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Basic validation
                let isValid = true;
                let errorMessage = '';

                if (!companySelect.value) {
                    isValid = false;
                    errorMessage = 'Please select a company';
                    companySelect.focus();
                } else if (!nameInput.value.trim()) {
                    isValid = false;
                    errorMessage = 'Please enter a department name';
                    nameInput.focus();
                }

                // Validate active staff count is not greater than total staff
                const staffCount = parseInt(document.getElementById('staff_count').value) || 0;
                const activeStaffCount = parseInt(document.getElementById('active_staff_count').value) || 0;

                if (activeStaffCount > staffCount) {
                    isValid = false;
                    errorMessage = 'Active staff count cannot be greater than total staff count';
                    document.getElementById('active_staff_count').focus();
                }

                if (!isValid) {
                    showNotification(errorMessage, 'error');
                    return;
                }

                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = `
                    <svg class="animate-spin mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating...
                `;
                submitButton.disabled = true;

                // Submit the form
                form.submit();
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S to save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    form.requestSubmit();
                }

                // Esc to cancel/go back
                if (e.key === 'Escape') {
                    window.location.href = '{{ route('admin.departments.index') }}';
                }
            });

            // Real-time validation for staff counts
            const staffCountInput = document.getElementById('staff_count');
            const activeStaffCountInput = document.getElementById('active_staff_count');

            staffCountInput.addEventListener('input', function() {
                const staffCount = parseInt(this.value) || 0;
                const activeStaffCount = parseInt(activeStaffCountInput.value) || 0;

                if (activeStaffCount > staffCount) {
                    activeStaffCountInput.classList.add('border-red-300', 'text-red-900');
                    activeStaffCountInput.classList.remove('border-gray-300');
                } else {
                    activeStaffCountInput.classList.remove('border-red-300', 'text-red-900');
                    activeStaffCountInput.classList.add('border-gray-300');
                }
            });

            activeStaffCountInput.addEventListener('input', function() {
                const staffCount = parseInt(staffCountInput.value) || 0;
                const activeStaffCount = parseInt(this.value) || 0;

                if (activeStaffCount > staffCount) {
                    this.classList.add('border-red-300', 'text-red-900');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-300', 'text-red-900');
                    this.classList.add('border-gray-300');
                }
            });
        });

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

        function redirectToList() {
            window.location.href = '{{ route('admin.departments.index') }}';
        }

        // Handle form submission success
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('{{ session('success') }}', 'success');
            });
        @endif

        // Handle form errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                // Scroll to first error
                const firstError = document.querySelector('.text-red-600');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                // Show notification for general errors
                @if ($errors->has('general'))
                    showNotification('{{ $errors->first('general') }}', 'error');
                @endif
            });
        @endif
    </script>
@endpush
