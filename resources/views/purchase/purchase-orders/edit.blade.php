@extends('layouts.admin')

@section('title', 'Edit Purchase Order')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-amber-50">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Purchase Order</h1>
                            <p class="text-sm text-gray-600 mt-1">PO# {{ $purchaseOrder->po_number }}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('purchase.purchase-orders.show', $purchaseOrder) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to View
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <form action="{{ route('purchase.purchase-orders.update', $purchaseOrder) }}" method="POST" class="space-y-6"
                id="purchaseOrderForm">
                @csrf
                @method('PUT')

                <!-- Hidden fields for financial calculations -->
                <input type="hidden" name="total_amount" id="total_amount"
                    value="{{ old('total_amount', $purchaseOrder->total_amount) }}">
                <input type="hidden" name="tax_amount" id="tax_amount"
                    value="{{ old('tax_amount', $purchaseOrder->tax_amount) }}">
                <input type="hidden" name="final_amount" id="final_amount"
                    value="{{ old('final_amount', $purchaseOrder->final_amount) }}">

                <!-- Error summary at the top -->
                @if ($errors->has('final_amount') || $errors->has('total_amount') || $errors->has('tax_amount'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Financial Calculation Errors</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @error('final_amount')
                                            <li>{{ $message }}</li>
                                        @enderror
                                        @error('total_amount')
                                            <li>{{ $message }}</li>
                                        @enderror
                                        @error('tax_amount')
                                            <li>{{ $message }}</li>
                                        @enderror
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Basic Information Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- PO Number -->
                                <div>
                                    <label for="po_number" class="block text-sm font-medium text-gray-700 mb-1">
                                        PO Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="po_number" name="po_number"
                                        value="{{ old('po_number', $purchaseOrder->po_number) }}"
                                        class="w-full px-3 py-2 border @error('po_number') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                    @error('po_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if ($errors->has('po_number') && str_contains($errors->first('po_number'), 'already been taken'))
                                        <p class="mt-1 text-sm text-amber-600">This PO number already exists. Please use a
                                            different one.</p>
                                    @endif
                                </div>

                                <!-- Company -->
                                <div>
                                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Company <span class="text-red-500">*</span>
                                    </label>
                                    <select id="company_id" name="company_id"
                                        class="w-full px-3 py-2 border @error('company_id') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company_id', $purchaseOrder->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dates -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Order Date -->
                                    <div>
                                        <label for="order_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            Order Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="order_date" name="order_date"
                                            value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}"
                                            class="w-full px-3 py-2 border @error('order_date') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            required>
                                        @error('order_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Expected Delivery Date -->
                                    <div>
                                        <label for="expected_delivery_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">
                                            Expected Delivery Date
                                        </label>
                                        <input type="date" id="expected_delivery_date" name="expected_delivery_date"
                                            value="{{ old('expected_delivery_date', $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('Y-m-d') : '') }}"
                                            class="w-full px-3 py-2 border @error('expected_delivery_date') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        @error('expected_delivery_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Payment Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Status & Payment</h2>
                            </div>
                            <div class="p-6 space-y-4">
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
                                                    {{ old('status', $purchaseOrder->status ?? '') == $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Payment Status -->
                                <div>
                                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Status
                                    </label>
                                    <select id="payment_status" name="payment_status"
                                        class="w-full px-3 py-2 border @error('payment_status') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="pending"
                                            {{ old('payment_status', $purchaseOrder->payment_status ?? 'pending') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="partial"
                                            {{ old('payment_status', $purchaseOrder->payment_status ?? 'pending') == 'partial' ? 'selected' : '' }}>
                                            Partial</option>
                                        <option value="paid"
                                            {{ old('payment_status', $purchaseOrder->payment_status ?? 'pending') == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                    </select>
                                    @error('payment_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">
                                        Payment Method
                                    </label>
                                    <select id="payment_method" name="payment_method"
                                        class="w-full px-3 py-2 border @error('payment_method') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="">Select Method</option>
                                        <option value="cash"
                                            {{ old('payment_method', $purchaseOrder->payment_method ?? '') == 'cash' ? 'selected' : '' }}>
                                            Cash</option>
                                        <option value="bank_transfer"
                                            {{ old('payment_method', $purchaseOrder->payment_method ?? '') == 'bank_transfer' ? 'selected' : '' }}>
                                            Bank Transfer</option>
                                        <option value="credit_card"
                                            {{ old('payment_method', $purchaseOrder->payment_method ?? '') == 'credit_card' ? 'selected' : '' }}>
                                            Credit Card</option>
                                        <option value="check"
                                            {{ old('payment_method', $purchaseOrder->payment_method ?? '') == 'check' ? 'selected' : '' }}>
                                            Check</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Supplier & Warehouse Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Supplier & Warehouse</h2>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Supplier -->
                                <div>
                                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Supplier <span class="text-red-500">*</span>
                                    </label>
                                    <select id="supplier_id" name="supplier_id"
                                        class="w-full px-3 py-2 border @error('supplier_id') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Warehouse -->
                                <div>
                                    <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Warehouse <span class="text-red-500">*</span>
                                    </label>
                                    <select id="warehouse_id" name="warehouse_id"
                                        class="w-full px-3 py-2 border @error('warehouse_id') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ old('warehouse_id', $purchaseOrder->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Reference Number -->
                                <div>
                                    <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">
                                        Reference Number
                                    </label>
                                    <input type="text" id="reference_number" name="reference_number"
                                        value="{{ old('reference_number', $purchaseOrder->reference_number) }}"
                                        class="w-full px-3 py-2 border @error('reference_number') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        placeholder="e.g., Supplier Invoice #">
                                    @error('reference_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Details Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Financial Details</h2>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Display calculated amounts -->
                                <div class="grid grid-cols-2 gap-4 mb-4 p-4 bg-blue-50 rounded-lg">
                                    <div class="text-sm">
                                        <div class="text-gray-600">Subtotal:</div>
                                        <div id="display_subtotal" class="font-semibold text-gray-900">
                                            {{ $purchaseOrder->currency_symbol ?? '৳' }}{{ number_format($purchaseOrder->total_amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="text-sm">
                                        <div class="text-gray-600">Tax Amount:</div>
                                        <div id="display_tax" class="font-semibold text-gray-900">
                                            {{ $purchaseOrder->currency_symbol ?? '৳' }}{{ number_format($purchaseOrder->tax_amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="col-span-2 pt-4 border-t border-blue-100">
                                        <div class="text-sm">
                                            <div class="text-gray-600">Final Amount:</div>
                                            <div id="display_final" class="text-lg font-bold text-blue-700">
                                                {{ $purchaseOrder->currency_symbol ?? '৳' }}{{ number_format($purchaseOrder->final_amount, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Discount -->
                                <div>
                                    <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Discount ({{ $purchaseOrder->currency_symbol ?? '৳' }})
                                    </label>
                                    <input type="number" id="discount" name="discount" step="0.01" min="0"
                                        value="{{ old('discount', $purchaseOrder->discount) }}"
                                        class="w-full px-3 py-2 border @error('discount') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <div class="mt-1 text-xs text-gray-500" id="discount_warning"></div>
                                    @error('discount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tax Rate -->
                                <div>
                                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tax Rate (%)
                                    </label>
                                    <input type="number" id="tax_rate" name="tax_rate" step="0.01" min="0"
                                        max="100" value="{{ old('tax_rate', $purchaseOrder->tax_rate) }}"
                                        class="w-full px-3 py-2 border @error('tax_rate') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    @error('tax_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Shipping Cost -->
                                <div>
                                    <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-1">
                                        Shipping Cost ({{ $purchaseOrder->currency_symbol ?? '৳' }})
                                    </label>
                                    <input type="number" id="shipping_cost" name="shipping_cost" step="0.01"
                                        min="0" value="{{ old('shipping_cost', $purchaseOrder->shipping_cost) }}"
                                        class="w-full px-3 py-2 border @error('shipping_cost') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    @error('shipping_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Currency -->
                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">
                                        Currency
                                    </label>
                                    <select id="currency" name="currency"
                                        class="w-full px-3 py-2 border @error('currency') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                        <option value="BDT"
                                            {{ old('currency', $purchaseOrder->currency ?? 'BDT') == 'BDT' ? 'selected' : '' }}>
                                            BDT (৳)</option>
                                        <option value="USD"
                                            {{ old('currency', $purchaseOrder->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>
                                            USD ($)</option>
                                    </select>
                                    @error('currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Notes</h2>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Additional Notes
                                    </label>
                                    <textarea id="notes" name="notes" rows="4"
                                        class="w-full px-3 py-2 border @error('notes') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        placeholder="Enter any additional notes or instructions...">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-wrap justify-end gap-3">
                        <a href="{{ route('purchase.purchase-orders.show', $purchaseOrder) }}"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" id="submitBtn"
                            class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Purchase Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get form and inputs
            const form = document.getElementById('purchaseOrderForm');
            const submitBtn = document.getElementById('submitBtn');
            const discountInput = document.getElementById('discount');
            const taxRateInput = document.getElementById('tax_rate');
            const shippingCostInput = document.getElementById('shipping_cost');
            const taxAmountInput = document.getElementById('tax_amount');
            const finalAmountInput = document.getElementById('final_amount');
            const totalAmountInput = document.getElementById('total_amount');
            const discountWarning = document.getElementById('discount_warning');

            // Display elements
            const displaySubtotal = document.getElementById('display_subtotal');
            const displayTax = document.getElementById('display_tax');
            const displayFinal = document.getElementById('display_final');

            // Currency symbol mapping
            const currencySymbols = {
                'BDT': '৳',
                'USD': '$'
            };

            // Get current currency
            const currencySelect = document.getElementById('currency');
            let currentCurrency = currencySelect.value;
            let currentSymbol = currencySymbols[currentCurrency] || '৳';

            // Update currency symbol when currency changes
            currencySelect.addEventListener('change', function() {
                currentCurrency = this.value;
                currentSymbol = currencySymbols[currentCurrency] || '৳';
                updateCurrencySymbols();
                calculateTotals();
            });

            function updateCurrencySymbols() {
                // Update all currency labels
                const discountLabel = discountInput.previousElementSibling;
                const shippingLabel = shippingCostInput.previousElementSibling;

                if (discountLabel && discountLabel.tagName === 'LABEL') {
                    discountLabel.textContent = `Discount (${currentSymbol})`;
                }
                if (shippingLabel && shippingLabel.tagName === 'LABEL') {
                    shippingLabel.textContent = `Shipping Cost (${currentSymbol})`;
                }
            }

            // Auto-format date inputs
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('order_date').max = today;

            // Set min date for expected delivery to order date
            const orderDateInput = document.getElementById('order_date');
            const expectedDateInput = document.getElementById('expected_delivery_date');

            orderDateInput.addEventListener('change', function() {
                expectedDateInput.min = this.value;
            });

            // Initialize min date if order date is already set
            if (orderDateInput.value) {
                expectedDateInput.min = orderDateInput.value;
            }

            // Function to calculate totals with validation
            function calculateTotals() {
                const discount = parseFloat(discountInput.value) || 0;
                const taxRate = parseFloat(taxRateInput.value) || 0;
                const shipping = parseFloat(shippingCostInput.value) || 0;
                const subtotal = parseFloat(totalAmountInput.value) || 0;

                // Validate discount doesn't exceed subtotal + shipping
                const maxDiscount = subtotal + shipping;
                let adjustedDiscount = discount;

                if (discount > maxDiscount) {
                    adjustedDiscount = maxDiscount;
                    discountWarning.textContent =
                        `Warning: Discount cannot exceed ${currentSymbol}${maxDiscount.toFixed(2)} (subtotal + shipping). Will be adjusted to ${currentSymbol}${maxDiscount.toFixed(2)}.`;
                    discountWarning.className = 'mt-1 text-xs text-red-600';
                    discountInput.value = maxDiscount.toFixed(2);
                } else {
                    discountWarning.textContent = '';
                    discountWarning.className = 'mt-1 text-xs text-gray-500';
                }

                // Calculate tax amount
                const taxAmount = (subtotal * taxRate) / 100;
                taxAmountInput.value = taxAmount.toFixed(2);

                // Calculate final amount with validation
                const finalAmount = subtotal + taxAmount + shipping - adjustedDiscount;

                // Ensure final amount is not negative
                if (finalAmount < 0) {
                    finalAmountInput.value = '0.00';
                    displayFinal.innerHTML =
                        `<span class="text-red-600">${currentSymbol}0.00 (Negative amount prevented)</span>`;
                } else {
                    finalAmountInput.value = finalAmount.toFixed(2);
                    displayFinal.innerHTML =
                        `<span class="text-blue-700">${currentSymbol}${finalAmount.toFixed(2)}</span>`;
                }

                // Update display values
                displaySubtotal.textContent = `${currentSymbol}${subtotal.toFixed(2)}`;
                displayTax.textContent = `${currentSymbol}${taxAmount.toFixed(2)}`;
            }

            // Add event listeners for financial calculations
            [discountInput, taxRateInput, shippingCostInput].forEach(input => {
                input.addEventListener('input', calculateTotals);
                input.addEventListener('change', calculateTotals);
            });

            // Validate form before submission
            form.addEventListener('submit', function(e) {
                // Calculate totals one last time
                calculateTotals();

                // Get final amount
                const finalAmount = parseFloat(finalAmountInput.value) || 0;

                // Check if final amount is negative or zero
                if (finalAmount < 0) {
                    e.preventDefault();
                    alert(
                        'Error: Final amount cannot be negative. Please adjust the discount, tax rate, or shipping cost.');
                    finalAmountInput.focus();
                    return false;
                }

                if (finalAmount === 0) {
                    const confirmation = confirm(
                        'Final amount is zero. Are you sure you want to save this purchase order?');
                    if (!confirmation) {
                        e.preventDefault();
                        return false;
                    }
                }

                // Disable submit button to prevent double submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Updating...
                `;

                return true;
            });

            // Initial calculation and currency symbol update
            updateCurrencySymbols();
            calculateTotals();
        });
    </script>
@endsection
