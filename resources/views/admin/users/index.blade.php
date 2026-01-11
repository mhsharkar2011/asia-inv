@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                        <p class="text-gray-600 mt-1">Manage system users, roles, and permissions</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Bulk Actions Dropdown -->
                        <div class="relative hidden" id="bulkActionsContainer">
                            <button
                                class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                id="bulkActionsButton">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                Bulk Actions
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden"
                                id="bulkActionsDropdown">
                                <div class="py-1">
                                    <button type="button" id="bulkActivate"
                                        class="block w-full text-left px-4 py-2.5 text-sm text-green-700 hover:bg-green-50">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Activate Selected
                                    </button>
                                    <button type="button" id="bulkDeactivate"
                                        class="block w-full text-left px-4 py-2.5 text-sm text-amber-700 hover:bg-amber-50">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 12H6" />
                                        </svg>
                                        Deactivate Selected
                                    </button>
                                    <button type="button" id="bulkDelete"
                                        class="block w-full text-left px-4 py-2.5 text-sm text-red-700 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Selected
                                    </button>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <button type="button" id="bulkExport"
                                        class="block w-full text-left px-4 py-2.5 text-sm text-blue-700 hover:bg-blue-50">
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export Selected
                                    </button>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.users.create') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New User
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Total Users Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                    onclick="filterUsers('all')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                            <div class="flex items-center mt-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $activeUsersPercentage }}% active
                                </span>
                            </div>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Users Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                    onclick="filterUsers('active')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Active Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeUsers }}</p>
                            <p class="text-sm text-gray-500 mt-4">{{ $todayLogins }} logged in today</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Admin Users Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                    onclick="filterUsers('admin')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Admin Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $adminUsers }}</p>
                            <p class="text-sm text-gray-500 mt-4">{{ $adminPercentage }}% of total</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg">
                            <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Unverified Users Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                    onclick="filterUsers('unverified')">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Unverified Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $unverifiedUsers }}</p>
                            <p class="text-sm text-gray-500 mt-4">{{ $unverifiedPercentage }}% of total</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Recent Activity</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $recentActivity }}</p>
                            <p class="text-sm text-gray-500 mt-4">Last 24 hours</p>
                        </div>
                        <div class="p-3 bg-cyan-50 rounded-lg">
                            <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 pb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div id="selectedCount" class="text-sm text-gray-600 hidden">
                                <span class="font-medium" id="selectedCountNumber">0</span> users selected
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" id="searchUsers"
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64 text-sm"
                                    placeholder="Search users...">
                            </div>

                            <div class="relative">
                                <button
                                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    id="filterButton">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden"
                                    id="filterDropdown">
                                    <div class="py-1">
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="all">All Users</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="active">Active Only</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="inactive">Inactive Only</a>
                                        <div class="border-t border-gray-200 my-1"></div>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="admin">Admin Users</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="manager">Manager Users</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="user">Regular Users</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="viewer">Viewer Users</a>
                                        <div class="border-t border-gray-200 my-1"></div>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="verified">Verified Email</a>
                                        <a href="#"
                                            class="filter-option block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                                            data-filter="unverified">Unverified Email</a>
                                    </div>
                                </div>
                            </div>

                            <button id="exportUsers"
                                class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export All
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left" style="width: 40px;">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="selectAllUsers"
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                    onclick="sortTable('name')">
                                    <div class="flex items-center">
                                        User
                                        <svg class="w-4 h-4 ml-1 sort-icon" data-column="name" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                    onclick="sortTable('role')">
                                    <div class="flex items-center">
                                        Role
                                        <svg class="w-4 h-4 ml-1 sort-icon" data-column="role" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company & Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                    onclick="sortTable('last_login')">
                                    <div class="flex items-center">
                                        Last Login
                                        <svg class="w-4 h-4 ml-1 sort-icon" data-column="last_login" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                            @forelse($users as $user)
                                <tr class="user-row hover:bg-gray-50 transition-colors duration-150"
                                    data-id="{{ $user->id }}"
                                    data-status="{{ $user->is_active ? 'active' : 'inactive' }}"
                                    data-role="{{ strtolower($user->role) }}"
                                    data-verified="{{ $user->email_verified_at ? 'verified' : 'unverified' }}"
                                    data-name="{{ strtolower($user->name) }}"
                                    data-email="{{ strtolower($user->email) }}"
                                    data-last-login="{{ $user->last_login_at ? $user->last_login_at->timestamp : 0 }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox"
                                            class="user-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                            value="{{ $user->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if ($user->avatar)
                                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white"
                                                        src="{{ asset('storage/' . $user->avatar) }}"
                                                        alt="{{ $user->name }}"
                                                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%236b7280\'%3E%3Cpath d=\'M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z\'/%3E%3C/svg%3E'">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold ring-2 ring-white">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                <div class="flex items-center mt-1 space-x-3">
                                                    <span class="inline-flex items-center text-xs text-gray-500">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        ID: {{ $user->id }}
                                                    </span>
                                                    @if ($user->phone)
                                                        <span class="inline-flex items-center text-xs text-gray-500">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                            </svg>
                                                            {{ $user->phone }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleConfig = [
                                                'admin' => [
                                                    'color' => 'bg-red-100 text-red-800',
                                                    'icon' => 'shield-check',
                                                ],
                                                'manager' => [
                                                    'color' => 'bg-amber-100 text-amber-800',
                                                    'icon' => 'briefcase',
                                                ],
                                                'user' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'user'],
                                                'viewer' => [
                                                    'color' => 'bg-green-100 text-green-800',
                                                    'icon' => 'eye',
                                                ],
                                                'super_admin' => [
                                                    'color' => 'bg-purple-100 text-purple-800',
                                                    'icon' => 'star',
                                                ],
                                            ];
                                            $role = strtolower($user->role);
                                            $config = $roleConfig[$role] ?? [
                                                'color' => 'bg-gray-100 text-gray-800',
                                                'icon' => 'user',
                                            ];
                                        @endphp
                                        <div class="inline-flex flex-col space-y-1">
                                            <span
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ $config['color'] }}">
                                                @if (isset($config['icon']))
                                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        @if ($config['icon'] == 'shield-check')
                                                            <path fill-rule="evenodd"
                                                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd" />
                                                        @elseif($config['icon'] == 'briefcase')
                                                            <path fill-rule="evenodd"
                                                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                                                clip-rule="evenodd" />
                                                        @elseif($config['icon'] == 'eye')
                                                            <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                                                clip-rule="evenodd" />
                                                            <path fill-rule="evenodd"
                                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                clip-rule="evenodd" />
                                                        @elseif($config['icon'] == 'star')
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        @else
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd" />
                                                        @endif
                                                    </svg>
                                                @endif
                                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if ($user->company)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $user->company->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 italic">No company</span>
                                            @endif

                                            @if ($user->branch)
                                                <div class="flex items-center ml-4">
                                                    <svg class="w-3 h-3 text-gray-400 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-xs text-gray-500">{{ $user->branch->name }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->last_login_at)
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm text-gray-900">{{ $user->last_login_at->format('d/m/Y H:i') }}</span>
                                                <span
                                                    class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500 italic">Never logged in</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if ($user->is_active)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Inactive
                                                </span>
                                            @endif
                                            @if ($user->email_verified_at)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Verified
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Unverified
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors duration-200"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <div class="relative inline-block text-left">
                                                <button
                                                    class="inline-flex items-center p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                                    id="menu-button-{{ $user->id }}">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                    </svg>
                                                </button>
                                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10 hidden"
                                                    id="user-menu-{{ $user->id }}">
                                                    <div class="py-1">
                                                        @can('impersonate', $user)
                                                            <a href="{{ route('admin.users.impersonate', $user) }}"
                                                                class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100">
                                                                <svg class="w-4 h-4 mr-2 inline" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                                </svg>
                                                                Login As User
                                                            </a>
                                                        @endcan
                                                        @if ($user->is_active)
                                                            <form action="{{ route('admin.users.deactivate', $user) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="block w-full text-left px-4 py-2.5 text-sm text-amber-700 hover:bg-amber-50">
                                                                    <svg class="w-4 h-4 mr-2 inline" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    Deactivate
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.users.activate', $user) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="block w-full text-left px-4 py-2.5 text-sm text-green-700 hover:bg-green-50">
                                                                    <svg class="w-4 h-4 mr-2 inline" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    Activate
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if (!$user->email_verified_at)
                                                            <form action="{{ route('admin.users.verify-email', $user) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="block w-full text-left px-4 py-2.5 text-sm text-cyan-700 hover:bg-cyan-50">
                                                                    <svg class="w-4 h-4 mr-2 inline" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd"
                                                                            d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 7.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 14.798l-4.445-2.963z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                    Verify Email
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <div class="border-t border-gray-200 my-1"></div>
                                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="block w-full text-left px-4 py-2.5 text-sm text-red-700 hover:bg-red-50">
                                                                <svg class="w-4 h-4 mr-2 inline" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Delete User
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="max-w-sm mx-auto">
                                            <div
                                                class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                            <p class="text-gray-500 mb-6">Create your first user to get started</p>
                                            <a href="{{ route('admin.users.create') }}"
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Add User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $users->firstItem() }}</span> to <span
                                    class="font-medium">{{ $users->lastItem() }}</span> of <span
                                    class="font-medium">{{ $users->total() }}</span> users
                            </div>
                            <div>
                                {{ $users->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bulk Delete Modal -->
        <div id="bulkDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.914-.833-2.684 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center">
                            <h3 class="text-lg font-medium text-gray-900">Delete Users</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete <span id="selectedCountModal"
                                        class="font-semibold">0</span> selected users? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center space-x-3">
                            <button type="button" id="cancelBulkDelete"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <form id="bulkDeleteForm" method="POST" action="{{ route('admin.users.bulk-delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="users" id="bulkDeleteUsers">
                                <button type="submit"
                                    class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentSort = {
            column: null,
            direction: 'asc'
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initBulkActions();
            initSorting();
        });

        // Bulk actions functionality
        function initBulkActions() {
            const selectAll = document.getElementById('selectAllUsers');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const bulkActionsContainer = document.getElementById('bulkActionsContainer');
            const bulkActionsButton = document.getElementById('bulkActionsButton');
            const bulkActionsDropdown = document.getElementById('bulkActionsDropdown');
            const selectedCount = document.getElementById('selectedCount');
            const selectedCountNumber = document.getElementById('selectedCountNumber');

            // Select all functionality
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    userCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCount();
                });
            }

            // Individual checkbox change
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Update selected count
            function updateSelectedCount() {
                const selected = document.querySelectorAll('.user-checkbox:checked');
                const count = selected.length;

                selectedCountNumber.textContent = count;

                if (count > 0) {
                    selectedCount.classList.remove('hidden');
                    bulkActionsContainer.classList.remove('hidden');
                } else {
                    selectedCount.classList.add('hidden');
                    bulkActionsContainer.classList.add('hidden');
                }

                // Update select all checkbox
                if (selectAll) {
                    selectAll.checked = count === userCheckboxes.length;
                    selectAll.indeterminate = count > 0 && count < userCheckboxes.length;
                }
            }

            // Toggle bulk actions dropdown
            if (bulkActionsButton && bulkActionsDropdown) {
                bulkActionsButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isVisible = !bulkActionsDropdown.classList.contains('hidden');

                    // Close all other dropdowns
                    document.querySelectorAll('[id^="user-menu-"]').forEach(menu => {
                        menu.classList.add('hidden');
                    });

                    const filterDropdown = document.getElementById('filterDropdown');
                    if (filterDropdown) {
                        filterDropdown.classList.add('hidden');
                    }

                    // Toggle current dropdown
                    if (isVisible) {
                        bulkActionsDropdown.classList.add('hidden');
                    } else {
                        bulkActionsDropdown.classList.remove('hidden');
                    }
                });
            }

            // Bulk activate
            document.getElementById('bulkActivate')?.addEventListener('click', function() {
                const selected = getSelectedUserIds();
                if (selected.length > 0) {
                    if (confirm(`Activate ${selected.length} selected user(s)?`)) {
                        submitBulkAction('{{ route('admin.users.bulk-activate') }}', selected);
                    }
                }
            });

            // Bulk deactivate
            document.getElementById('bulkDeactivate')?.addEventListener('click', function() {
                const selected = getSelectedUserIds();
                if (selected.length > 0) {
                    if (confirm(`Deactivate ${selected.length} selected user(s)?`)) {
                        submitBulkAction('{{ route('admin.users.bulk-deactivate') }}', selected);
                    }
                }
            });

            // Bulk delete
            document.getElementById('bulkDelete')?.addEventListener('click', function() {
                const selected = getSelectedUserIds();
                if (selected.length > 0) {
                    document.getElementById('selectedCountModal').textContent = selected.length;
                    document.getElementById('bulkDeleteUsers').value = selected.join(',');
                    document.getElementById('bulkDeleteModal').classList.remove('hidden');
                }
            });

            // Bulk export
            document.getElementById('bulkExport')?.addEventListener('click', function() {
                const selected = getSelectedUserIds();
                const url = new URL('{{ route('admin.users.export') }}');

                if (selected.length > 0) {
                    url.searchParams.append('users', selected.join(','));
                }

                window.location.href = url.toString();
            });

            // Close bulk delete modal
            document.getElementById('cancelBulkDelete')?.addEventListener('click', function() {
                document.getElementById('bulkDeleteModal').classList.add('hidden');
            });

            // Get selected user IDs
            function getSelectedUserIds() {
                return Array.from(document.querySelectorAll('.user-checkbox:checked'))
                    .map(checkbox => checkbox.value);
            }

            // Submit bulk action
            function submitBulkAction(url, userIds) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';

                const usersInput = document.createElement('input');
                usersInput.type = 'hidden';
                usersInput.name = 'users';
                usersInput.value = userIds.join(',');

                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                form.appendChild(usersInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Table sorting
        function initSorting() {
            document.querySelectorAll('.sort-icon').forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const column = this.getAttribute('data-column');
                    sortTable(column);
                });
            });
        }

        function sortTable(column) {
            const rows = Array.from(document.querySelectorAll('.user-row'));
            const tbody = document.getElementById('usersTableBody');

            if (!tbody) return;

            // Determine sort direction
            let direction = 'asc';
            if (currentSort.column === column) {
                direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            }

            // Sort rows
            rows.sort((a, b) => {
                let aValue, bValue;

                switch (column) {
                    case 'name':
                        aValue = a.getAttribute('data-name');
                        bValue = b.getAttribute('data-name');
                        break;
                    case 'role':
                        aValue = a.getAttribute('data-role');
                        bValue = b.getAttribute('data-role');
                        break;
                    case 'last_login':
                        aValue = parseInt(a.getAttribute('data-last-login'));
                        bValue = parseInt(b.getAttribute('data-last-login'));
                        break;
                    default:
                        aValue = a.getAttribute(`data-${column}`);
                        bValue = b.getAttribute(`data-${column}`);
                }

                if (direction === 'asc') {
                    return aValue > bValue ? 1 : -1;
                } else {
                    return aValue < bValue ? 1 : -1;
                }
            });

            // Update table
            rows.forEach(row => tbody.appendChild(row));

            // Update sort indicators
            updateSortIndicators(column, direction);

            // Save current sort state
            currentSort = {
                column,
                direction
            };
        }

        function updateSortIndicators(column, direction) {
            document.querySelectorAll('.sort-icon').forEach(icon => {
                const iconColumn = icon.getAttribute('data-column');
                if (iconColumn === column) {
                    icon.style.transform = direction === 'asc' ? 'rotate(180deg)' : 'rotate(0deg)';
                    icon.classList.add('text-blue-600');
                } else {
                    icon.style.transform = 'rotate(0deg)';
                    icon.classList.remove('text-blue-600');
                }
            });
        }

        // Filter users from statistics cards
        function filterUsers(filterType) {
            const rows = document.querySelectorAll('.user-row');
            const filterButton = document.getElementById('filterButton');

            rows.forEach(row => {
                if (filterType === 'all') {
                    row.style.display = '';
                } else if (filterType === 'active') {
                    row.style.display = row.getAttribute('data-status') === 'active' ? '' : 'none';
                } else if (filterType === 'inactive') {
                    row.style.display = row.getAttribute('data-status') === 'inactive' ? '' : 'none';
                } else if (filterType === 'admin') {
                    row.style.display = row.getAttribute('data-role') === 'admin' ? '' : 'none';
                } else if (filterType === 'unverified') {
                    row.style.display = row.getAttribute('data-verified') === 'unverified' ? '' : 'none';
                }
            });

            // Update filter button text
            if (filterButton) {
                const filterText = getFilterText(filterType);
                filterButton.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    ${filterText}
                `;
            }
        }

        function getFilterText(filterType) {
            const texts = {
                'all': 'All Users',
                'active': 'Active Only',
                'inactive': 'Inactive Only',
                'admin': 'Admin Users',
                'unverified': 'Unverified Users'
            };
            return texts[filterType] || 'Filter';
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Close user menus
            document.querySelectorAll('[id^="user-menu-"]').forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            // Close filter dropdown
            const filterDropdown = document.getElementById('filterDropdown');
            const filterButton = document.getElementById('filterButton');
            if (filterDropdown && filterButton &&
                !filterDropdown.contains(e.target) &&
                !filterButton.contains(e.target)) {
                filterDropdown.classList.add('hidden');
            }

            // Close bulk actions dropdown
            const bulkActionsDropdown = document.getElementById('bulkActionsDropdown');
            const bulkActionsButton = document.getElementById('bulkActionsButton');
            if (bulkActionsDropdown && bulkActionsButton &&
                !bulkActionsDropdown.contains(e.target) &&
                !bulkActionsButton.contains(e.target)) {
                bulkActionsDropdown.classList.add('hidden');
            }

            // Close bulk delete modal
            const bulkDeleteModal = document.getElementById('bulkDeleteModal');
            if (bulkDeleteModal && !bulkDeleteModal.contains(e.target) &&
                e.target.id !== 'bulkDelete') {
                bulkDeleteModal.classList.add('hidden');
            }
        });

        // Search functionality
        const searchInput = document.getElementById('searchUsers');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.user-row');

                    rows.forEach(row => {
                        const name = row.getAttribute('data-name');
                        const email = row.getAttribute('data-email');
                        const shouldShow = name.includes(searchTerm) || email.includes(searchTerm);
                        row.style.display = shouldShow ? '' : 'none';
                    });
                }, 300);
            });
        }

        // Export all users
        const exportBtn = document.getElementById('exportUsers');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                window.location.href = '{{ route('admin.users.export') }}';
            });
        }

        // Toggle dropdown menus for individual users
        document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const menuId = this.id.replace('menu-button-', 'user-menu-');
                const menu = document.getElementById(menuId);
                const isVisible = !menu.classList.contains('hidden');

                // Hide all other menus and dropdowns
                document.querySelectorAll('[id^="user-menu-"]').forEach(m => {
                    if (m.id !== menuId) {
                        m.classList.add('hidden');
                    }
                });

                const filterDropdown = document.getElementById('filterDropdown');
                if (filterDropdown) {
                    filterDropdown.classList.add('hidden');
                }

                const bulkActionsDropdown = document.getElementById('bulkActionsDropdown');
                if (bulkActionsDropdown) {
                    bulkActionsDropdown.classList.add('hidden');
                }

                // Toggle current menu
                if (isVisible) {
                    menu.classList.add('hidden');
                } else {
                    menu.classList.remove('hidden');
                }
            });
        });

        // Show alerts
        @if (session('success'))
            showAlert('{{ session('success') }}', 'success');
        @endif

        @if (session('error'))
            showAlert('{{ session('error') }}', 'error');
        @endif

        function showAlert(message, type = 'success') {
            const alert = document.createElement('div');
            alert.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg ${
                type === 'success'
                    ? 'bg-green-50 border border-green-200 text-green-700'
                    : 'bg-red-50 border border-red-200 text-red-700'
            }`;
            alert.innerHTML = `
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success'
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                    </svg>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(alert);

            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
@endpush
