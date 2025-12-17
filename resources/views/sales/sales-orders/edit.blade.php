{{-- resources/views/sales/sales-orders/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Sales Order - ' . $salesOrder->order_number)

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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
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
                        <li class="breadcrumb-item"><a
                                href="{{ route('sales.sales-orders.show', $salesOrder) }}">{{ $salesOrder->order_number }}</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Edit Sales Order</h1>
                <p class="text-muted mb-0">{{ $salesOrder->order_number }}</p>

                <!-- Status Badge -->
                <div class="mt-2">
                    <span class="badge bg-{{ $salesOrder->status_color }} fs-6">
                        {{ ucfirst($salesOrder->status) }}
                    </span>
                    @if ($salesOrder->status != 'draft')
                        <small class="text-muted ms-2">
                            <i class="fas fa-info-circle"></i> This order is {{ $salesOrder->status }}. Some fields may be
                            disabled.
                        </small>
                    @endif
                </div>
            </div>
            <div>
                <a href="{{ route('sales.sales-orders.show', $salesOrder) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </div>

        <form action="{{ route('sales.sales-orders.update', $salesOrder) }}" method="POST" id="salesOrderForm">
            @csrf
            @method('PUT')

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
                                    <input type="text" class="form-control" value="{{ $salesOrder->order_number }}"
                                        readonly>
                                    <small class="text-muted">Auto-generated</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Order Date *</label>
                                    <input type="date" name="order_date"
                                        class="form-control @error('order_date') is-invalid @enderror"
                                        value="{{ old('order_date', $salesOrder->order_date->format('Y-m-d')) }}"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : 'required' }}>
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer *</label>
                                    <select name="customer_id" id="customerSelect"
                                        class="form-select @error('customer_id') is-invalid @enderror"
                                        {{ $salesOrder->status != 'draft' ? 'disabled' : 'required' }}>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id', $salesOrder->customer_id) == $customer->id ? 'selected' : '' }}
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
                                    @if ($salesOrder->status != 'draft')
                                        <input type="hidden" name="customer_id" value="{{ $salesOrder->customer_id }}">
                                    @endif
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Delivery Date *</label>
                                    <input type="date" name="delivery_date"
                                        class="form-control @error('delivery_date') is-invalid @enderror"
                                        value="{{ old('delivery_date', $salesOrder->delivery_date->format('Y-m-d')) }}"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : 'required' }}>
                                    @error('delivery_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Sales Person</label>
                                    <input type="text" name="sales_person"
                                        class="form-control @error('sales_person') is-invalid @enderror"
                                        value="{{ old('sales_person', $salesOrder->sales_person) }}"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>
                                    @error('sales_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" name="reference_number"
                                        class="form-control @error('reference_number') is-invalid @enderror"
                                        value="{{ old('reference_number', $salesOrder->reference_number) }}"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Shipping Address</label>
                                    <textarea name="shipping_address" id="shippingAddress"
                                        class="form-control @error('shipping_address') is-invalid @enderror" rows="2"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>{{ old('shipping_address', $salesOrder->shipping_address) }}</textarea>
                                    <small class="text-muted">Leave blank to use customer's default address</small>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Billing Address</label>
                                    <textarea name="billing_address" id="billingAddress"
                                        class="form-control @error('billing_address') is-invalid @enderror" rows="2"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>{{ old('billing_address', $salesOrder->billing_address) }}</textarea>
                                    <small class="text-muted">Leave blank to use shipping address</small>
                                    @error('billing_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select"
                                        {{ $salesOrder->status != 'draft' ? 'disabled' : '' }}>
                                        <option value="draft"
                                            {{ old('status', $salesOrder->status) == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="pending"
                                            {{ old('status', $salesOrder->status) == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="confirmed"
                                            {{ old('status', $salesOrder->status) == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing"
                                            {{ old('status', $salesOrder->status) == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="completed"
                                            {{ old('status', $salesOrder->status) == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="cancelled"
                                            {{ old('status', $salesOrder->status) == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    @if ($salesOrder->status != 'draft')
                                        <input type="hidden" name="status" value="{{ $salesOrder->status }}">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Payment Status</label>
                                    <select name="payment_status" class="form-select">
                                        <option value="pending"
                                            {{ old('payment_status', $salesOrder->payment_status) == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="partial"
                                            {{ old('payment_status', $salesOrder->payment_status) == 'partial' ? 'selected' : '' }}>
                                            Partial</option>
                                        <option value="paid"
                                            {{ old('payment_status', $salesOrder->payment_status) == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                        <option value="overdue"
                                            {{ old('payment_status', $salesOrder->payment_status) == 'overdue' ? 'selected' : '' }}>
                                            Overdue</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Currency</label>
                                    <select name="currency" class="form-select">
                                        <option value="BDT"
                                            {{ old('currency', $salesOrder->currency) == 'BDT' ? 'selected' : '' }}>BDT -
                                            Bangladeshi Taka</option>
                                        <option value="USD"
                                            {{ old('currency', $salesOrder->currency) == 'USD' ? 'selected' : '' }}>USD -
                                            US Dollar</option>
                                        <option value="EUR"
                                            {{ old('currency', $salesOrder->currency) == 'EUR' ? 'selected' : '' }}>EUR -
                                            Euro</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date"
                                        class="form-control @error('due_date') is-invalid @enderror"
                                        value="{{ old('due_date', \Carbon\Carbon::parse($salesOrder->due_date)->format('d M, Y') ?? 'N/A') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Order Items</h5>
                            @if ($salesOrder->status == 'draft')
                                <button type="button" class="btn btn-light btn-sm" id="addItemBtn">
                                    <i class="fas fa-plus me-1"></i>Add Item
                                </button>
                            @endif
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
                                            @if ($salesOrder->status == 'draft')
                                                <th width="5%"></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        @foreach ($salesOrder->items as $index => $item)
                                            <tr class="item-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <select name="items[{{ $index }}][product_id]"
                                                        class="form-select product-select @error('items.' . $index . '.product_id') is-invalid @enderror"
                                                        {{ $salesOrder->status != 'draft' ? 'disabled' : 'required' }}
                                                        data-index="{{ $index }}">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                data-price="{{ $product->selling_price }}"
                                                                data-stock="{{ $product->stock_quantity }}"
                                                                data-unit="{{ $product->unit_of_measure ?? 'pcs' }}"
                                                                {{ old('items.' . $index . '.product_id', $item->product_id) == $product->id ? 'selected' : '' }}>
                                                                {{ $product->product_name }}
                                                                ({{ $product->product_code }})
                                                                - Stock: {{ $product->stock_quantity }}
                                                                - Price: ৳{{ number_format($product->selling_price, 2) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($salesOrder->status != 'draft')
                                                        <input type="hidden"
                                                            name="items[{{ $index }}][product_id]"
                                                            value="{{ $item->product_id }}">
                                                    @endif
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
                                                            value="{{ old('items.' . $index . '.quantity', $item->quantity) }}"
                                                            min="0.0001" step="0.0001"
                                                            {{ $salesOrder->status != 'draft' ? 'readonly' : 'required' }}
                                                            data-index="{{ $index }}">
                                                        <span class="input-group-text unit-text">
                                                            {{ $item->product->unit_of_measure ?? 'pcs' }}
                                                        </span>
                                                    </div>
                                                    @error('items.' . $index . '.quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control item-price @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                        value="{{ old('items.' . $index . '.unit_price', $item->unit_price) }}"
                                                        min="0" step="0.01"
                                                        {{ $salesOrder->status != 'draft' ? 'readonly' : 'required' }}
                                                        data-index="{{ $index }}">
                                                    @error('items.' . $index . '.unit_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" name="items[{{ $index }}][discount]"
                                                            class="form-control item-discount"
                                                            value="{{ old('items.' . $index . '.discount', $item->discount_percentage) }}"
                                                            min="0" max="100" step="0.01"
                                                            {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}
                                                            data-index="{{ $index }}">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control item-amount"
                                                        value="{{ number_format($item->total_amount, 2) }}" readonly>
                                                    <input type="hidden" name="items[{{ $index }}][amount]"
                                                        class="item-amount-hidden" value="{{ $item->total_amount }}">
                                                </td>
                                                @if ($salesOrder->status == 'draft')
                                                    <td>
                                                        @if ($loop->first && $salesOrder->items->count() == 1)
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item" disabled>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-item">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Subtotal:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="subtotal"
                                                    value="{{ number_format($salesOrder->subtotal, 2) }}" readonly>
                                                <input type="hidden" name="subtotal" id="subtotal-hidden"
                                                    value="{{ $salesOrder->subtotal }}">
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Discount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="totalDiscount"
                                                    value="{{ number_format($salesOrder->total_discount, 2) }}" readonly>
                                                <input type="hidden" name="total_discount" id="total-discount-hidden"
                                                    value="{{ $salesOrder->total_discount }}">
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Taxable Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="taxableAmount"
                                                    value="{{ number_format($salesOrder->taxable_amount, 2) }}" readonly>
                                                <input type="hidden" name="taxable_amount" id="taxable-amount-hidden"
                                                    value="{{ $salesOrder->taxable_amount }}">
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <label class="me-2 mb-0">Tax %:</label>
                                                    <input type="number" name="tax_rate" id="taxRate"
                                                        class="form-control w-auto @error('tax_rate') is-invalid @enderror"
                                                        value="{{ old('tax_rate', $salesOrder->tax_rate) }}"
                                                        min="0" max="100" step="0.01"
                                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>
                                                    @error('tax_rate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="taxAmount"
                                                    value="{{ number_format($salesOrder->tax_amount, 2) }}" readonly>
                                                <input type="hidden" name="tax_amount" id="tax-amount-hidden"
                                                    value="{{ $salesOrder->tax_amount }}">
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Shipping Charges:</strong></td>
                                            <td>
                                                <input type="number" name="shipping_charges" id="shippingChargesInput"
                                                    class="form-control @error('shipping_charges') is-invalid @enderror"
                                                    value="{{ old('shipping_charges', $salesOrder->shipping_charges) }}"
                                                    min="0" step="0.01"
                                                    {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>
                                                @error('shipping_charges')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Adjustment:</strong></td>
                                            <td>
                                                <input type="number" name="adjustment" id="adjustmentInput"
                                                    class="form-control"
                                                    value="{{ old('adjustment', $salesOrder->adjustment) }}"
                                                    step="0.01"
                                                    {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>
                                                <small class="text-muted">+/- adjustment</small>
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="{{ $salesOrder->status == 'draft' ? '5' : '4' }}"
                                                class="text-end"><strong>Total Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control fw-bold" id="totalAmount"
                                                    value="{{ number_format($salesOrder->total_amount, 2) }}" readonly>
                                                <input type="hidden" name="total_amount" id="total-amount-hidden"
                                                    value="{{ $salesOrder->total_amount }}">
                                            </td>
                                            @if ($salesOrder->status == 'draft')
                                                <td></td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if ($salesOrder->status != 'draft')
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Items cannot be modified because this order is {{ $salesOrder->status }}.
                                </div>
                            @endif
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
                                    <select name="shipping_method" class="form-select"
                                        {{ $salesOrder->status != 'draft' ? 'disabled' : '' }}>
                                        <option value="">Select Method</option>
                                        <option value="pickup"
                                            {{ old('shipping_method', $salesOrder->shipping_method) == 'pickup' ? 'selected' : '' }}>
                                            Customer Pickup</option>
                                        <option value="delivery"
                                            {{ old('shipping_method', $salesOrder->shipping_method) == 'delivery' ? 'selected' : '' }}>
                                            Delivery</option>
                                        <option value="courier"
                                            {{ old('shipping_method', $salesOrder->shipping_method) == 'courier' ? 'selected' : '' }}>
                                            Courier</option>
                                        <option value="transport"
                                            {{ old('shipping_method', $salesOrder->shipping_method) == 'transport' ? 'selected' : '' }}>
                                            Transport</option>
                                    </select>
                                    @if ($salesOrder->status != 'draft')
                                        <input type="hidden" name="shipping_method"
                                            value="{{ $salesOrder->shipping_method }}">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Payment Terms</label>
                                    <select name="payment_terms" class="form-select"
                                        {{ $salesOrder->status != 'draft' ? 'disabled' : '' }}>
                                        <option value="">Select Terms</option>
                                        <option value="advance"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == 'advance' ? 'selected' : '' }}>
                                            100% Advance</option>
                                        <option value="delivery"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == 'delivery' ? 'selected' : '' }}>
                                            On Delivery</option>
                                        <option value="7days"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == '7days' ? 'selected' : '' }}>
                                            7 Days</option>
                                        <option value="15days"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == '15days' ? 'selected' : '' }}>
                                            15 Days</option>
                                        <option value="30days"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == '30days' ? 'selected' : '' }}>
                                            30 Days</option>
                                        <option value="custom"
                                            {{ old('payment_terms', $salesOrder->payment_terms) == 'custom' ? 'selected' : '' }}>
                                            Custom</option>
                                    </select>
                                    @if ($salesOrder->status != 'draft')
                                        <input type="hidden" name="payment_terms"
                                            value="{{ $salesOrder->payment_terms }}">
                                    @endif
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                                        {{ $salesOrder->status != 'draft' ? 'readonly' : '' }} placeholder="Any special instructions or notes...">{{ old('notes', $salesOrder->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Terms & Conditions</label>
                                    <textarea name="terms_conditions" class="form-control @error('terms_conditions') is-invalid @enderror"
                                        rows="3" {{ $salesOrder->status != 'draft' ? 'readonly' : '' }}>{{ old('terms_conditions', $salesOrder->terms_conditions) }}</textarea>
                                    @error('terms_conditions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <div id="customerDetails">
                                <p class="mb-2"><strong>{{ $salesOrder->customer->customer_name }}</strong></p>
                                @if ($salesOrder->customer->company_name)
                                    <p class="mb-2"><strong>Company:</strong> {{ $salesOrder->customer->company_name }}
                                    </p>
                                @endif
                                @if ($salesOrder->customer->email)
                                    <p class="mb-2"><strong>Email:</strong> {{ $salesOrder->customer->email }}</p>
                                @endif
                                @if ($salesOrder->customer->phone)
                                    <p class="mb-2"><strong>Phone:</strong> {{ $salesOrder->customer->phone }}</p>
                                @endif
                                @if ($salesOrder->customer->address)
                                    <p class="mb-2"><strong>Address:</strong><br>{{ $salesOrder->customer->address }}
                                    </p>
                                @endif
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
                                <span id="summarySubtotal">৳{{ number_format($salesOrder->subtotal, 2) }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <span id="summaryDiscount"
                                    class="text-danger">-৳{{ number_format($salesOrder->total_discount, 2) }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Taxable Amount:</span>
                                <span id="summaryTaxable">৳{{ number_format($salesOrder->taxable_amount, 2) }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Tax (<span
                                        id="summaryTaxRate">{{ number_format($salesOrder->tax_rate, 2) }}</span>%):</span>
                                <span id="summaryTax">৳{{ number_format($salesOrder->tax_amount, 2) }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Charges:</span>
                                <span id="summaryShipping">৳{{ number_format($salesOrder->shipping_charges, 2) }}</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Adjustment:</span>
                                <span
                                    id="summaryAdjustment">{{ $salesOrder->adjustment > 0 ? '+' : '' }}৳{{ number_format($salesOrder->adjustment, 2) }}</span>
                            </div>

                            <hr>

                            <div class="mb-3 d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="summaryTotal">৳{{ number_format($salesOrder->total_amount, 2) }}</span>
                            </div>

                            <div class="alert alert-info">
                                <small><i class="fas fa-info-circle me-1"></i>
                                    Total Items: <span id="totalItemsCount">{{ $salesOrder->items->count() }}</span> |
                                    Total Quantity: <span
                                        id="totalQuantity">{{ number_format($salesOrder->items->sum('quantity'), 4) }}</span>
                                </small>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                @if ($salesOrder->status == 'draft')
                                    <button type="submit" name="action" value="update" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Order
                                    </button>
                                    <button type="submit" name="action" value="confirm" class="btn btn-success">
                                        <i class="fas fa-check-circle me-2"></i>Update & Confirm
                                    </button>
                                @else
                                    <button type="submit" name="action" value="update" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Order Details
                                    </button>
                                    <div class="alert alert-warning">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Only non-item fields can be updated for {{ $salesOrder->status }} orders.
                                        </small>
                                    </div>
                                @endif
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
                                <a href="{{ route('sales.sales-orders.show', $salesOrder) }}"
                                    class="btn btn-outline-secondary">
                                    <i class="fas fa-eye me-2"></i>View Order
                                </a>
                                @if ($salesOrder->status == 'draft')
                                    <button type="button" class="btn btn-outline-warning" id="clearForm">
                                        <i class="fas fa-broom me-2"></i>Reset Changes
                                    </button>
                                @endif
                                @if ($salesOrder->status == 'confirmed')
                                    <a href="{{ route('sales.invoices.create', ['order_id' => $salesOrder->id]) }}"
                                        class="btn btn-outline-success">
                                        <i class="fas fa-file-invoice me-2"></i>Create Invoice
                                    </a>
                                @endif
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

        input:read-only,
        select:disabled,
        textarea:read-only {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .badge.bg-draft {
            background-color: #6c757d;
        }

        .badge.bg-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge.bg-confirmed {
            background-color: #198754;
        }

        .badge.bg-processing {
            background-color: #0dcaf0;
        }

        .badge.bg-completed {
            background-color: #6f42c1;
        }

        .badge.bg-cancelled {
            background-color: #dc3545;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sales Order Edit Form - Initializing...');

            let itemCount = {{ $salesOrder->items->count() }};
            let taxRate = {{ $salesOrder->tax_rate }};
            let shippingCharges = {{ $salesOrder->shipping_charges }};
            let adjustment = {{ $salesOrder->adjustment }};
            const isDraft = {{ $salesOrder->status == 'draft' ? 'true' : 'false' }};

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
                clearFormBtn: document.getElementById('clearForm')
            };

            // Initialize
            updateCustomerDetails();
            if (isDraft) {
                attachEventListeners();
                calculateTotals(); // Recalculate to ensure consistency
            }

            function attachEventListeners() {
                // Customer select change
                if (elements.customerSelect) {
                    elements.customerSelect.addEventListener('change', updateCustomerDetails);
                }

                // Add item (only for draft orders)
                if (elements.addItemBtn && isDraft) {
                    elements.addItemBtn.addEventListener('click', addItemRow);
                }

                // Clear form (reset changes)
                if (elements.clearFormBtn) {
                    elements.clearFormBtn.addEventListener('click', function() {
                        if (confirm(
                                'Are you sure you want to reset all changes? This will reload the page with original values.'
                            )) {
                            window.location.reload();
                        }
                    });
                }

                // Tax rate change
                if (elements.taxRateInput && isDraft) {
                    elements.taxRateInput.addEventListener('input', function() {
                        taxRate = parseFloat(this.value) || 0;
                        updateElementText('summaryTaxRate', taxRate.toFixed(2));
                        calculateTotals();
                    });
                }

                // Shipping charges change
                if (elements.shippingChargesInput && isDraft) {
                    elements.shippingChargesInput.addEventListener('input', function() {
                        shippingCharges = parseFloat(this.value) || 0;
                        updateElementText('summaryShipping', formatCurrency(shippingCharges));
                        calculateTotals();
                    });
                }

                // Adjustment change
                if (elements.adjustmentInput && isDraft) {
                    elements.adjustmentInput.addEventListener('input', function() {
                        adjustment = parseFloat(this.value) || 0;
                        const sign = adjustment >= 0 ? '+' : '';
                        updateElementText('summaryAdjustment', sign + formatCurrency(adjustment));
                        calculateTotals();
                    });
                }

                // Remove item event delegation (only for draft)
                if (isDraft) {
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
                }

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

                        // For draft orders, validate items
                        if (isDraft) {
                            let validItems = 0;
                            document.querySelectorAll('.product-select').forEach(select => {
                                if (select.value) validItems++;
                            });

                            if (validItems === 0) {
                                e.preventDefault();
                                alert('Please add at least one item with a product selected');
                                return false;
                            }
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
                            <strong>${selectedOption.text.split('(')[0].trim()}</strong>
                        </div>
                        ${email ? `<div class="mb-2"><strong>Email:</strong> ${email}</div>` : ''}
                        ${phone ? `<div class="mb-2"><strong>Phone:</strong> ${phone}</div>` : ''}
                        ${address ? `<div class="mb-2"><strong>Address:</strong><br>${address}</div>` : ''}
                    `;

                    if (address && elements.shippingAddress && !elements.shippingAddress.value && isDraft) {
                        elements.shippingAddress.value = address;
                    }

                    if (address && elements.billingAddress && !elements.billingAddress.value && isDraft) {
                        elements.billingAddress.value = address;
                    }
                } else {
                    // Show current customer info
                    elements.customerDetails.innerHTML = `
                        <p class="mb-2"><strong>{{ $salesOrder->customer->customer_name }}</strong></p>
                        @if ($salesOrder->customer->company_name)
                            <p class="mb-2"><strong>Company:</strong> {{ $salesOrder->customer->company_name }}</p>
                        @endif
                        @if ($salesOrder->customer->email)
                            <p class="mb-2"><strong>Email:</strong> {{ $salesOrder->customer->email }}</p>
                        @endif
                        @if ($salesOrder->customer->phone)
                            <p class="mb-2"><strong>Phone:</strong> {{ $salesOrder->customer->phone }}</p>
                        @endif
                        @if ($salesOrder->customer->address)
                            <p class="mb-2"><strong>Address:</strong><br>{{ $salesOrder->customer->address }}</p>
                        @endif
                    `;
                }
            }

            function addItemRow() {
                if (!isDraft) return;

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

            function updateProductDetails(index) {
                if (!isDraft) return;

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
                if (!isDraft) return;

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
                if (!isDraft) return;

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
                if (!isDraft) return;

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
                if (!isDraft) return;

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

            console.log('Sales Order Edit Form - Initialization complete');
        });
    </script>
@endpush
