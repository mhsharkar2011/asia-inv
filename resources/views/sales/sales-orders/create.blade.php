{{-- resources/views/sales/sales-orders/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Sales Order')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.sales-orders.index') }}">Sales Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                    <!-- Basic Information Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Order Number *</label>
                                    <input type="text" class="form-control"
                                        value="{{ 'SO-' . date('Ymd') . rand(100, 999) }}" readonly>
                                    <small class="text-muted">Auto-generated</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Order Date *</label>
                                    <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer *</label>
                                    <select name="customer_id" id="customerSelect" class="form-select" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-gstin="{{ $customer->gstin ?? '' }}"
                                                data-address="{{ $customer->address_line1 ?? '' }} {{ $customer->city ?? '' }}"
                                                data-phone="{{ $customer->phone ?? '' }}">
                                                {{ $customer->name }} - {{ $customer->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Expected Delivery Date *</label>
                                    <input type="date" name="delivery_date" class="form-control"
                                        value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Sales Person</label>
                                    <input type="text" name="sales_person" class="form-control"
                                        placeholder="Enter sales person name">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" name="reference_number" class="form-control"
                                        placeholder="Customer PO/Reference">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Shipping Address</label>
                                    <textarea name="shipping_address" id="shippingAddress" class="form-control" rows="2"></textarea>
                                    <small class="text-muted">Leave blank to use customer's default address</small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Billing Address</label>
                                    <textarea name="billing_address" id="billingAddress" class="form-control" rows="2"></textarea>
                                    <small class="text-muted">Leave blank to use shipping address</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Card -->
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
                                            <th width="35%">Product/Service *</th>
                                            <th width="15%">Quantity *</th>
                                            <th width="15%">Unit Price *</th>
                                            <th width="15%">Discount %</th>
                                            <th width="15%">Amount</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <!-- Items will be added here dynamically -->
                                        <tr class="item-row">
                                            <td>1</td>
                                            <td>
                                                <input type="text" name="items[0][description]"
                                                    class="form-control item-description"
                                                    placeholder="Product description" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]"
                                                    class="form-control item-quantity" value="1" min="1"
                                                    step="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][unit_price]"
                                                    class="form-control item-price" value="0" min="0"
                                                    step="0.01" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][discount]"
                                                    class="form-control item-discount" value="0" min="0"
                                                    max="100" step="0.01">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-amount" value="0.00"
                                                    readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="subtotal" value="0.00"
                                                    readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Discount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="totalDiscount"
                                                    value="0.00" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>Taxable Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="taxableAmount"
                                                    value="0.00" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <label class="me-2 mb-0">GST %:</label>
                                                    <select id="gstRate" class="form-select w-auto">
                                                        <option value="0">0%</option>
                                                        <option value="5">5%</option>
                                                        <option value="12">12%</option>
                                                        <option value="18" selected>18%</option>
                                                        <option value="28">28%</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="gstAmount" value="0.00"
                                                    readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="5" class="text-end"><strong>Total Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control fw-bold" id="totalAmount"
                                                    value="0.00" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Card -->
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
                                        <option value="pickup">Customer Pickup</option>
                                        <option value="delivery">Delivery</option>
                                        <option value="courier">Courier</option>
                                        <option value="transport">Transport</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Payment Terms</label>
                                    <select name="payment_terms" class="form-select">
                                        <option value="">Select Terms</option>
                                        <option value="advance">100% Advance</option>
                                        <option value="delivery">On Delivery</option>
                                        <option value="7days" selected>7 Days</option>
                                        <option value="15days">15 Days</option>
                                        <option value="30days">30 Days</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Shipping Charges</label>
                                    <input type="number" name="shipping_charges" class="form-control" value="0"
                                        min="0" step="0.01" id="shippingCharges">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions or notes..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Terms & Conditions</label>
                                    <textarea name="terms_conditions" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Customer Details Card -->
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

                    <!-- Order Summary Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Subtotal:</span>
                                <span id="summarySubtotal">₹0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <span id="summaryDiscount" class="text-danger">-₹0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Taxable Amount:</span>
                                <span id="summaryTaxable">₹0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">GST (<span id="summaryGstRate">18</span>%):</span>
                                <span id="summaryGst">₹0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Charges:</span>
                                <span id="summaryShipping">₹0.00</span>
                            </div>

                            <hr>

                            <div class="mb-3 d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="summaryTotal">₹0.00</span>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" name="action" value="save_draft"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-save me-2"></i>Save as Draft
                                </button>
                                <button type="submit" name="action" value="save_confirm" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i>Save & Confirm Order
                                </button>
                                <button type="submit" name="action" value="save_invoice" class="btn btn-primary">
                                    <i class="fas fa-file-invoice me-2"></i>Save & Create Invoice
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
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
                                <a href="{{ route('inventory.products.create') }}" target="_blank"
                                    class="btn btn-outline-success">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Product
                                </a>
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
        .table th {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .item-row td {
            vertical-align: middle;
        }

        .form-control:read-only {
            background-color: #f8f9fa;
        }

        #customerDetails p {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 1;
            let gstRate = 18;
            let shippingCharges = 0;

            // Initialize elements
            const customerSelect = document.getElementById('customerSelect');
            const customerDetails = document.getElementById('customerDetails');
            const shippingAddress = document.getElementById('shippingAddress');
            const billingAddress = document.getElementById('billingAddress');
            const gstRateSelect = document.getElementById('gstRate');
            const shippingChargesInput = document.getElementById('shippingCharges');

            // Sample products for quick add
            const sampleProducts = [{
                    description: 'Laptop - Dell Inspiron 15',
                    price: 45000
                },
                {
                    description: 'Wireless Mouse - Logitech',
                    price: 1200
                },
                {
                    description: 'Keyboard - Mechanical',
                    price: 2500
                },
                {
                    description: 'Monitor 24" Full HD',
                    price: 12000
                },
                {
                    description: 'Webcam HD 1080p',
                    price: 3500
                }
            ];

            // Update customer details when selection changes
            customerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const gstin = selectedOption.getAttribute('data-gstin');
                    const address = selectedOption.getAttribute('data-address');
                    const phone = selectedOption.getAttribute('data-phone');

                    let detailsHtml = `
                <p><strong>GSTIN:</strong> ${gstin || 'Not Available'}</p>
                <p><strong>Address:</strong> ${address || 'Not Available'}</p>
                <p><strong>Phone:</strong> ${phone || 'Not Available'}</p>
            `;

                    customerDetails.innerHTML = detailsHtml;

                    // Auto-fill shipping address
                    if (address && !shippingAddress.value) {
                        shippingAddress.value = address;
                    }
                } else {
                    customerDetails.innerHTML =
                        '<p class="mb-2"><i class="fas fa-info-circle me-2"></i>Select a customer to view details</p>';
                }
            });

            // Add new item row
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const tbody = document.getElementById('itemsBody');
                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
            <td>${itemCount + 1}</td>
            <td>
                <input type="text" name="items[${itemCount}][description]"
                       class="form-control item-description"
                       placeholder="Product description" required>
            </td>
            <td>
                <input type="number" name="items[${itemCount}][quantity]"
                       class="form-control item-quantity"
                       value="1" min="1" step="1" required>
            </td>
            <td>
                <input type="number" name="items[${itemCount}][unit_price]"
                       class="form-control item-price"
                       value="0" min="0" step="0.01" required>
            </td>
            <td>
                <input type="number" name="items[${itemCount}][discount]"
                       class="form-control item-discount"
                       value="0" min="0" max="100" step="0.01">
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
                tbody.appendChild(newRow);
                itemCount++;

                // Enable remove button for first row if we have more than one row
                if (document.querySelectorAll('.item-row').length > 1) {
                    document.querySelector('.item-row .remove-item').disabled = false;
                }

                // Add event listeners to new inputs
                const inputs = newRow.querySelectorAll('.item-quantity, .item-price, .item-discount');
                inputs.forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });
            });

            // Remove item row
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const row = e.target.closest('.item-row');
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        renumberRows();
                        calculateTotals();
                    }
                }
            });

            // GST rate change
            gstRateSelect.addEventListener('change', function() {
                gstRate = parseFloat(this.value);
                document.getElementById('summaryGstRate').textContent = gstRate;
                calculateTotals();
            });

            // Shipping charges change
            shippingChargesInput.addEventListener('input', function() {
                shippingCharges = parseFloat(this.value) || 0;
                document.getElementById('summaryShipping').textContent = '₹' + shippingCharges.toFixed(2);
                calculateTotals();
            });

            // Calculate totals
            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;

                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const discountPercent = parseFloat(row.querySelector('.item-discount').value) || 0;

                    const itemTotal = quantity * price;
                    const itemDiscount = itemTotal * (discountPercent / 100);
                    const itemAmount = itemTotal - itemDiscount;

                    row.querySelector('.item-amount').value = itemAmount.toFixed(2);
                    subtotal += itemTotal;
                    totalDiscount += itemDiscount;
                });

                const taxableAmount = subtotal - totalDiscount;
                const gstAmount = taxableAmount * (gstRate / 100);
                const totalAmount = taxableAmount + gstAmount + shippingCharges;

                // Update table footer
                document.getElementById('subtotal').value = subtotal.toFixed(2);
                document.getElementById('totalDiscount').value = totalDiscount.toFixed(2);
                document.getElementById('taxableAmount').value = taxableAmount.toFixed(2);
                document.getElementById('gstAmount').value = gstAmount.toFixed(2);
                document.getElementById('totalAmount').value = totalAmount.toFixed(2);

                // Update summary
                document.getElementById('summarySubtotal').textContent = '₹' + subtotal.toFixed(2);
                document.getElementById('summaryDiscount').textContent = '-₹' + totalDiscount.toFixed(2);
                document.getElementById('summaryTaxable').textContent = '₹' + taxableAmount.toFixed(2);
                document.getElementById('summaryGst').textContent = '₹' + gstAmount.toFixed(2);
                document.getElementById('summaryTotal').textContent = '₹' + totalAmount.toFixed(2);
            }

            // Renumber rows
            function renumberRows() {
                document.querySelectorAll('.item-row').forEach((row, index) => {
                    row.querySelector('td:first-child').textContent = index + 1;

                    // Update input names
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name.includes('items[')) {
                            input.name = name.replace(/items\[\d+\]/, `items[${index}]`);
                        }
                    });
                });
                itemCount = document.querySelectorAll('.item-row').length;
            }

            // Add sample items
            document.getElementById('addSampleItems').addEventListener('click', function() {
                // Clear existing items except first
                const rows = document.querySelectorAll('.item-row');
                for (let i = 1; i < rows.length; i++) {
                    rows[i].remove();
                }
                itemCount = 1;

                // Update first row with first sample product
                const firstRow = document.querySelector('.item-row');
                firstRow.querySelector('.item-description').value = sampleProducts[0].description;
                firstRow.querySelector('.item-price').value = sampleProducts[0].price;

                // Add remaining sample products
                for (let i = 1; i < sampleProducts.length; i++) {
                    document.getElementById('addItemBtn').click();
                    const newRow = document.querySelector('.item-row:last-child');
                    newRow.querySelector('.item-description').value = sampleProducts[i].description;
                    newRow.querySelector('.item-price').value = sampleProducts[i].price;
                    newRow.querySelector('.item-quantity').value = 1;
                }

                calculateTotals();
            });

            // Clear form
            document.getElementById('clearForm').addEventListener('click', function() {
                if (confirm('Are you sure you want to clear the form? All data will be lost.')) {
                    // Reset customer selection
                    customerSelect.selectedIndex = 0;
                    customerDetails.innerHTML =
                        '<p class="mb-2"><i class="fas fa-info-circle me-2"></i>Select a customer to view details</p>';

                    // Clear addresses
                    shippingAddress.value = '';
                    billingAddress.value = '';

                    // Reset items to one empty row
                    const rows = document.querySelectorAll('.item-row');
                    for (let i = 1; i < rows.length; i++) {
                        rows[i].remove();
                    }

                    const firstRow = document.querySelector('.item-row');
                    firstRow.querySelector('.item-description').value = '';
                    firstRow.querySelector('.item-quantity').value = 1;
                    firstRow.querySelector('.item-price').value = 0;
                    firstRow.querySelector('.item-discount').value = 0;
                    firstRow.querySelector('.remove-item').disabled = true;

                    itemCount = 1;
                    renumberRows();

                    // Reset other fields
                    document.querySelector('input[name="order_date"]').value = '{{ date('Y-m-d') }}';
                    document.querySelector('input[name="delivery_date"]').value =
                        '{{ date('Y-m-d', strtotime('+7 days')) }}';
                    document.querySelector('input[name="sales_person"]').value = '';
                    document.querySelector('input[name="reference_number"]').value = '';
                    document.querySelector('select[name="shipping_method"]').selectedIndex = 0;
                    document.querySelector('select[name="payment_terms"]').selectedIndex = 0;
                    shippingChargesInput.value = 0;
                    document.querySelector('textarea[name="notes"]').value = '';
                    document.querySelector('textarea[name="terms_conditions"]').value = '';

                    // Reset GST
                    gstRateSelect.value = 18;
                    gstRate = 18;
                    document.getElementById('summaryGstRate').textContent = '18';

                    calculateTotals();
                }
            });

            // Initialize event listeners for existing inputs
            document.querySelectorAll('.item-quantity, .item-price, .item-discount').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Initial calculation
            calculateTotals();
            shippingChargesInput.dispatchEvent(new Event('input'));
        });
    </script>
@endpush
