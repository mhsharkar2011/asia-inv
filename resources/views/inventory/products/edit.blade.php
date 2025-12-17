@extends('layouts.app')

@section('title', 'Edit Product - ' . $product->product_name . ' - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Edit Product</h1>
                <p class="text-muted mb-0">Product Code: {{ $product->product_code }}</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('inventory.products.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('inventory.products.show', $product->id) }}" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-eye"></i> View Product
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Product Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventory.products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <h6 class="mb-3">Basic Information</h6>

                                    <div class="mb-3">
                                        <label for="product_code" class="form-label">Product Code *</label>
                                        <input type="text"
                                            class="form-control @error('product_code') is-invalid @enderror"
                                            id="product_code" name="product_code"
                                            value="{{ old('product_code', $product->product_code) }}" required>
                                        <div class="form-text">Unique product identifier</div>
                                        @error('product_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name *</label>
                                        <input type="text"
                                            class="form-control @error('product_name') is-invalid @enderror"
                                            id="product_name" name="product_name"
                                            value="{{ old('product_name', $product->product_name) }}" required>
                                        @error('product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="serial_no" class="form-label">Serial No</label>
                                            <input type="text" class="form-control @error('serial_no') is-invalid @enderror" id="serial_no" name="serial_no" value="{{ old('serial_no', $product->serial_no) }}">
                                            @error('serial_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="category_id" class="form-label">Category *</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="2">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="unit_of_measure" class="form-label">Unit of Measure *</label>
                                            <select class="form-select @error('unit_of_measure') is-invalid @enderror"
                                                id="unit_of_measure" name="unit_of_measure" required>
                                                <option value="">-- Select Unit --</option>
                                                <option value="PCS"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'PCS' ? 'selected' : '' }}>
                                                    Pieces</option>
                                                <option value="KG"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'KG' ? 'selected' : '' }}>
                                                    Kilogram</option>
                                                <option value="LTR"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'LTR' ? 'selected' : '' }}>
                                                    Liter</option>
                                                <option value="MTR"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'MTR' ? 'selected' : '' }}>
                                                    Meter</option>
                                                <option value="BOX"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'BOX' ? 'selected' : '' }}>
                                                    Box</option>
                                                <option value="SET"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'SET' ? 'selected' : '' }}>
                                                    Set</option>
                                                <option value="PKT"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'PKT' ? 'selected' : '' }}>
                                                    Packet</option>
                                                <option value="ROLL"
                                                    {{ old('unit_of_measure', $product->unit_of_measure) == 'ROLL' ? 'selected' : '' }}>
                                                    Roll</option>
                                            </select>
                                            @error('unit_of_measure')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Stock & Pricing Information -->
                                <div class="col-md-6">
                                    <h6 class="mb-3">Stock & Pricing Information</h6>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="reorder_level" class="form-label">Reorder Level *</label>
                                            <input type="number"
                                                class="form-control @error('reorder_level') is-invalid @enderror"
                                                id="reorder_level" name="reorder_level"
                                                value="{{ old('reorder_level', $product->reorder_level) }}" required
                                                min="0">
                                            <div class="form-text">Minimum stock before reordering</div>
                                            @error('reorder_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="min_stock" class="form-label">Minimum Stock *</label>
                                            <input type="number"
                                                class="form-control @error('min_stock') is-invalid @enderror"
                                                id="min_stock" name="min_stock"
                                                value="{{ old('min_stock', $product->min_stock) }}" required
                                                min="0">
                                            @error('min_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tax_rate" class="form-label">Tax Rate (%) *</label>
                                            <select class="form-select @error('tax_rate') is-invalid @enderror"
                                                id="tax_rate" name="tax_rate" required>
                                                <option value="0"
                                                    {{ old('tax_rate', $product->tax_rate) == 0 ? 'selected' : '' }}>0%
                                                </option>
                                                <option value="5"
                                                    {{ old('tax_rate', $product->tax_rate) == 5 ? 'selected' : '' }}>5%
                                                </option>
                                                <option value="12"
                                                    {{ old('tax_rate', $product->tax_rate) == 12 ? 'selected' : '' }}>
                                                    12%
                                                </option>
                                                <option value="18"
                                                    {{ old('tax_rate', $product->tax_rate) == 18 ? 'selected' : '' }}>
                                                    18%
                                                </option>
                                                <option value="28"
                                                    {{ old('tax_rate', $product->tax_rate) == 28 ? 'selected' : '' }}>
                                                    28%
                                                </option>
                                            </select>
                                            @error('tax_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="max_stock" class="form-label">Maximum Stock</label>
                                            <input type="number"
                                                class="form-control @error('max_stock') is-invalid @enderror"
                                                id="max_stock" name="max_stock"
                                                value="{{ old('max_stock', $product->max_stock) }}" min="0">
                                            @error('max_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="purchase_price" class="form-label">Purchase Price (₹)</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('purchase_price') is-invalid @enderror"
                                                id="purchase_price" name="purchase_price"
                                                value="{{ old('purchase_price', $product->purchase_price) }}"
                                                min="0">
                                            @error('purchase_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="selling_price" class="form-label">Selling Price (₹)</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('selling_price') is-invalid @enderror"
                                                id="selling_price" name="selling_price"
                                                value="{{ old('selling_price', $product->selling_price) }}"
                                                min="0">
                                            @error('selling_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mrp" class="form-label">MRP (₹)</label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('mrp') is-invalid @enderror" id="mrp"
                                                name="mrp" value="{{ old('mrp', $product->mrp) }}" min="0">
                                            @error('mrp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="track_batch"
                                                    name="track_batch" value="1"
                                                    {{ old('track_batch', $product->track_batch) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="track_batch">Track Batch
                                                    Numbers</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="track_expiry"
                                                    name="track_expiry" value="1"
                                                    {{ old('track_expiry', $product->track_expiry) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="track_expiry">Track Expiry
                                                    Dates</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1" checked>
                                                <label class="form-check-label" for="is_active">
                                                    Active Product
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="active"
                                                {{ old('status', $product->is_active ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $product->is_active ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Current Stock Information -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="bi bi-box-seam me-2"></i>Current Stock                                              Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="text-center p-3 border rounded">
                                                        <div class="h4 mb-1">{{ $product->stock_quantity ?? 0 }}</div>
                                                        <small class="text-muted">Current Stock</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-3 border rounded">
                                                        <div class="h4 mb-1">{{ $product->reorder_level ?? 0 }}</div>
                                                        <small class="text-muted">Reorder Level</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-3 border rounded">
                                                        <div class="h4 mb-1">{{ $product->min_stock ?? 0 }}</div>
                                                        <small class="text-muted">Minimum Stock</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-3 border rounded">
                                                        @if ($product->stock_quantity <= 0)
                                                            <span class="badge bg-danger h4 mb-1">Out of Stock</span>
                                                        @elseif($product->stock_quantity <= $product->reorder_level)
                                                            <span class="badge bg-warning h4 mb-1">Low Stock</span>
                                                        @else
                                                            <span class="badge bg-success h4 mb-1">In Stock</span>
                                                        @endif
                                                        <small class="text-muted">Stock Status</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <a href="#" class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#updateStockModal">
                                                    <i class="bi bi-plus-slash-minus me-1"></i>Update Stock
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        <i class="bi bi-trash"></i> Delete Product
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ route('inventory.products.show', $product->id) }}"
                                        class="btn btn-secondary me-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Update Product
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Value Calculation -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Stock Value Calculation</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Current Stock:</span>
                                <span class="fw-bold">{{ $product->stock_quantity ?? 0 }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Cost Price:</span>
                                <span>₹{{ number_format($product->purchase_price ?? 0, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Selling Price:</span>
                                <span>₹{{ number_format($product->selling_price ?? 0, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <span class="fw-bold">Stock Value (at cost):</span>
                                <span class="fw-bold text-primary">
                                    BDT{{ number_format(($product->stock_quantity ?? 0) * ($product->purchase_price ?? 0), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Product Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-5">Product Code:</dt>
                                    <dd class="col-sm-7">{{ $product->product_code }}</dd>

                                    <dt class="col-sm-5">Created:</dt>
                                    <dd class="col-sm-7">{{ $product->created_at->format('d M, Y') }}</dd>

                                    <dt class="col-sm-5">Last Updated:</dt>
                                    <dd class="col-sm-7">{{ $product->updated_at->format('d M, Y h:i A') }}</dd>

                                    <dt class="col-sm-5">Track Batch:</dt>
                                    <dd class="col-sm-7">
                                        @if ($product->track_batch)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-5">Serial No:</dt>
                                    <dd class="col-sm-7">{{ $product->serial_no ?? 'N/A' }}</dd>

                                    <dt class="col-sm-5">Tax Rate:</dt>
                                    <dd class="col-sm-7">{{ $product->tax_rate ?? 0 }}%</dd>

                                    <dt class="col-sm-5">Track Expiry:</dt>
                                    <dd class="col-sm-7">
                                        @if ($product->track_expiry)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-5">Status:</dt>
                                    <dd class="col-sm-7">
                                        @if ($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete product <strong>{{ $product->product_name }}</strong>?</p>
                    <p class="text-danger">
                        <i class="bi bi-exclamation-triangle"></i> This action cannot be undone.
                        All associated inventory records will be deleted.
                    </p>
                    <div class="alert alert-warning">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            <strong>Note:</strong> You cannot delete products that have inventory transactions.
                            Instead, you can set the status to "Inactive".
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('inventory.products.destroy', $product->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Stock Modal -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStockModalLabel">Update Stock Quantity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inventory.products.update-stock', $product->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Stock</label>
                            <input type="text" name="stock_quantity" class="form-control"
                                value="{{ $product->stock_quantity }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="adjustment_type" class="form-label">Adjustment Type *</label>
                            <select class="form-select" id="adjustment_type" name="adjustment_type" required>
                                <option value="add">Add Stock</option>
                                <option value="subtract">Subtract Stock</option>
                                <option value="set">Set Stock to Specific Value</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity *</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Update Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid rgba(0, 0, 0, .125);
            }

            h6 {
                color: #495057;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                padding-bottom: 8px;
            }

            .form-label {
                font-weight: 500;
                color: #495057;
            }

            .form-text {
                font-size: 0.85rem;
            }

            .border-info {
                border-color: #0dcaf0 !important;
            }

            .bg-info {
                background-color: #0dcaf0 !important;
            }

            dt {
                font-weight: 500;
                color: #6c757d;
            }

            dd {
                color: #212529;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Update form status based on is_active
            document.addEventListener('DOMContentLoaded', function() {
                const statusSelect = document.getElementById('status');
                const isActive = {{ $product->is_active ? 'true' : 'false' }};

                // Set initial value
                statusSelect.value = isActive ? 'active' : 'inactive';

                // Handle stock update modal calculation
                const adjustmentType = document.getElementById('adjustment_type');
                const quantityInput = document.getElementById('quantity');
                const currentStock = {{ $product->stock_quantity ?? 0 }};

                adjustmentType.addEventListener('change', function() {
                    if (this.value === 'set') {
                        quantityInput.min = 0;
                        quantityInput.value = currentStock;
                    } else {
                        quantityInput.min = 1;
                        quantityInput.value = 1;
                    }
                });

                // Calculate new stock based on adjustment
                quantityInput.addEventListener('input', function() {
                    const type = adjustmentType.value;
                    const quantity = parseInt(this.value) || 0;

                    let newStock = currentStock;

                    switch (type) {
                        case 'add':
                            newStock = currentStock + quantity;
                            break;
                        case 'subtract':
                            newStock = Math.max(0, currentStock - quantity);
                            break;
                        case 'set':
                            newStock = quantity;
                            break;
                    }

                    // Show preview (optional)
                    console.log('New stock would be:', newStock);
                });

                // Validate purchase and selling prices
                const purchasePrice = document.getElementById('purchase_price');
                const sellingPrice = document.getElementById('selling_price');
                const mrpInput = document.getElementById('mrp');

                function validatePrices() {
                    const purchase = parseFloat(purchasePrice.value) || 0;
                    const selling = parseFloat(sellingPrice.value) || 0;
                    const mrp = parseFloat(mrpInput.value) || 0;

                    if (selling > 0 && purchase > 0 && selling < purchase) {
                        sellingPrice.classList.add('is-invalid');
                        sellingPrice.nextElementSibling?.remove();
                        sellingPrice.insertAdjacentHTML('afterend',
                            '<div class="invalid-feedback">Selling price should be higher than purchase price for profit.</div>'
                        );
                    } else {
                        sellingPrice.classList.remove('is-invalid');
                    }

                    if (mrp > 0 && selling > 0 && mrp < selling) {
                        mrpInput.classList.add('is-invalid');
                        mrpInput.nextElementSibling?.remove();
                        mrpInput.insertAdjacentHTML('afterend',
                            '<div class="invalid-feedback">MRP should be higher than or equal to selling price.</div>'
                        );
                    } else {
                        mrpInput.classList.remove('is-invalid');
                    }
                }

                purchasePrice.addEventListener('blur', validatePrices);
                sellingPrice.addEventListener('blur', validatePrices);
                mrpInput.addEventListener('blur', validatePrices);

                // Initial validation
                validatePrices();

                // Show confirmation before leaving page if form has changes
                let formChanged = false;
                const form = document.querySelector('form');

                form.addEventListener('change', function() {
                    formChanged = true;
                });

                form.addEventListener('submit', function() {
                    formChanged = false;
                });

                window.addEventListener('beforeunload', function(e) {
                    if (formChanged) {
                        e.preventDefault();
                        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                    }
                });
            });
        </script>
    @endpush
@endsection
