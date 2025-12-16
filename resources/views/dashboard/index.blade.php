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
        @include('components.widgets.stats-card', [
            'title' => 'Total Stock Value',
            'value' => '₹' . number_format($totalStockValue, 2),
            'icon' => 'bi-box-seam',
            'color' => 'primary'
        ])
    </div>
    <div class="col-md-3">
        @include('components.widgets.stats-card', [
            'title' => 'Low Stock Items',
            'value' => $lowStockItems,
            'icon' => 'bi-exclamation-triangle',
            'color' => 'warning'
        ])
    </div>
    <div class="col-md-3">
        @include('components.widgets.stats-card', [
            'title' => 'Pending Orders',
            'value' => $pendingOrders,
            'icon' => 'bi-cart',
            'color' => 'info'
        ])
    </div>
    <div class="col-md-3">
        @include('components.widgets.stats-card', [
            'title' => 'Monthly Revenue',
            'value' => '₹' . number_format($monthlyRevenue, 2),
            'icon' => 'bi-currency-rupee',
            'color' => 'success'
        ])
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
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($stockAlerts as $alert)
                    <a href="{{ route('inventory.products.show', $alert->product_id) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $alert->product_name }}
                        <span class="badge bg-warning">{{ $alert->quantity_available }}</span>
                    </a>
                    @endforeach
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
                                <td>{{ $activity->reference }}</td>
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
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endpush
