@extends('layouts.app')

@section('title', 'Edit Category - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('inventory.categories.show', $category->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-eye"></i> View
            </a>
            <a href="{{ route('inventory.categories.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Category Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_code" class="form-label">Category Code *</label>
                                    <input type="text" class="form-control @error('category_code') is-invalid @enderror"
                                        id="category_code" name="category_code"
                                        value="{{ old('category_code', $category->category_code) }}" required>
                                    @error('category_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name *</label>
                                    <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                        id="category_name" name="category_name"
                                        value="{{ old('category_name', $category->category_name) }}" required>
                                    @error('category_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="parent_category_id" class="form-label">Parent Category</label>
                                    <select class="form-select @error('parent_category_id') is-invalid @enderror"
                                        id="parent_category_id" name="parent_category_id">
                                        <option value="">-- Select Parent Category --</option>
                                        @foreach ($parentCategories as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_category_id', $category->parent_category_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->category_name }} ({{ $parent->category_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_rate_applicable" class="form-label">Default Tax Rate (%)</label>
                                    <select class="form-select @error('tax_rate_applicable') is-invalid @enderror"
                                        id="tax_rate_applicable" name="tax_rate_applicable">
                                        <option value="">-- Select Tax Rate --</option>
                                        <option value="0"
                                            {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 0 ? 'selected' : '' }}>
                                            0% (Exempt)</option>
                                        <option value="5"
                                            {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 5 ? 'selected' : '' }}>
                                            5%</option>
                                        <option value="12"
                                            {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 12 ? 'selected' : '' }}>
                                            12%</option>
                                        <option value="18"
                                            {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 18 ? 'selected' : '' }}>
                                            18%</option>
                                        <option value="28"
                                            {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 28 ? 'selected' : '' }}>
                                            28%</option>
                                    </select>
                                    @error('tax_rate_applicable')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="4">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('inventory.categories.show', $category->id) }}"
                                class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Information -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle me-1"></i> Current Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Category Path:</strong> {{ $category->full_path }}</p>
                            <p><strong>Products in Category:</strong> {{ $category->products->count() }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Subcategories:</strong> {{ $category->children->count() }}</p>
                            <p><strong>Created:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
