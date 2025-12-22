@extends('layouts.admin')

@section('title', 'Create Purchase Order')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('purchase.purchase-orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    Purchase Orders
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Create New</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="mt-2 text-2xl font-semibold text-gray-900">Create Purchase Order</h1>
                    <p class="mt-1 text-sm text-gray-600">Add new purchase order to your inventory system</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('purchase.purchase-orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="px-6 py-6">
        <form action="{{ route('purchase.purchase-orders.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Basic Information -->
                <div class="space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                            <p class="mt-1 text-sm text-gray-500">Primary details of the purchase order</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- PO Number -->
                            <div>
                                <label for="po_number" class="block text-sm font-medium text-gray-700 mb-1">
                                    PO Number *
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="po_number" name="po_number" value="{{ old('po_number', $poNumber) }}"
                                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('po_number') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           placeholder="PO-2024-001" required>
                                </div>
                                @error('po_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Selection -->
                            <div>
                                <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Company *
                                </label>
                                <div class="relative">
                                    <select id="company_id" name="company_id"
                                            class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg sm:text-sm @error('company_id') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                            required>
                                        <option value="">Select a company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }} - {{ $company->code }} - {{ $company->contact_person }} - {{ $company->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('company_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Order Date -->
                                <div>
                                    <label for="order_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Order Date *
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}"
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('order_date') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('order_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Expected Delivery Date -->
                                <div>
                                    <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Expected Delivery
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" id="expected_delivery_date" name="expected_delivery_date"
                                               value="{{ old('expected_delivery_date') }}"
                                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier & Warehouse Card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Supplier & Warehouse</h3>
                            <p class="mt-1 text-sm text-gray-500">Select supplier and destination warehouse</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Supplier Selection -->
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Supplier *
                                </label>
                                <div class="relative">
                                    <select id="supplier_id" name="supplier_id"
                                            class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg sm:text-sm @error('supplier_id') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                            required>
                                        <option value="">Select a supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('supplier_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Warehouse Selection -->
                            <div>
                                <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Warehouse *
                                </label>
                                <div class="relative">
                                    <select id="warehouse_id" name="warehouse_id"
                                            class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg sm:text-sm @error('warehouse_id') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                            required>
                                        <option value="">Select a warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('warehouse_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Financial Information -->
                <div class="space-y-6">
                    <!-- Financial Information Card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Financial Information</h3>
                            <p class="mt-1 text-sm text-gray-500">Enter payment and tax details</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Amount Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Total Amount -->
                                <div>
                                    <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Total Amount *
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="total_amount" name="total_amount"
                                               value="{{ old('total_amount', 0) }}"
                                               class="block w-full pl-7 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('total_amount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="0.00" required>
                                    </div>
                                    @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tax Amount -->
                                <div>
                                    <label for="tax_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tax Amount *
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="tax_amount" name="tax_amount"
                                               value="{{ old('tax_amount', 0) }}"
                                               class="block w-full pl-7 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('tax_amount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="0.00" required>
                                    </div>
                                    @error('tax_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Discount -->
                                <div>
                                    <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Discount *
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="discount" name="discount"
                                               value="{{ old('discount', 0) }}"
                                               class="block w-full pl-7 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('discount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="0.00" required>
                                    </div>
                                    @error('discount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Final Amount -->
                                <div>
                                    <label for="final_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Final Amount *
                                    </label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="final_amount" name="final_amount"
                                               value="{{ old('final_amount', 0) }}"
                                               class="block w-full pl-7 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('final_amount') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="0.00" required readonly>
                                    </div>
                                    @error('final_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Selection -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Status *
                                </label>
                                <div class="relative">
                                    <select id="status" name="status"
                                            class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg sm:text-sm @error('status') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                            required>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ old('status', 'draft') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                    Notes
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                          class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm placeholder-gray-400"
                                          placeholder="Add any additional notes or instructions">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Summary</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Items:</span>
                                    <span class="font-medium">0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-medium">$0.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax:</span>
                                    <span class="font-medium">$0.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount:</span>
                                    <span class="font-medium text-green-600">-$0.00</span>
                                </div>
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between">
                                        <span class="text-base font-semibold text-gray-900">Total:</span>
                                        <span class="text-xl font-bold text-blue-600">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('purchase.purchase-orders.index') }}"
                                   class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="px-6 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Create Purchase Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const totalAmount = document.getElementById('total_amount');
    const taxAmount = document.getElementById('tax_amount');
    const discount = document.getElementById('discount');
    const finalAmount = document.getElementById('final_amount');

    // Calculate final amount
    function calculateFinalAmount() {
        const total = parseFloat(totalAmount.value) || 0;
        const tax = parseFloat(taxAmount.value) || 0;
        const discountValue = parseFloat(discount.value) || 0;
        const final = total + tax - discountValue;

        // Update final amount field
        finalAmount.value = final.toFixed(2);

        // Update summary
        updateSummary(total, tax, discountValue, final);
    }

    // Update summary panel
    function updateSummary(total, tax, discountValue, final) {
        // Update summary elements if they exist
        const subtotalEl = document.querySelector('[data-subtotal]');
        const taxEl = document.querySelector('[data-tax]');
        const discountEl = document.querySelector('[data-discount]');
        const totalEl = document.querySelector('[data-total]');

        if (subtotalEl) subtotalEl.textContent = `$${total.toFixed(2)}`;
        if (taxEl) taxEl.textContent = `$${tax.toFixed(2)}`;
        if (discountEl) discountEl.textContent = `-$${discountValue.toFixed(2)}`;
        if (totalEl) totalEl.textContent = `$${final.toFixed(2)}`;
    }

    // Event listeners for amount calculations
    if (totalAmount && taxAmount && discount && finalAmount) {
        totalAmount.addEventListener('input', calculateFinalAmount);
        taxAmount.addEventListener('input', calculateFinalAmount);
        discount.addEventListener('input', calculateFinalAmount);

        // Initial calculation
        calculateFinalAmount();
    }

    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    const orderDate = document.getElementById('order_date');
    const expectedDelivery = document.getElementById('expected_delivery_date');

    if (orderDate) {
        orderDate.min = today;
        orderDate.addEventListener('change', function() {
            if (expectedDelivery) {
                expectedDelivery.min = this.value;
            }
        });
    }

    if (expectedDelivery) {
        if (orderDate && orderDate.value) {
            expectedDelivery.min = orderDate.value;
        } else {
            expectedDelivery.min = today;
        }
    }

    // Form validation enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Custom validation logic can be added here
            console.log('Form submitted');
        });
    }

    // Add input formatting for currency fields
    function formatCurrencyInput(input) {
        input.addEventListener('blur', function() {
            if (this.value) {
                const value = parseFloat(this.value);
                this.value = value.toFixed(2);
            }
        });
    }

    [totalAmount, taxAmount, discount, finalAmount].forEach(input => {
        if (input) formatCurrencyInput(input);
    });
});
</script>

<style>
/* Custom form styling */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Focus styles */
.focus\:ring-2:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}

/* Transition effects */
.transition-colors {
    transition-property: color, background-color, border-color;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Select dropdown styling */
select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}
</style>
@endpush
