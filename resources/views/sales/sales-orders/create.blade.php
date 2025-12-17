{{-- resources/views/sales/sales-orders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Sales Order')

@section('content')
    <div class="container-fluid py-4">
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
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Order Number</label>
                                    <input type="text" class="form-control"
                                        value="{{ $order_number ?? 'SO-' . date('YmdHis') }}" readonly>
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
                                                {{ old('customer_id', $selected_customer_id) == $customer->id ? 'selected' : '' }}
                                                data-address="{{ $customer->address ?? '' }}"
                                                data-phone="{{ $customer->phone ?? '' }}"
                                                data-email="{{ $customer->email ?? '' }}">
                                                {{ $customer->customer_name ?? $customer->email }}
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
                                        value="{{ old('sales_person') }}" placeholder="Enter sales person name">
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
                            </div>
                        </div>
                    </div>

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
                                            <th width="35%">Description *</th>
                                            <th width="15%">Quantity *</th>
                                            <th width="15%">Unit Price *</th>
                                            <th width="15%">Discount %</th>
                                            <th width="15%">Amount</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        @php
                                            $oldItems = old('items', [
                                                [
                                                    'description' => '',
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
                                                    <input type="text" name="items[{{ $index }}][description]"
                                                        class="form-control item-description @error('items.' . $index . '.description') is-invalid @enderror"
                                                        value="{{ $item['description'] }}"
                                                        placeholder="Product/Service description" required>
                                                    @error('items.' . $index . '.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror"
                                                        value="{{ $item['quantity'] }}" min="0.01" step="0.01"
                                                        required>
                                                    @error('items.' . $index . '.quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control item-price @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                        value="{{ $item['unit_price'] }}" min="0" step="0.01"
                                                        required>
                                                    @error('items.' . $index . '.unit_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][discount]"
                                                        class="form-control item-discount"
                                                        value="{{ $item['discount'] ?? 0 }}" min="0"
                                                        max="100" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control item-amount" value="0.00"
                                                        readonly>
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
                                            <td><input type="text" class="form-control" id="subtotal" value="0.00"
                                                    readonly></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Discount:</strong></td>
                                            <td><input type="text" class="form-control" id="totalDiscount"
                                                    value="0.00" readonly></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Taxable Amount:</strong></td>
                                            <td><input type="text" class="form-control" id="taxableAmount"
                                                    value="0.00" readonly></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <label class="me-2 mb-0">Tax %:</label>
                                                    <input type="number" name="tax_rate" id="taxRate"
                                                        class="form-control w-auto @error('tax_rate') is-invalid @enderror"
                                                        value="{{ old('tax_rate', 18) }}" min="0" max="100"
                                                        step="0.01">
                                                    @error('tax_rate')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td><input type="text" class="form-control" id="taxAmount" value="0.00"
                                                    readonly></td>
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
                                        <tr class="table-active">
                                            <td colspan="5" class="text-end"><strong>Total Amount:</strong></td>
                                            <td><input type="text" class="form-control fw-bold" id="totalAmount"
                                                    value="0.00" readonly></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

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

                <div class="col-lg-4">
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
                                <span class="text-muted">Tax (<span id="summaryTaxRate">18</span>%):</span>
                                <span id="summaryTax">৳0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Charges:</span>
                                <span id="summaryShipping">৳0.00</span>
                            </div>

                            <hr>

                            <div class="mb-3 d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="summaryTotal">৳0.00</span>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" name="action" value="save_draft"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-save me-2"></i>Save as Draft
                                </button>
                                <button type="submit" name="action" value="save_confirm" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i>Save & Confirm
                                </button>
                            </div>
                        </div>
                    </div>

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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sales Order Form - Initializing...');

            let itemCount = {{ count(old('items', [0])) }};
            let taxRate = parseFloat({{ old('tax_rate', 18) }});
            let shippingCharges = parseFloat({{ old('shipping_charges', 0) }});

            // Initialize elements
            const elements = {
                customerSelect: document.getElementById('customerSelect'),
                customerDetails: document.getElementById('customerDetails'),
                shippingAddress: document.getElementById('shippingAddress'),
                billingAddress: document.getElementById('billingAddress'),
                taxRateInput: document.getElementById('taxRate'),
                shippingChargesInput: document.getElementById('shippingChargesInput'),
                form: document.getElementById('salesOrderForm'),
                addItemBtn: document.getElementById('addItemBtn'),
                addSampleItemsBtn: document.getElementById('addSampleItems'),
                clearFormBtn: document.getElementById('clearForm'),
                itemsBody: document.getElementById('itemsBody'),
            };

            // Sample products
            const sampleProducts = [{
                    description: 'Laptop - Dell Inspiron 15',
                    quantity: 1,
                    unit_price: 45000.00,
                    discount: 5.00
                },
                {
                    description: 'Wireless Mouse - Logitech',
                    quantity: 2,
                    unit_price: 1200.00,
                    discount: 0.00
                },
                {
                    description: 'Monitor 24" Full HD',
                    quantity: 1,
                    unit_price: 12000.00,
                    discount: 10.00
                }
            ];

            // Helper to format currency
            function formatCurrency(amount) {
                return '৳' + parseFloat(amount).toFixed(2);
            }

            // Helper to update text in summary box
            function updateElementText(id, value) {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value;
                }
            }

            // --- Core Calculation Logic ---
            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;

                // 1. Loop through all item rows
                document.querySelectorAll('.item-row').forEach(row => {
                    const quantityInput = row.querySelector('.item-quantity');
                    const priceInput = row.querySelector('.item-price');
                    const discountInput = row.querySelector('.item-discount');
                    const amountInput = row.querySelector('.item-amount');

                    // Sanitize inputs
                    const quantity = parseFloat(quantityInput ? quantityInput.value : 0) || 0;
                    const price = parseFloat(priceInput ? priceInput.value : 0) || 0;
                    const discountRate = parseFloat(discountInput ? discountInput.value : 0) || 0;

                    // Calculate item total
                    let lineTotal = quantity * price;
                    let lineDiscount = (lineTotal * discountRate) / 100;
                    let itemAmount = lineTotal - lineDiscount;

                    // Update item amount field
                    if (amountInput) {
                        amountInput.value = itemAmount.toFixed(2);
                    }

                    // Accumulate totals
                    subtotal += lineTotal;
                    totalDiscount += lineDiscount;
                });

                // 2. Calculate Order Totals
                const taxableAmount = subtotal - totalDiscount;
                const taxAmount = (taxableAmount * taxRate) / 100;
                const totalAmount = taxableAmount + taxAmount + shippingCharges;

                // 3. Update Footer (Items Table)
                document.getElementById('subtotal').value = subtotal.toFixed(2);
                document.getElementById('totalDiscount').value = totalDiscount.toFixed(2);
                document.getElementById('taxableAmount').value = taxableAmount.toFixed(2);
                document.getElementById('taxAmount').value = taxAmount.toFixed(2);
                document.getElementById('totalAmount').value = totalAmount.toFixed(2);

                // 4. Update Summary Card
                updateElementText('summarySubtotal', formatCurrency(subtotal));
                updateElementText('summaryDiscount', formatCurrency(totalDiscount));
                updateElementText('summaryTaxable', formatCurrency(taxableAmount));
                updateElementText('summaryTax', formatCurrency(taxAmount));
                updateElementText('summaryTotal', formatCurrency(totalAmount));
            }

            // --- Dynamic Row Management ---
            function getNewItemRow(index, data = {}) {
                const defaultData = {
                    description: '',
                    quantity: 1,
                    unit_price: 0.00,
                    discount: 0.00,
                    ...data
                };

                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <input type="text" name="items[${index}][description]" class="form-control item-description"
                            value="${defaultData.description}" placeholder="Product/Service description" required>
                    </td>
                    <td>
                        <input type="number" name="items[${index}][quantity]" class="form-control item-quantity"
                            value="${defaultData.quantity}" min="0.01" step="0.01" required>
                    </td>
                    <td>
                        <input type="number" name="items[${index}][unit_price]" class="form-control item-price"
                            value="${defaultData.unit_price}" min="0" step="0.01" required>
                    </td>
                    <td>
                        <input type="number" name="items[${index}][discount]" class="form-control item-discount"
                            value="${defaultData.discount}" min="0" max="100" step="0.01">
                    </td>
                    <td>
                        <input type="text" class="form-control item-amount" value="0.00" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                // Add event listeners to the new inputs
                newRow.querySelectorAll('.item-quantity, .item-price, .item-discount').forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });

                return newRow;
            }

            function addItemRow(data = {}) {
                const itemsBody = elements.itemsBody;
                const newRow = getNewItemRow(itemCount, data);
                itemsBody.appendChild(newRow);
                itemCount++;
                renumberRows();
                calculateTotals();
            }

            function renumberRows() {
                const rows = document.querySelectorAll('#itemsBody .item-row');
                itemCount = 0;
                rows.forEach((row, index) => {
                    // Update the index display in the first column
                    row.querySelector('td:first-child').textContent = index + 1;

                    // Update input names to ensure sequential indexing for Laravel
                    row.querySelectorAll('input, select').forEach(input => {
                        const nameAttr = input.getAttribute('name');
                        if (nameAttr) {
                            input.setAttribute('name', nameAttr.replace(/\[\d+\]/g, `[${index}]`));
                        }
                    });

                    // Manage the disabled state of the remove button (disable on the last/only row)
                    const removeButton = row.querySelector('.remove-item');
                    if (removeButton) {
                        if (rows.length === 1) {
                            removeButton.setAttribute('disabled', 'disabled');
                        } else {
                            removeButton.removeAttribute('disabled');
                        }
                    }
                    itemCount++;
                });
            }

            // --- Event Handlers ---

            function updateCustomerDetails() {
                if (!elements.customerSelect || !elements.customerDetails) return;

                const selectedOption = elements.customerSelect.options[elements.customerSelect.selectedIndex];

                if (selectedOption.value) {
                    const address = selectedOption.getAttribute('data-address');
                    const phone = selectedOption.getAttribute('data-phone');
                    const email = selectedOption.getAttribute('data-email');

                    // Update Customer Details Card
                    elements.customerDetails.innerHTML = `
                        <p><strong>Email:</strong> ${email || 'Not Available'}</p>
                        <p><strong>Phone:</strong> ${phone || 'Not Available'}</p>
                        <p><strong>Address:</strong> ${address || 'Not Available'}</p>
                    `;

                    // Auto-fill Shipping/Billing Address if they are empty
                    if (!elements.shippingAddress.value) {
                        elements.shippingAddress.value = address || '';
                    }
                    if (!elements.billingAddress.value) {
                        elements.billingAddress.value = elements.shippingAddress.value;
                    }

                } else {
                    elements.customerDetails.innerHTML =
                        '<p class="mb-2"><i class="fas fa-info-circle me-2"></i>Select a customer to view details</p>';
                    // Clear addresses if customer is deselected
                    elements.shippingAddress.value = '';
                    elements.billingAddress.value = '';
                }
            }

            function addSampleItems() {
                // Clear existing items first, then add samples
                elements.itemsBody.innerHTML = '';
                itemCount = 0;
                sampleProducts.forEach(item => {
                    addItemRow(item);
                });
                calculateTotals();
            }

            function clearForm() {
                if (confirm('Are you sure you want to clear the entire form? All unsaved data will be lost.')) {
                    elements.form.reset(); // Reset form elements
                    elements.itemsBody.innerHTML = ''; // Clear items
                    itemCount = 0;
                    addItemRow(); // Add the default empty row back
                    // Reset variables to initial state
                    taxRate = 18;
                    shippingCharges = 0;
                    updateCustomerDetails(); // Reset customer details
                    calculateTotals(); // Recalculate totals
                }
            }


            // --- Initialization and Event Attachments ---

            // 1. Update customer details on load/change
            if (elements.customerSelect) {
                elements.customerSelect.addEventListener('change', updateCustomerDetails);
                updateCustomerDetails(); // Initial call to populate if old data exists
            }

            // 2. Add item button
            if (elements.addItemBtn) {
                elements.addItemBtn.addEventListener('click', () => addItemRow({}));
            }

            // 3. Add sample items button
            if (elements.addSampleItemsBtn) {
                elements.addSampleItemsBtn.addEventListener('click', addSampleItems);
            }

            // 4. Clear form button
            if (elements.clearFormBtn) {
                elements.clearFormBtn.addEventListener('click', clearForm);
            }

            // 5. Tax rate change
            if (elements.taxRateInput) {
                elements.taxRateInput.addEventListener('input', function() {
                    taxRate = parseFloat(this.value) || 0;
                    updateElementText('summaryTaxRate', taxRate);
                    calculateTotals();
                });
            }

            // 6. Shipping charges change
            if (elements.shippingChargesInput) {
                elements.shippingChargesInput.addEventListener('input', function() {
                    shippingCharges = parseFloat(this.value) || 0;
                    updateElementText('summaryShipping', formatCurrency(shippingCharges));
                    calculateTotals();
                });
                // Trigger initial update for shipping in summary
                updateElementText('summaryShipping', formatCurrency(shippingCharges));
            }

            // 7. Event delegation for removing rows and item calculations
            elements.itemsBody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const row = e.target.closest('.item-row');
                    if (row && document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        renumberRows();
                        calculateTotals();
                    }
                }
            });

            elements.itemsBody.addEventListener('input', function(e) {
                if (e.target.closest('.item-quantity') || e.target.closest('.item-price') || e.target.closest(
                        '.item-discount')) {
                    calculateTotals();
                }
            });

            // Initial calculations
            renumberRows(); // Ensure correct indexes and remove button state on page load (for old data)
            calculateTotals();
        });
    </script>
@endpush
