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
                        <h6 class="text-muted fw-normal">Products</h6>
                        <h4 class="mb-0">{{ $productCount }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-box display-4 text-primary"></i>
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
                        <h6 class="text-muted fw-normal">Categories</h6>
                        <h4 class="mb-0">{{ $categoryCount }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-tags display-4 text-success"></i>
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
                        <h6 class="text-muted fw-normal">Suppliers</h6>
                        <h4 class="mb-0">{{ $supplierCount }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-people display-4 text-info"></i>
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
                        <h6 class="text-muted fw-normal">Customers</h6>
                        <h4 class="mb-0">{{ $customerCount }}</h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-person-badge display-4 text-warning"></i>
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
                <h5 class="card-title mb-0">Recent Products</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($lowStockProducts as $product)
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $product->product_name }}</strong><br>
                                <small class="text-muted">{{ $product->product_code }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                {{ $product->category->category_code ?? 'N/A' }}
                            </span>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="bi bi-box display-4 mb-2"></i><br>
                            No products yet
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
                        <a href="{{ route('inventory.categories.create') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-tags display-6 d-block mb-2"></i>
                            New Category
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('purchase.suppliers.create') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-person-plus display-6 d-block mb-2"></i>
                            New Supplier
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('sales.customers.create') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-person-plus display-6 d-block mb-2"></i>
                            New Customer
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('inventory.categories.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-list-ul display-6 d-block mb-2"></i>
                            View Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-box-seam display-1 text-primary mb-3"></i>
                <h3>Welcome to Asia Enterprise Inventory System</h3>
                <p class="text-muted">Get started by adding products, categories, suppliers, and customers.</p>
                <div class="mt-3">
                    <a href="{{ route('inventory.products.create') }}" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle me-1"></i> Add First Product
                    </a>
                    <a href="{{ route('inventory.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-tags me-1"></i> Manage Categories
                    </a>
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
