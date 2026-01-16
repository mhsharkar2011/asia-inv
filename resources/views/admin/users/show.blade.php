@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <!-- Breadcrumb -->
                <div class="flex items-center space-x-3 mb-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-900 transition-all duration-200 shadow-sm hover:shadow border border-gray-200 group">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Users
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-sm font-medium text-gray-700">User Details</span>
                </div>

                <!-- User Header -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex items-start space-x-6">
                                <!-- Avatar -->
                                <div class="relative">
                                    @if ($user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                            class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-xl">
                                    @else
                                        <div
                                            class="h-24 w-24 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                                                    flex items-center justify-center text-white text-4xl font-bold
                                                    ring-4 ring-white shadow-xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <!-- Status Badge -->
                                    <div class="absolute -bottom-2 -right-2">
                                        @if ($user->is_active)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border-2 border-white shadow">
                                                <span class="h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border-2 border-white shadow">
                                                <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- User Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                                            <div class="flex items-center flex-wrap gap-3 mb-4">
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                    </svg>
                                                    <span class="font-medium">{{ $user->email }}</span>
                                                </div>

                                                @if ($user->email_verified_at)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Verified
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Unverified
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ $user->posts_count ?? 0 }}
                                            </div>
                                            <div class="text-sm text-gray-500">Posts</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ $user->comments_count ?? 0 }}
                                            </div>
                                            <div class="text-sm text-gray-500">Comments</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ $user->activities_count ?? 0 }}
                                            </div>
                                            <div class="text-sm text-gray-500">Activities</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900">{{ $user->logins_count ?? 0 }}
                                            </div>
                                            <div class="text-sm text-gray-500">Logins</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600
                                           text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700
                                           transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit User
                                </a>
                                <button onclick="showDeleteModal()"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600
                                           text-white font-medium rounded-xl hover:from-red-600 hover:to-pink-700
                                           transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - User Information -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Personal Information</h2>
                                    <p class="text-gray-600 mt-2">Basic details and contact information</p>
                                </div>
                                <div class="p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="font-medium text-gray-900">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <!-- Phone -->
                                @if ($user->phone)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->phone }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Role -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-medium text-gray-900">
                                            @if($user->roles->count() > 0)
                                                {{ $user->roles->pluck('name')->join(', ') }}
                                            @else
                                                No Role Assigned
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <!-- Address -->
                                @if ($user->address)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                        <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-1" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->address }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Bio -->
                                @if ($user->bio)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <p class="text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Roles & Permissions Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Roles & Permissions</h2>
                                    <p class="text-gray-600 mt-2">User roles and assigned permissions</p>
                                </div>
                                <div class="p-3 bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Roles Section -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assigned Roles</h3>
                                @if($user->roles->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($user->roles as $role)
                                            <div class="bg-gradient-to-r from-purple-50 to-violet-50 border border-purple-100 rounded-xl p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        <div class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <span class="font-semibold text-gray-900">{{ $role->name }}</span>
                                                    </div>
                                                    <span class="text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded-full">
                                                        {{ $role->permissions->count() }} permissions
                                                    </span>
                                                </div>
                                                @if($role->description)
                                                    <p class="text-sm text-gray-600 mt-2">{{ $role->description }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No roles assigned</h3>
                                        <p class="mt-1 text-sm text-gray-500">This user doesn't have any roles yet.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Assign Roles
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Permissions Section -->
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Direct Permissions</h3>
                                    <span class="text-sm text-gray-500">
                                        {{ $user->getAllPermissions()->count() }} total permissions
                                    </span>
                                </div>

                                @php
                                    $permissions = $user->getAllPermissions()->groupBy(function($permission) {
                                        return explode(' ', $permission->name)[0] ?? 'other';
                                    });
                                @endphp

                                @if($user->getAllPermissions()->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($permissions as $group => $groupPermissions)
                                            <div class="bg-gray-50 rounded-xl p-4">
                                                <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wider">
                                                    {{ ucfirst($group) }}
                                                </h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                    @foreach($groupPermissions as $permission)
                                                        <div class="flex items-center bg-white rounded-lg px-3 py-2 border border-gray-200">
                                                            <div class="h-2 w-2 rounded-full bg-green-500 mr-3"></div>
                                                            <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">No direct permissions assigned</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline -->
                    @if ($user->activities && $user->activities->count() > 0)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="p-8">
                                <div class="flex items-center justify-between mb-8">
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900">Recent Activity</h2>
                                        <p class="text-gray-600 mt-2">Latest actions and events</p>
                                    </div>
                                    <div class="p-3 bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    @foreach ($user->activities->take(5) as $activity)
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-3 w-3 rounded-full bg-blue-500 mt-2"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->description }}
                                                </p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ optional($activity->created_at)->diffForHumans() ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($user->activities->count() > 5)
                                    <div class="mt-8 pt-6 border-t border-gray-100">
                                        <a href="{{ route('admin.users.activities', $user) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                            View all activities
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-8">
                    <!-- Account Timeline Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Account Timeline</h2>
                                    <p class="text-gray-600 mt-2">Important dates and events</p>
                                </div>
                                <div class="p-3 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl">
                                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- Created At -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Account Created</p>
                                            <p class="text-xs text-gray-500">
                                                {{ optional($user->created_at)->format('M d, Y \a\t h:i A') ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Updated At -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                            <p class="text-xs text-gray-500">
                                                {{ optional($user->updated_at)->format('M d, Y \a\t h:i A') ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Last Login -->
                                @if ($user->last_login_at)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-lg bg-gradient-to-br from-purple-50 to-violet-50 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Last Login</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ optional($user->last_login_at)->format('M d, Y \a\t h:i A') ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Email Verified -->
                                @if ($user->email_verified_at)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-lg bg-gradient-to-br from-emerald-50 to-green-50 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Email Verified</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ optional($user->email_verified_at)->format('M d, Y') ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Company & Profile Info -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">Company Info</h2>
                                    <p class="text-gray-600 mt-2">Organization details</p>
                                </div>
                                <div class="p-3 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>

                            <div class="space-y-6">
                                @if ($user->company)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->company->name }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($user->branch)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Branch</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->branch->name }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($user->language_preference)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Language
                                            Preference</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                            </svg>
                                            @php
                                                $languages = [
                                                    'en' => 'English',
                                                    'es' => 'Spanish',
                                                    'fr' => 'French',
                                                    'de' => 'German',
                                                    'zh' => 'Chinese',
                                                ];
                                            @endphp
                                            <span
                                                class="font-medium text-gray-900">{{ $languages[$user->language_preference] ?? ucfirst($user->language_preference) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="sticky top-8 space-y-4">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600
                                   text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700
                                   transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit User Profile
                        </a>

                        <!-- Manage Roles Button -->
                        <a href="{{ route('admin.users.roles.edit', $user) }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-purple-500 to-violet-600
                                   text-white font-medium rounded-xl hover:from-purple-600 hover:to-violet-700
                                   transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Manage Roles
                        </a>

                        <!-- Manage Permissions Button -->
                        <a href="{{ route('admin.users.permissions.edit', $user) }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-600
                                   text-white font-medium rounded-xl hover:from-emerald-600 hover:to-green-700
                                   transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Manage Permissions
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 bg-white border-2 border-gray-200
                                   text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300
                                   transition-all duration-200 shadow hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to All Users
                        </a>

                        <div class="pt-6 border-t border-gray-200 mt-6">
                            <div class="text-center">
                                <p class="text-sm text-gray-500 mb-4">Need to reset user password?</p>
                                <button onclick="sendPasswordReset()"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-600
                                           text-white text-sm font-medium rounded-xl hover:from-amber-600 hover:to-orange-700
                                           transition-all duration-200 shadow hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Send Password Reset Link
                                </button>
                                <p class="text-xs text-gray-400 mt-4">User ID: {{ $user->id }}</p>
                                <p class="text-xs text-gray-400">Total Permissions: {{ $user->getAllPermissions()->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true">
            </div>

            <div
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div
                            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-r from-red-100 to-pink-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900 leading-6" id="modal-title">
                            Delete User Account
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete <span
                                    class="font-semibold text-gray-900">{{ $user->name }}</span>'s account?
                                This action cannot be undone and all user data will be permanently removed.
                            </p>
                            @if ($user->is_active)
                                <div
                                    class="mt-4 p-4 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border border-red-100">
                                    <p class="text-sm text-red-700">
                                        ⚠️ <span class="font-semibold">Warning:</span> This user is currently active.
                                        Deleting their account will immediately revoke all access and permissions.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-5 py-3 border border-transparent
                                   text-base font-medium rounded-xl text-white bg-gradient-to-r from-red-500 to-pink-600
                                   hover:from-red-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                   focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Delete Account
                        </button>
                    </form>
                    <button type="button" onclick="hideDeleteModal()"
                        class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-gray-300
                               text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                               transition-all duration-200 shadow hover:shadow-lg">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functions
            function showDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                setTimeout(() => { modal.style.opacity = '1'; }, 10);
            }

            function hideDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }, 200);
            }

            // Send password reset
            async function sendPasswordReset() {
                try {
                    const response = await fetch('{{ route("admin.users.send-password-reset", $user) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAlert('Password reset link sent successfully!', 'success');
                    } else {
                        showAlert(result.message || 'Failed to send reset link', 'error');
                    }
                } catch (error) {
                    showAlert('An error occurred. Please try again.', 'error');
                }
            }

            // Alert notification function
            function showAlert(message, type = 'info') {
                const alert = document.createElement('div');
                alert.className = `
                    fixed top-6 right-6 z-50 px-5 py-4 rounded-xl shadow-xl transform transition-all duration-300
                    ${type === 'success' ? 'bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800' :
                      type === 'error' ? 'bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800' :
                      'bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 text-blue-800'}
                `;

                alert.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                             type === 'error' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                        </svg>
                        <span class="font-medium">${message}</span>
                    </div>
                `;

                document.body.appendChild(alert);

                setTimeout(() => { alert.style.transform = 'translateX(0)'; }, 10);

                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => { alert.remove(); }, 300);
                }, 5000);
            }

            // Show session messages
            @if (session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showAlert('{{ session('error') }}', 'error');
            @endif

            // Global functions
            window.showDeleteModal = showDeleteModal;
            window.hideDeleteModal = hideDeleteModal;
            window.sendPasswordReset = sendPasswordReset;
            window.showAlert = showAlert;
        });
    </script>
@endpush
