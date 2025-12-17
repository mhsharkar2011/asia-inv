@extends('layouts.app')

@section('title', $product->product_name . ' - Product Details - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">{{ $product->product_name }}</h1>
                <p class="text-muted mb-0">Product Code: {{ $product->product_code }}</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('inventory.products.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('inventory.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>

        <!-- Product Details -->
        <div class="row">
            <!-- Left Column - Basic Info -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Product Code:</dt>
                                    <dd class="col-sm-8">{{ $product->product_code }}</dd>

                                    <dt class="col-sm-4">Product Name:</dt>
                                    <dd class="col-sm-8">{{ $product->product_name }}</dd>

                                    <dt class="col-sm-4">Category:</dt>
                                    <dd class="col-sm-8">{{ $product->category->category_name ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Description:</dt>
                                    <dd class="col-sm-8">{{ $product->description ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Unit of Measure:</dt>
                                    <dd class="col-sm-8">{{ $product->unit_of_measure }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">HSN/SAC Code:</dt>
                                    <dd class="col-sm-8">{{ $product->hsn_sac_code ?? 'N/A' }}</dd>

                                    <dt class="col-sm-4">Tax Rate:</dt>
                                    <dd class="col-sm-8">{{ $product->tax_rate }}%</dd>

                                    <dt class="col-sm-4">Status:</dt>
                                    <dd class="col-sm-8">
                                        @if ($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </dd>

                                    <dt class="col-sm-4">Created:</dt>
                                    <dd class="col-sm-8">{{ $product->created_at->format('d M, Y') }}</dd>

                                    <dt class="col-sm-4">Last Updated:</dt>
                                    <dd class="col-sm-8">{{ $product->updated_at->format('d M, Y h:i A') }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Stock Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="p-3 border rounded">
                                    <div
                                        class="h2 mb-1 {{ $product->stock_quantity <= 0 ? 'text-danger' : ($product->stock_quantity <= $product->reorder_level ? 'text-warning' : 'text-success') }}">
                                        {{ $product->stock_quantity }}
                                    </div>
                                    <small class="text-muted">Current Stock</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded">
                                    <div class="h2 mb-1">{{ $product->reorder_level }}</div>
                                    <small class="text-muted">Reorder Level</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded">
                                    <div class="h2 mb-1">{{ $product->min_stock }}</div>
                                    <small class="text-muted">Minimum Stock</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 border rounded">
                                    <div class="h2 mb-1">{{ $product->max_stock ?? 'N/A' }}</div>
                                    <small class="text-muted">Maximum Stock</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="progress" style="height: 20px;">
                                @php
                                    $maxStock = $product->max_stock ?? $product->reorder_level * 3;
                                    $stockPercent =
                                        $maxStock > 0 ? min(100, ($product->stock_quantity / $maxStock) * 100) : 0;

                                    if ($product->stock_quantity <= 0) {
                                        $progressClass = 'bg-danger';
                                    } elseif ($product->stock_quantity <= $product->reorder_level) {
                                        $progressClass = 'bg-warning';
                                    } else {
                                        $progressClass = 'bg-success';
                                    }
                                @endphp
                                <div class="progress-bar {{ $progressClass }}" role="progressbar"
                                    style="width: {{ $stockPercent }}%" aria-valuenow="{{ $product->stock_quantity }}"
                                    aria-valuemin="0" aria-valuemax="{{ $maxStock }}">
                                    {{ $product->stock_quantity }} / {{ $maxStock }}
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    @if ($product->stock_quantity <= 0)
                                        <span class="text-danger"><i class="bi bi-exclamation-triangle"></i> Out of
                                            Stock</span>
                                    @elseif($product->stock_quantity <= $product->reorder_level)
                                        <span class="text-warning"><i class="bi bi-exclamation-triangle"></i> Low Stock -
                                            Reorder Now</span>
                                    @else
                                        <span class="text-success"><i class="bi bi-check-circle"></i> Stock Level OK</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Pricing & Actions -->
            <div class="col-md-4">
                <!-- Pricing Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pricing Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Purchase Price:</span>
                                <span class="fw-bold">BDT{{ number_format($product->purchase_price, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Selling Price:</span>
                                <span class="fw-bold text-primary">BDT{{ number_format($product->selling_price, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>MRP:</span>
                                <span class="fw-bold">BDT{{ number_format($product->mrp, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <span>Profit Margin:</span>
                                <span class="fw-bold text-success">
                                    @if ($product->purchase_price > 0)
                                        {{ number_format((($product->selling_price - $product->purchase_price) / $product->purchase_price) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Stock Value (at cost):</span>
                                <span class="fw-bold text-info">
                                    BDT{{ number_format($product->stock_quantity * $product->purchase_price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('inventory.products.edit', $product->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Product
                            </a>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#updateStockModal">
                                <i class="bi bi-plus-slash-minus me-2"></i>Update Stock
                            </button>
                            <a href="#" class="btn btn-outline-success">
                                <i class="bi bi-cart-plus me-2"></i>Create Purchase Order
                            </a>
                            @if ($product->is_active)
                                <form action="{{ route('inventory.products.toggle-status', $product->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning w-100">
                                        <i class="bi bi-toggle-off me-2"></i>Deactivate Product
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('inventory.products.toggle-status', $product->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="bi bi-toggle-on me-2"></i>Activate Product
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking Information -->
        @if ($product->track_batch || $product->track_expiry)
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tracking Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if ($product->track_batch)
                            <div class="col-md-6">
                                <h6><i class="bi bi-upc-scan me-2"></i>Batch Tracking</h6>
                                <p class="text-muted">This product tracks batch numbers for better inventory management.
                                </p>
                            </div>
                        @endif
                        @if ($product->track_expiry)
                            <div class="col-md-6">
                                <h6><i class="bi bi-calendar-date me-2"></i>Expiry Tracking</h6>
                                <p class="text-muted">This product tracks expiry dates to prevent selling expired items.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
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
                    </p>
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
                            <input type="text" class="form-control" value="{{ $product->stock_quantity }}" readonly>
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

    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        dt {
            font-weight: 500;
            color: #6c757d;
        }

        dd {
            color: #212529;
        }

        .progress {
            background-color: #e9ecef;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }
    </style>
@endsection
