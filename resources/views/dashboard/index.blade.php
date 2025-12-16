@extends('layouts.app')

@section('title', 'Dashboard - Asia Enterprise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Today</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">This Week</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">This Month</button>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h6 class="text-muted fw-normal">Total Stock Value</h6>
                        <h4 class="mb-0">₹{{ number_format($totalStockValue, 2) }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card border-warning">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h6 class="text-muted fw-normal">Low Stock Items</h6>
                        <h4 class="mb-0">{{ $lowStockItems }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card border-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h6 class="text-muted fw-normal">Pending Orders</h6>
                        <h4 class="mb-0">{{ $pendingOrders }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-cart display-4 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stats-card border-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h6 class="text-muted fw-normal">Monthly Revenue</h6>
                        <h4 class="mb-0">₹{{ number_format($monthlyRevenue, 2) }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-currency-rupee display-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Sales Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Stock Alerts</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($stockAlerts as $product)
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $product->product_name }}</strong><br>
                                <small class="text-muted">{{ $product->product_code }}</small>
                            </div>
                            <span class="badge bg-warning rounded-pill">
                                {{ $product->inventories->sum('quantity_available') }}
                            </span>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-check-circle display-4 mb-2"></i><br>
                            No stock alerts
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2">
                        <a href="{{ route('inventory.products.create') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                            New Product
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('purchase.purchase-orders.create') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-file-text display-6 d-block mb-2"></i>
                            New PO
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sales.sales-orders.create') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-receipt display-6 d-block mb-2"></i>
                            New Invoice
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('inventory.stock.index') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-clipboard-data display-6 d-block mb-2"></i>
                            Stock Check
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('reports.inventory.summary') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-graph-up display-6 d-block mb-2"></i>
                            Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activities</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Activity</th>
                                <th>User</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivities as $activity)
                            <tr>
                                <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->user->full_name }}</td>
                                <td><span class="badge bg-secondary">{{ $activity->reference }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($salesData['labels']),
            datasets: [{
                label: 'Sales Amount',
                data: @json($salesData['values']),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₹' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
