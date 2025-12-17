@extends('layouts.app')

@section('title', 'Product Report - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Product Report</h1>
                <p class="text-muted mb-0">Stock and inventory analysis</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-primary me-2">
                    <i class="bi bi-printer"></i> Print
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>

        <!-- Stock Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Low Stock Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $lowStockProducts->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Out of Stock</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $products->where('stock_quantity', '<=', 0)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    In Stock Value</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    BDT{{ number_format(
                                        $products->sum(function ($product) {
                                            return $product->stock_quantity * $product->cost_price;
                                        }),
                                        2,
                                    ) }}
                                </div>
                            </div>
                            <div class="col-auto">
                               <i class="bi bi-currency-taka fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Products</h5>
                <span class="badge bg-primary">{{ $products->count() }} Products</span>
            </div>
            <div class="card-body">
                @if ($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Stock Qty</th>
                                    <th>Reorder Level</th>
                                    <th>Cost Price</th>
                                    <th>Selling Price</th>
                                    <th>Stock Value</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $product->product_code }}</strong></td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-{{ $product->stock_quantity <= 0 ? 'danger' : ($product->stock_quantity <= $product->reorder_level ? 'warning' : 'success') }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $product->reorder_level }}</td>
                                        <td class="text-end">BDT{{ number_format($product->cost_price, 2) }}</td>
                                        <td class="text-end">BDT{{ number_format($product->selling_price, 2) }}</td>
                                        <td class="text-end">
                                            BDT{{ number_format($product->stock_quantity * $product->cost_price, 2) }}
                                        </td>
                                        <td>
                                            @if ($product->is_active == '1')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="8" class="text-end"><strong>Total Stock Value:</strong></td>
                                    <td class="text-end">
                                        <strong>
                                            BDT{{ number_format(
                                                $products->sum(function ($product) {
                                                    return $product->stock_quantity * $product->cost_price;
                                                }),
                                                2,
                                            ) }}
                                        </strong>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-box display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Products Found</h5>
                        <p class="text-muted">No product data available.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Low Stock Products (Need Reordering)</h5>
                <span class="badge bg-warning">{{ $lowStockProducts->count() }} Products</span>
            </div>
            <div class="card-body">
                @if ($lowStockProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                    <th>Deficit</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockProducts as $product)
                                    <tr>
                                        <td><strong>{{ $product->product_code }}</strong></td>
                                        <td>{{ $product->product_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                        </td>
                                        <td class="text-center">{{ $product->reorder_level }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-danger">
                                                {{ max(0, $product->reorder_level - $product->stock_quantity) }}
                                            </span>
                                        </td>
                                        <td>{{ $product->category ?? 'N/A' }}</td>
                                        <td>
                                            @if ($product->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('inventory.products.edit', $product->id) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i> Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle display-4 text-success"></i>
                        <h5 class="text-success mt-3">All Products Have Sufficient Stock</h5>
                        <p class="text-muted">No products need reordering at this time.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock Analysis -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Stock Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $products->where('stock_quantity', '>', 0)->count() }}</div>
                                    <small class="text-muted">In Stock</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $lowStockProducts->count() }}</div>
                                    <small class="text-muted">Low Stock</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $products->where('stock_quantity', '<=', 0)->count() }}</div>
                                    <small class="text-muted">Out of Stock</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $products->where('status', 'inactive')->count() }}</div>
                                    <small class="text-muted">Inactive</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top 10 Products by Stock Value</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $topProducts = $products
                                ->sortByDesc(function ($product) {
                                    return $product->stock_quantity * $product->cost_price;
                                })
                                ->take(10);
                        @endphp

                        @if ($topProducts->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($topProducts as $product)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $product->product_code }}</strong><br>
                                            <small class="text-muted">{{ $product->product_name }}</small>
                                        </div>
                                        <span class="fw-bold">
                                            BDT{{ number_format($product->stock_quantity * $product->cost_price, 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No product data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
            }

            .table {
                font-size: 11px;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: #000 !important;
            }

            .badge {
                border: 1px solid #000;
                color: #000 !important;
                background-color: transparent !important;
            }
        }

        .card-header {
            background-color: #f8f9fa;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 4px solid #e74a3b !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }
    </style>
@endsection
