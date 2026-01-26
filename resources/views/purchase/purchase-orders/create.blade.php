@extends('layouts.admin')

@section('title', 'Create Purchase Order')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center">
                            <div class="p-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-indigo-600 shadow-lg mr-4">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">
                                    Create Purchase Order
                                </h1>
                                <p class="mt-2 text-lg text-gray-600">
                                    Create a new purchase order for your procurement needs
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('purchase.purchase-orders.index') }}"
                            class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('purchase.purchase-orders.store') }}" method="POST" id="purchaseOrderForm">
                    @csrf

                    <!-- Form Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-indigo-200">
                        <h2 class="text-lg font-bold text-indigo-900">
                            Purchase Order Information
                        </h2>
                    </div>

                    <!-- Form Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column: Basic Information -->
                            <div class="space-y-6">
                                <!-- PO Number -->
                                <div>
                                    <label for="po_number" class="block text-sm font-bold text-gray-700 mb-2">
                                        PO Number <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <input type="text" name="po_number" id="po_number"
                                            value="{{ old('po_number', $poNumber) }}"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('po_number') border-red-300 @enderror"
                                            placeholder="Enter PO number" required>
                                        @error('po_number')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Auto-generated PO number: <span class="font-bold">{{ $poNumber }}</span>
                                    </p>
                                </div>

                                <!-- Company -->
                                <div>
                                    <label for="company_id" class="block text-sm font-bold text-gray-700 mb-2">
                                        Company <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select name="company_id" id="company_id"
                                            class="pl-10 w-full px-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('company_id') border-red-300 @enderror"
                                            required>
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Dates -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Order Date -->
                                    <div>
                                        <label for="order_date" class="block text-sm font-bold text-gray-700 mb-2">
                                            Order Date <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="date" name="order_date" id="order_date"
                                                value="{{ old('order_date', date('Y-m-d')) }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('order_date') border-red-300 @enderror"
                                                required>
                                            @error('order_date')
                                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Expected Delivery Date -->
                                    <div>
                                        <label for="expected_delivery_date"
                                            class="block text-sm font-bold text-gray-700 mb-2">
                                            Expected Delivery Date
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <input type="date" name="expected_delivery_date"
                                                id="expected_delivery_date" value="{{ old('expected_delivery_date') }}"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('expected_delivery_date') border-red-300 @enderror">
                                            @error('expected_delivery_date')
                                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select name="status" id="status"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('status') border-red-300 @enderror"
                                            required>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', 'draft') == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Supplier & Warehouse -->
                            <div class="space-y-6">
                                <!-- Supplier -->
                                <div>
                                    <label for="supplier_id" class="block text-sm font-bold text-gray-700 mb-2">
                                        Supplier <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <select name="supplier_id" id="supplier_id"
                                            class="pl-10 w-full px-4 py-3 border border-orange-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('supplier_id') border-red-300 @enderror"
                                            required>
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Warehouse -->
                                <div>
                                    <label for="warehouse_id" class="block text-sm font-bold text-gray-700 mb-2">
                                        Warehouse <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <select name="warehouse_id" id="warehouse_id"
                                            class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('warehouse_id') border-red-300 @enderror"
                                            required>
                                            <option value="">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_id')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Financial Information Card -->
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-5">
                                    <h3 class="text-sm font-bold text-gray-900 mb-4">Financial Information</h3>
                                    <div class="space-y-4">
                                        <!-- Total Amount -->
                                        <div>
                                            <label for="total_amount"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Total Amount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="total_amount"
                                                    id="total_amount" value="{{ old('total_amount', 0) }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('total_amount') border-red-300 @enderror"
                                                    required>
                                                @error('total_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Tax Amount -->
                                        <div>
                                            <label for="tax_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                                Tax Amount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="tax_amount" id="tax_amount"
                                                    value="{{ old('tax_amount', 0) }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('tax_amount') border-red-300 @enderror"
                                                    required>
                                                @error('tax_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Discount -->
                                        <div>
                                            <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">
                                                Discount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="discount" id="discount"
                                                    value="{{ old('discount', 0) }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('discount') border-red-300 @enderror"
                                                    required>
                                                @error('discount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Final Amount (Calculated) -->
                                        <div>
                                            <label for="final_amount"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Final Amount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="final_amount"
                                                    id="final_amount" value="{{ old('final_amount', 0) }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('final_amount') border-red-300 @enderror"
                                                    required readonly>
                                                @error('final_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Calculated automatically: Total + Tax - Discount
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">
                                Notes
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <textarea name="notes" id="notes" rows="3"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('notes') border-red-300 @enderror"
                                    placeholder="Add any additional notes or instructions...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('purchase.purchase-orders.index') }}"
                                class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Create Purchase Order
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
            const form = document.getElementById('purchaseOrderForm');
            const totalInput = document.getElementById('total_amount');
            const taxInput = document.getElementById('tax_amount');
            const discountInput = document.getElementById('discount');
            const finalInput = document.getElementById('final_amount');
            const orderDateInput = document.getElementById('order_date');
            const deliveryDateInput = document.getElementById('expected_delivery_date');

            // Auto-calculate final amount
            function calculateFinalAmount() {
                const total = parseFloat(totalInput.value) || 0;
                const tax = parseFloat(taxInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const final = total + tax - discount;
                finalInput.value = final.toFixed(2);
            }

            // Add event listeners for calculation
            [totalInput, taxInput, discountInput].forEach(input => {
                input.addEventListener('input', calculateFinalAmount);
            });

            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            orderDateInput.min = today;
            deliveryDateInput.min = today;

            // Set default date values if not set
            if (!orderDateInput.value) {
                orderDateInput.value = today;
            }

            // Prevent delivery date before order date
            orderDateInput.addEventListener('change', function() {
                deliveryDateInput.min = this.value;
                if (deliveryDateInput.value && deliveryDateInput.value < this.value) {
                    deliveryDateInput.value = this.value;
                }
            });

            // Initial calculation
            calculateFinalAmount();

            // Form validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('input[required], select[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-300');
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        // Show error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className =
                            'mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700';
                        errorDiv.innerHTML = '<strong>Please fill in all required fields.</strong>';

                        const firstChild = form.querySelector('.space-y-6');
                        if (firstChild) {
                            form.insertBefore(errorDiv, firstChild);
                        }

                        // Scroll to first invalid field
                        if (firstInvalidField) {
                            firstInvalidField.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstInvalidField.focus();
                        }
                    }
                });

                // Remove error styling when user starts typing
                const inputs = form.querySelectorAll('input[required], select[required]');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('border-red-300');
                    });
                    input.addEventListener('change', function() {
                        this.classList.remove('border-red-300');
                    });
                });
            }

            // Focus on first input field
            const firstInput = document.querySelector('input[required], select[required]');
            if (firstInput) {
                firstInput.focus();
            }

            // Format currency inputs on blur
            const currencyInputs = [totalInput, taxInput, discountInput];
            currencyInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    const value = parseFloat(this.value);
                    if (!isNaN(value)) {
                        this.value = value.toFixed(2);
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .transition-all {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Focus styles */
        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Disabled input styling */
        input:read-only {
            background-color: #f9fafb;
            cursor: not-allowed;
        }

        /* Custom scrollbar for selects */
        select {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        select::-webkit-scrollbar {
            width: 6px;
        }

        select::-webkit-scrollbar-track {
            background: transparent;
        }

        select::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }
    </style>
@endpush
