@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.invoices.index') }}">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Invoice</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Create New Invoice</h1>
            </div>
            <div>
                <a href="{{ route('sales.invoices.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancel
                </a>
            </div>
        </div>

        <form action="{{ route('sales.invoices.store') }}" method="POST" id="invoiceForm">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <!-- Invoice Details Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Invoice Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Invoice Number *</label>
                                    <input type="text" class="form-control" value="{{ $invoice_number }}" readonly>
                                    <small class="text-muted">Auto-generated</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Customer *</label>
                                    <select name="customer_id" class="form-select" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $selected_customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Invoice Date *</label>
                                    <input type="date" name="invoice_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Due Date *</label>
                                    <input type="date" name="due_date" class="form-control"
                                        value="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Terms & Conditions</label>
                                    <textarea name="terms" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Items Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Invoice Items</h5>
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
                                            <th width="45%">Description *</th>
                                            <th width="15%">Quantity *</th>
                                            <th width="20%">Unit Price *</th>
                                            <th width="15%">Total</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <!-- Items will be added here dynamically -->
                                        <tr class="item-row">
                                            <td>1</td>
                                            <td>
                                                <input type="text" name="items[0][description]"
                                                    class="form-control item-description" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]"
                                                    class="form-control item-quantity" value="1" min="1"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][unit_price]"
                                                    class="form-control item-price" value="0" min="0"
                                                    step="0.01" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-total" value="0.00"
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
                                            <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="subtotal" value="0.00"
                                                    readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Tax (18%):</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="taxAmount" value="0.00"
                                                    readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-active">
                                            <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                                            <td>
                                                <input type="text" class="form-control" id="totalAmount"
                                                    value="0.00" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Invoice Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Invoice Number</label>
                                <p class="mb-0">{{ $invoice_number }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-secondary">Draft</span>
                                </p>
                            </div>

                            <hr>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Subtotal:</span>
                                <span id="summarySubtotal">₹0.00</span>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Tax (18%):</span>
                                <span id="summaryTax">₹0.00</span>
                            </div>

                            <div class="mb-3 d-flex justify-content-between fw-bold">
                                <span>Total Amount:</span>
                                <span id="summaryTotal">₹0.00</span>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Invoice
                                </button>
                                <button type="submit" name="action" value="save_and_send" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-2"></i>Save & Send
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
            let itemCount = 1;

            // Add new item row
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const tbody = document.getElementById('itemsBody');
                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
            <td>${itemCount + 1}</td>
            <td>
                <input type="text" name="items[${itemCount}][description]"
                       class="form-control item-description" required>
            </td>
            <td>
                <input type="number" name="items[${itemCount}][quantity]"
                       class="form-control item-quantity" value="1" min="1" required>
            </td>
            <td>
                <input type="number" name="items[${itemCount}][unit_price]"
                       class="form-control item-price" value="0" min="0" step="0.01" required>
            </td>
            <td>
                <input type="text" class="form-control item-total" value="0.00" readonly>
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
                const inputs = newRow.querySelectorAll('.item-quantity, .item-price');
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

            // Calculate totals
            function calculateTotals() {
                let subtotal = 0;

                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const total = quantity * price;

                    row.querySelector('.item-total').value = total.toFixed(2);
                    subtotal += total;
                });

                const taxRate = 0.18; // 18% GST
                const taxAmount = subtotal * taxRate;
                const totalAmount = subtotal + taxAmount;

                // Update table footer
                document.getElementById('subtotal').value = subtotal.toFixed(2);
                document.getElementById('taxAmount').value = taxAmount.toFixed(2);
                document.getElementById('totalAmount').value = totalAmount.toFixed(2);

                // Update summary
                document.getElementById('summarySubtotal').textContent = '₹' + subtotal.toFixed(2);
                document.getElementById('summaryTax').textContent = '₹' + taxAmount.toFixed(2);
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

            // Initialize event listeners
            document.querySelectorAll('.item-quantity, .item-price').forEach(input => {
                input.addEventListener('input', calculateTotals);
            });

            // Initial calculation
            calculateTotals();
        });
    </script>
@endpush
