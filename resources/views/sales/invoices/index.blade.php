@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Invoices</h1>
                <p class="text-muted mb-0">Manage all customer invoices</p>
            </div>
            <div>
                <a href="{{ route('sales.invoices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Invoice
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('sales.invoices.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by invoice number or customer..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="all">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invoices List -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>
                                        <strong>{{ $invoice->invoice_number }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('sales.customers.show', $invoice->customer_id) }}"
                                            class="text-decoration-none">
                                            {{ $invoice->customer->customer_name }}
                                        </a>
                                    </td>
                                    <td>{{ $invoice->invoice_date->format('d M, Y') }}</td>
                                    <td>{{ $invoice->due_date->format('d M, Y') }}</td>
                                    <td>BDT{{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>BDT{{ number_format($invoice->balance_due, 2) }}</td>
                                    <td>
                                        @if ($invoice->status == 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($invoice->status == 'sent')
                                            <span class="badge bg-info">Sent</span>
                                        @elseif($invoice->status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($invoice->status == 'overdue')
                                            <span class="badge bg-danger">Overdue</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.invoices.edit', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($invoice->status == 'draft')
                                                <form action="{{ route('sales.invoices.destroy', $invoice->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Invoices Found</h5>
                                        <p class="text-muted">Create your first invoice to get started</p>
                                        <a href="{{ route('sales.invoices.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($invoices->hasPages())
                    <div class="card-footer">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
