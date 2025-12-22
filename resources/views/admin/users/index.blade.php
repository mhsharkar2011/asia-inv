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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users Card -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
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
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
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
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
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
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">User List</h2>
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
                                    </div>
                                </div>
                            </div>

                            <button id="exportUsers"
                                class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="selectAllUsers"
                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company & Branch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Login</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="user-row hover:bg-gray-50 transition-colors duration-150"
                                    data-status="{{ $user->is_active ? '1' : '0' }}"
                                    data-role="{{ strtolower($user->role) }}">
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
                                                        alt="{{ $user->name }}">
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
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                            class="inline"
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
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle dropdown menus
        document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const menuId = this.id.replace('menu-button-', 'user-menu-');
                const menu = document.getElementById(menuId);
                const isVisible = menu.classList.contains('hidden');

                // Hide all other menus and dropdowns
                document.querySelectorAll('[id^="user-menu-"]').forEach(m => {
                    if (m.id !== menuId) {
                        m.classList.add('hidden');
                    }
                });

                // Hide filter dropdown if open
                const filterDropdown = document.getElementById('filterDropdown');
                if (filterDropdown) {
                    filterDropdown.classList.add('hidden');
                }

                // Toggle current menu
                if (isVisible) {
                    menu.classList.remove('hidden');
                } else {
                    menu.classList.add('hidden');
                }
            });
        });

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
        });

        // Search functionality
        const searchInput = document.getElementById('searchUsers');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.user-row');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Filter functionality
        const filterButton = document.getElementById('filterButton');
        const filterDropdown = document.getElementById('filterDropdown');

        if (filterButton && filterDropdown) {
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isVisible = !filterDropdown.classList.contains('hidden');

                // Close all user menus first
                document.querySelectorAll('[id^="user-menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });

                // Toggle filter dropdown
                if (isVisible) {
                    filterDropdown.classList.add('hidden');
                } else {
                    filterDropdown.classList.remove('hidden');
                }
            });

            // Add click listeners to filter options
            document.querySelectorAll('.filter-option').forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    const rows = document.querySelectorAll('.user-row');

                    rows.forEach(row => {
                        if (filterType === 'all') {
                            row.style.display = '';
                        } else if (filterType === 'active') {
                            row.style.display = row.getAttribute('data-status') === 'active' ? '' :
                                'none';
                        } else if (filterType === 'inactive') {
                            row.style.display = row.getAttribute('data-status') === 'inactive' ?
                                '' : 'none';
                        } else {
                            row.style.display = row.getAttribute('data-role') === filterType ? '' :
                                'none';
                        }
                    });

                    filterDropdown.classList.add('hidden');

                    // Update button text to show active filter
                    const filterText = this.textContent.trim();
                    filterButton.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    ${filterText}
                `;
                });
            });

            // Close filter dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (filterDropdown && !filterDropdown.contains(e.target) &&
                    filterButton && !filterButton.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
        }

        // Bulk selection
        const selectAll = document.getElementById('selectAllUsers');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }

        // Export users
        const exportBtn = document.getElementById('exportUsers');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                // Get selected user IDs
                const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedUsers.length > 0) {
                    // Export only selected users
                    const url = new URL('{{ route('admin.users.export') }}');
                    url.searchParams.append('users', selectedUsers.join(','));
                    window.location.href = url.toString();
                } else {
                    // Export all users
                    window.location.href = '{{ route('admin.users.export') }}';
                }
            });
        }

        // Show success message if exists
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
