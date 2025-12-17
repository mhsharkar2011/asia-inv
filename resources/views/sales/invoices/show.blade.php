@extends('layouts.app')

@section('title', 'Invoice - ' . $invoice->invoice_number)

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.invoices.index') }}">Invoices</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $invoice->invoice_number }}</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Invoice Details</h1>
            </div>
            <div class="d-flex gap-2">
                @if ($invoice->status == 'draft')
                    <a href="{{ route('sales.invoices.edit', $invoice->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Invoice
                    </a>
                @endif
                <a href="{{ route('sales.invoices.print', $invoice->id) }}" target="_blank" class="btn btn-success">
                    <i class="fas fa-print me-2"></i>Print
                </a>
                <a href="{{ route('sales.invoices.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <!-- Invoice Status Banner -->
        <div
            class="alert alert-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'info') }} mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="alert-heading mb-1">
                        Invoice {{ $invoice->invoice_number }} -
                        <span class="text-uppercase">{{ $invoice->status }}</span>
                    </h5>
                    <p class="mb-0">
                        @if ($invoice->status == 'draft')
                            <i class="fas fa-info-circle me-1"></i>This invoice is in draft mode. Edit or send to customer.
                        @elseif($invoice->status == 'sent')
                            <i class="fas fa-paper-plane me-1"></i>Invoice sent to customer on
                            {{ $invoice->updated_at->format('d M, Y') }}.
                        @elseif($invoice->status == 'paid')
                            <i class="fas fa-check-circle me-1"></i>Invoice paid in full. Thank you!
                        @elseif($invoice->status == 'overdue')
                            <i class="fas fa-exclamation-triangle me-1"></i>This invoice is overdue by
                            {{ now()->diffInDays($invoice->due_date) }} days.
                        @endif
                    </p>
                </div>
                <div>
                    @if ($invoice->status == 'draft')
                        <form action="{{ route('sales.invoices.send', $invoice->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane me-2"></i>Send Invoice
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Invoice Details -->
            <div class="col-lg-8">
                <!-- Invoice Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-0">Invoice</h5>
                                <p class="text-muted mb-0">{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h5 class="mb-0">BDT{{ number_format($invoice->total_amount, 2) }}</h5>
                                <p class="text-muted mb-0">Total Amount</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- From/To Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">From:</h6>
                                <address class="mb-0">
                                    <strong>Your Company Name</strong><br>
                                    123 Business Street<br>
                                    City, State 12345<br>
                                    Phone: (123) 456-7890<br>
                                    Email: billing@company.com<br>
                                    GSTIN: 22AAAAA0000A1Z5
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">To:</h6>
                                <address class="mb-0">
                                    <strong>{{ $invoice->customer->name }}</strong><br>
                                    @if ($invoice->customer->address_line1)
                                        {{ $invoice->customer->address_line1 }}<br>
                                        @if ($invoice->customer->address_line2)
                                            {{ $invoice->customer->address_line2 }}<br>
                                        @endif
                                        {{ $invoice->customer->city }}, {{ $invoice->customer->state }}
                                        {{ $invoice->customer->pincode }}<br>
                                    @endif
                                    Phone: {{ $invoice->customer->phone }}<br>
                                    Email: {{ $invoice->customer->email }}<br>
                                    @if ($invoice->customer->gstin)
                                        GSTIN: {{ $invoice->customer->gstin }}
                                    @endif
                                </address>
                            </div>
                        </div>

                        <!-- Invoice Items Table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td class="text-end">{{ $item->quantity }}</td>
                                            <td class="text-end">BDT{{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-end">BDT{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                        <td class="text-end">BDT{{ number_format($invoice->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Tax (18%):</strong></td>
                                        <td class="text-end">BDT{{ number_format($invoice->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                                        <td class="text-end">
                                            <strong>BDT{{ number_format($invoice->total_amount, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Amount Paid:</strong></td>
                                        <td class="text-end">BDT{{ number_format($invoice->amount_paid, 2) }}</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td colspan="4" class="text-end"><strong>Balance Due:</strong></td>
                                        <td class="text-end">
                                            <strong>BDT{{ number_format($invoice->balance_due, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Notes & Terms -->
                        @if ($invoice->notes || $invoice->terms)
                            <div class="row">
                                @if ($invoice->notes)
                                    <div class="col-md-6">
                                        <h6>Notes:</h6>
                                        <p class="text-muted">{{ $invoice->notes }}</p>
                                    </div>
                                @endif
                                @if ($invoice->terms)
                                    <div class="col-md-6">
                                        <h6>Terms & Conditions:</h6>
                                        <p class="text-muted">{{ $invoice->terms }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Invoice Date: {{ $invoice->invoice_date->format('d M, Y') }}
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    Due Date: {{ $invoice->due_date->format('d M, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                @if ($invoice->amount_paid > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Payment History</h5>
                        </div>
                        <div class="card-body">
                            <!-- Add payment history table here -->
                            <p class="text-center text-muted">Payment history will be displayed here</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Payment Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Record Payment</h5>
                    </div>
                    <div class="card-body">
                        @if ($invoice->balance_due > 0)
                            <form action="{{ route('sales.invoices.payment', $invoice->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Payment Amount *</label>
                                    <input type="number" name="amount" class="form-control"
                                        max="{{ $invoice->balance_due }}" min="0.01" step="0.01"
                                        value="{{ $invoice->balance_due }}" required>
                                    <small class="text-muted">Balance Due:
                                        BDT{{ number_format($invoice->balance_due, 2) }}</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Payment Date *</label>
                                    <input type="date" name="payment_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Payment Method *</label>
                                    <select name="payment_method" class="form-select" required>
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="upi">UPI</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" name="reference" class="form-control"
                                        placeholder="Cheque/Transaction number">
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle me-2"></i>Record Payment
                                </button>
                            </form>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-success">Invoice Paid in Full</h5>
                                <p class="text-muted">No payment required</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Invoice Actions Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Invoice Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('sales.invoices.print', $invoice->id) }}" target="_blank"
                                class="btn btn-outline-primary">
                                <i class="fas fa-print me-2"></i>Print Invoice
                            </a>

                            <a href="#" class="btn btn-outline-success">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </a>

                            @if ($invoice->status == 'draft')
                                <a href="{{ route('sales.invoices.edit', $invoice->id) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Invoice
                                </a>

                                <form action="{{ route('sales.invoices.destroy', $invoice->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100"
                                        onclick="return confirm('Are you sure you want to delete this invoice?')">
                                        <i class="fas fa-trash me-2"></i>Delete Invoice
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('sales.customers.show', $invoice->customer_id) }}" class="btn btn-outline-info">
                                <i class="fas fa-user me-2"></i>View Customer
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Invoice Summary Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Invoice Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Invoice Number:</span>
                            <span>{{ $invoice->invoice_number }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span
                                class="badge bg-{{ $invoice->status == 'draft' ? 'secondary' : ($invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'info')) }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Invoice Date:</span>
                            <span>{{ $invoice->invoice_date->format('d M, Y') }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Due Date:</span>
                            <span>{{ $invoice->due_date->format('d M, Y') }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Days Overdue:</span>
                            <span>
                                @if ($invoice->due_date < now() && $invoice->status != 'paid')
                                    {{ now()->diffInDays($invoice->due_date) }} days
                                @else
                                    0 days
                                @endif
                            </span>
                        </div>

                        <hr>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Subtotal:</span>
                            <span>BDT{{ number_format($invoice->subtotal, 2) }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Tax Amount:</span>
                            <span>BDT{{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between fw-bold">
                            <span>Total Amount:</span>
                            <span>BDT{{ number_format($invoice->total_amount, 2) }}</span>
                        </div>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Amount Paid:</span>
                            <span>BDT{{ number_format($invoice->amount_paid, 2) }}</span>
                        </div>

                        <div class="mb-0 d-flex justify-content-between fw-bold">
                            <span>Balance Due:</span>
                            <span class="{{ $invoice->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                BDT{{ number_format($invoice->balance_due, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
