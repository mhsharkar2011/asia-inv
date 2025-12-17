@extends('layouts.app')

@section('title', 'Products - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('inventory.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> New Product
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('inventory.products.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by name, code, HSN..." value="{{ $search }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Products</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                            <option value="low_stock" {{ $status == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ $status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            @if ($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Tax</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <strong>{{ $product->product_code }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $product->product_name }}</div>
                                        @if ($product->description)
                                            <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->category)
                                            <span class="badge bg-info">{{ $product->category->category_name }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->unit_of_measure }}</td>
                                    <td>
                                        @if ($product->selling_price)
                                            BDT{{ number_format($product->selling_price, 2) }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->tax_rate)
                                            <span class="badge bg-success">{{ $product->tax_rate }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $totalStock = $product->stock_quantity;
                                            $stockStatus =
                                                $totalStock > $product->reorder_level
                                                    ? 'success'
                                                    : ($totalStock == 0
                                                        ? 'danger'
                                                        : 'warning');
                                            $stockText =
                                                $totalStock > $product->reorder_level
                                                    ? 'In Stock'
                                                    : ($totalStock == 0
                                                        ? 'Out of Stock'
                                                        : 'Low Stock');
                                        @endphp
                                        <span class="badge bg-{{ $stockStatus }}" title="{{ $stockText }}">
                                            {{ $totalStock }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($product->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif

                                        @if ($product->track_batch)
                                            <span class="badge bg-info mt-1">Batch</span>
                                        @endif

                                        @if ($product->track_expiry)
                                            <span class="badge bg-warning mt-1">Expiry</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('inventory.products.show', $product->id) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('inventory.products.edit', $product->id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('inventory.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box display-4 text-muted mb-3"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted">Get started by adding your first product.</p>
                    <a href="{{ route('inventory.products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Product
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
