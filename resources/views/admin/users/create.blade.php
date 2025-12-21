@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <!-- Header -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-700">Users</a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li class="text-gray-900 font-medium">Create</li>
                    </ol>
                </nav>

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
                        <p class="mt-1 text-sm text-gray-500">Add a new user to the system</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
            @csrf

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <!-- Left Column - User Details -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Basic Information Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Basic Information</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Name *
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required placeholder="John Doe">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address *
                                        </label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required placeholder="john@example.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="+1 (555) 123-4567">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                            Role *
                                        </label>
                                        <select name="role" id="role"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="">Select Role</option>
                                            <option value="super_admin"
                                                {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>
                                                Manager</option>
                                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User
                                            </option>
                                            <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer
                                            </option>
                                        </select>
                                        @error('role')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                            Password *
                                        </label>
                                        <div class="relative">
                                            <input type="password" name="password" id="password"
                                                class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                required>
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
                                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Confirm Password *
                                        </label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                                required>
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
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organization & Location Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-600 to-green-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Organization & Location</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Company -->
                                    <div>
                                        <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Company
                                        </label>
                                        <select name="company_id" id="company_id"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Branch -->
                                    <div>
                                        <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Branch
                                        </label>
                                        <select name="branch_id" id="branch_id"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            disabled>
                                            <option value="">Select Branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    data-company="{{ $branch->company_id }}"
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-purple-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Additional Details</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <!-- Address -->
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                            Address
                                        </label>
                                        <textarea name="address" id="address" rows="3"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                            placeholder="Enter full address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Avatar Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Profile Picture
                                        </label>
                                        <div class="mt-1 flex items-center space-x-4">
                                            <div class="relative">
                                                <img id="avatar-preview"
                                                    class="h-24 w-24 rounded-full object-cover border-2 border-gray-300"
                                                    src="{{ asset('images/default-avatar.png') }}" alt="Avatar preview">
                                                <div id="avatar-remove"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 cursor-pointer hidden">
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
                                                    class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Upload Photo
                                                </label>
                                                <p class="mt-1 text-xs text-gray-500">JPG, PNG or GIF (Max 2MB)</p>
                                            </div>
                                        </div>
                                        @error('avatar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Language Preference -->
                                    <div>
                                        <label for="language_preference"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Language Preference
                                        </label>
                                        <select name="language_preference" id="language_preference"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                            <option value="en"
                                                {{ old('language_preference', 'en') == 'en' ? 'selected' : '' }}>English
                                            </option>
                                            <option value="es"
                                                {{ old('language_preference') == 'es' ? 'selected' : '' }}>Spanish</option>
                                            <option value="fr"
                                                {{ old('language_preference') == 'fr' ? 'selected' : '' }}>French</option>
                                            <option value="de"
                                                {{ old('language_preference') == 'de' ? 'selected' : '' }}>German</option>
                                            <option value="zh"
                                                {{ old('language_preference') == 'zh' ? 'selected' : '' }}>Chinese</option>
                                        </select>
                                        @error('language_preference')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                                {{ old('is_active', true) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                                Account is active
                                            </label>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">
                                            Inactive users cannot log in to the system
                                        </p>
                                        @error('is_active')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Actions & Summary -->
                    <div class="lg:col-span-4 mt-6 lg:mt-0">
                        <!-- Actions Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-indigo-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Actions</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Create User
                                    </button>

                                    <a href="{{ route('admin.users.index') }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Account Information</h4>
                                    <ul class="space-y-2 text-sm text-gray-600">
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Email verification will be required
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Welcome email will be sent
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Password can be changed later
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 text-center">
                                        All fields marked with * are required.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Role Permissions Summary -->
                        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-600 to-amber-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Role Permissions</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div id="role-descriptions" class="space-y-4">
                                    <!-- Super Admin -->
                                    <div id="super_admin-desc" class="role-desc hidden">
                                        <h4 class="font-medium text-gray-900 mb-2">Super Admin</h4>
                                        <ul class="space-y-1 text-sm text-gray-600">
                                            <li>• Full system access and control</li>
                                            <li>• Can manage all organizations</li>
                                            <li>• Can create/delete any user</li>
                                            <li>• System configuration access</li>
                                            <li>• Audit log access</li>
                                        </ul>
                                    </div>

                                    <!-- Admin -->
                                    <div id="admin-desc" class="role-desc hidden">
                                        <h4 class="font-medium text-gray-900 mb-2">Admin</h4>
                                        <ul class="space-y-1 text-sm text-gray-600">
                                            <li>• Full access within assigned company</li>
                                            <li>• Can manage company users</li>
                                            <li>• Financial and inventory management</li>
                                            <li>• Report generation</li>
                                            <li>• Settings configuration</li>
                                        </ul>
                                    </div>

                                    <!-- Manager -->
                                    <div id="manager-desc" class="role-desc hidden">
                                        <h4 class="font-medium text-gray-900 mb-2">Manager</h4>
                                        <ul class="space-y-1 text-sm text-gray-600">
                                            <li>• Department/branch management</li>
                                            <li>• Team management</li>
                                            <li>• View and update records</li>
                                            <li>• Basic reporting</li>
                                            <li>• Limited settings access</li>
                                        </ul>
                                    </div>

                                    <!-- User -->
                                    <div id="user-desc" class="role-desc hidden">
                                        <h4 class="font-medium text-gray-900 mb-2">User</h4>
                                        <ul class="space-y-1 text-sm text-gray-600">
                                            <li>• Basic system access</li>
                                            <li>• Create and view own records</li>
                                            <li>• Limited data modification</li>
                                            <li>• No administrative functions</li>
                                            <li>• Personal settings only</li>
                                        </ul>
                                    </div>

                                    <!-- Viewer -->
                                    <div id="viewer-desc" class="role-desc hidden">
                                        <h4 class="font-medium text-gray-900 mb-2">Viewer</h4>
                                        <ul class="space-y-1 text-sm text-gray-600">
                                            <li>• Read-only access</li>
                                            <li>• View reports and data</li>
                                            <li>• No modification rights</li>
                                            <li>• Export capabilities</li>
                                            <li>• Dashboard access only</li>
                                        </ul>
                                    </div>

                                    <!-- Default message -->
                                    <div id="default-desc" class="role-desc">
                                        <p class="text-sm text-gray-500">Select a role to see its permissions and
                                            capabilities.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .transition {
            transition: all 0.15s ease-in-out;
        }

        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .role-desc {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('User Form - Initializing...');

            // Elements
            const companySelect = document.getElementById('company_id');
            const branchSelect = document.getElementById('branch_id');
            const roleSelect = document.getElementById('role');
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarRemove = document.getElementById('avatar-remove');
            const defaultAvatar = "{{ asset('images/default-avatar.png') }}";

            // Initialize branch filtering based on company
            if (companySelect && branchSelect) {
                filterBranches();

                companySelect.addEventListener('change', function() {
                    filterBranches();
                });
            }

            // Role description display
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    updateRoleDescription(this.value);
                });

                // Initialize with current value
                updateRoleDescription(roleSelect.value);
            }

            // Avatar removal
            if (avatarRemove) {
                avatarRemove.addEventListener('click', function(e) {
                    e.preventDefault();
                    avatarInput.value = '';
                    avatarPreview.src = defaultAvatar;
                    avatarRemove.classList.add('hidden');
                });
            }

            // Form validation
            const form = document.getElementById('userForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    }
                });
            }

            // Functions
            function filterBranches() {
                const selectedCompany = companySelect.value;
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

            function updateRoleDescription(role) {
                // Hide all descriptions
                document.querySelectorAll('.role-desc').forEach(desc => {
                    desc.classList.add('hidden');
                });

                // Show selected role description or default
                const descElement = document.getElementById(role + '-desc');
                if (descElement) {
                    descElement.classList.remove('hidden');
                } else {
                    document.getElementById('default-desc').classList.remove('hidden');
                }
            }

            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                        avatarRemove.classList.remove('hidden');
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

                // Check password strength
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

            function showAlert(message, type = 'info') {
                // Create alert element
                const alert = document.createElement('div');
                alert.className =
                    `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg ${type === 'error' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-blue-50 border border-blue-200 text-blue-700'}`;
                alert.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'error' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                        </svg>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(alert);

                // Remove alert after 5 seconds
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            }

            console.log('User Form - Initialization complete');
        });
    </script>
@endpush
