@extends('layouts.app')

@section('title', $category->category_name . ' - Asia Enterprise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $category->category_name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('inventory.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('inventory.categories.destroy', $category->id) }}"
                  method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this category?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
        <a href="{{ route('inventory.categories.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <!-- Category Details -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Category Code:</th>
                                <td><strong>{{ $category->category_code }}</strong></td>
                            </tr>
                            <tr>
                                <th>Category Name:</th>
                                <td>{{ $category->category_name }}</td>
                            </tr>
                            <tr>
                                <th>Full Path:</th>
                                <td>{{ $category->full_path }}</td>
                            </tr>
                            <tr>
                                <th>Parent Category:</th>
                                <td>
                                    @if($category->parent)
                                        <a href="{{ route('inventory.categories.show', $category->parent->id) }}"
                                           class="text-decoration-none">
                                            {{ $category->parent->category_name }} ({{ $category->parent->category_code }})
                                        </a>
                                    @else
                                        <span class="text-muted">No Parent (Top Level)</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Default Tax Rate:</th>
                                <td>
                                    @if($category->tax_rate_applicable)
                                        <span class="badge bg-success">{{ $category->tax_rate_applicable }}%</span>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Products Count:</th>
                                <td>
                                    <span class="badge bg-primary">{{ $category->products->count() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Subcategories:</th>
                                <td>
                                    <span class="badge bg-info">{{ $category->children->count() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($category->description)
                <div class="mt-3">
                    <h6>Description:</h6>
                    <p class="text-muted">{{ $category->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Products in this Category -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Products in this Category</h5>
                <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
            </div>
            <div class="card-body">
                @if($category->products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->products as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        @php
                                            $totalStock = $product->inventories->sum('quantity_available');
                                            $status = $totalStock > $product->reorder_level ? 'success' :
                                                     ($totalStock == 0 ? 'danger' : 'warning');
                                        @endphp
                                        <span class="badge bg-{{ $status }}">{{ $totalStock }}</span>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('inventory.products.show', $product->id) }}"
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-box display-4 text-muted mb-3"></i>
                        <p class="text-muted">No products in this category yet.</p>
                        <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                           class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Subcategories -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Subcategories</h5>
                <a href="{{ route('inventory.categories.create') }}?parent={{ $category->id }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Add Subcategory
                </a>
            </div>
            <div class="card-body">
                @if($category->children->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($category->children as $subcategory)
                        <a href="{{ route('inventory.categories.show', $subcategory->id) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $subcategory->category_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $subcategory->category_code }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                {{ $subcategory->products->count() }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-folder-x display-4 text-muted mb-2"></i>
                        <p class="text-muted">No subcategories</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                       class="btn btn-outline-primary text-start">
                        <i class="bi bi-plus-circle me-2"></i> Add Product
                    </a>
                    <a href="{{ route('inventory.categories.create') }}?parent={{ $category->id }}"
                       class="btn btn-outline-success text-start">
                        <i class="bi bi-plus-square me-2"></i> Add Subcategory
                    </a>
                    <a href="{{ route('inventory.products.index') }}?category={{ $category->id }}"
                       class="btn btn-outline-info text-start">
                        <i class="bi bi-list-ul me-2"></i> View All Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
