@extends('layouts.app')

@section('title', 'Create Product - Asia Enterprise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Product</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('inventory.products.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('inventory.products.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-6">
                    <h5 class="mb-3">Basic Information</h5>

                    <div class="mb-3">
                        <label for="product_code" class="form-label">Product Code *</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror"
                               id="product_code" name="product_code" value="{{ old('product_code') }}" required>
                        @error('product_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                               id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                        @error('product_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}"
                                        {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="hsn_sac_code" class="form-label">HSN/SAC Code</label>
                        <input type="text" class="form-control @error('hsn_sac_code') is-invalid @enderror"
                               id="hsn_sac_code" name="hsn_sac_code" value="{{ old('hsn_sac_code') }}">
                        @error('hsn_sac_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Units -->
                <div class="col-md-6">
                    <h5 class="mb-3">Pricing & Units</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="unit_of_measure" class="form-label">Unit of Measure *</label>
                            <select class="form-select @error('unit_of_measure') is-invalid @enderror"
                                    id="unit_of_measure" name="unit_of_measure" required>
                                <option value="">Select Unit</option>
                                <option value="PCS" {{ old('unit_of_measure') == 'PCS' ? 'selected' : '' }}>Pieces</option>
                                <option value="KG" {{ old('unit_of_measure') == 'KG' ? 'selected' : '' }}>Kilogram</option>
                                <option value="LTR" {{ old('unit_of_measure') == 'LTR' ? 'selected' : '' }}>Liter</option>
                                <option value="MTR" {{ old('unit_of_measure') == 'MTR' ? 'selected' : '' }}>Meter</option>
                                <option value="DOZ" {{ old('unit_of_measure') == 'DOZ' ? 'selected' : '' }}>Dozen</option>
                            </select>
                            @error('unit_of_measure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="purchase_unit" class="form-label">Purchase Unit</label>
                            <select class="form-select" id="purchase_unit" name="purchase_unit">
                                <option value="">Same as UOM</option>
                                <option value="DOZ" {{ old('purchase_unit') == 'DOZ' ? 'selected' : '' }}>Dozen</option>
                                <option value="BOX" {{ old('purchase_unit') == 'BOX' ? 'selected' : '' }}>Box</option>
                                <option value="CASE" {{ old('purchase_unit') == 'CASE' ? 'selected' : '' }}>Case</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Purchase Price</label>
                        <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror"
                               id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}">
                        @error('purchase_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Selling Price</label>
                        <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror"
                               id="selling_price" name="selling_price" value="{{ old('selling_price') }}">
                        @error('selling_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mrp" class="form-label">MRP</label>
                        <input type="number" step="0.01" class="form-control @error('mrp') is-invalid @enderror"
                               id="mrp" name="mrp" value="{{ old('mrp') }}">
                        @error('mrp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tax_rate" class="form-label">GST Rate</label>
                        <select class="form-select @error('tax_rate') is-invalid @enderror" id="tax_rate" name="tax_rate">
                            <option value="0" {{ old('tax_rate') == 0 ? 'selected' : '' }}>0%</option>
                            <option value="5" {{ old('tax_rate') == 5 ? 'selected' : '' }}>5%</option>
                            <option value="12" {{ old('tax_rate') == 12 ? 'selected' : '' }}>12%</option>
                            <option value="18" {{ old('tax_rate') == 18 ? 'selected' : '' }}>18%</option>
                            <option value="28" {{ old('tax_rate') == 28 ? 'selected' : '' }}>28%</option>
                        </select>
                        @error('tax_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>

            <!-- Stock Management -->
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Stock Management</h5>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="reorder_level" class="form-label">Reorder Level</label>
                            <input type="number" class="form-control @error('reorder_level') is-invalid @enderror"
                                   id="reorder_level" name="reorder_level" value="{{ old('reorder_level', 0) }}">
                            @error('reorder_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="min_stock" class="form-label">Min Stock</label>
                            <input type="number" class="form-control @error('min_stock') is-invalid @enderror"
                                   id="min_stock" name="min_stock" value="{{ old('min_stock', 0) }}">
                            @error('min_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="max_stock" class="form-label">Max Stock</label>
                            <input type="number" class="form-control @error('max_stock') is-invalid @enderror"
                                   id="max_stock" name="max_stock" value="{{ old('max_stock') }}">
                            @error('max_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="track_batch" name="track_batch"
                                   {{ old('track_batch') ? 'checked' : '' }}>
                            <label class="form-check-label" for="track_batch">
                                Track Batch
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="track_expiry" name="track_expiry"
                                   {{ old('track_expiry') ? 'checked' : '' }}>
                            <label class="form-check-label" for="track_expiry">
                                Track Expiry
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end">
                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary me-2">Save</button>
                <button type="submit" name="save_and_new" value="1" class="btn btn-success">Save & New</button>
            </div>
        </form>
    </div>
</div>
@endsection
