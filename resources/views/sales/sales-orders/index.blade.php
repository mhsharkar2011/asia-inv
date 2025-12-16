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
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by order number, reference or customer..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="all">All Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped
                                </option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
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

        <!-- Sales Orders List -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Delivery Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesOrders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                        @if ($order->reference_number)
                                            <br>
                                            <small class="text-muted">Ref: {{ $order->reference_number }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('customers.show', $order->customer_id) }}"
                                            class="text-decoration-none">
                                            {{ $order->customer->name }}
                                        </a>
                                    </td>
                                    <td>{{ $order->order_date->format('d M, Y') }}</td>
                                    <td>{{ $order->delivery_date->format('d M, Y') }}</td>
                                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @if ($order->status == 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-primary">Confirmed</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-warning">Processing</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($order->status == 'draft')
                                                <a href="{{ route('sales.sales-orders.edit', $order->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('sales.sales-orders.destroy', $order->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if ($order->status == 'confirmed')
                                                <a href="{{ route('sales.sales-orders.convert-to-invoice', $order->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-file-invoice"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Sales Orders Found</h5>
                                        <p class="text-muted">Create your first sales order to get started</p>
                                        <a href="{{ route('sales.sales-orders.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Sales Order
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($salesOrders->hasPages())
                    <div class="card-footer">
                        {{ $salesOrders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
