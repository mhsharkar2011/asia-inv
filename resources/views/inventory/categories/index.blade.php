@extends('layouts.app')

@section('title', 'Categories - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Categories</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('inventory.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> New Category
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('inventory.categories.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by code or name..." value="{{ $search }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('inventory.categories.index') }}" class="btn btn-secondary">
                            Clear Search
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-body">
            @if ($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Category Name</th>
                                <th>Parent Category</th>
                                <th>Tax Rate</th>
                                <th>Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <strong>{{ $category->category_code }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $category->category_name }}</div>
                                        @if ($category->description)
                                            <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->parent)
                                            <span class="badge bg-info">{{ $category->parent->category_name }}</span>
                                        @else
                                            <span class="badge bg-secondary">Parent</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->tax_rate_applicable)
                                            <span class="badge bg-success">{{ $category->tax_rate_applicable }}%</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary">{{ $category->products_count ?? $category->products->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('inventory.categories.show', $category->id) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('inventory.categories.edit', $category->id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('inventory.categories.destroy', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this category?')"
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
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-tags display-4 text-muted mb-3"></i>
                    <h4>No Categories Found</h4>
                    <p class="text-muted">Get started by creating your first category.</p>
                    <a href="{{ route('inventory.categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
