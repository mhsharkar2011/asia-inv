@extends('layouts.admin')

@section('title', 'Create Supplier - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-6">
                    <div>
                        <div class="flex items-center">
                            <div class="h-10 w-1.5 bg-blue-600 rounded-full mr-3"></div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Create New Supplier</h1>
                                <p class="text-sm text-gray-600 mt-1">Add a new supplier to your vendor list</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('purchase.suppliers.index') }}"
                            class="inline-flex items-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Suppliers
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <!-- Form Header -->
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Supplier Information</h2>
                            <p class="text-sm text-gray-600">Fill in the supplier details below</p>
                        </div>

                        <form action="{{ route('purchase.suppliers.store') }}" method="POST" class="p-6">
                            @csrf

                            @if ($errors->any())
                                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z">
                                            </path>
                                        </svg>
                                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                    </div>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="supplier_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                Supplier Code *
                                            </label>
                                            <div class="relative">
                                                <input type="text" name="supplier_code" id="supplier_code"
                                                    value="{{ old('supplier_code') }}"
                                                    class="w-full px-4 py-2.5 border @error('supplier_code') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    required>
                                                <button type="button" onclick="generateCode()"
                                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-600 transition-colors">
                                                    Generate
                                                </button>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Unique identifier for the supplier</p>
                                            @error('supplier_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="supplier_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                Supplier Name *
                                            </label>
                                            <input type="text" name="supplier_name" id="supplier_name"
                                                value="{{ old('supplier_name') }}"
                                                class="w-full px-4 py-2.5 border @error('supplier_name') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            @error('supplier_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                        <div>
                                            <label for="contact_person"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Contact Person
                                            </label>
                                            <input type="text" name="contact_person" id="contact_person"
                                                value="{{ old('contact_person') }}"
                                                class="w-full px-4 py-2.5 border @error('contact_person') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('contact_person')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">
                                                Business Type
                                            </label>
                                            <select name="business_type" id="business_type"
                                                class="w-full px-4 py-2.5 border @error('business_type') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Business Type</option>
                                                <option value="Sole Proprietorship"
                                                    {{ old('business_type') == 'Sole Proprietorship' ? 'selected' : '' }}>
                                                    Sole Proprietorship</option>
                                                <option value="Partnership"
                                                    {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>
                                                    Partnership</option>
                                                <option value="Private Limited"
                                                    {{ old('business_type') == 'Private Limited' ? 'selected' : '' }}>
                                                    Private Limited</option>
                                                <option value="Public Limited"
                                                    {{ old('business_type') == 'Public Limited' ? 'selected' : '' }}>
                                                    Public Limited</option>
                                                <option value="LLC"
                                                    {{ old('business_type') == 'LLC' ? 'selected' : '' }}>LLC</option>
                                                <option value="Other"
                                                    {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('business_type')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                                Phone
                                            </label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                                class="w-full px-4 py-2.5 border @error('phone') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                                Email
                                            </label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email') }}"
                                                class="w-full px-4 py-2.5 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                            Address
                                        </label>
                                        <textarea name="address" id="address" rows="3"
                                            class="w-full px-4 py-2.5 border @error('address') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tax & Financial Information -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tax & Financial Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        <div>
                                            <label for="tin" class="block text-sm font-medium text-gray-700 mb-2">
                                                TIN Number
                                            </label>
                                            <input type="text" name="tin" id="tin"
                                                value="{{ old('tin') }}"
                                                class="w-full px-4 py-2.5 border @error('tin') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <p class="mt-1 text-xs text-gray-500">9 or 12 digits</p>
                                            @error('tin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="bin" class="block text-sm font-medium text-gray-700 mb-2">
                                                BIN Number
                                            </label>
                                            <input type="text" name="bin" id="bin"
                                                value="{{ old('bin') }}"
                                                class="w-full px-4 py-2.5 border @error('bin') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <p class="mt-1 text-xs text-gray-500">13 or 15 digits</p>
                                            @error('bin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="trade_license"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Trade License
                                            </label>
                                            <input type="text" name="trade_license" id="trade_license"
                                                value="{{ old('trade_license') }}"
                                                class="w-full px-4 py-2.5 border @error('trade_license') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('trade_license')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="payment_terms"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Payment Terms
                                            </label>
                                            <select name="payment_terms" id="payment_terms"
                                                class="w-full px-4 py-2.5 border @error('payment_terms') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Terms</option>
                                                <option value="Cash on Delivery"
                                                    {{ old('payment_terms') == 'Cash on Delivery' ? 'selected' : '' }}>
                                                    Cash on Delivery</option>
                                                <option value="Net 7 Days"
                                                    {{ old('payment_terms') == 'Net 7 Days' ? 'selected' : '' }}>Net 7
                                                    Days</option>
                                                <option value="Net 15 Days"
                                                    {{ old('payment_terms') == 'Net 15 Days' ? 'selected' : '' }}>Net 15
                                                    Days</option>
                                                <option value="Net 30 Days"
                                                    {{ old('payment_terms') == 'Net 30 Days' ? 'selected' : '' }}>Net 30
                                                    Days</option>
                                                <option value="Net 45 Days"
                                                    {{ old('payment_terms') == 'Net 45 Days' ? 'selected' : '' }}>Net 45
                                                    Days</option>
                                                <option value="Net 60 Days"
                                                    {{ old('payment_terms') == 'Net 60 Days' ? 'selected' : '' }}>Net 60
                                                    Days</option>
                                                <option value="Advance Payment"
                                                    {{ old('payment_terms') == 'Advance Payment' ? 'selected' : '' }}>
                                                    Advance Payment</option>
                                            </select>
                                            @error('payment_terms')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                        <div>
                                            <label for="credit_limit"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Credit Limit (BDT)
                                            </label>
                                            <div class="relative">
                                                <input type="number" name="credit_limit" id="credit_limit"
                                                    step="0.01" value="{{ old('credit_limit') }}"
                                                    class="w-full px-4 py-2.5 border @error('credit_limit') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <div
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">৳</span>
                                                </div>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Maximum credit allowed</p>
                                            @error('credit_limit')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="outstanding_balance"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Outstanding Balance (BDT)
                                            </label>
                                            <div class="relative">
                                                <input type="number" name="outstanding_balance" id="outstanding_balance"
                                                    step="0.01" value="{{ old('outstanding_balance', 0) }}"
                                                    class="w-full px-4 py-2.5 border @error('outstanding_balance') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <div
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">৳</span>
                                                </div>
                                            </div>
                                            @error('outstanding_balance')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                            Notes
                                        </label>
                                        <textarea name="notes" id="notes" rows="3"
                                            class="w-full px-4 py-2.5 border @error('notes') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-6">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                                Set supplier as active
                                            </label>
                                        </div>
                                        <p class="text-sm text-gray-500 ml-6">Active suppliers can be used in purchase
                                            orders</p>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div
                                    class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200">
                                    <a href="{{ route('purchase.suppliers.index') }}"
                                        class="inline-flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex justify-center items-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Create Supplier
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="space-y-6">
                    <!-- Tips Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-900">Tips for Adding Suppliers</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-blue-800">Use a unique supplier code for easy
                                    identification</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-blue-800">Set appropriate credit limits to manage cash
                                    flow</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-blue-800">Add tax information for compliance and reporting</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm text-blue-800">Clear payment terms help avoid disputes</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Required Fields Card -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Required Information</h3>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="h-2 w-2 rounded-full bg-red-500 mr-2"></div>
                                Supplier Code
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="h-2 w-2 rounded-full bg-red-500 mr-2"></div>
                                Supplier Name
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Fields marked with * are required. Other fields are optional
                                but recommended for better supplier management.</p>
                        </div>
                    </div>

                    <!-- Contact Support Card -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h3>
                        <p class="text-sm text-gray-600 mb-4">If you're unsure about any information, contact your finance
                            team or system administrator.</p>
                        <a href="mailto:finance@asiaenterprise.com"
                            class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Contact Finance Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generateCode() {
            const name = document.getElementById('supplier_name').value;
            const codeField = document.getElementById('supplier_code');

            if (name.trim().length >= 3) {
                // Get first 3 letters of each word
                const words = name.split(' ');
                let initials = '';

                if (words.length === 1) {
                    initials = words[0].substring(0, 3).toUpperCase();
                } else {
                    initials = words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Add timestamp for uniqueness
                const timestamp = Date.now().toString().slice(-4);
                codeField.value = `SUP-${initials}-${timestamp}`;
            } else {
                alert('Please enter a supplier name first (minimum 3 characters)');
            }
        }

        // Auto-generate code when name loses focus and code is empty
        document.getElementById('supplier_name').addEventListener('blur', function() {
            const codeField = document.getElementById('supplier_code');
            if (codeField.value.trim() === '') {
                generateCode();
            }
        });

        // Auto-focus on first input
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('input');
            if (firstInput) {
                firstInput.focus();
            }
        });
    </script>
@endpush
