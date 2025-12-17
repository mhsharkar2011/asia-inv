@extends('layouts.app')

@section('title', 'Sales Orders')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Sales Orders</h1>
                <p class="text-muted mb-0">Manage customer sales orders</p>
            </div>
            <div>
                <a href="{{ route('sales.sales-orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Sales Order
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('sales.sales-orders.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by order number, reference or customer..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="all">All Status</option>
                                @foreach (['draft', 'pending', 'confirmed', 'processing', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="customer_id" class="form-select">
                                <option value="">All Customers</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <a href="{{ route('sales.sales-orders.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Summary -->
        @if ($salesOrders->count() > 0)
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Total Orders</h6>
                                    <h4 class="mb-0 mt-2">{{ $salesOrders->total() }}</h4>
                                </div>
                                <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Total Amount</h6>
                                    <h4 class="mb-0 mt-2">৳{{ number_format($salesOrders->sum('total_amount'), 2) }}</h4>
                                </div>
                                <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Confirmed Orders</h6>
                                    <h4 class="mb-0 mt-2">{{ $salesOrders->where('status', 'confirmed')->count() }}</h4>
                                </div>
                                <i class="fas fa-check-circle fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Draft Orders</h6>
                                    <h4 class="mb-0 mt-2">{{ $salesOrders->where('status', 'draft')->count() }}</h4>
                                </div>
                                <i class="fas fa-file-alt fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Sales Orders List -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales Orders List</h5>
                <div class="d-flex gap-2">
                    @if ($salesOrders->count() > 0)
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('sales.sales-orders.export') }}?{{ http_build_query(request()->query()) }}"><i
                                            class="fas fa-file-excel me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th class="text-end">Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesOrders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $order->order_number }}</strong>
                                            @if ($order->reference_number)
                                                <small class="text-muted">Ref: {{ $order->reference_number }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            @if ($order->customer)
                                                <a href="{{ route('sales.customers.show', $order->customer_id) }}"
                                                    class="text-decoration-none">
                                                    {{ $order->customer->customer_name }}
                                                </a>
                                                @if ($order->customer->company_name)
                                                    <small class="text-muted">{{ $order->customer->company_name }}</small>
                                                @endif
                                            @else
                                                <span class="text-danger">Customer Deleted</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $order->order_date->format('d M, Y') }}</span>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $order->delivery_date->format('d M, Y') }}</span>
                                            @if ($order->due_date)
                                                <small class="text-muted">Due: {{ \Carbon\Carbon::parse($order->due_date)->format('d M, Y') }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex flex-column">
                                            <strong>৳{{ number_format($order->total_amount, 2) }}</strong>
                                            @if ($order->items->count() > 0)
                                                <small class="text-muted">{{ $order->items->count() }} item(s)</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'draft' => 'secondary',
                                                'pending' => 'warning',
                                                'confirmed' => 'success',
                                                'processing' => 'info',
                                                'completed' => 'primary',
                                                'cancelled' => 'danger',
                                            ];
                                            $color = $statusColors[$order->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                                        @if ($order->confirmed_at)
                                            <small class="d-block text-muted">{{ \Carbon\Carbon::parse($order->confirmed_at)->format('d M') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $paymentColors = [
                                                'pending' => 'warning',
                                                'partial' => 'info',
                                                'paid' => 'success',
                                                'overdue' => 'danger',
                                            ];
                                            $pColor = $paymentColors[$order->payment_status] ?? 'secondary';
                                        @endphp
                                        <span
                                            class="badge bg-{{ $pColor }}">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if ($order->status == 'draft')
                                                <a href="{{ route('sales.sales-orders.edit', $order->id) }}"
                                                    class="btn btn-sm btn-outline-secondary" title="Edit">
                                                   <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('sales.sales-orders.destroy', $order->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this order?')"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('sales.sales-orders.edit', $order->id) }}"
                                                    class="btn btn-sm btn-outline-info" title="Edit Details">
                                                     <i class="bi bi-gear"></i>
                                                </a>
                                            @endif
                                            @if ($order->status == 'confirmed')
                                                <a href="{{ route('sales.invoices.create', ['order_id' => $order->id]) }}"
                                                    class="btn btn-sm btn-outline-success" title="Create Invoice">
                                                    <i class="bi bi-file-text"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('sales.sales-orders.print', $order->id) }}" target="_blank"
                                                class="btn btn-sm btn-outline-dark" title="Print">
                                                 <i class="bi bi-printer"></i>
                                            </a>
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" title="More Actions">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if ($order->status != 'draft')
                                                        <li>
                                                            <form
                                                                action="{{ route('sales.sales-orders.change-status', $order->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                                                    <i class="fas fa-ban me-2 text-danger"></i>Cancel Order
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="duplicateOrder({{ $order->id }})">
                                                            <i class="fas fa-copy me-2"></i>Duplicate Order
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('sales.sales-orders.show', $order->id) }}">
                                                            <i class="fas fa-external-link-alt me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Sales Orders Found</h5>
                                            <p class="text-muted mb-4">Create your first sales order to get started</p>
                                            <a href="{{ route('sales.sales-orders.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Create Sales Order
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($salesOrders->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Showing {{ $salesOrders->firstItem() }} to {{ $salesOrders->lastItem() }} of
                                {{ $salesOrders->total() }} entries
                            </div>
                            <div>
                                {{ $salesOrders->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function duplicateOrder(orderId) {
            if (confirm('Are you sure you want to duplicate this order?')) {
                // You can implement AJAX duplication or redirect to create with prefilled data
                // For now, just show a message
                alert('Duplication feature coming soon!');
                // window.location.href = '/sales/sales-orders/duplicate/' + orderId;
            }
        }

        // Quick status change
        document.addEventListener('DOMContentLoaded', function() {
            // Add any JavaScript functionality here
        });
    </script>
@endpush
