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
                                                    {{ old('status', 'pending') == $status ? 'selected' : '' }}>
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
                                                    {{ $warehouse->name }}
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
                                        <!-- Currency Selection -->
                                        <div>
                                            <label for="currency" class="block text-sm font-bold text-gray-700 mb-2">
                                                Currency <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <select name="currency" id="currency"
                                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('currency') border-red-300 @enderror"
                                                    required>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency }}"
                                                            {{ old('currency') == $currency ? 'selected' : '' }}>
                                                            {{ $currency }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('currency')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Total Amount -->
                                        <div>
                                            <label for="total_amount"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Total Amount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500" id="currency_symbol">$</span>
                                                </div>
                                                <input type="number" name="total_amount" id="total_amount"
                                                    value="{{ old('total_amount', '0.00') }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('total_amount') border-red-300 @enderror"
                                                    data-field="amount" required>
                                                <input type="hidden" name="total_amount_raw" id="total_amount_raw"
                                                    value="{{ old('total_amount_raw', '0.00') }}">
                                                @error('total_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Enter amount in decimal format (e.g., 1000.50)
                                            </p>
                                        </div>

                                        <!-- Tax Amount -->
                                        <div>
                                            <label for="tax_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                                Tax Amount <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500" id="currency_symbol_tax">$</span>
                                                </div>
                                                <input type="number" name="tax_amount" id="tax_amount"
                                                    value="{{ old('tax_amount', '0.00') }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('tax_amount') border-red-300 @enderror"
                                                    data-field="amount" required>
                                                <input type="hidden" name="tax_amount_raw" id="tax_amount_raw"
                                                    value="{{ old('tax_amount_raw', '0.00') }}">
                                                @error('tax_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Shipping Cost -->
                                        <div>
                                            <label for="shipping_cost"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Shipping Cost <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500" id="currency_symbol_shipping">$</span>
                                                </div>
                                                <input type="number" name="shipping_cost" id="shipping_cost"
                                                    value="{{ old('shipping_cost', '0.00') }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('shipping_cost') border-red-300 @enderror"
                                                    data-field="amount" required>
                                                <input type="hidden" name="shipping_cost_raw" id="shipping_cost_raw"
                                                    value="{{ old('shipping_cost_raw', '0.00') }}">
                                                @error('shipping_cost')
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
                                                    <span class="text-gray-500" id="currency_symbol_discount">$</span>
                                                </div>
                                                <input type="number" name="discount" id="discount"
                                                    value="{{ old('discount', '0.00') }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('discount') border-red-300 @enderror"
                                                    data-field="amount" required>
                                                <input type="hidden" name="discount_raw" id="discount_raw"
                                                    value="{{ old('discount_raw', '0.00') }}">
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
                                                    <span class="text-gray-500" id="currency_symbol_final">$</span>
                                                </div>
                                                <input type="number" name="final_amount" id="final_amount"
                                                    value="{{ old('final_amount', '0.00') }}"
                                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('final_amount') border-red-300 @enderror"
                                                    data-field="amount" required readonly>
                                                <input type="hidden" name="final_amount_raw" id="final_amount_raw"
                                                    value="{{ old('final_amount_raw', '0.00') }}">
                                                @error('final_amount')
                                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Calculated automatically: Total + Tax + Shipping - Discount
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
            const currencySelect = document.getElementById('currency');
            const currencySymbols = document.querySelectorAll('[id^="currency_symbol"]');

            // Currency symbols mapping
            const currencySymbolMap = {
                'USD': '$',
                'EUR': '€',
                'GBP': '£',
                'JPY': '¥',
                'INR': '₹'
            };

            // Format number to currency
            function formatCurrency(value, currency = 'USD') {
                const num = parseFloat(value) || 0;
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(num);
            }

            // Parse currency string to number
            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;
            }

            // Update currency symbols
            function updateCurrencySymbols() {
                const currency = currencySelect.value;
                const symbol = currencySymbolMap[currency] || '$';

                currencySymbols.forEach(el => {
                    el.textContent = symbol;
                });
            }

            // Auto-calculate final amount
            function calculateFinalAmount() {
                const total = parseCurrency(document.getElementById('total_amount').value);
                const tax = parseCurrency(document.getElementById('tax_amount').value);
                const shipping = parseCurrency(document.getElementById('shipping_cost').value);
                const discount = parseCurrency(document.getElementById('discount').value);
                const final = total + tax + shipping - discount;

                const formattedFinal = formatCurrency(final);
                document.getElementById('final_amount').value = formattedFinal;
                document.getElementById('final_amount_raw').value = final.toFixed(2);
            }

            // Format input on blur
            function formatInput(input) {
                const value = parseCurrency(input.value);
                const formatted = formatCurrency(value);
                input.value = formatted;

                // Update hidden raw value
                const rawInput = document.getElementById(input.id + '_raw');
                if (rawInput) {
                    rawInput.value = value.toFixed(2);
                }
            }

            // Parse input on focus
            function parseInput(input) {
                const value = parseCurrency(input.value);
                input.value = value > 0 ? value.toString() : '';
            }

            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            const orderDateInput = document.getElementById('order_date');
            const deliveryDateInput = document.getElementById('expected_delivery_date');

            orderDateInput.min = today;
            deliveryDateInput.min = today;

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

            // Event listeners for currency inputs
            const amountInputs = document.querySelectorAll('input[data-field="amount"]');
            amountInputs.forEach(input => {
                // Format on blur
                input.addEventListener('blur', function() {
                    formatInput(this);
                    calculateFinalAmount();
                });

                // Parse on focus
                input.addEventListener('focus', function() {
                    parseInput(this);
                });

                // Calculate on input change
                input.addEventListener('input', calculateFinalAmount);
            });

            // Currency change listener
            currencySelect.addEventListener('change', updateCurrencySymbols);

            // Initial setup
            updateCurrencySymbols();

            // Format initial values
            amountInputs.forEach(input => {
                if (input.value) {
                    formatInput(input);
                }
            });

            // Calculate initial final amount
            calculateFinalAmount();

            // Form validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Convert all currency inputs to raw values before submit
                    amountInputs.forEach(input => {
                        if (!input.readOnly) {
                            const value = parseCurrency(input.value);
                            const rawInput = document.getElementById(input.id + '_raw');
                            if (rawInput) {
                                rawInput.value = value.toFixed(2);
                            }
                        }
                    });

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

                    // Validate currency amounts are positive numbers
                    amountInputs.forEach(input => {
                        const value = parseCurrency(input.value);
                        if (value < 0) {
                            isValid = false;
                            input.classList.add('border-red-300');
                            if (!firstInvalidField) {
                                firstInvalidField = input;
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        // Show error message
                        const errorDiv = document.createElement('div');
                        errorDiv.className =
                            'mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700';
                        errorDiv.innerHTML =
                            '<strong>Please fill in all required fields with valid values.</strong>';

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
        });

        // Additional script for dynamic currency symbol updates and auto-calculation of final amount
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('purchaseOrderForm');
            const currencySelect = document.getElementById('currency');
            const currencySymbols = document.querySelectorAll('[id^="currency_symbol"]');

            // Comprehensive currency symbols mapping
            const currencySymbolMap = {
                'USD': '$', // US Dollar
                'EUR': '€', // Euro
                'GBP': '£', // British Pound
                'JPY': '¥', // Japanese Yen
                'INR': '₹', // Indian Rupee
                'AUD': 'A$', // Australian Dollar
                'CAD': 'C$', // Canadian Dollar
                'CHF': 'CHF', // Swiss Franc
                'CNY': '¥', // Chinese Yuan
                'HKD': 'HK$', // Hong Kong Dollar
                'SGD': 'S$', // Singapore Dollar
                'KRW': '₩', // South Korean Won
                'BRL': 'R$', // Brazilian Real
                'RUB': '₽', // Russian Ruble
                'ZAR': 'R', // South African Rand
                'TRY': '₺', // Turkish Lira
                'MXN': 'Mex$', // Mexican Peso
                'AED': 'د.إ', // UAE Dirham
                'SAR': '﷼', // Saudi Riyal
                'MYR': 'RM', // Malaysian Ringgit
                'THB': '฿', // Thai Baht
                'IDR': 'Rp', // Indonesian Rupiah
                'PHP': '₱', // Philippine Peso
                'VND': '₫', // Vietnamese Dong
                'PKR': '₨', // Pakistani Rupee
                'BDT': '৳', // Bangladeshi Taka
                'EGP': 'E£', // Egyptian Pound
                'NGN': '₦', // Nigerian Naira
                'KES': 'KSh', // Kenyan Shilling
                'GHS': 'GH₵', // Ghanaian Cedi
            };

            // Format number to currency
            function formatCurrency(value) {
                const num = parseFloat(value) || 0;
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(num);
            }

            // Parse currency string to number
            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9.-]+/g, "")) || 0;
            }

            // Update all currency symbols on the page
            function updateCurrencySymbols() {
                const currency = currencySelect.value;
                const symbol = currencySymbolMap[currency] || '$';

                console.log('Updating currency symbols to:', symbol);

                // Update all currency symbol spans
                currencySymbols.forEach(el => {
                    el.textContent = symbol;
                    console.log('Updated element:', el.id, 'to', symbol);
                });

                // Reformat all currency inputs with new symbol
                amountInputs.forEach(input => {
                    if (input.value) {
                        formatInput(input);
                    }
                });

                calculateFinalAmount();
            }

            // Auto-calculate final amount
            function calculateFinalAmount() {
                const total = parseCurrency(document.getElementById('total_amount').value);
                const tax = parseCurrency(document.getElementById('tax_amount').value);
                const shipping = parseCurrency(document.getElementById('shipping_cost').value);
                const discount = parseCurrency(document.getElementById('discount').value);
                const final = total + tax + shipping - discount;

                const formattedFinal = formatCurrency(final);
                document.getElementById('final_amount').value = formattedFinal;
                document.getElementById('final_amount_raw').value = final.toFixed(2);
            }

            // Format input on blur
            function formatInput(input) {
                const value = parseCurrency(input.value);
                const formatted = formatCurrency(value);
                input.value = formatted;

                // Update hidden raw value
                const rawInput = document.getElementById(input.id + '_raw');
                if (rawInput) {
                    rawInput.value = value.toFixed(2);
                }
            }

            // Parse input on focus
            function parseInput(input) {
                const value = parseCurrency(input.value);
                input.value = value > 0 ? value.toString() : '';
            }

            // Get all amount inputs
            const amountInputs = document.querySelectorAll('input[data-field="amount"]');

            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            const orderDateInput = document.getElementById('order_date');
            const deliveryDateInput = document.getElementById('expected_delivery_date');

            orderDateInput.min = today;
            deliveryDateInput.min = today;

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

            // Event listeners for currency inputs
            amountInputs.forEach(input => {
                // Format on blur
                input.addEventListener('blur', function() {
                    formatInput(this);
                    calculateFinalAmount();
                });

                // Parse on focus
                input.addEventListener('focus', function() {
                    parseInput(this);
                });

                // Calculate on input change
                input.addEventListener('input', calculateFinalAmount);
            });

            // Currency change listener
            currencySelect.addEventListener('change', updateCurrencySymbols);

            // Initial setup
            updateCurrencySymbols();

            // Format initial values
            amountInputs.forEach(input => {
                if (input.value) {
                    formatInput(input);
                }
            });

            // Calculate initial final amount
            calculateFinalAmount();

            // ... rest of your existing form validation code
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

        /* Currency input styling */
        input[data-field="amount"] {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }
    </style>
@endpush
