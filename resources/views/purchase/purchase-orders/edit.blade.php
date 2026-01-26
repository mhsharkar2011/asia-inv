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
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status"
                                        class="w-full px-3 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        required>
                                        <option value="">Select Status</option>
                                        <option value="pending"
                                            {{ old('status', $purchaseOrder->status) == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="confirmed"
                                            {{ old('status', $purchaseOrder->status) == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing"
                                            {{ old('status', $purchaseOrder->status) == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="shipped"
                                            {{ old('status', $purchaseOrder->status) == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="delivered"
                                            {{ old('status', $purchaseOrder->status) == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled"
                                            {{ old('status', $purchaseOrder->status) == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if ($errors->has('status') && str_contains($errors->first('status'), 'invalid'))
                                        <p class="mt-1 text-sm text-amber-600">Please select a valid status from the
                                            dropdown.</p>
                                    @endif
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
                                                {{ $warehouse->warehouse_name }}
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
                                <!-- Discount -->
                                <div>
                                    <label for="discount" class="block text-sm font-medium text-gray-700 mb-1">
                                        Discount ($)
                                    </label>
                                    <input type="number" id="discount" name="discount" step="0.01" min="0"
                                        value="{{ old('discount', $purchaseOrder->discount) }}"
                                        class="w-full px-3 py-2 border @error('discount') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
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
                                        Shipping Cost ($)
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
                                        <option value="USD"
                                            {{ old('currency', $purchaseOrder->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>
                                            USD ($)</option>
                                        <option value="EUR"
                                            {{ old('currency', $purchaseOrder->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>
                                            EUR (€)</option>
                                        <option value="GBP"
                                            {{ old('currency', $purchaseOrder->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>
                                            GBP (£)</option>
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
                        <button type="submit"
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

            // Auto-calculate financial amounts
            const discountInput = document.getElementById('discount');
            const taxRateInput = document.getElementById('tax_rate');
            const shippingCostInput = document.getElementById('shipping_cost');
            const taxAmountInput = document.getElementById('tax_amount');
            const finalAmountInput = document.getElementById('final_amount');
            const totalAmountInput = document.getElementById('total_amount');

            // Function to calculate totals
            function calculateTotals() {
                const discount = parseFloat(discountInput.value) || 0;
                const taxRate = parseFloat(taxRateInput.value) || 0;
                const shipping = parseFloat(shippingCostInput.value) || 0;

                // For now, use the existing total amount from hidden field
                // In a real app, you would calculate based on order items
                const subtotal = parseFloat(totalAmountInput.value) || 0;

                // Calculate tax amount
                const taxAmount = (subtotal * taxRate) / 100;
                taxAmountInput.value = taxAmount.toFixed(2);

                // Calculate final amount
                const finalAmount = subtotal + taxAmount + shipping - discount;
                finalAmountInput.value = finalAmount.toFixed(2);
            }

            // Add event listeners for financial calculations
            [discountInput, taxRateInput, shippingCostInput].forEach(input => {
                input.addEventListener('input', calculateTotals);
                input.addEventListener('change', calculateTotals);
            });

            // Initial calculation
            calculateTotals();
        });
    </script>
@endsection
