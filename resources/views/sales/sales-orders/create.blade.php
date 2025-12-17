{{-- resources/views/sales/sales-orders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Sales Order')

@section('content')
    <div class="container-fluid py-4">
        <!-- Error Display -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">Please fix the following errors:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.sales-orders.index') }}">Sales Orders</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Create Sales Order</h1>
            </div>
            <div>
                <a href="{{ route('sales.sales-orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancel
                </a>
            </div>
        </div>

        <form action="{{ route('sales.sales-orders.store') }}" method="POST" id="salesOrderForm">
            @csrf

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Order Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Order Number</label>
                                    <input type="text" class="form-control" name="order_number"
                                        value="{{ old('order_number', $order_number) }}" readonly>
                                    <small class="text-muted">Auto-generated</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Order Date *</label>
                                    <input type="date" name="order_date"
                                        class="form-control @error('order_date') is-invalid @enderror"
                                        value="{{ old('order_date', date('Y-m-d')) }}" required>
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer *</label>
                                    <select name="customer_id" id="customerSelect"
                                        class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                                data-address="{{ $customer->address ?? '' }}"
                                                data-phone="{{ $customer->phone ?? '' }}"
                                                data-email="{{ $customer->email ?? '' }}">
                                                {{ $customer->customer_name }}
                                                @if ($customer->company_name)
                                                    ({{ $customer->company_name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Delivery Date *</label>
                                    <input type="date" name="delivery_date"
                                        class="form-control @error('delivery_date') is-invalid @enderror"
                                        value="{{ old('delivery_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                                    @error('delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Sales Person</label>
                                    <input type="text" name="sales_person" class="form-control"
                                        value="{{ old('sales_person', auth()->user()->name) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" name="reference_number" class="form-control"
                                        value="{{ old('reference_number') }}" placeholder="Customer PO/Reference">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Shipping Address</label>
                                    <textarea name="shipping_address" id="shippingAddress" class="form-control" rows="2">{{ old('shipping_address') }}</textarea>
                                    <small class="text-muted">Leave blank to use customer's default address</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Billing Address</label>
                                    <textarea name="billing_address" id="billingAddress" class="form-control" rows="2">{{ old('billing_address') }}</textarea>
                                    <small class="text-muted">Leave blank to use shipping address</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                                            Draft</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Currency</label>
                                    <select name="currency" class="form-select">
                                        <option value="BDT" selected>BDT - Bangladeshi Taka</option>
                                        <option value="USD">USD - US Dollar</option>
                                        <option value="EUR">EUR - Euro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Order Items</h5>
                            <button type="button" class="btn btn-light btn-sm" id="addItemBtn">
                                <i class="fas fa-plus me-1"></i>Add Item
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="35%">Product *</th>
                                            <th width="15%">Quantity *</th>
                                            <th width="15%">Unit Price *</th>
                                            <th width="15%">Discount %</th>
                                            <th width="15%">Amount</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <!-- Default item row -->
                                        @php
                                            $oldItems = old('items', [
                                                [
                                                    'product_id' => '',
                                                    'quantity' => 1,
                                                    'unit_price' => 0,
                                                    'discount' => 0,
                                                ],
                                            ]);
                                        @endphp

                                        @foreach ($oldItems as $index => $item)
                                            <tr class="item-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <select name="items[{{ $index }}][product_id]"
                                                        class="form-select product-select @error('items.' . $index . '.product_id') is-invalid @enderror"
                                                        required data-index="{{ $index }}">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                data-price="{{ $product->selling_price }}"
                                                                data-stock="{{ $product->stock_quantity }}"
                                                                {{ old('items.' . $index . '.product_id', $item['product_id']) == $product->id ? 'selected' : '' }}>
                                                                {{ $product->product_name }}
                                                                ({{ $product->product_code }})
                                                                - Stock: {{ $product->stock_quantity }}
                                                                - Price: ৳{{ number_format($product->selling_price, 2) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('items.' . $index . '.product_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted stock-info"
                                                        id="stock-info-{{ $index }}"></small>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="items[{{ $index }}][quantity]"
                                                            class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror"
                                                            value="{{ old('items.' . $index . '.quantity', $item['quantity']) }}"
                                                            min="0.0001" step="0.0001" required
                                                            data-index="{{ $index }}">
                                                        <span class="input-group-text unit-text">
                                                            {{ $products->first()->unit_of_measure ?? 'pcs' }}
                                                        </span>
                                                    </div>
                                                    @error('items.' . $index . '.quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control item-price @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                        value="{{ old('items.' . $index . '.unit_price', $item['unit_price']) }}"
                                                        min="0" step="0.01" required
                                                        data-index="{{ $index }}">
                                                    @error('items.' . $index . '.unit_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="items[{{ $index }}][discount]"
                                                            class="form-control item-discount"
                                                            value="{{ old('items.' . $index . '.discount', $item['discount'] ?? 0) }}"
                                                            min="0" max="100" step="0.01"
                                                            data-index="{{ $index }}">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control item-amount" value="0.00"
                                                        readonly>
                                                    <input type="hidden" name="items[{{ $index }}][amount]"
                                                        class="item-amount-hidden" value="0">
                                                </td>
                                                <td>
                                                    @if ($loop->first)
                                                        <button type="button" class="btn btn-sm btn-danger remove-item"
                                                            disabled>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-danger remove-item">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="subtotal" value="0.00"
                                                    readonly>
                                                <input type="hidden" name="subtotal" id="subtotal-hidden"
                                                    value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Discount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="totalDiscount"
                                                    value="0.00" readonly>
                                                <input type="hidden" name="total_discount" id="total-discount-hidden"
                                                    value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Taxable Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="taxableAmount"
                                                    value="0.00" readonly>
                                                <input type="hidden" name="taxable_amount" id="taxable-amount-hidden"
                                                    value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <label class="me-2 mb-0">Tax %:</label>
                                                    <input type="number" name="tax_rate" id="taxRate"
                                                        class="form-control w-auto @error('tax_rate') is-invalid @enderror"
                                                        value="{{ old('tax_rate', 15) }}" min="0" max="100"
                                                        step="0.01">
                                                    @error('tax_rate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="taxAmount" value="0.00"
                                                    readonly>
                                                <input type="hidden" name="tax_amount" id="tax-amount-hidden"
                                                    value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Shipping Charges:</strong></td>
                                            <td>
                                                <input type="number" name="shipping_charges" id="shippingChargesInput"
                                                    class="form-control @error('shipping_charges') is-invalid @enderror"
                                                    value="{{ old('shipping_charges', 0) }}" min="0"
                                                    step="0.01">
                                                @error('shipping_charges')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Adjustment:</strong></td>
                                            <td>
                                                <input type="number" name="adjustment" id="adjustmentInput"
                                                    class="form-control" value="{{ old('adjustment', 0) }}"
                                                    step="0.01">
                                                <small class="text-muted">+/- adjustment</small>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="5" class="text-end"><strong>Total Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control fw-bold" id="totalAmount"
                                                    value="0.00" readonly>
                                                <input type="hidden" name="total_amount" id="total-amount-hidden"
                                                    value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Shipping Method</label>
                                    <select name="shipping_method" class="form-select">
                                        <option value="">Select Method</option>
                                        <option value="pickup" {{ old('shipping_method') == 'pickup' ? 'selected' : '' }}>
                                            Customer Pickup</option>
                                        <option value="delivery"
                                            {{ old('shipping_method') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                                        <option value="courier"
                                            {{ old('shipping_method') == 'courier' ? 'selected' : '' }}>Courier</option>
                                        <option value="transport"
                                            {{ old('shipping_method') == 'transport' ? 'selected' : '' }}>Transport
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Payment Terms</label>
                                    <select name="payment_terms" class="form-select">
                                        <option value="">Select Terms</option>
                                        <option value="advance" {{ old('payment_terms') == 'advance' ? 'selected' : '' }}>
                                            100% Advance</option>
                                        <option value="delivery"
                                            {{ old('payment_terms') == 'delivery' ? 'selected' : '' }}>On Delivery</option>
                                        <option value="7days"
                                            {{ old('payment_terms', '7days') == '7days' ? 'selected' : '' }}>7 Days
                                        </option>
                                        <option value="15days" {{ old('payment_terms') == '15days' ? 'selected' : '' }}>15
                                            Days</option>
                                        <option value="30days" {{ old('payment_terms') == '30days' ? 'selected' : '' }}>30
                                            Days</option>
                                        <option value="custom" {{ old('payment_terms') == 'custom' ? 'selected' : '' }}>
                                            Custom</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select">
                                        <option value="pending"
                                            {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="partial"
                                            {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                        <option value="overdue"
                                            {{ old('payment_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control"
                                        value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions or notes...">{{ old('notes') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Terms & Conditions</label>
                                    <textarea name="terms_conditions" class="form-control" rows="3">{{ old('terms_conditions') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Customer Details -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Details</h5>
                        </div>
                        <div class="card-body">
                            <div id="customerDetails" class="text-muted">
                                <p class="mb-2"><i class="fas fa-info-circle me-2"></i>Select a customer to view details
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Subtotal:</span>
                                <span id="summarySubtotal">৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <span id="summaryDiscount" class="text-danger">-৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Taxable Amount:</span>
                                <span id="summaryTaxable">৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Tax (<span id="summaryTaxRate">15</span>%):</span>
                                <span id="summaryTax">৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Charges:</span>
                                <span id="summaryShipping">৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Adjustment:</span>
                                <span id="summaryAdjustment">৳0.00</span>
                            </div>

                            <hr>

                            <div class="mb-3 d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="summaryTotal">৳0.00</span>
                            </div>

                            <div class="alert alert-info">
                                <small><i class="fas fa-info-circle me-1"></i>
                                    Total Items: <span id="totalItemsCount">0</span> |
                                    Total Quantity: <span id="totalQuantity">0</span>
                                </small>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-primary">
                                    <i class="fas fa-save me-2"></i>Save as Draft
                                </button>
                                <button type="submit" name="action" value="confirm" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i>Save & Confirm
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-info" id="addSampleItems">
                                    <i class="fas fa-magic me-2"></i>Add Sample Items
                                </button>
                                <button type="button" class="btn btn-outline-warning" id="clearForm">
                                    <i class="fas fa-broom me-2"></i>Clear Form
                                </button>
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
        .item-row {
            transition: all 0.3s ease;
        }

        .item-row:hover {
            background-color: #f8f9fa;
        }

        .product-select {
            min-width: 300px;
        }

        .stock-warning {
            color: #dc3545;
            font-weight: bold;
        }

        .stock-ok {
            color: #28a745;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .unit-text {
            min-width: 60px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sales Order Form - Initializing...');

            let itemCount = {{ count(old('items', [0])) }};
            let taxRate = {{ old('tax_rate', 15) }};
            let shippingCharges = {{ old('shipping_charges', 0) }};
            let adjustment = {{ old('adjustment', 0) }};

            // Initialize elements
            const elements = {
                customerSelect: document.getElementById('customerSelect'),
                customerDetails: document.getElementById('customerDetails'),
                shippingAddress: document.getElementById('shippingAddress'),
                billingAddress: document.getElementById('billingAddress'),
                taxRateInput: document.getElementById('taxRate'),
                shippingChargesInput: document.getElementById('shippingChargesInput'),
                adjustmentInput: document.getElementById('adjustmentInput'),
                form: document.getElementById('salesOrderForm'),
                addItemBtn: document.getElementById('addItemBtn'),
                addSampleItemsBtn: document.getElementById('addSampleItems'),
                clearFormBtn: document.getElementById('clearFormBtn')
            };

            // Initialize
            updateCustomerDetails();
            attachEventListeners();
            calculateTotals();

            function attachEventListeners() {
                // Customer select change
                if (elements.customerSelect) {
                    elements.customerSelect.addEventListener('change', updateCustomerDetails);
                }

                // Add item
                if (elements.addItemBtn) {
                    elements.addItemBtn.addEventListener('click', addItemRow);
                }

                // Add sample items
                if (elements.addSampleItemsBtn) {
                    elements.addSampleItemsBtn.addEventListener('click', addSampleItems);
                }

                // Clear form
                if (elements.clearFormBtn) {
                    elements.clearFormBtn.addEventListener('click', clearForm);
                }

                // Tax rate change
                if (elements.taxRateInput) {
                    elements.taxRateInput.addEventListener('input', function() {
                        taxRate = parseFloat(this.value) || 0;
                        updateElementText('summaryTaxRate', taxRate.toFixed(2));
                        calculateTotals();
                    });
                }

                // Shipping charges change
                if (elements.shippingChargesInput) {
                    elements.shippingChargesInput.addEventListener('input', function() {
                        shippingCharges = parseFloat(this.value) || 0;
                        updateElementText('summaryShipping', formatCurrency(shippingCharges));
                        calculateTotals();
                    });
                }

                // Adjustment change
                if (elements.adjustmentInput) {
                    elements.adjustmentInput.addEventListener('input', function() {
                        adjustment = parseFloat(this.value) || 0;
                        const sign = adjustment >= 0 ? '+' : '';
                        updateElementText('summaryAdjustment', sign + formatCurrency(adjustment));
                        calculateTotals();
                    });
                }

                // Remove item event delegation
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-item')) {
                        const row = e.target.closest('.item-row');
                        if (row && document.querySelectorAll('.item-row').length > 1) {
                            row.remove();
                            renumberRows();
                            calculateTotals();
                        }
                    }
                });

                // Product select change
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('product-select')) {
                        const index = e.target.dataset.index;
                        updateProductDetails(index);
                    }
                });

                // Quantity/Price/Discount change
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('item-quantity') ||
                        e.target.classList.contains('item-price') ||
                        e.target.classList.contains('item-discount')) {
                        const index = e.target.dataset.index;
                        updateStockInfo(index);
                        calculateItemTotal(index);
                        calculateTotals();
                    }
                });

                // Form submission validation
                if (elements.form) {
                    elements.form.addEventListener('submit', function(e) {
                        // Validate customer selection
                        if (!elements.customerSelect || !elements.customerSelect.value) {
                            e.preventDefault();
                            alert('Please select a customer');
                            elements.customerSelect.focus();
                            return false;
                        }

                        // Validate at least one item with product selected
                        let validItems = 0;
                        document.querySelectorAll('.product-select').forEach(select => {
                            if (select.value) validItems++;
                        });

                        if (validItems === 0) {
                            e.preventDefault();
                            alert('Please add at least one item with a product selected');
                            return false;
                        }

                        return true;
                    });
                }
            }

            function updateCustomerDetails() {
                if (!elements.customerSelect || !elements.customerDetails) return;

                const selectedOption = elements.customerSelect.options[elements.customerSelect.selectedIndex];

                if (selectedOption.value) {
                    const address = selectedOption.getAttribute('data-address');
                    const phone = selectedOption.getAttribute('data-phone');
                    const email = selectedOption.getAttribute('data-email');

                    elements.customerDetails.innerHTML = `
                        <div class="mb-2">
                            <strong>Email:</strong> ${email || 'Not Available'}
                        </div>
                        <div class="mb-2">
                            <strong>Phone:</strong> ${phone || 'Not Available'}
                        </div>
                        <div class="mb-2">
                            <strong>Address:</strong> ${address || 'Not Available'}
                        </div>
                    `;

                    if (address && elements.shippingAddress && !elements.shippingAddress.value) {
                        elements.shippingAddress.value = address;
                    }

                    if (address && elements.billingAddress && !elements.billingAddress.value) {
                        elements.billingAddress.value = address;
                    }
                } else {
                    elements.customerDetails.innerHTML =
                        '<p class="mb-2"><i class="fas fa-info-circle me-2"></i>Select a customer to view details</p>';
                }
            }

            function addItemRow() {
                const tbody = document.getElementById('itemsBody');
                if (!tbody) return;

                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
                    <td>${itemCount + 1}</td>
                    <td>
                        <select name="items[${itemCount}][product_id]"
                               class="form-select product-select"
                               required data-index="${itemCount}">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    data-price="{{ $product->selling_price }}"
                                    data-stock="{{ $product->stock_quantity }}"
                                    data-unit="{{ $product->unit_of_measure ?? 'pcs' }}">
                                    {{ $product->product_name }}
                                    ({{ $product->product_code }})
                                    - Stock: {{ $product->stock_quantity }}
                                    - Price: ৳{{ number_format($product->selling_price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted stock-info" id="stock-info-${itemCount}"></small>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="items[${itemCount}][quantity]"
                                   class="form-control item-quantity"
                                   value="1" min="0.0001" step="0.0001" required data-index="${itemCount}">
                            <span class="input-group-text unit-text">pcs</span>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="items[${itemCount}][unit_price]"
                               class="form-control item-price"
                               value="0" min="0" step="0.01" required data-index="${itemCount}">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="items[${itemCount}][discount]"
                                   class="form-control item-discount"
                                   value="0" min="0" max="100" step="0.01" data-index="${itemCount}">
                            <span class="input-group-text">%</span>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control item-amount" value="0.00" readonly>
                        <input type="hidden" name="items[${itemCount}][amount]" class="item-amount-hidden" value="0">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                tbody.appendChild(newRow);
                itemCount++;

                // Enable first remove button if multiple rows
                const firstRemoveBtn = document.querySelector('.item-row:first-child .remove-item');
                if (firstRemoveBtn && document.querySelectorAll('.item-row').length > 1) {
                    firstRemoveBtn.disabled = false;
                }

                renumberRows();
                calculateTotals();
            }

            function addSampleItems() {
                if ({{ $products->count() }} === 0) {
                    alert('No products available. Please add products first.');
                    return;
                }

                // Clear existing items except first
                const rows = document.querySelectorAll('.item-row');
                for (let i = 1; i < rows.length; i++) {
                    rows[i].remove();
                }
                itemCount = 1;

                // Get first product
                const firstProduct = {!! $products->count() > 0 ? json_encode($products->first()) : 'null' !!};
                if (!firstProduct) return;

                // Update first row
                const firstRow = document.querySelector('.item-row');
                if (firstRow) {
                    const productSelect = firstRow.querySelector('.product-select');
                    const unitText = firstRow.querySelector('.unit-text');

                    if (productSelect) {
                        productSelect.value = firstProduct.id;
                        updateProductDetails(0);
                    }

                    if (unitText) {
                        unitText.textContent = firstProduct.unit_of_measure || 'pcs';
                    }

                    firstRow.querySelector('.item-quantity').value = 2;
                    firstRow.querySelector('.item-discount').value = 5;
                }

                // Add 2 more sample items if available
                for (let i = 1; i < 3 && i < {{ $products->count() }}; i++) {
                    addItemRow();
                    const newRow = document.querySelector('.item-row:last-child');
                    const product = {!! json_encode($products->get(1)) !!}; // Get second product

                    if (newRow && product) {
                        const productSelect = newRow.querySelector('.product-select');
                        const unitText = newRow.querySelector('.unit-text');

                        if (productSelect) {
                            productSelect.value = product.id;
                            updateProductDetails(itemCount - 1);
                        }

                        if (unitText) {
                            unitText.textContent = product.unit_of_measure || 'pcs';
                        }

                        newRow.querySelector('.item-quantity').value = 3;
                        newRow.querySelector('.item-discount').value = i * 2;
                    }
                }

                calculateTotals();
            }

            function clearForm() {
                if (confirm('Are you sure you want to clear the form? All data will be lost.')) {
                    // Reset form fields
                    if (elements.form) {
                        elements.form.reset();
                        // Manually reset select elements
                        document.querySelectorAll('select').forEach(select => {
                            select.selectedIndex = 0;
                        });
                    }

                    // Reset customer selection
                    if (elements.customerSelect) {
                        elements.customerSelect.selectedIndex = 0;
                        updateCustomerDetails();
                    }

                    // Clear items
                    const rows = document.querySelectorAll('.item-row');
                    for (let i = 1; i < rows.length; i++) {
                        rows[i].remove();
                    }

                    // Reset first row
                    const firstRow = document.querySelector('.item-row');
                    if (firstRow) {
                        const productSelect = firstRow.querySelector('.product-select');
                        if (productSelect) productSelect.selectedIndex = 0;
                        firstRow.querySelector('.item-quantity').value = 1;
                        firstRow.querySelector('.item-price').value = 0;
                        firstRow.querySelector('.item-discount').value = 0;
                        const firstRemoveBtn = firstRow.querySelector('.remove-item');
                        if (firstRemoveBtn) firstRemoveBtn.disabled = true;

                        // Clear stock info
                        const stockInfo = firstRow.querySelector('.stock-info');
                        if (stockInfo) stockInfo.textContent = '';

                        // Reset unit text
                        const unitText = firstRow.querySelector('.unit-text');
                        if (unitText) unitText.textContent = 'pcs';
                    }

                    itemCount = 1;
                    taxRate = 15;
                    shippingCharges = 0;
                    adjustment = 0;

                    // Reset tax, shipping, and adjustment
                    if (elements.taxRateInput) elements.taxRateInput.value = 15;
                    if (elements.shippingChargesInput) elements.shippingChargesInput.value = 0;
                    if (elements.adjustmentInput) elements.adjustmentInput.value = 0;

                    updateElementText('summaryTaxRate', '15.00');
                    updateElementText('summaryShipping', formatCurrency(0));
                    updateElementText('summaryAdjustment', '+৳0.00');

                    renumberRows();
                    calculateTotals();
                }
            }

            function updateProductDetails(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const productSelect = row.querySelector('.product-select');
                const priceInput = row.querySelector('.item-price');
                const unitText = row.querySelector('.unit-text');
                const selectedOption = productSelect.options[productSelect.selectedIndex];

                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const unit = selectedOption.getAttribute('data-unit');

                    if (price && priceInput) {
                        priceInput.value = parseFloat(price).toFixed(2);
                    }

                    if (unit && unitText) {
                        unitText.textContent = unit;
                    }

                    updateStockInfo(index);
                }

                calculateItemTotal(index);
                calculateTotals();
            }

            function updateStockInfo(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.item-quantity');
                const stockInfo = row.querySelector('.stock-info');

                if (!productSelect || !quantityInput || !stockInfo) return;

                const selectedOption = productSelect.options[productSelect.selectedIndex];

                if (selectedOption.value) {
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                    const quantity = parseFloat(quantityInput.value) || 0;

                    if (stock < quantity) {
                        stockInfo.textContent = `Insufficient stock! Available: ${stock}`;
                        stockInfo.className = 'stock-warning';
                    } else {
                        stockInfo.textContent = `Stock available: ${stock}`;
                        stockInfo.className = 'stock-ok';
                    }
                } else {
                    stockInfo.textContent = '';
                }
            }

            function calculateItemTotal(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const discount = parseFloat(row.querySelector('.item-discount').value) || 0;

                const itemTotal = quantity * price;
                const itemDiscount = itemTotal * (discount / 100);
                const itemAmount = itemTotal - itemDiscount;

                const amountInput = row.querySelector('.item-amount');
                const amountHidden = row.querySelector('.item-amount-hidden');

                if (amountInput) amountInput.value = formatCurrency(itemAmount, false);
                if (amountHidden) amountHidden.value = itemAmount.toFixed(2);
            }

            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalItems = 0;
                let totalQuantity = 0;

                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const discount = parseFloat(row.querySelector('.item-discount').value) || 0;

                    const itemTotal = quantity * price;
                    const itemDiscount = itemTotal * (discount / 100);
                    const itemAmount = itemTotal - itemDiscount;

                    subtotal += itemTotal;
                    totalDiscount += itemDiscount;

                    if (quantity > 0) totalItems++;
                    totalQuantity += quantity;

                    calculateItemTotal(index);
                });

                const taxableAmount = subtotal - totalDiscount;
                const taxAmount = taxableAmount * (taxRate / 100);
                const totalAmount = taxableAmount + taxAmount + shippingCharges + adjustment;

                // Update table
                updateElementValue('subtotal', formatCurrency(subtotal, false));
                updateElementValue('totalDiscount', formatCurrency(totalDiscount, false));
                updateElementValue('taxableAmount', formatCurrency(taxableAmount, false));
                updateElementValue('taxAmount', formatCurrency(taxAmount, false));
                updateElementValue('totalAmount', formatCurrency(totalAmount, false));

                // Update hidden fields
                updateElementValue('subtotal-hidden', subtotal.toFixed(2));
                updateElementValue('total-discount-hidden', totalDiscount.toFixed(2));
                updateElementValue('taxable-amount-hidden', taxableAmount.toFixed(2));
                updateElementValue('tax-amount-hidden', taxAmount.toFixed(2));
                updateElementValue('total-amount-hidden', totalAmount.toFixed(2));

                // Update summary
                updateElementText('summarySubtotal', formatCurrency(subtotal));
                updateElementText('summaryDiscount', '- ' + formatCurrency(totalDiscount));
                updateElementText('summaryTaxable', formatCurrency(taxableAmount));
                updateElementText('summaryTax', formatCurrency(taxAmount));
                updateElementText('summaryTotal', formatCurrency(totalAmount));

                // Update counters
                updateElementText('totalItemsCount', totalItems);
                updateElementText('totalQuantity', totalQuantity.toFixed(4));
            }

            function renumberRows() {
                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const firstTd = row.querySelector('td:first-child');
                    if (firstTd) firstTd.textContent = index + 1;

                    // Update all input names
                    const inputs = row.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && name.includes('items[')) {
                            input.name = name.replace(/items\[\d+\]/, `items[${index}]`);
                            input.dataset.index = index;
                        }
                    });

                    // Update stock info ID
                    const stockInfo = row.querySelector('.stock-info');
                    if (stockInfo) stockInfo.id = `stock-info-${index}`;
                });
                itemCount = document.querySelectorAll('.item-row').length;
            }

            function formatCurrency(amount, withSymbol = true) {
                const formatted = parseFloat(amount).toLocaleString('en-BD', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                return withSymbol ? `৳${formatted}` : formatted;
            }

            function updateElementValue(id, value) {
                const element = document.getElementById(id);
                if (element) element.value = value;
            }

            function updateElementText(id, text) {
                const element = document.getElementById(id);
                if (element) element.textContent = text;
            }

            console.log('Sales Order Form - Initialization complete');
        });
    </script>
@endpush
