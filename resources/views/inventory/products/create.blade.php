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

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Information</h5>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('inventory.products.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label for="product_code" class="form-label">Product Code *</label>
                                    <input type="text" class="form-control @error('product_code') is-invalid @enderror"
                                        id="product_code" name="product_code" value="{{ old('product_code') }}" required>
                                    <div class="form-text">Unique code for the product (e.g., P-001)</div>
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
                                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                        name="category_id" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="hs_code" class="form-label">HS Code</label>
                                    <input type="text" class="form-control @error('hs_code') is-invalid @enderror"
                                        id="hs_code" name="hs_code" value="{{ old('hs_code') }}">
                                    @error('hs_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pricing & Units -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Pricing & Units</h6>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="unit_of_measure" class="form-label">Unit of Measure *</label>
                                        <select class="form-select @error('unit_of_measure') is-invalid @enderror"
                                            id="unit_of_measure" name="unit_of_measure" required>
                                            <option value="">-- Select Unit --</option>
                                            <option value="PCS" {{ old('unit_of_measure') == 'PCS' ? 'selected' : '' }}>
                                                Pieces</option>
                                            <option value="KG" {{ old('unit_of_measure') == 'KG' ? 'selected' : '' }}>
                                                Kilogram</option>
                                            <option value="LTR" {{ old('unit_of_measure') == 'LTR' ? 'selected' : '' }}>
                                                Liter</option>
                                            <option value="MTR" {{ old('unit_of_measure') == 'MTR' ? 'selected' : '' }}>
                                                Meter</option>
                                            <option value="DOZ" {{ old('unit_of_measure') == 'DOZ' ? 'selected' : '' }}>
                                                Dozen</option>
                                            <option value="BOX" {{ old('unit_of_measure') == 'BOX' ? 'selected' : '' }}>
                                                Box</option>
                                            <option value="CASE"
                                                {{ old('unit_of_measure') == 'CASE' ? 'selected' : '' }}>Case</option>
                                            <option value="PKT" {{ old('unit_of_measure') == 'PKT' ? 'selected' : '' }}>
                                                Packet</option>
                                        </select>
                                        @error('unit_of_measure')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tax_rate" class="form-label">GST Rate (%) *</label>
                                        <select class="form-select @error('tax_rate') is-invalid @enderror" id="tax_rate"
                                            name="tax_rate" required>
                                            <option value="">-- Select Tax Rate --</option>
                                            <option value="0" {{ old('tax_rate') == 0 ? 'selected' : '' }}>0% (Exempt)
                                            </option>
                                            <option value="5" {{ old('tax_rate') == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="12" {{ old('tax_rate') == 12 ? 'selected' : '' }}>12%
                                            </option>
                                            <option value="18" {{ old('tax_rate') == 18 ? 'selected' : '' }}>18%
                                            </option>
                                            <option value="28" {{ old('tax_rate') == 28 ? 'selected' : '' }}>28%
                                            </option>
                                        </select>
                                        @error('tax_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="purchase_price" class="form-label">Purchase Price (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            id="purchase_price" name="purchase_price"
                                            value="{{ old('purchase_price') }}">
                                        @error('purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="selling_price" class="form-label">Selling Price (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('selling_price') is-invalid @enderror"
                                            id="selling_price" name="selling_price" value="{{ old('selling_price') }}">
                                        @error('selling_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mrp" class="form-label">MRP (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('mrp') is-invalid @enderror" id="mrp"
                                            name="mrp" value="{{ old('mrp') }}">
                                        @error('mrp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h6 class="mt-4 mb-3">Stock Management</h6>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="reorder_level" class="form-label">Reorder Level *</label>
                                        <input type="number"
                                            class="form-control @error('reorder_level') is-invalid @enderror"
                                            id="reorder_level" name="reorder_level"
                                            value="{{ old('reorder_level', 0) }}" required>
                                        @error('reorder_level')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="min_stock" class="form-label">Min Stock *</label>
                                        <input type="number"
                                            class="form-control @error('min_stock') is-invalid @enderror" id="min_stock"
                                            name="min_stock" value="{{ old('min_stock', 0) }}" required>
                                        @error('min_stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="max_stock" class="form-label">Max Stock</label>
                                        <input type="number"
                                            class="form-control @error('max_stock') is-invalid @enderror" id="max_stock"
                                            name="max_stock" value="{{ old('max_stock') }}">
                                        @error('max_stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <h6 class="mb-3">Tracking Options</h6>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="track_batch" name="track_batch"
                                                                    {{ old('track_batch') ? 'checked' : '' }}>
                                                                <label class="form-check-label d-flex align-items-center"
                                                                    for="track_batch">
                                                                    <span class="badge bg-info me-2">B</span>
                                                                    Track Batch Numbers
                                                                </label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="track_expiry" name="track_expiry"
                                                                    {{ old('track_expiry') ? 'checked' : '' }}>
                                                                <label class="form-check-label d-flex align-items-center"
                                                                    for="track_expiry">
                                                                    <span class="badge bg-warning me-2">E</span>
                                                                    Track Expiry Dates
                                                                </label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="track_serial" name="track_serial"
                                                                    {{ old('track_serial') ? 'checked' : '' }}>
                                                                <label class="form-check-label d-flex align-items-center"
                                                                    for="track_serial">
                                                                    <span class="badge bg-secondary me-2">S</span>
                                                                    Track Serial Numbers
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <h6 class="mb-3">Stock Management</h6>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="manage_stock" name="manage_stock"
                                                                    value="1"
                                                                    {{ old('manage_stock', true) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="manage_stock">
                                                                    Manage Stock Levels
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="allow_backorder"
                                                                    name="allow_backorder" value="1"
                                                                    {{ old('allow_backorder') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="allow_backorder">
                                                                    Allow Backorders
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="allow_negative"
                                                                    name="allow_negative" value="1"
                                                                    {{ old('allow_negative') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="allow_negative">
                                                                    Allow Negative Stock
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Checkboxes Section -->
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <h6 class="mb-3">Tracking Options</h6>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-check form-switch mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="track_batch"
                                                                            name="track_batch" value="1"
                                                                            {{ old('track_batch') ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="track_batch">
                                                                            Track Batch Numbers
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-check form-switch mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="track_expiry"
                                                                            name="track_expiry" value="1"
                                                                            {{ old('track_expiry') ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="track_expiry">
                                                                            Track Expiry Dates
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-check form-switch mb-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch" id="is_active"
                                                                            name="is_active" value="1"
                                                                            {{ old('is_active', true) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="is_active">
                                                                            Active Product
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @error('track_batch')
                                                                <div class="text-danger small">{{ $message }}</div>
                                                            @enderror
                                                            @error('track_expiry')
                                                                <div class="text-danger small">{{ $message }}</div>
                                                            @enderror
                                                            @error('is_active')
                                                                <div class="text-danger small">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('inventory.products.index') }}" class="btn btn-secondary me-2">
                                    Cancel
                                </a>
                                <button type="submit" name="save" class="btn btn-primary me-2">
                                    <i class="bi bi-check-circle me-1"></i> Save Product
                                </button>
                                <button type="submit" name="save_and_new" value="1" class="btn btn-success">
                                    <i class="bi bi-plus-circle me-1"></i> Save & New
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate product code from name
        document.getElementById('product_name').addEventListener('blur', function() {
            const nameInput = this;
            const codeInput = document.getElementById('product_code');

            // Only generate code if code field is empty
            if (codeInput.value.trim() === '' && nameInput.value.trim() !== '') {
                const productName = nameInput.value.trim();
                const words = productName.split(' ');
                let code = '';

                if (words.length === 1) {
                    code = 'P-' + words[0].substring(0, 3).toUpperCase();
                } else {
                    code = 'P-' + words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Make it 6 characters max
                if (code.length > 6) {
                    code = code.substring(0, 6);
                }

                codeInput.value = code;
            }
        });

        // Auto-calculate selling price if purchase price entered
        document.getElementById('purchase_price').addEventListener('blur', function() {
            const purchasePrice = parseFloat(this.value) || 0;
            const sellingInput = document.getElementById('selling_price');
            const mrpInput = document.getElementById('mrp');

            if (purchasePrice > 0 && (!sellingInput.value || sellingInput.value === '0')) {
                // Add 20% margin
                const sellingPrice = purchasePrice * 1.2;
                sellingInput.value = sellingPrice.toFixed(2);

                // Set MRP as 30% above purchase price
                if (!mrpInput.value || mrpInput.value === '0') {
                    mrpInput.value = (purchasePrice * 1.3).toFixed(2);
                }
            }
        });
    </script>
@endpush
