@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 fw-bold text-gray-900">Invoices</h1>
                <p class="text-muted mb-0">Manage all customer invoices and payments</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text"
                           class="form-control ps-5"
                           placeholder="Search invoices...">
                </div>
                <a href="{{ route('sales.invoices.create') }}"
                   class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-plus-lg me-2"></i>
                    New Invoice
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Total Invoices</span>
                                <h3 class="mb-0 fw-bold">{{ $invoices->total() }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-receipt fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-arrow-up me-1"></i>All invoices
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Paid</span>
                                <h3 class="mb-0 fw-bold">{{ $invoices->where('status', 'paid')->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle fs-4 text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                Fully paid
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Pending</span>
                                <h3 class="mb-0 fw-bold">{{ $invoices->where('status', 'pending')->count() }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clock fs-4 text-warning"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                Awaiting payment
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="text-muted small">Overdue</span>
                                <h3 class="mb-0 fw-bold">{{ $invoices->where('status', 'overdue')->count() }}</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                Past due date
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('sales.invoices.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Search by invoice number, customer..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="all">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Invoices</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Invoice</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Balance</th>
                                <th>Status</th>
                                <th class="pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold">{{ $invoice->invoice_number }}</div>
                                        @if($invoice->reference_number)
                                            <small class="text-muted">Ref: {{ $invoice->reference_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ $invoice->customer->customer_name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $invoice->customer->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $invoice->invoice_date->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $invoice->invoice_date->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $invoice->due_date->format('M d, Y') }}</div>
                                        @php
                                            $daysDiff = now()->diffInDays($invoice->due_date, false);
                                            $dateClass = $daysDiff < 0 ? 'text-danger' : ($daysDiff < 3 ? 'text-warning' : 'text-success');
                                        @endphp
                                        <small class="{{ $dateClass }}">
                                            {{ abs($daysDiff) }} days {{ $daysDiff < 0 ? 'ago' : 'left' }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="fw-bold">৳{{ number_format($invoice->total_amount, 2) }}</div>
                                        <small class="text-muted">{{ $invoice->items->count() }} items</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="fw-bold {{ $invoice->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                            ৳{{ number_format($invoice->balance_due, 2) }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'draft' => 'bg-secondary',
                                                'sent' => 'bg-info',
                                                'pending' => 'bg-warning',
                                                'paid' => 'bg-success',
                                                'overdue' => 'bg-danger',
                                                'cancelled' => 'bg-dark',
                                            ];
                                            $statusClass = $statusClasses[$invoice->status] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($invoice->status) }}</span>
                                    </td>
                                    <td class="pe-4">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.invoices.edit', $invoice->id) }}"
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($invoice->status == 'draft')
                                                <form action="{{ route('sales.invoices.destroy', $invoice->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('sales.invoices.print', $invoice->id) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-dark">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-receipt fs-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">No invoices found</h5>
                                            <p class="text-muted mb-4">Get started by creating a new invoice</p>
                                            <a href="{{ route('sales.invoices.create') }}"
                                               class="btn btn-primary">
                                                <i class="bi bi-plus me-2"></i>Create First Invoice
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($invoices->hasPages())
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} results
                        </div>
                        <div>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
    }

    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }

    .btn-group-vertical .btn {
        border-radius: 0.25rem;
        margin-bottom: 0.25rem;
    }

    .btn-group-vertical .btn:last-child {
        margin-bottom: 0;
    }

    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }

    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush
