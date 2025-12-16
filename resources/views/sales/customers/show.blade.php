{{-- resources/views/customers/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Customer Details - ' . $customer->name)

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $customer->name }}</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Customer Details</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('sales.customers.edit', $customer->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Customer
                </a>
                <a href="{{ route('sales.customers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <!-- Customer Information Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Basic Information</h5>
                        <span class="badge bg-light text-dark">
                            @if ($customer->status == 'active')
                                <i class="fas fa-circle text-success me-1"></i>Active
                            @elseif($customer->status == 'inactive')
                                <i class="fas fa-circle text-danger me-1"></i>Inactive
                            @else
                                <i class="fas fa-circle text-secondary me-1"></i>{{ ucfirst($customer->status) }}
                            @endif
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Full Name</label>
                                    <p class="mb-0 fs-5">{{ $customer->name }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Email Address</label>
                                    <p class="mb-0">
                                        <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-2 text-primary"></i>{{ $customer->email }}
                                        </a>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Phone Number</label>
                                    <p class="mb-0">
                                        <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-2 text-primary"></i>{{ $customer->phone }}
                                        </a>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Customer Since</label>
                                    <p class="mb-0">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        {{ $customer->created_at->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Customer Type</label>
                                    <p class="mb-0">
                                        <span class="badge bg-info">
                                            {{ ucfirst($customer->customer_type) }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Customer ID</label>
                                    <p class="mb-0">
                                        <code>{{ $customer->customer_code ?? 'CUST-' . str_pad($customer->id, 6, '0', STR_PAD_LEFT) }}</code>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Last Updated</label>
                                    <p class="mb-0">
                                        <i class="fas fa-history me-2 text-primary"></i>
                                        {{ $customer->updated_at->format('d M, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($customer->notes)
                            <div class="mt-4 pt-3 border-top">
                                <label class="form-label text-muted small mb-2">Additional Notes</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $customer->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Stats -->
            <div class="col-lg-4">
                <!-- Address Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Address Details</h6>
                    </div>
                    <div class="card-body">
                        @if ($customer->address_line1)
                            <div class="mb-2">
                                <label class="form-label text-muted small mb-1">Address</label>
                                <p class="mb-1">{{ $customer->address_line1 }}</p>
                                @if ($customer->address_line2)
                                    <p class="mb-1">{{ $customer->address_line2 }}</p>
                                @endif
                                <p class="mb-0">
                                    {{ $customer->city }},
                                    {{ $customer->state }} -
                                    {{ $customer->pincode }}
                                </p>
                                <p class="mb-0">{{ $customer->country ?? 'India' }}</p>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-map-marker-alt fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No address provided</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- GST & PAN Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Tax Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($customer->gstin)
                                <div class="col-12 mb-3">
                                    <label class="form-label text-muted small mb-1">GSTIN</label>
                                    <p class="mb-0">
                                        <code class="bg-light p-1 rounded">{{ $customer->gstin }}</code>
                                    </p>
                                </div>
                            @endif

                            @if ($customer->pan_number)
                                <div class="col-12">
                                    <label class="form-label text-muted small mb-1">PAN Number</label>
                                    <p class="mb-0">
                                        <code class="bg-light p-1 rounded">{{ $customer->pan_number }}</code>
                                    </p>
                                </div>
                            @endif

                            @if (!$customer->gstin && !$customer->pan_number)
                                <div class="col-12 text-center py-2">
                                    <p class="text-muted mb-0">No tax information available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}"
                                class="btn btn-success">
                                <i class="fas fa-file-invoice me-2"></i>Create Invoice
                            </a>
                            <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}"
                                class="btn btn-warning">
                                <i class="fas fa-shopping-cart me-2"></i>New Order
                            </a>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Delete Customer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Tabs -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="customerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders"
                            type="button" role="tab">
                            <i class="fas fa-shopping-bag me-2"></i>Orders
                            <span class="badge bg-primary ms-2">{{ $customer->orders_count ?? 0 }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices"
                            type="button" role="tab">
                            <i class="fas fa-file-invoice me-2"></i>Invoices
                            <span class="badge bg-success ms-2">{{ $customer->invoices_count ?? 0 }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="transactions-tab" data-bs-toggle="tab"
                            data-bs-target="#transactions" type="button" role="tab">
                            <i class="fas fa-exchange-alt me-2"></i>Transactions
                            <span class="badge bg-info ms-2">{{ $customer->transactions_count ?? 0 }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity"
                            type="button" role="tab">
                            <i class="fas fa-history me-2"></i>Activity Log
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="customerTabsContent">
                    <!-- Orders Tab -->
                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                        @if (isset($customer->orders) && $customer->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->orders->take(5) as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->created_at->format('d M, Y') }}</td>
                                                <td>{{ $order->items_count }}</td>
                                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($customer->orders->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route('orders.index', ['customer_id' => $customer->id]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View All Orders ({{ $customer->orders->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Orders Found</h5>
                                <p class="text-muted">This customer hasn't placed any orders yet.</p>
                                <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create First Order
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Invoices Tab -->
                    <div class="tab-pane fade" id="invoices" role="tabpanel">
                        @if (isset($customer->invoices) && $customer->invoices->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->invoices->take(5) as $invoice)
                                            <tr>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->invoice_date->format('d M, Y') }}</td>
                                                <td>{{ $invoice->due_date->format('d M, Y') }}</td>
                                                <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
                                                <td>
                                                    @if ($invoice->status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($invoice->status == 'overdue')
                                                        <span class="badge bg-danger">Overdue</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('invoices.download', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($customer->invoices->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="{{ route('invoices.index', ['customer_id' => $customer->id]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View All Invoices ({{ $customer->invoices->count() }})
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Invoices Found</h5>
                                <p class="text-muted">This customer doesn't have any invoices yet.</p>
                                <a href="{{ route('invoices.create', ['customer_id' => $customer->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create First Invoice
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Transactions Tab -->
                    <div class="tab-pane fade" id="transactions" role="tabpanel">
                        @if (isset($customer->transactions) && $customer->transactions->count() > 0)
                            <!-- Content for transactions -->
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Transactions Found</h5>
                                <p class="text-muted">This customer doesn't have any transactions yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Activity Tab -->
                    <div class="tab-pane fade" id="activity" role="tabpanel">
                        <!-- Activity log content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $customer->name }}</strong>?</p>
                    <p class="text-danger mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        This action cannot be undone. All associated orders, invoices, and transactions will be affected.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('sales.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card-header h5,
        .card-header h6 {
            font-weight: 600;
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
            background: transparent;
        }

        .form-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6c757d;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Tab persistence (optional)
            if (location.hash) {
                const tabTrigger = document.querySelector(`[data-bs-target="${location.hash}"]`);
                if (tabTrigger) {
                    new bootstrap.Tab(tabTrigger).show();
                }
            }

            // Update URL when tab changes
            const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabEls.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    const target = event.target.getAttribute('data-bs-target');
                    if (target) {
                        history.pushState(null, null, target);
                    }
                });
            });
        });
    </script>
@endsection
