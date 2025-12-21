@extends('layouts.admin')

@section('title', 'Edit Organization')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <a href="{{ route('admin.organizations.show', $organization) }}"
                                class="text-gray-500 hover:text-gray-700 mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </a>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Organization</h1>
                        </div>
                    </div>
                    <p class="text-gray-600">Update the details for {{ $organization->name }}</p>
                </div>

                <!-- Form Card -->
                <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <h2 class="text-xl font-semibold text-white">{{ $organization->name }}</h2>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium bg-blue-500 text-white rounded-full">
                                {{ ucfirst($organization->code) }}
                            </span>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="p-6">
                        <form action="{{ route('admin.organizations.update', $organization) }}" method="POST"
                            enctype="multipart/form-data" id="editOrganizationForm">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Basic Information
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Organization Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Organization Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $organization->name) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                            placeholder="Enter organization name" required>
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Organization Type -->
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                                            Organization Type
                                        </label>
                                        <select id="type" name="type"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                                            <option value="">Select Type</option>
                                            @foreach ($types as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('type', $organization->type) == $value ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace(['-', '_'], ' ', $value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email Address
                                        </label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $organization->email) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                            placeholder="organization@example.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Phone Number
                                        </label>
                                        <input type="tel" id="phone" name="phone"
                                            value="{{ old('phone', $organization->phone) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                            placeholder="+1 (555) 123-4567">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Website -->
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                            Website
                                        </label>
                                        <div class="flex">
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                https://
                                            </span>
                                            <input type="url" id="website" name="website"
                                                value="{{ old('website', $organization->website) }}"
                                                class="flex-1 min-w-0 block w-full px-4 py-2 rounded-none rounded-r-md border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('website') border-red-500 @enderror"
                                                placeholder="www.example.com">
                                        </div>
                                        @error('website')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Industry -->
                                    <div>
                                        <label for="industry" class="block text-sm font-medium text-gray-700 mb-1">
                                            Industry
                                        </label>
                                        <input type="text" id="industry" name="industry"
                                            value="{{ old('industry', $organization->industry) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('industry') border-red-500 @enderror"
                                            placeholder="e.g., Technology, Healthcare, Education">
                                        @error('industry')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Company Details -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Company Details
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Founded Year -->
                                    <div>
                                        <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-1">
                                            Founded Year
                                        </label>
                                        <input type="number" id="founded_year" name="founded_year"
                                            value="{{ old('founded_year', $organization->founded_year) }}" min="1800"
                                            max="{{ date('Y') }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('founded_year') border-red-500 @enderror"
                                            placeholder="1990">
                                        @error('founded_year')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Employee Count -->
                                    <div>
                                        <label for="employee_count" class="block text-sm font-medium text-gray-700 mb-1">
                                            Employee Count
                                        </label>
                                        <select id="employee_count" name="employee_count"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('employee_count') border-red-500 @enderror">
                                            <option value="">Select Range</option>
                                            <option value="1-10"
                                                {{ old('employee_count', $organization->employee_count) == '1-10' ? 'selected' : '' }}>
                                                1-10 Employees
                                            </option>
                                            <option value="11-50"
                                                {{ old('employee_count', $organization->employee_count) == '11-50' ? 'selected' : '' }}>
                                                11-50 Employees
                                            </option>
                                            <option value="51-200"
                                                {{ old('employee_count', $organization->employee_count) == '51-200' ? 'selected' : '' }}>
                                                51-200 Employees
                                            </option>
                                            <option value="201-500"
                                                {{ old('employee_count', $organization->employee_count) == '201-500' ? 'selected' : '' }}>
                                                201-500 Employees
                                            </option>
                                            <option value="501-1000"
                                                {{ old('employee_count', $organization->employee_count) == '501-1000' ? 'selected' : '' }}>
                                                501-1000 Employees
                                            </option>
                                            <option value="1000+"
                                                {{ old('employee_count', $organization->employee_count) == '1000+' ? 'selected' : '' }}>
                                                1000+ Employees
                                            </option>
                                        </select>
                                        @error('employee_count')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Address Information
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Street Address -->
                                    <div class="md:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                            Street Address
                                        </label>
                                        <input type="text" id="address" name="address"
                                            value="{{ old('address', $organization->address) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                                            placeholder="123 Main Street">
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- City -->
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                                            City
                                        </label>
                                        <input type="text" id="city" name="city"
                                            value="{{ old('city', $organization->city) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                                            placeholder="New York">
                                        @error('city')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- State -->
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                                            State/Province
                                        </label>
                                        <input type="text" id="state" name="state"
                                            value="{{ old('state', $organization->state) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('state') border-red-500 @enderror"
                                            placeholder="NY">
                                        @error('state')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Zip Code -->
                                    <div>
                                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">
                                            Zip/Postal Code
                                        </label>
                                        <input type="text" id="zip_code" name="zip_code"
                                            value="{{ old('zip_code', $organization->zip_code) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('zip_code') border-red-500 @enderror"
                                            placeholder="10001">
                                        @error('zip_code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                                            Country
                                        </label>
                                        <select id="country" name="country"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror">
                                            <option value="">Select Country</option>
                                            <option value="US"
                                                {{ old('country', $organization->country) == 'US' ? 'selected' : '' }}>
                                                United States</option>
                                            <option value="CA"
                                                {{ old('country', $organization->country) == 'CA' ? 'selected' : '' }}>
                                                Canada</option>
                                            <option value="UK"
                                                {{ old('country', $organization->country) == 'UK' ? 'selected' : '' }}>
                                                United Kingdom</option>
                                            <option value="AU"
                                                {{ old('country', $organization->country) == 'AU' ? 'selected' : '' }}>
                                                Australia</option>
                                            <option value="Other"
                                                {{ old('country', $organization->country) == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                        @error('country')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-8">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                    placeholder="Brief description of the organization">{{ old('description', $organization->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Logo Upload -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Logo
                                </label>
                                <div
                                    class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                                    @if ($organization->logo)
                                        <div class="flex-shrink-0">
                                            <div class="relative group">
                                                <img src="{{ Storage::url($organization->logo) }}"
                                                    alt="{{ $organization->name }} Logo"
                                                    class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200 group-hover:border-blue-500 transition-colors">
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg">
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 text-center">Current Logo</p>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <div
                                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="mt-4">
                                                <label for="logo" class="cursor-pointer">
                                                    <span class="text-blue-600 hover:text-blue-500 font-medium">Upload a
                                                        new logo</span>
                                                    <span class="text-gray-500"> or drag and drop</span>
                                                </label>
                                                <input type="file" id="logo" name="logo" accept="image/*"
                                                    class="hidden">
                                                <p class="text-xs text-gray-500 mt-2">
                                                    PNG, JPG, GIF up to 2MB. Recommended: 300x300px
                                                </p>
                                            </div>
                                        </div>
                                        @error('logo')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Links -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                    <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    Social Media Links
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Facebook -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <span class="inline-flex items-center">
                                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                </svg>
                                                Facebook
                                            </span>
                                        </label>
                                        <input type="url" name="facebook_url"
                                            value="{{ old('facebook_url', $organization->facebook_url) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('facebook_url') border-red-500 @enderror"
                                            placeholder="https://facebook.com/username">
                                        @error('facebook_url')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Twitter -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <span class="inline-flex items-center">
                                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                </svg>
                                                Twitter
                                            </span>
                                        </label>
                                        <input type="url" name="twitter_url"
                                            value="{{ old('twitter_url', $organization->twitter_url) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('twitter_url') border-red-500 @enderror"
                                            placeholder="https://twitter.com/username">
                                        @error('twitter_url')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- LinkedIn -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <span class="inline-flex items-center">
                                                <svg class="w-5 h-5 text-blue-700 mr-2" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                                </svg>
                                                LinkedIn
                                            </span>
                                        </label>
                                        <input type="url" name="linkedin_url"
                                            value="{{ old('linkedin_url', $organization->linkedin_url) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('linkedin_url') border-red-500 @enderror"
                                            placeholder="https://linkedin.com/company/username">
                                        @error('linkedin_url')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Instagram -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <span class="inline-flex items-center">
                                                <svg class="w-5 h-5 text-pink-600 mr-2" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                </svg>
                                                Instagram
                                            </span>
                                        </label>
                                        <input type="url" name="instagram_url"
                                            value="{{ old('instagram_url', $organization->instagram_url) }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('instagram_url') border-red-500 @enderror"
                                            placeholder="https://instagram.com/username">
                                        @error('instagram_url')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Status
                                </label>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="status" value="active"
                                            {{ old('status', $organization->status) == 'active' ? 'checked' : '' }}
                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Active
                                            </span>
                                        </span>
                                    </label>

                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="status" value="inactive"
                                            {{ old('status', $organization->status) == 'inactive' ? 'checked' : '' }}
                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-gray-700">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Inactive
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-8 border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.organizations.index') }}"
                                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel
                                        </a>

                                        <button type="button" onclick="openDeleteModal()"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>

                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Update Organization
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full transform transition-all">
            <div class="bg-red-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Confirm Deletion</h3>
                </div>
            </div>

            <div class="p-6">
                <p class="text-gray-700 mb-4">Are you sure you want to delete <strong
                        class="text-gray-900">{{ $organization->name }}</strong>?</p>
                <p class="text-sm text-red-600 mb-6">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    This action cannot be undone. All associated data will be permanently removed.
                </p>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </button>

                    <form action="{{ route('admin.organizations.destroy', $organization) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Delete Organization
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Delete Modal Functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal on background click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Phone number formatting
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (value.length <= 3) {
                            value = value;
                        } else if (value.length <= 6) {
                            value = value.slice(0, 3) + '-' + value.slice(3);
                        } else {
                            value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                        }
                    }
                    e.target.value = value;
                });
            }

            // Logo preview
            const logoInput = document.getElementById('logo');
            if (logoInput) {
                logoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size must be less than 2MB');
                            e.target.value = '';
                            return;
                        }

                        if (!file.type.startsWith('image/')) {
                            alert('Please select an image file');
                            e.target.value = '';
                            return;
                        }

                        // Preview the image (optional enhancement)
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // You could add a preview here if needed
                            console.log('Image loaded:', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Drag and drop for logo
            const dropZone = logoInput?.closest('.border-dashed');
            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });

                function highlight(e) {
                    dropZone.classList.add('border-blue-500', 'bg-blue-50');
                }

                function unhighlight(e) {
                    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                }

                dropZone.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    logoInput.files = files;
                    logoInput.dispatchEvent(new Event('change'));
                });
            }

            // Form validation
            const form = document.getElementById('editOrganizationForm');
            form.addEventListener('submit', function(e) {
                const nameInput = document.getElementById('name');
                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    nameInput.focus();
                    nameInput.classList.add('border-red-500');
                    return false;
                }

                const emailInput = document.getElementById('email');
                if (emailInput.value && !isValidEmail(emailInput.value)) {
                    e.preventDefault();
                    emailInput.focus();
                    emailInput.classList.add('border-red-500');
                    return false;
                }
            });

            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Real-time validation
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                    const errorElement = this.nextElementSibling;
                    if (errorElement && errorElement.classList.contains('text-red-600')) {
                        errorElement.remove();
                    }
                });
            });

            function validateField(field) {
                if (field.hasAttribute('required') && !field.value.trim()) {
                    field.classList.add('border-red-500');
                    return false;
                }

                if (field.type === 'email' && field.value && !isValidEmail(field.value)) {
                    field.classList.add('border-red-500');
                    return false;
                }

                return true;
            }
        });
    </script>

    @push('styles')
        <style>
            /* Custom scrollbar for better UX */
            textarea::-webkit-scrollbar {
                width: 8px;
            }

            textarea::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            textarea::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            textarea::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Smooth transitions */
            * {
                transition: background-color 0.2s ease, border-color 0.2s ease;
            }
        </style>
    @endpush
