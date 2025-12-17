@extends('layouts.app')

@section('title', 'Dashboard - Asia Enterprise')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <i class="bi bi-box-seam display-1 text-primary mb-4"></i>
                <h1 class="display-4 mb-4">Welcome to Asia Enterprise Inventory System</h1>
                <p class="lead mb-4">Your inventory management system is ready to use!</p>

                <div class="row mt-5">
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="bi bi-box display-4 text-primary mb-3"></i>
                                <h5>Products</h5>
                                <p>Manage your product catalog</p>
                                <a href="{{ route('inventory.products.index') }}" class="btn btn-outline-primary">View
                                    Products</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="bi bi-tags display-4 text-success mb-3"></i>
                                <h5>Categories</h5>
                                <p>Organize products by categories</p>
                                <a href="{{ route('inventory.categories.index') }}" class="btn btn-outline-success">View
                                    Categories</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="bi bi-people display-4 text-info mb-3"></i>
                                <h5>Suppliers</h5>
                                <p>Manage your suppliers</p>
                                <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-outline-info">View
                                    Suppliers</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="bi bi-person-badge display-4 text-warning mb-3"></i>
                                <h5>Customers</h5>
                                <p>Manage your customers</p>
                                <a href="{{ route('sales.customers.index') }}" class="btn btn-outline-warning">View
                                    Customers</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h4>Getting Started</h4>
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-8">
                            <div class="list-group">
                                <div class="list-group-item">
                                    1. Start by creating product categories
                                </div>
                                <div class="list-group-item">
                                    2. Add your products to the catalog
                                </div>
                                <div class="list-group-item">
                                    3. Add suppliers for purchasing
                                </div>
                                <div class="list-group-item">
                                    4. Add customers for sales
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
