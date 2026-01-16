@extends('layouts.admin')

@section('title', 'Edit Branch: ' . $branch->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <div class="p-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 shadow-lg mr-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">
                                Edit Branch: <span class="text-amber-600">{{ $branch->name }}</span>
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                Update branch information and settings
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.branches.index') }}"
                       class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST" id="branchForm">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-amber-100 border-b border-amber-200">
                    <h2 class="text-lg font-bold text-amber-900">
                        Branch Information
                    </h2>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Name & Code Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Branch Name -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                    Branch Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ old('name', $branch->name) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('name') border-red-300 @enderror"
                                           placeholder="Enter branch name"
                                           required>
                                    @error('name')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Branch Code -->
                            <div>
                                <label for="code" class="block text-sm font-bold text-gray-700 mb-2">
                                    Branch Code <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                           name="code"
                                           id="code"
                                           value="{{ old('code', $branch->code) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('code') border-red-300 @enderror"
                                           placeholder="e.g., BR001"
                                           required>
                                    @error('code')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Unique identifier for this branch
                                </p>
                            </div>
                        </div>

                        <!-- Company Selection -->
                        <div>
                            <label for="company_id" class="block text-sm font-bold text-gray-700 mb-2">
                                Company <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select name="company_id"
                                        id="company_id"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('company_id') border-red-300 @enderror"
                                        required>
                                    <option value="">Select a Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $branch->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }} ({{ $company->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2">
                                Address
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('address') border-red-300 @enderror"
                                          placeholder="Enter complete branch address">{{ old('address', $branch->address) }}</textarea>
                                @error('address')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- City & Country Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-bold text-gray-700 mb-2">
                                    City
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                           name="city"
                                           id="city"
                                           value="{{ old('city', $branch->city) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('city') border-red-300 @enderror"
                                           placeholder="Enter city">
                                    @error('city')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-bold text-gray-700 mb-2">
                                    Country
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                           name="country"
                                           id="country"
                                           value="{{ old('country', $branch->country) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('country') border-red-300 @enderror"
                                           placeholder="Enter country">
                                    @error('country')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Phone & Email Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="tel"
                                           name="phone"
                                           id="phone"
                                           value="{{ old('phone', $branch->phone) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('phone') border-red-300 @enderror"
                                           placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           value="{{ old('email', $branch->email) }}"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('email') border-red-300 @enderror"
                                           placeholder="Enter email address">
                                    @error('email')
                                        <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Manager Name -->
                        <div>
                            <label for="manager_name" class="block text-sm font-bold text-gray-700 mb-2">
                                Manager Name
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text"
                                       name="manager_name"
                                       id="manager_name"
                                       value="{{ old('manager_name', $branch->manager_name) }}"
                                       class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('manager_name') border-red-300 @enderror"
                                       placeholder="Enter branch manager name">
                                @error('manager_name')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                                Description (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <textarea name="description"
                                          id="description"
                                          rows="3"
                                          class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('description') border-red-300 @enderror"
                                          placeholder="Enter any additional notes or description">{{ old('description', $branch->description) }}</textarea>
                                @error('description')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 mb-1">Branch Status</h3>
                                    <p class="text-sm text-gray-600">
                                        Active branches are visible and operational
                                    </p>
                                </div>
                                <div class="flex items-center">
                                    <label for="is_active" class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox"
                                                   name="is_active"
                                                   id="is_active"
                                                   value="1"
                                                   {{ old('is_active', $branch->is_active) ? 'checked' : '' }}
                                                   class="sr-only">
                                            <div class="block bg-gray-300 w-14 h-8 rounded-full transition-all duration-300"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all duration-300"></div>
                                        </div>
                                        <div class="ml-3 text-sm font-medium text-gray-900">
                                            <span id="statusText">{{ old('is_active', $branch->is_active) ? 'Active' : 'Inactive' }}</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.branches.index') }}"
                           class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                                class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Branch
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status toggle
        const statusToggle = document.getElementById('is_active');
        const statusText = document.getElementById('statusText');

        if (statusToggle) {
            statusToggle.addEventListener('change', function() {
                const dot = this.nextElementSibling.querySelector('.dot');
                const block = this.nextElementSibling.querySelector('.block');

                if (this.checked) {
                    block.classList.remove('bg-gray-300');
                    block.classList.add('bg-green-500');
                    dot.classList.remove('left-1');
                    dot.classList.add('left-7');
                    statusText.textContent = 'Active';
                } else {
                    block.classList.remove('bg-green-500');
                    block.classList.add('bg-gray-300');
                    dot.classList.remove('left-7');
                    dot.classList.add('left-1');
                    statusText.textContent = 'Inactive';
                }
            });

            // Initialize status toggle
            const dot = statusToggle.nextElementSibling.querySelector('.dot');
            const block = statusToggle.nextElementSibling.querySelector('.block');

            if (statusToggle.checked) {
                block.classList.add('bg-green-500');
                dot.classList.add('left-7');
            } else {
                block.classList.add('bg-gray-300');
                dot.classList.add('left-1');
            }
        }

        // Form validation
        const form = document.getElementById('branchForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const code = document.getElementById('code').value.trim();
                const companyId = document.getElementById('company_id').value;

                if (!name || !code || !companyId) {
                    e.preventDefault();

                    // Highlight empty required fields
                    if (!name) {
                        document.getElementById('name').classList.add('border-red-300');
                    }
                    if (!code) {
                        document.getElementById('code').classList.add('border-red-300');
                    }
                    if (!companyId) {
                        document.getElementById('company_id').classList.add('border-red-300');
                    }

                    // Show error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700';
                    errorDiv.innerHTML = '<strong>Please fill in all required fields.</strong>';

                    const firstChild = form.querySelector('.space-y-6');
                    if (firstChild) {
                        form.insertBefore(errorDiv, firstChild);
                    }

                    // Scroll to error message
                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }

        // Remove error styling when user starts typing
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-300');
            });
            // For select elements
            input.addEventListener('change', function() {
                this.classList.remove('border-red-300');
            });
        });

        // Focus on first input field
        const firstInput = document.querySelector('input[required]');
        if (firstInput) {
            firstInput.focus();
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Custom toggle switch styles */
    #is_active:checked ~ .block {
        background-color: #10b981;
    }

    #is_active:checked ~ .dot {
        transform: translateX(1.5rem);
    }

    .transition-all {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Focus styles */
    input:focus, textarea:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
    }

    /* Amber focus for edit form */
    input:focus.amber, textarea:focus.amber, select:focus.amber {
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
    }
</style>
@endpush
