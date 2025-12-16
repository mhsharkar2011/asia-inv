@extends('layouts.app')

@section('title', 'Stock View - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Stock View</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-clipboard-data display-1 text-primary mb-3"></i>
                    <h3>Stock Management Module</h3>
                    <p class="text-muted">This module is under development.</p>
                    <p class="text-muted">Coming soon: Real-time stock tracking, inventory valuation, and stock reports.</p>

                    <div class="mt-4">
                        <a href="{{ route('inventory.products.index') }}" class="btn btn-primary me-2">
                            <i class="bi bi-box me-1"></i> Manage Products
                        </a>
                        <a href="{{ route('inventory.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-tags me-1"></i> Manage Categories
                        </a>
                    </div>
                </div>
            </div>

            <!-- Placeholder Table -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sample Stock Data</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product A</td>
                                    <td>Electronics</td>
                                    <td>50</td>
                                    <td>20</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Product B</td>
                                    <td>Clothing</td>
                                    <td>10</td>
                                    <td>15</td>
                                    <td><span class="badge bg-warning">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Product C</td>
                                    <td>Furniture</td>
                                    <td>0</td>
                                    <td>5</td>
                                    <td><span class="badge bg-danger">Out of Stock</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
