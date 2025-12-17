@extends('layouts.app')

@section('title', $supplier->supplier_name . ' - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ $supplier->supplier_name }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('purchase.suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('purchase.suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this supplier?')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
            <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Suppliers
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Supplier Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Supplier Code:</th>
                                    <td><strong>{{ $supplier->supplier_code }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Supplier Name:</th>
                                    <td>{{ $supplier->supplier_name }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Person:</th>
                                    <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $supplier->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $supplier->email ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">GSTIN:</th>
                                    <td>
                                        @if ($supplier->gstin)
                                            <span class="badge bg-info">{{ $supplier->gstin }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>PAN Number:</th>
                                    <td>{{ $supplier->pan_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Credit Limit:</th>
                                    <td>
                                        @if ($supplier->credit_limit)
                                            ₹{{ number_format($supplier->credit_limit, 2) }}
                                        @else
                                            <span class="text-muted">No Limit</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Outstanding:</th>
                                    <td>
                                        @if ($supplier->outstanding_balance > 0)
                                            <span
                                                class="badge bg-warning">₹{{ number_format($supplier->outstanding_balance, 2) }}</span>
                                        @else
                                            ₹0.00
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payment Terms:</th>
                                    <td>{{ $supplier->payment_terms ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if ($supplier->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif

                                        @if ($supplier->is_credit_limit_exceeded)
                                            <span class="badge bg-danger ms-1">Credit Limit Exceeded</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($supplier->address)
                        <div class="mt-3">
                            <h6>Address:</h6>
                            <p class="text-muted">{{ $supplier->address }}</p>
                        </div>
                    @endif

                    @if ($supplier->notes)
                        <div class="mt-3">
                            <h6>Notes:</h6>
                            <p class="text-muted">{{ $supplier->notes }}</p>
                        </div>
                    @endif

                    <!-- Credit Information -->
                    @if ($supplier->credit_limit)
                        <div class="mt-4">
                            <h6>Credit Information</h6>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar {{ $supplier->credit_usage_percentage > 80 ? 'bg-danger' : ($supplier->credit_usage_percentage > 60 ? 'bg-warning' : 'bg-success') }}"
                                    role="progressbar" style="width: {{ min($supplier->credit_usage_percentage, 100) }}%;">
                                    {{ number_format($supplier->credit_usage_percentage, 1) }}%
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>Credit Used: ₹{{ number_format($supplier->outstanding_balance, 2) }}</small>
                                <small>Available: ₹{{ number_format($supplier->credit_available, 2) }}</small>
                                <small>Limit: ₹{{ number_format($supplier->credit_limit, 2) }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Purchase Orders -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Purchase Orders</h5>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> New PO
                    </a>
                </div>
                <div class="card-body">
                    @if ($supplier->purchaseOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>PO Number</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier->purchaseOrders as $order)
                                        <tr>
                                            <td>{{ $order->po_number }}</td>
                                            <td>{{ $order->order_date->format('d/m/Y') }}</td>
                                            <td>₹{{ number_format($order->final_amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'secondary',
                                                        'pending' => 'warning',
                                                        'partial' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-file-text display-4 text-muted mb-3"></i>
                            <p class="text-muted">No purchase orders for this supplier yet.</p>
                            <a href="#" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Create First PO
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Supplier Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Total Purchase Orders
                            <span
                                class="badge bg-primary rounded-pill">{{ $supplier->purchase_orders_count ?? $supplier->purchaseOrders->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Completed Orders
                            <span
                                class="badge bg-success rounded-pill">{{ $supplier->completed_orders_count ?? $supplier->purchaseOrders->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Pending Orders
                            <span
                                class="badge bg-warning rounded-pill">{{ $supplier->pending_orders_count ?? $supplier->purchaseOrders->whereIn('status', ['draft', 'pending', 'partial'])->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Total Purchases
                            <span
                                class="badge bg-info rounded-pill">₹{{ number_format($supplier->total_purchases ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary text-start">
                            <i class="bi bi-file-plus me-2"></i> Create Purchase Order
                        </a>
                        <a href="{{ route('purchase.suppliers.edit', $supplier->id) }}"
                            class="btn btn-outline-success text-start">
                            <i class="bi bi-pencil me-2"></i> Edit Supplier
                        </a>
                        <form action="{{ route('purchase.suppliers.toggle-status', $supplier->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning text-start w-100">
                                <i class="bi bi-power me-2"></i>
                                {{ $supplier->is_active ? 'Deactivate' : 'Activate' }} Supplier
                            </button>
                        </form>
                        <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-outline-secondary text-start">
                            <i class="bi bi-list-ul me-2"></i> View All Suppliers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
