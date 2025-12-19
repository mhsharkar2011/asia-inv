@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name ?? 'User' }}!</p>
            </div>
            <div>
                <a href="{{ route('reports.index') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-download me-2"></i>Generate Reports
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Customers Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small fw-semibold text-uppercase">Total Customers</div>
                                <div class="h4 fw-bold mb-0">{{ $totalCustomers ?? 0 }}</div>
                                <div class="mt-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-arrow-up me-1"></i>Active
                                    </span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-people-fill text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 py-2">
                        <a href="{{ route('sales.organizations.index') }}" class="text-decoration-none small">
                            View all customers <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Products Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small fw-semibold text-uppercase">Total Products</div>
                                <div class="h4 fw-bold mb-0">{{ $totalProducts ?? 0 }}</div>
                                <div class="mt-2">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-box-seam me-1"></i>In Stock
                                    </span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-box text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 py-2">
                        <a href="{{ route('inventory.products.index') }}" class="text-decoration-none small">
                            Manage products <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Invoices Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-info border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small fw-semibold text-uppercase">Total Invoices</div>
                                <div class="h4 fw-bold mb-0">{{ $totalInvoices ?? 0 }}</div>
                                <div class="mt-2">
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="bi bi-cash-stack me-1"></i>Revenue
                                    </span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-receipt text-info fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 py-2">
                        <a href="{{ route('sales.invoices.index') }}" class="text-decoration-none small">
                            View all invoices <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pending Invoices Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-muted small fw-semibold text-uppercase">Pending Invoices</div>
                                <div class="h4 fw-bold mb-0">{{ $pendingInvoices ?? 0 }}</div>
                                <div class="mt-2">
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-clock me-1"></i>Awaiting Payment
                                    </span>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                    <i class="bi bi-clock-history text-warning fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 py-2">
                        <a href="{{ route('sales.invoices.index', ['status' => 'pending']) }}"
                            class="text-decoration-none small">
                            View pending <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Quick Actions Row -->
        <div class="row g-4 mb-4">
            <!-- Revenue Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="bi bi-graph-up me-2"></i>Monthly Revenue
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                This Year
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                                <li><a class="dropdown-item" href="#">Last Year</a></li>
                                <li><a class="dropdown-item" href="#">Custom Range</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Low Stock -->
            <div class="col-xl-4 col-lg-5">
                <!-- Quick Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">
                            <i class="bi bi-lightning me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('sales.sales-orders.create') }}"
                                    class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3">
                                    <i class="bi bi-cart-plus fs-4 mb-2"></i>
                                    <span class="small">New Order</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('sales.invoices.create') }}"
                                    class="btn btn-outline-success w-100 d-flex flex-column align-items-center p-3">
                                    <i class="bi bi-file-earmark-plus fs-4 mb-2"></i>
                                    <span class="small">New Invoice</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('sales.organizations.create') }}"
                                    class="btn btn-outline-info w-100 d-flex flex-column align-items-center p-3">
                                    <i class="bi bi-person-plus fs-4 mb-2"></i>
                                    <span class="small">Add Customer</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('inventory.products.create') }}"
                                    class="btn btn-outline-warning w-100 d-flex flex-column align-items-center p-3">
                                    <i class="bi bi-plus-square fs-4 mb-2"></i>
                                    <span class="small">Add Product</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products -->
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alert
                        </h6>
                        <span class="badge bg-warning">{{ $lowStockProducts->count() ?? 0 }}</span>
                    </div>
                    <div class="card-body">
                        @if (isset($lowStockProducts) && $lowStockProducts->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($lowStockProducts->take(4) as $product)
                                    <div class="list-group-item border-0 px-0 py-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $product->product_name }}</h6>
                                                <small class="text-muted">{{ $product->product_code }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span
                                                    class="badge bg-{{ $product->stock_quantity <= 0 ? 'danger' : 'warning' }}">
                                                    {{ $product->stock_quantity }} in stock
                                                </span>
                                                <div class="mt-1">
                                                    <a href="{{ route('inventory.products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($lowStockProducts->count() > 4)
                                <div class="text-center mt-3">
                                    <a href="{{ route('inventory.products.index', ['low_stock' => true]) }}"
                                        class="text-decoration-none">
                                        View all {{ $lowStockProducts->count() }} low stock items
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                                <p class="text-muted mb-0">All products have sufficient stock</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Row -->
        <div class="row g-4">
            <!-- Recent Invoices -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="bi bi-receipt me-2"></i>Recent Invoices
                        </h6>
                        <a href="{{ route('sales.invoices.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if (isset($recentInvoices) && $recentInvoices->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th class="text-end">Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentInvoices as $invoice)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                                        class="text-decoration-none fw-semibold">
                                                        {{ $invoice->invoice_number }}
                                                    </a>
                                                    <div class="text-muted small">
                                                        {{ $invoice->invoice_date->format('M d, Y') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>{{ $invoice->customer->customer_name ?? 'N/A' }}</div>
                                                    <div class="text-muted small">
                                                        {{ $invoice->customer->email ?? '' }}
                                                    </div>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    ৳{{ number_format($invoice->total_amount, 2) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'paid' => 'success',
                                                            'overdue' => 'danger',
                                                            'pending' => 'warning',
                                                            'draft' => 'secondary',
                                                        ];
                                                        $color = $statusColors[$invoice->status] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $color }}">
                                                        {{ ucfirst($invoice->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-receipt text-muted fs-1 mb-3"></i>
                                <p class="text-muted mb-0">No recent invoices</p>
                                <a href="{{ route('sales.invoices.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus me-1"></i>Create Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Sales Orders -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="bi bi-cart me-2"></i>Recent Sales Orders
                        </h6>
                        <a href="{{ route('sales.sales-orders.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if (isset($recentSalesOrders) && $recentSalesOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th class="text-end">Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentSalesOrders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                        class="text-decoration-none fw-semibold">
                                                        {{ $order->order_number }}
                                                    </a>
                                                    <div class="text-muted small">
                                                        {{ $order->order_date->format('M d, Y') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>{{ $order->customer->customer_name ?? 'N/A' }}</div>
                                                    <div class="text-muted small">
                                                        {{ $order->customer->company_name ?? '' }}
                                                    </div>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    ৳{{ number_format($order->total_amount, 2) }}
                                                </td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'draft' => 'secondary',
                                                            'pending' => 'warning',
                                                            'confirmed' => 'primary',
                                                            'processing' => 'info',
                                                            'completed' => 'success',
                                                            'cancelled' => 'danger',
                                                        ];
                                                        $color = $statusColors[$order->status] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $color }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-cart text-muted fs-1 mb-3"></i>
                                <p class="text-muted mb-0">No recent sales orders</p>
                                <a href="{{ route('sales.sales-orders.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-plus me-1"></i>Create Order
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .border-start {
            border-left-width: 4px !important;
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            transition: all 0.2s;
        }

        .btn-outline-primary:hover {
            background-color: var(--bs-primary);
            color: white;
        }

        .btn-outline-success:hover {
            background-color: var(--bs-success);
            color: white;
        }

        .btn-outline-info:hover {
            background-color: var(--bs-info);
            color: white;
        }

        .btn-outline-warning:hover {
            background-color: var(--bs-warning);
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            @if (isset($monthlyRevenue))
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueChart = new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: @json(array_column($monthlyRevenue, 'month')),
                        datasets: [{
                            label: 'Revenue (BDT)',
                            data: @json(array_column($monthlyRevenue, 'revenue')),
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'rgba(13, 110, 253, 1)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return `Revenue: ৳${context.parsed.y.toLocaleString()}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6c757d'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    borderDash: [2, 2]
                                },
                                ticks: {
                                    color: '#6c757d',
                                    callback: function(value) {
                                        return '৳' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            @endif

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
