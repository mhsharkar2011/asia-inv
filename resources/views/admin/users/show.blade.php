@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6">
        <!-- Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center space-x-4 mb-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div class="h-6 w-0.5 bg-gray-300"></div>
                    <nav class="flex items-center text-sm">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">Users</a>
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                    </nav>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-4">
                            @if ($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                    class="h-20 w-20 rounded-2xl object-cover ring-4 ring-white shadow-lg">
                            @else
                                <div
                                    class="h-20 w-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                                    flex items-center justify-center text-white text-3xl font-bold ring-4 ring-white shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="mt-2 text-gray-600">{{ $user->email }}</p>
                                <div class="mt-3 flex items-center space-x-3">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $statusColors[$user->is_active ? 'active' : 'inactive'] }}">
                                        @if ($user->is_active)
                                            <span class="h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                        @else
                                            <span class="h-2 w-2 rounded-full bg-red-500 mr-2"></span>
                                        @endif
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Unverified
                                        </span>
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Member since {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium
                                  text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700
                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                  transition-all duration-200 shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit User
                        </a>
                        <button onclick="showDeleteModal()"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-medium
                                  text-white bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700
                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                  transition-all duration-200 shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Left Column - User Information -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center">
                                <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Basic Information</h2>
                                    <p class="text-sm text-gray-600 mt-1">Personal details and contact information</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Full Name -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900">Full Name</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900">Email Address</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="font-medium text-gray-900">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <!-- Phone -->
                                @if ($user->phone)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-900">Phone Number</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->phone }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Role -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900">Role</label>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span
                                            class="font-medium text-gray-900">{{ $user->role ? ucfirst($user->role) : 'No Role Assigned' }}</span>
                                    </div>
                                </div>

                                <!-- Address -->
                                @if ($user->address)
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="block text-sm font-semibold text-gray-900">Address</label>
                                        <div class="flex items-start p-4 bg-gray-50 rounded-xl">
                                            <svg class="h-5 w-5 text-gray-400 mr-3 mt-1" fill="none"
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
                            </div>
                        </div>
                    </div>

                    <!-- Company & Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                            <div class="flex items-center">
                                <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Company & Profile</h2>
                                    <p class="text-sm text-gray-600 mt-1">Company assignment and profile settings</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Company -->
                                @if ($user->company)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-900">Company</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->company->name }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Branch -->
                                @if ($user->branch)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-900">Branch</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="font-medium text-gray-900">{{ $user->branch->name }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Language Preference -->
                                @if ($user->language_preference)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-900">Language
                                            Preference</label>
                                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                            <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
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
                                                class="font-medium text-gray-900">{{ $languages[$user->language_preference] ?? $user->language_preference }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($user->bio)
                                <div class="mt-8 space-y-2">
                                    <label class="block text-sm font-semibold text-gray-900">Bio</label>
                                    <div class="p-4 bg-gray-50 rounded-xl">
                                        <p class="text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Stats & Activity -->
                <div class="lg:col-span-4 mt-8 lg:mt-0 space-y-8">
                    <!-- User Stats Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-violet-50">
                            <div class="flex items-center">
                                <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">User Statistics</h2>
                                    <p class="text-sm text-gray-600 mt-1">Activity and engagement metrics</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Posts Count -->
                                <div class="text-center">
                                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl">
                                        <div class="text-3xl font-bold text-blue-600">{{ $user->posts_count ?? 0 }}</div>
                                        <div class="text-sm text-gray-600 mt-1">Posts</div>
                                    </div>
                                </div>

                                <!-- Comments Count -->
                                <div class="text-center">
                                    <div class="p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl">
                                        <div class="text-3xl font-bold text-green-600">{{ $user->comments_count ?? 0 }}
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">Comments</div>
                                    </div>
                                </div>

                                <!-- Activities Count -->
                                <div class="text-center">
                                    <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl">
                                        <div class="text-3xl font-bold text-amber-600">{{ $user->activities_count ?? 0 }}
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">Activities</div>
                                    </div>
                                </div>

                                <!-- Logins Count -->
                                <div class="text-center">
                                    <div class="p-4 bg-gradient-to-br from-purple-50 to-violet-50 rounded-2xl">
                                        <div class="text-3xl font-bold text-purple-600">{{ $user->logins_count ?? 0 }}
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">Logins</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Timeline Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">Recent Activity</h2>
                                        <p class="text-sm text-gray-600 mt-1">Latest user actions</p>
                                    </div>
                                </div>
                                @if ($user->activities && $user->activities->count() > 5)
                                    <a href="{{ route('admin.users.activities', $user) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        View All
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="p-8">
                            @if ($user->activities && $user->activities->count() > 0)
                                <div class="space-y-6">
                                    @foreach ($user->activities->take(5) as $activity)
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-1">
                                                <div class="h-4 w-4 rounded-full bg-blue-500"></div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $activity->description }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-4 text-sm text-gray-500">No recent activity</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Status Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-cyan-50 to-blue-50">
                            <div class="flex items-center">
                                <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Account Status</h2>
                                    <p class="text-sm text-gray-600 mt-1">Timeline and verification status</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Account Created:</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $user->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Last Updated:</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $user->updated_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>

                                @if ($user->last_login_at)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Last Login:</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $user->last_login_at->format('M d, Y h:i A') }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Last Login IP:</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $user->last_login_ip ?? 'N/A' }}
                                        </span>
                                    </div>
                                @endif

                                @if ($user->email_verified_at)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Email Verified:</span>
                                        <span class="text-sm font-medium text-green-600">
                                            {{ $user->email_verified_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="sticky top-8 space-y-4">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent
                                   rounded-xl text-base font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600
                                   hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                   focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit User
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="w-full inline-flex items-center justify-center px-6 py-4 border border-gray-300
                                  rounded-xl text-base font-medium text-gray-700 bg-white hover:bg-gray-50
                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                                  transition-all duration-200 shadow-sm hover:shadow">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Users
                        </a>

                        <div class="pt-6 border-t border-gray-200">
                            <div class="text-center space-y-3">
                                <p class="text-sm text-gray-500">
                                    Need to reset password?
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Send reset link
                                    </a>
                                </p>
                                <div class="text-xs text-gray-400">
                                    User ID: {{ $user->id }}
                                </div>
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
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true">
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-8 pt-8 pb-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-gradient-to-r from-red-100 to-pink-100 sm:mx-0 sm:h-12 sm:w-12">
                            <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left">
                            <h3 class="text-xl font-bold text-gray-900" id="modal-title">
                                Delete User Account
                            </h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">
                                    Are you sure you want to delete <span
                                        class="font-semibold">{{ $user->name }}</span>'s account? This action cannot be
                                    undone.
                                </p>
                                @if ($user->is_active)
                                    <div class="mt-4 p-4 bg-red-50 rounded-xl">
                                        <p class="text-sm text-red-700">
                                            ⚠️ This user is currently active. Deleting their account will immediately revoke
                                            all access.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-8 py-6 sm:px-8 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-5 py-3 border border-transparent
                                   rounded-xl text-base font-medium text-white bg-gradient-to-r from-red-500 to-pink-600
                                   hover:from-red-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                   focus:ring-red-500 transition-all duration-200 shadow-sm hover:shadow sm:ml-3 sm:w-auto">
                            Delete Account
                        </button>
                    </form>
                    <button type="button" onclick="hideDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center items-center px-5 py-3 border border-gray-300
                               rounded-xl text-base font-medium text-gray-700 bg-white hover:bg-gray-50
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                               transition-all duration-200 shadow-sm hover:shadow sm:mt-0 sm:ml-3 sm:w-auto">
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

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
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
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('User Show Page - Initializing...');

            function showDeleteModal() {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function hideDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function showAlert(message, type = 'info') {
                // Create alert element
                const alert = document.createElement('div');
                alert.className =
                    `fixed top-6 right-6 z-50 px-5 py-4 rounded-xl shadow-xl ${type === 'error' ? 'bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-700' : 'bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 text-blue-700'}`;
                alert.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'error' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                        </svg>
                        <span class="font-medium">${message}</span>
                    </div>
                `;

                document.body.appendChild(alert);

                // Remove alert after 5 seconds
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            }

            // Show success/error messages from session
            @if (session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showAlert('{{ session('error') }}', 'error');
            @endif

            // Make functions globally available
            window.showDeleteModal = showDeleteModal;
            window.hideDeleteModal = hideDeleteModal;

            console.log('User Show Page - Initialization complete');
        });
    </script>
@endpush
