@extends('layouts.admin')

@section('title', 'Edit User')

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
                        <span class="text-gray-900 font-medium">Edit {{ $user->name }}</span>
                    </nav>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-4">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                    class="h-16 w-16 rounded-2xl object-cover ring-4 ring-white shadow-lg">
                            @else
                                <div
                                    class="h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                                            flex items-center justify-center text-white text-2xl font-bold
                                            ring-4 ring-white shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                                <p class="mt-2 text-gray-600">Update user information and permissions</p>
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
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        Member since {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium
                                  text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2
                                  focus:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Profile
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

        <!-- Main Form -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
                id="editUserForm">
                @csrf
                @method('PUT')

                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <!-- Left Column - Main Information -->
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
                                        <label for="name" class="block text-sm font-semibold text-gray-900">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-all duration-200 hover:border-gray-400"
                                                placeholder="John Doe" required>
                                        </div>
                                        @error('name')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label for="email" class="block text-sm font-semibold text-gray-900">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                </svg>
                                            </div>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-all duration-200 hover:border-gray-400"
                                                placeholder="john@example.com" required>
                                        </div>
                                        @error('email')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="space-y-2">
                                        <label for="phone" class="block text-sm font-semibold text-gray-900">
                                            Phone Number
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                            </div>
                                            <input type="tel" name="phone" id="phone"
                                                value="{{ old('phone', $user->phone) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-all duration-200 hover:border-gray-400"
                                                placeholder="+1 (555) 123-4567">
                                        </div>
                                        @error('phone')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="space-y-2">
                                        <label for="role" class="block text-sm font-semibold text-gray-900">
                                            Role <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <select name="role" id="role"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                           transition-all duration-200 hover:border-gray-400 appearance-none"
                                                required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('role')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="md:col-span-2 space-y-2">
                                        <label for="address" class="block text-sm font-semibold text-gray-900">
                                            Address
                                        </label>
                                        <div class="relative">
                                            <div class="absolute top-3 left-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <textarea name="address" id="address" rows="3"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                             transition-all duration-200 hover:border-gray-400"
                                                placeholder="Enter full address">{{ old('address', $user->address) }}</textarea>
                                        </div>
                                        @error('address')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
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
                                    <div class="space-y-2">
                                        <label for="company_id" class="block text-sm font-semibold text-gray-900">
                                            Company
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <select name="company_id" id="company_id"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                           transition-all duration-200 hover:border-gray-400 appearance-none">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('company_id')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Branch -->
                                    <div class="space-y-2">
                                        <label for="branch_id" class="block text-sm font-semibold text-gray-900">
                                            Branch
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <select name="branch_id" id="branch_id"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                           transition-all duration-200 hover:border-gray-400 appearance-none">
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        data-company="{{ $branch->company_id }}"
                                                        {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('branch_id')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Avatar Upload -->
                                    <div class="md:col-span-2 space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                                Profile Picture
                                            </label>
                                            <div class="flex items-start space-x-6">
                                                <div class="relative group">
                                                    @if ($user->avatar)
                                                        <img id="avatar-preview"
                                                            src="{{ asset('storage/' . $user->avatar) }}"
                                                            alt="Avatar preview"
                                                            class="h-32 w-32 rounded-2xl object-cover ring-4 ring-white shadow-lg">
                                                    @else
                                                        <div id="avatar-preview"
                                                            class="h-32 w-32 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                                                                    flex items-center justify-center text-white text-4xl font-bold
                                                                    ring-4 ring-white shadow-lg">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div id="avatar-remove"
                                                        class="absolute -top-2 -right-2 bg-gradient-to-r from-red-500 to-pink-600
                                                                text-white rounded-full p-2 cursor-pointer opacity-0 group-hover:opacity-100
                                                                transition-opacity duration-200 shadow-lg">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                                        class="hidden" onchange="previewAvatar(this)">
                                                    <label for="avatar"
                                                        class="inline-flex items-center px-5 py-3.5 border-2 border-dashed border-gray-300
                                                                  rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50
                                                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                                                  transition-all duration-200 cursor-pointer hover:border-gray-400">
                                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Upload New Photo
                                                    </label>
                                                    <p class="mt-3 text-sm text-gray-500">
                                                        JPG, PNG or GIF (Max 2MB). Recommended size: 400x400px
                                                    </p>
                                                    @if ($user->avatar)
                                                        <p class="mt-2 text-xs text-gray-400">
                                                            Current: {{ basename($user->avatar) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            @error('avatar')
                                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Language Preference -->
                                        <div class="pt-4 border-t border-gray-100">
                                            <label for="language_preference"
                                                class="block text-sm font-semibold text-gray-900 mb-2">
                                                Language Preference
                                            </label>
                                            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                                                @foreach (['en' => 'English', 'es' => 'Spanish', 'fr' => 'French', 'de' => 'German', 'zh' => 'Chinese'] as $code => $name)
                                                    <label class="relative flex cursor-pointer">
                                                        <input type="radio" name="language_preference"
                                                            value="{{ $code }}"
                                                            {{ old('language_preference', $user->language_preference) == $code ? 'checked' : '' }}
                                                            class="sr-only peer">
                                                        <div
                                                            class="w-full py-3 px-4 border-2 border-gray-200 rounded-xl
                                                                    text-sm font-medium text-gray-700 text-center
                                                                    peer-checked:border-blue-500 peer-checked:bg-blue-50
                                                                    peer-checked:text-blue-700 hover:bg-gray-50
                                                                    transition-all duration-200">
                                                            {{ $name }}
                                                        </div>
                                                        <div
                                                            class="absolute -top-2 -right-2 w-5 h-5 bg-blue-500 rounded-full
                                                                    flex items-center justify-center text-white text-xs
                                                                    opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                                            ✓
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('language_preference')
                                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Status & Actions -->
                    <div class="lg:col-span-4 mt-8 lg:mt-0 space-y-8">
                        <!-- Status & Actions Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                                <div class="flex items-center">
                                    <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">Status & Actions</h2>
                                        <p class="text-sm text-gray-600 mt-1">Account status and quick actions</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="space-y-6">
                                    <!-- Account Status -->
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-900">Account Status</label>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                            <div class="flex items-center">
                                                @if ($user->is_active)
                                                    <div class="h-3 w-3 rounded-full bg-green-500 mr-3 animate-pulse">
                                                    </div>
                                                    <span class="font-medium text-gray-900">Active</span>
                                                @else
                                                    <div class="h-3 w-3 rounded-full bg-red-500 mr-3"></div>
                                                    <span class="font-medium text-gray-900">Inactive</span>
                                                @endif
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="is_active" value="1"
                                                    class="sr-only peer"
                                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                                          peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full
                                                          peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px]
                                                          after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full
                                                          after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </div>
                                        @error('is_active')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Verification -->
                                    <div class="space-y-3">
                                        <label class="block text-sm font-semibold text-gray-900">Email Verification</label>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                            <div class="flex items-center">
                                                @if ($user->email_verified_at)
                                                    <div class="h-3 w-3 rounded-full bg-green-500 mr-3"></div>
                                                    <div>
                                                        <span class="font-medium text-gray-900">Verified</span>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $user->email_verified_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="h-3 w-3 rounded-full bg-yellow-500 mr-3"></div>
                                                    <span class="font-medium text-gray-900">Pending Verification</span>
                                                @endif
                                            </div>
                                            @if (!$user->email_verified_at)
                                                <button type="button" onclick="verifyEmail()"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg
                                                               text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                    Verify Now
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Last Login -->
                                    <div class="pt-6 border-t border-gray-100">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-4">Activity</h4>
                                        <div class="space-y-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Last Login:</span>
                                                <span class="text-sm font-medium text-gray-900">
                                                    @if ($user->last_login_at)
                                                        {{ $user->last_login_at->diffForHumans() }}
                                                    @else
                                                        Never
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Account Created:</span>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Last Updated:</span>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $user->updated_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Update Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-violet-50">
                                <div class="flex items-center">
                                    <div class="p-3 bg-white rounded-xl shadow-sm mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-gray-900">Password Update</h2>
                                        <p class="text-sm text-gray-600 mt-1">Change user password (optional)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="space-y-6">
                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label for="password" class="block text-sm font-medium text-gray-900">
                                            New Password (Optional)
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <input type="password" name="password" id="password"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-all duration-200 hover:border-gray-400"
                                                placeholder="Leave blank to keep current">
                                            <button type="button" onclick="togglePassword('password')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <svg id="password-eye" class="h-5 w-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="space-y-2">
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-900">
                                            Confirm Password
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl
                                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                                          transition-all duration-200 hover:border-gray-400"
                                                placeholder="Confirm new password">
                                            <button type="button" onclick="togglePassword('password_confirmation')"
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <svg id="password_confirmation-eye" class="h-5 w-5" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                        @error('password_confirmation')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="pt-4 border-t border-gray-100">
                                        <p class="text-xs text-gray-500">
                                            <svg class="w-4 h-4 inline mr-1 text-blue-500" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Password must be at least 8 characters. Leave blank to keep current password.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="sticky top-8 space-y-4">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent
                                           rounded-xl text-base font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600
                                           hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                           focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update User
                            </button>

                            <a href="{{ route('admin.users.index') }}"
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-gray-300
                                      rounded-xl text-base font-medium text-gray-700 bg-white hover:bg-gray-50
                                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                                      transition-all duration-200 shadow-sm hover:shadow">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>

                            <div class="pt-6 border-t border-gray-200">
                                <div class="text-center space-y-3">
                                    <p class="text-sm text-gray-500">
                                        Need help?
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                                            View user documentation
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
            </form>
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
            console.log('User Edit Form - Initializing...');

            // Elements
            const companieselect = document.getElementById('company_id');
            const branchSelect = document.getElementById('branch_id');
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarRemove = document.getElementById('avatar-remove');
            const editUserForm = document.getElementById('editUserForm');

            // Initialize branch filtering
            if (companieselect && branchSelect) {
                filterBranches();

                companieselect.addEventListener('change', function() {
                    filterBranches();
                });
            }

            // Avatar removal
            if (avatarRemove) {
                avatarRemove.addEventListener('click', function(e) {
                    e.preventDefault();
                    avatarInput.value = '';

                    // Show initials instead
                    const name = document.getElementById('name').value || '{{ $user->name }}';
                    const initial = name.charAt(0).toUpperCase();

                    avatarPreview.src = '';
                    avatarPreview.className =
                        'h-32 w-32 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-4xl font-bold ring-4 ring-white shadow-lg';
                    avatarPreview.innerHTML = initial;
                    avatarRemove.classList.add('opacity-0');

                    // Add a hidden input to indicate avatar removal
                    let removeInput = document.getElementById('remove_avatar');
                    if (!removeInput) {
                        removeInput = document.createElement('input');
                        removeInput.type = 'hidden';
                        removeInput.name = 'remove_avatar';
                        removeInput.id = 'remove_avatar';
                        removeInput.value = '1';
                        editUserForm.appendChild(removeInput);
                    }
                });
            }

            // Form validation
            if (editUserForm) {
                editUserForm.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    }
                });
            }

            // Functions
            function filterBranches() {
                const selectedCompany = companieselect.value;
                const branches = branchSelect.querySelectorAll('option');

                // Enable/disable branch select
                if (selectedCompany) {
                    branchSelect.disabled = false;
                } else {
                    branchSelect.disabled = true;
                    branchSelect.value = '';
                    return;
                }

                // Filter branches
                let hasVisibleBranches = false;
                branches.forEach(option => {
                    if (option.value === '') {
                        option.hidden = false;
                        return;
                    }

                    const companyId = option.dataset.company;
                    if (companyId === selectedCompany) {
                        option.hidden = false;
                        hasVisibleBranches = true;
                    } else {
                        option.hidden = true;
                        option.selected = false;
                    }
                });

                // If no branches for selected company, select empty option
                if (!hasVisibleBranches) {
                    branchSelect.value = '';
                }
            }

            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.className =
                            'h-32 w-32 rounded-2xl object-cover ring-4 ring-white shadow-lg';
                        avatarRemove.classList.remove('opacity-0');

                        // Remove the remove_avatar input if it exists
                        const removeInput = document.getElementById('remove_avatar');
                        if (removeInput) {
                            removeInput.remove();
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                const eyeIcon = document.getElementById(fieldId + '-eye');

                if (field.type === 'password') {
                    field.type = 'text';
                    eyeIcon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                } else {
                    field.type = 'password';
                    eyeIcon.innerHTML =
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
            }

            function validateForm() {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('password_confirmation');

                // Check password if provided
                if (password.value) {
                    if (password.value.length < 8) {
                        showAlert('Password must be at least 8 characters long.', 'error');
                        password.focus();
                        return false;
                    }

                    // Check password confirmation
                    if (password.value !== confirmPassword.value) {
                        showAlert('Passwords do not match.', 'error');
                        confirmPassword.focus();
                        return false;
                    }
                }

                // Check email format
                const email = document.getElementById('email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    showAlert('Please enter a valid email address.', 'error');
                    email.focus();
                    return false;
                }

                return true;
            }

            function verifyEmail() {
                if (confirm('Manually verify this user\'s email address?')) {
                    // Add a hidden input to trigger email verification
                    let verifyInput = document.getElementById('verify_email');
                    if (!verifyInput) {
                        verifyInput = document.createElement('input');
                        verifyInput.type = 'hidden';
                        verifyInput.name = 'verify_email';
                        verifyInput.id = 'verify_email';
                        verifyInput.value = '1';
                        editUserForm.appendChild(verifyInput);
                    }

                    // Submit form
                    editUserForm.submit();
                }
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

            function showDeleteModal() {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function hideDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Show success/error messages from session
            @if (session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                showAlert('{{ session('error') }}', 'error');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showAlert('{{ $error }}', 'error');
                @endforeach
            @endif

            console.log('User Edit Form - Initialization complete');
        });
    </script>
@endpush
