@extends('layouts.admin')

@section('title', 'Create ' . ucfirst($type))

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create New {{ ucfirst($type) }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Add a new {{ $type }} to the system</p>
                </div>
                <div>
                    <a href="{{ route('admin.companies.index', ['type' => $type]) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h6 class="text-sm font-medium text-gray-900">Basic Info</h6>
                    </div>
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h6 class="text-sm font-medium text-gray-500">Address</h6>
                    </div>
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h6 class="text-sm font-medium text-gray-500">Financial</h6>
                    </div>
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h6 class="text-sm font-medium text-gray-500">Complete</h6>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Form Content -->
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <div>
                                    <h4 class="font-medium text-red-800">Please fix the following errors:</h4>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.companies.store') }}" method="POST" id="createForm">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column: Basic Information -->
                            <div class="space-y-6">
                                <!-- Basic Information Header -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Basic Information
                                    </h3>

                                    <!-- Company Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Company Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                            placeholder="Enter Company name">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Company Code & Sub Type -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                                Company Code <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="code" name="code"
                                                value="{{ old('code') }}" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('code') border-red-500 @enderror"
                                                placeholder="Auto-generated">
                                            <p class="mt-1 text-xs text-gray-500">Unique identifier</p>
                                            @error('code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="sub_type" class="block text-sm font-medium text-gray-700 mb-1">
                                                Sub Type
                                            </label>
                                            <select id="sub_type" name="sub_type"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('sub_type') border-red-500 @enderror">
                                                <option value="">Select Sub Type</option>
                                                @foreach ($subTypes as $subType)
                                                    <option value="{{ $subType }}"
                                                        {{ old('sub_type') == $subType ? 'selected' : '' }}>
                                                        {{ ucfirst($subType) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sub_type')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Contact Person -->
                                    <div>
                                        <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-1">
                                            Contact Person <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="contact_person" name="contact_person"
                                            value="{{ old('contact_person') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('contact_person') border-red-500 @enderror"
                                            placeholder="Enter contact person name">
                                        @error('contact_person')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email & Phone -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                                Email Address
                                            </label>
                                            <input type="email" id="email" name="email"
                                                value="{{ old('email') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                                placeholder="email@example.com">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                                Phone Number <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="phone" name="phone"
                                                value="{{ old('phone') }}" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                                placeholder="Enter phone number">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Mobile Number -->
                                    <div>
                                        <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">
                                            Mobile Number
                                        </label>
                                        <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror"
                                            placeholder="Enter mobile number">
                                        @error('mobile')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Website -->
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                            Website
                                        </label>
                                        <input type="url" id="website" name="website"
                                            value="{{ old('website') }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('website') border-red-500 @enderror"
                                            placeholder="https://example.com">
                                        @error('website')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Tax & Address -->
                            <div class="space-y-6">
                                <!-- Tax & Registration -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Tax & Registration
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="tin" class="block text-sm font-medium text-gray-700 mb-1">
                                                TIN Number
                                            </label>
                                            <input type="text" id="tin" name="tin"
                                                value="{{ old('tin') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tin') border-red-500 @enderror"
                                                placeholder="Enter TIN">
                                            <p class="mt-1 text-xs text-gray-500">Tax Identification Number</p>
                                            @error('tin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="bin" class="block text-sm font-medium text-gray-700 mb-1">
                                                BIN Number
                                            </label>
                                            <input type="text" id="bin" name="bin"
                                                value="{{ old('bin') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('bin') border-red-500 @enderror"
                                                placeholder="Enter BIN">
                                            <p class="mt-1 text-xs text-gray-500">Business Identification Number</p>
                                            @error('bin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Address Information
                                    </h3>

                                    <!-- Address -->
                                    <div class="mb-4">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                            Address
                                        </label>
                                        <textarea id="address" name="address" rows="3"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                                            placeholder="Enter full address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- City & District -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                                                City
                                            </label>
                                            <input type="text" id="city" name="city"
                                                value="{{ old('city') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror"
                                                placeholder="Enter city">
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="district" class="block text-sm font-medium text-gray-700 mb-1">
                                                District
                                            </label>
                                            <input type="text" id="district" name="district"
                                                value="{{ old('district') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('district') border-red-500 @enderror"
                                                placeholder="Enter district">
                                            @error('district')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Country & Postal Code -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                                                Country
                                            </label>
                                            <select id="country" name="country"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror">
                                                <option value="Bangladesh"
                                                    {{ old('country', 'Bangladesh') == 'Bangladesh' ? 'selected' : '' }}>
                                                    Bangladesh
                                                </option>
                                                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>
                                                    India
                                                </option>
                                                <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>
                                                    United States
                                                </option>
                                                <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>
                                                    United Kingdom
                                                </option>
                                                <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('country')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                                Postal Code
                                            </label>
                                            <input type="text" id="postal_code" name="postal_code"
                                                value="{{ old('postal_code') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('postal_code') border-red-500 @enderror"
                                                placeholder="Enter postal code">
                                            @error('postal_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Conditional Sections -->
                                @if ($type == 'customer')
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Credit Information
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="credit_limit"
                                                    class="block text-sm font-medium text-gray-700 mb-1">
                                                    Credit Limit (৳)
                                                </label>
                                                <input type="number" step="0.01" id="credit_limit"
                                                    name="credit_limit" value="{{ old('credit_limit', 0) }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="0.00">
                                            </div>
                                            <div>
                                                <label for="outstanding_balance"
                                                    class="block text-sm font-medium text-gray-700 mb-1">
                                                    Outstanding Balance (৳)
                                                </label>
                                                <input type="number" step="0.01" id="outstanding_balance"
                                                    name="outstanding_balance"
                                                    value="{{ old('outstanding_balance', 0) }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($type == 'supplier')
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Payment Terms
                                        </h3>
                                        <div>
                                            <label for="payment_terms"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Payment Terms
                                            </label>
                                            <select id="payment_terms" name="payment_terms"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Terms</option>
                                                <option value="Cash on Delivery"
                                                    {{ old('payment_terms') == 'Cash on Delivery' ? 'selected' : '' }}>
                                                    Cash on Delivery
                                                </option>
                                                <option value="Net 7 Days"
                                                    {{ old('payment_terms') == 'Net 7 Days' ? 'selected' : '' }}>
                                                    Net 7 Days
                                                </option>
                                                <option value="Net 15 Days"
                                                    {{ old('payment_terms') == 'Net 15 Days' ? 'selected' : '' }}>
                                                    Net 15 Days
                                                </option>
                                                <option value="Net 30 Days"
                                                    {{ old('payment_terms') == 'Net 30 Days' ? 'selected' : '' }}>
                                                    Net 30 Days
                                                </option>
                                                <option value="Advance Payment"
                                                    {{ old('payment_terms') == 'Advance Payment' ? 'selected' : '' }}>
                                                    Advance Payment
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <!-- Additional Information -->
                                <div class="pt-4 mt-4 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Additional Information
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">
                                                Currency
                                            </label>
                                            <select id="currency" name="currency"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="BDT"
                                                    {{ old('currency', 'BDT') == 'BDT' ? 'selected' : '' }}>
                                                    Bangladeshi Taka (BDT)
                                                </option>
                                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>
                                                    US Dollar (USD)
                                                </option>
                                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>
                                                    Euro (EUR)
                                                </option>
                                                <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>
                                                    Indian Rupee (INR)
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="language" class="block text-sm font-medium text-gray-700 mb-1">
                                                Language
                                            </label>
                                            <select id="language" name="language"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="en"
                                                    {{ old('language', 'en') == 'en' ? 'selected' : '' }}>
                                                    English
                                                </option>
                                                <option value="bn" {{ old('language') == 'bn' ? 'selected' : '' }}>
                                                    Bangla
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                            Description
                                        </label>
                                        <textarea id="description" name="description" rows="3"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Enter description">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                            Notes
                                        </label>
                                        <textarea id="notes" name="notes" rows="2"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_active" name="is_active" value="1" checked
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                            Active {{ ucfirst($type) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4">
                                <a href="{{ route('admin.companies.index', ['type' => $type]) }}"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-base font-medium text-white rounded-lg shadow-sm hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create {{ ucfirst($type) }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');

            // Auto-generate code from name
            if (nameInput && codeInput) {
                nameInput.addEventListener('blur', function() {
                    const name = nameInput.value.trim();
                    if (name && !codeInput.value) {
                        let prefix = '{{ strtoupper(substr($type, 0, 4)) }}';
                        if (prefix.length < 4) {
                            prefix += 'X'.repeat(4 - prefix.length);
                        }

                        const randomNum = Math.floor(Math.random() * 9000) + 1000;
                        const code = prefix + randomNum;
                        codeInput.value = code;
                    }
                });

                // Auto-capitalize Company name
                nameInput.addEventListener('keyup', function() {
                    this.value = this.value.toUpperCase();
                });
            }

            // Form validation
            const form = document.getElementById('createForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const phone = document.getElementById('phone')?.value;
                    const email = document.getElementById('email')?.value;

                    // Phone validation
                    if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
                        e.preventDefault();
                        alert('Please enter a valid phone number');
                        return false;
                    }

                    // Email validation
                    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        e.preventDefault();
                        alert('Please enter a valid email address');
                        return false;
                    }

                    return true;
                });
            }
        });
    </script>
@endpush
