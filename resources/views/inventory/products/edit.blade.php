@extends('layouts.admin')

@section('title', 'Edit Product - ' . $product->product_name . ' - Asia Enterprise')

@section('breadcrumb', 'Edit Product')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Edit Product</h1>
                <p class="text-gray-600 mt-1">Product Code: {{ $product->product_code }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('inventory.products.index') }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Products
                </a>
                <a href="{{ route('inventory.products.show', $product->id) }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Product
                </a>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Edit Product Information</h2>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form action="{{ route('inventory.products.update', $product->id) }}" method="POST" id="productForm">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column: Basic Information -->
                        <div class="space-y-6">
                            <!-- Basic Information Header -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Basic
                                    Information</h3>

                                <!-- Product Code -->
                                <div class="mb-4">
                                    <label for="product_code" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="product_code" name="product_code"
                                        value="{{ old('product_code', $product->product_code) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_code') border-red-500 @enderror"
                                        placeholder="PROD-001">
                                    <p class="mt-1 text-sm text-gray-500">Unique product identifier</p>
                                    @error('product_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Product Name -->
                                <div class="mb-4">
                                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="product_name" name="product_name"
                                        value="{{ old('product_name', $product->product_name) }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_name') border-red-500 @enderror"
                                        placeholder="Enter product name">
                                    @error('product_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Serial No & Category Row -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Serial No -->
                                    <div>
                                        <label for="serial_no" class="block text-sm font-medium text-gray-700 mb-1">
                                            Serial No
                                        </label>
                                        <input type="text" id="serial_no" name="serial_no"
                                            value="{{ old('serial_no', $product->serial_no) }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('serial_no') border-red-500 @enderror"
                                            placeholder="Optional serial number">
                                        @error('serial_no')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select id="category_id" name="category_id" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Description
                                    </label>
                                    <textarea id="description" name="description" rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Unit of Measure -->
                                <div class="mb-4">
                                    <label for="unit_of_measure" class="block text-sm font-medium text-gray-700 mb-1">
                                        Unit of Measure <span class="text-red-500">*</span>
                                    </label>
                                    <select id="unit_of_measure" name="unit_of_measure" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('unit_of_measure') border-red-500 @enderror">
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
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Stock & Pricing Information -->
                        <div class="space-y-6">
                            <!-- Stock & Pricing Header -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Stock &
                                    Pricing Information</h3>

                                <!-- Reorder Level & Minimum Stock -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-1">
                                            Reorder Level <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" id="reorder_level" name="reorder_level"
                                            value="{{ old('reorder_level', $product->reorder_level) }}" required
                                            min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reorder_level') border-red-500 @enderror">
                                        <p class="mt-1 text-sm text-gray-500">Minimum stock before reordering</p>
                                        @error('reorder_level')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                            Minimum Stock <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" id="min_stock" name="min_stock"
                                            value="{{ old('min_stock', $product->min_stock) }}" required min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('min_stock') border-red-500 @enderror">
                                        @error('min_stock')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tax Rate & Maximum Stock -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-1">
                                            Tax Rate (%) <span class="text-red-500">*</span>
                                        </label>
                                        <select id="tax_rate" name="tax_rate" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tax_rate') border-red-500 @enderror">
                                            <option value="0"
                                                {{ old('tax_rate', $product->tax_rate) == 0 ? 'selected' : '' }}>0%
                                            </option>
                                            <option value="5"
                                                {{ old('tax_rate', $product->tax_rate) == 5 ? 'selected' : '' }}>5%
                                            </option>
                                            <option value="12"
                                                {{ old('tax_rate', $product->tax_rate) == 12 ? 'selected' : '' }}>12%
                                            </option>
                                            <option value="18"
                                                {{ old('tax_rate', $product->tax_rate) == 18 ? 'selected' : '' }}>18%
                                            </option>
                                            <option value="28"
                                                {{ old('tax_rate', $product->tax_rate) == 28 ? 'selected' : '' }}>28%
                                            </option>
                                        </select>
                                        @error('tax_rate')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="max_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                            Maximum Stock
                                        </label>
                                        <input type="number" id="max_stock" name="max_stock"
                                            value="{{ old('max_stock', $product->max_stock) }}" min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_stock') border-red-500 @enderror">
                                        @error('max_stock')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Purchase & Selling Price -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                            Purchase Price (BDT)
                                        </label>
                                        <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                                            value="{{ old('purchase_price', $product->purchase_price) }}" min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purchase_price') border-red-500 @enderror">
                                        @error('purchase_price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">
                                            Selling Price (BDT)
                                        </label>
                                        <input type="number" step="0.01" id="selling_price" name="selling_price"
                                            value="{{ old('selling_price', $product->selling_price) }}" min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('selling_price') border-red-500 @enderror">
                                        @error('selling_price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- MRP & Checkboxes -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="mrp" class="block text-sm font-medium text-gray-700 mb-1">
                                            MRP (BDT)
                                        </label>
                                        <input type="number" step="0.01" id="mrp" name="mrp"
                                            value="{{ old('mrp', $product->mrp) }}" min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mrp') border-red-500 @enderror">
                                        @error('mrp')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="track_batch" name="track_batch" value="1"
                                                {{ old('track_batch', $product->track_batch) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="track_batch" class="ml-2 text-sm text-gray-700">Track Batch
                                                Numbers</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="track_expiry" name="track_expiry" value="1"
                                                {{ old('track_expiry', $product->track_expiry) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="track_expiry" class="ml-2 text-sm text-gray-700">Track Expiry
                                                Dates</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                        <option value="active"
                                            {{ old('status', $product->is_active ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ old('status', $product->is_active ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Stock Information -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Current Stock Information</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <!-- Current Stock -->
                                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $product->stock_quantity ?? 0 }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">Current Stock</div>
                                </div>

                                <!-- Reorder Level -->
                                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                                    <div class="text-2xl font-bold text-amber-600">{{ $product->reorder_level ?? 0 }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">Reorder Level</div>
                                </div>

                                <!-- Minimum Stock -->
                                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                                    <div class="text-2xl font-bold text-orange-600">{{ $product->min_stock ?? 0 }}</div>
                                    <div class="text-sm text-gray-500 mt-1">Minimum Stock</div>
                                </div>

                                <!-- Stock Status -->
                                <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
                                    @if ($product->stock_quantity <= 0)
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            Out of Stock
                                        </div>
                                    @elseif($product->stock_quantity <= $product->reorder_level)
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                            Low Stock
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            In Stock
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500 mt-2">Stock Status</div>
                                </div>
                            </div>

                            <button type="button" onclick="openUpdateStockModal()"
                                class="inline-flex items-center px-4 py-2 border border-cyan-300 text-sm font-medium rounded-lg text-cyan-700 bg-white hover:bg-cyan-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Update Stock
                            </button>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <button type="button" onclick="openDeleteModal()"
                                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Product
                                </button>
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('inventory.products.show', $product->id) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg shadow-sm hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bottom Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Stock Value Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Stock Value Calculation</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Current Stock:</span>
                            <span class="font-medium text-gray-900">{{ $product->stock_quantity ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Cost Price:</span>
                            <span
                                class="font-medium text-gray-900">৳{{ number_format($product->purchase_price ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Selling Price:</span>
                            <span
                                class="font-medium text-gray-900">৳{{ number_format($product->selling_price ?? 0, 2) }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Stock Value (at cost):</span>
                                <span class="text-lg font-bold text-blue-600">
                                    ৳{{ number_format(($product->stock_quantity ?? 0) * ($product->purchase_price ?? 0), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Card -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Product Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Product Code:</span>
                                <span class="text-sm text-gray-900">{{ $product->product_code }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Created:</span>
                                <span class="text-sm text-gray-900">{{ $product->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                                <span
                                    class="text-sm text-gray-900">{{ $product->updated_at->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Track Batch:</span>
                                <span class="text-sm">
                                    @if ($product->track_batch)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Yes</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">No</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Serial No:</span>
                                <span class="text-sm text-gray-900">{{ $product->serial_no ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Tax Rate:</span>
                                <span class="text-sm text-gray-900">{{ $product->tax_rate ?? 0 }}%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Track Expiry:</span>
                                <span class="text-sm">
                                    @if ($product->track_expiry)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Yes</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">No</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Status:</span>
                                <span class="text-sm">
                                    @if ($product->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Delete</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">Are you sure you want to delete product
                    <strong>{{ $product->product_name }}</strong>?</p>
                <p class="text-sm text-red-600 mb-4">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    This action cannot be undone. All associated inventory records will be deleted.
                </p>
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800">
                                <strong>Note:</strong> You cannot delete products that have inventory transactions.
                                Instead, you can set the status to "Inactive".
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </button>
                    <form action="{{ route('inventory.products.destroy', $product->id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Stock Modal -->
    <div id="updateStockModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Update Stock Quantity</h3>
            </div>
            <form action="{{ route('inventory.products.update-stock', $product->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <!-- Current Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Stock</label>
                        <input type="text" name="stock_quantity" value="{{ $product->stock_quantity }}" readonly
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                    </div>

                    <!-- Adjustment Type -->
                    <div>
                        <label for="adjustment_type" class="block text-sm font-medium text-gray-700 mb-1">
                            Adjustment Type <span class="text-red-500">*</span>
                        </label>
                        <select id="adjustment_type" name="adjustment_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="add">Add Stock</option>
                            <option value="subtract">Subtract Stock</option>
                            <option value="set">Set Stock to Specific Value</option>
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                            Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeUpdateStockModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Update Stock
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal Functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openUpdateStockModal() {
            document.getElementById('updateStockModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            initializeStockModal();
        }

        function closeUpdateStockModal() {
            document.getElementById('updateStockModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modals on background click
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.getElementById('updateStockModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeUpdateStockModal();
        });

        // Initialize stock modal
        function initializeStockModal() {
            const currentStock = {{ $product->stock_quantity ?? 0 }};
            const adjustmentType = document.getElementById('adjustment_type');
            const quantityInput = document.getElementById('quantity');

            if (adjustmentType && quantityInput) {
                adjustmentType.addEventListener('change', function() {
                    if (this.value === 'set') {
                        quantityInput.min = 0;
                        quantityInput.value = currentStock;
                    } else {
                        quantityInput.min = 1;
                        quantityInput.value = 1;
                    }
                });
            }
        }

        // Price validation
        document.addEventListener('DOMContentLoaded', function() {
            const purchasePrice = document.getElementById('purchase_price');
            const sellingPrice = document.getElementById('selling_price');
            const mrpInput = document.getElementById('mrp');

            function validatePrices() {
                const purchase = parseFloat(purchasePrice.value) || 0;
                const selling = parseFloat(sellingPrice.value) || 0;
                const mrp = parseFloat(mrpInput.value) || 0;

                // Validate selling price
                if (selling > 0 && purchase > 0 && selling < purchase) {
                    sellingPrice.classList.add('border-red-500');
                    showError(sellingPrice, 'Selling price should be higher than purchase price for profit.');
                } else {
                    sellingPrice.classList.remove('border-red-500');
                    removeError(sellingPrice);
                }

                // Validate MRP
                if (mrp > 0 && selling > 0 && mrp < selling) {
                    mrpInput.classList.add('border-red-500');
                    showError(mrpInput, 'MRP should be higher than or equal to selling price.');
                } else {
                    mrpInput.classList.remove('border-red-500');
                    removeError(mrpInput);
                }
            }

            function showError(input, message) {
                // Remove existing error
                removeError(input);

                // Add error message
                const errorDiv = document.createElement('p');
                errorDiv.className = 'mt-1 text-sm text-red-600';
                errorDiv.textContent = message;
                input.parentNode.appendChild(errorDiv);
            }

            function removeError(input) {
                const errorElement = input.parentNode.querySelector('.text-red-600');
                if (errorElement) {
                    errorElement.remove();
                }
            }

            if (purchasePrice && sellingPrice && mrpInput) {
                purchasePrice.addEventListener('blur', validatePrices);
                sellingPrice.addEventListener('blur', validatePrices);
                mrpInput.addEventListener('blur', validatePrices);
                validatePrices(); // Initial validation
            }

            // Form change detection
            let formChanged = false;
            const form = document.getElementById('productForm');

            if (form) {
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
            }
        });
    </script>
@endpush
