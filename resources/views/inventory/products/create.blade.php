@extends('layouts.app')

@section('title', 'Create Product - Asia Enterprise')

@section('breadcrumb', 'Create Product')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create Product</h1>
            <p class="text-gray-600 mt-1">Add a new product to your inventory</p>
        </div>
        <div>
            <a href="{{ route('inventory.products.index') }}"
                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Product Information</h2>
            <p class="text-sm text-gray-600 mt-1">Fill in the product details below</p>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div>
                            <h4 class="font-medium">Please fix the following errors:</h4>
                            <ul class="mt-2 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('inventory.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Basic Information & Images -->
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Basic Information
                            </h3>

                            <!-- Product Code -->
                            <div class="mb-4">
                                <label for="product_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Product Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="product_code" name="product_code"
                                    value="{{ old('product_code', $productCode) }}" required readonly
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_code') border-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500">Auto-generated product code</p>
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
                                    value="{{ old('product_name') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_name') border-red-500 @enderror"
                                    placeholder="Enter product name">
                                @error('product_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                    placeholder="Product description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Images Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Product Images
                            </h3>

                            <div class="space-y-4">
                                <!-- Image Upload Area -->
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center transition-colors bg-gray-50 hover:bg-blue-50"
                                     id="dropArea">

                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">

                                    <div class="space-y-3">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>

                                        <div>
                                            <p class="text-sm font-medium text-gray-700">
                                                Drag & drop images here or click to browse
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Upload up to 10 images (JPEG, PNG, GIF, WebP)
                                            </p>
                                            <p class="text-xs text-gray-500">Max file size: 5MB each</p>
                                        </div>

                                        <button type="button"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Select Images
                                        </button>
                                    </div>
                                </div>

                                <!-- Image Previews -->
                                <div id="imagePreviewsContainer" class="hidden">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-medium text-gray-900">Selected Images</h4>
                                        <div class="flex items-center space-x-3">
                                            <span id="imageCount" class="text-xs text-gray-500">0 images</span>
                                            <button type="button"
                                                    onclick="clearAllImages()"
                                                    class="text-xs text-red-600 hover:text-red-800 font-medium">
                                                Clear All
                                            </button>
                                        </div>
                                    </div>

                                    <div id="imagePreviews" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                        <!-- Image previews will be dynamically added here -->
                                    </div>

                                    <div class="mt-4 flex items-center justify-between text-sm">
                                        <div class="text-gray-600">
                                            <span id="totalSize">0 KB</span> total
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <span id="imageCounter">0</span>/10 images
                                        </div>
                                    </div>
                                </div>

                                <!-- No Images Placeholder -->
                                <div id="noImagesPlaceholder" class="text-center py-4">
                                    <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-400 mt-2">No images selected yet</p>
                                </div>

                                <!-- Validation Errors -->
                                @error('images')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('images.*')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Pricing & Stock Information -->
                    <div class="space-y-6">
                        <!-- Pricing & Units -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Pricing & Units
                            </h3>

                            <!-- Unit of Measure & Tax Rate -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="unit_of_measure" class="block text-sm font-medium text-gray-700 mb-1">
                                        Unit of Measure <span class="text-red-500">*</span>
                                    </label>
                                    <select id="unit_of_measure" name="unit_of_measure" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('unit_of_measure') border-red-500 @enderror">
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
                                        <option value="CASE" {{ old('unit_of_measure') == 'CASE' ? 'selected' : '' }}>
                                            Case</option>
                                        <option value="PKT" {{ old('unit_of_measure') == 'PKT' ? 'selected' : '' }}>
                                            Packet</option>
                                    </select>
                                    @error('unit_of_measure')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-1">
                                        AIT Rate (%) <span class="text-red-500">*</span>
                                    </label>
                                    <select id="tax_rate" name="tax_rate" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tax_rate') border-red-500 @enderror">
                                        <option value="">-- Select Tax Rate --</option>
                                        <option value="0" {{ old('tax_rate') == 0 ? 'selected' : '' }}>0%
                                            (Exempt)</option>
                                        <option value="5" {{ old('tax_rate') == 5 ? 'selected' : '' }}>5%
                                        </option>
                                        <option value="12" {{ old('tax_rate') == 12 ? 'selected' : '' }}>12%
                                        </option>
                                        <option value="18" {{ old('tax_rate') == 18 ? 'selected' : '' }}>18%
                                        </option>
                                        <option value="28" {{ old('tax_rate') == 28 ? 'selected' : '' }}>28%
                                        </option>
                                    </select>
                                    @error('tax_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div>
                                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Purchase Price (BDT)
                                    </label>
                                    <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                                        value="{{ old('purchase_price') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purchase_price') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('purchase_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">
                                        Selling Price (BDT)
                                    </label>
                                    <input type="number" step="0.01" id="selling_price" name="selling_price"
                                        value="{{ old('selling_price') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('selling_price') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('selling_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="mrp" class="block text-sm font-medium text-gray-700 mb-1">
                                        MRP (BDT)
                                    </label>
                                    <input type="number" step="0.01" id="mrp" name="mrp"
                                        value="{{ old('mrp') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mrp') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('mrp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stock Management -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                Stock Management
                            </h3>

                            <!-- Stock Levels -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div>
                                    <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-1">
                                        Reorder Level <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="reorder_level" name="reorder_level"
                                        value="{{ old('reorder_level', 0) }}" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reorder_level') border-red-500 @enderror"
                                        placeholder="0">
                                    <p class="mt-1 text-xs text-gray-500">Minimum stock before reordering</p>
                                    @error('reorder_level')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="min_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                        Min Stock <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="min_stock" name="min_stock"
                                        value="{{ old('min_stock', 0) }}" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('min_stock') border-red-500 @enderror"
                                        placeholder="0">
                                    @error('min_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="max_stock" class="block text-sm font-medium text-gray-700 mb-1">
                                        Max Stock
                                    </label>
                                    <input type="number" id="max_stock" name="max_stock"
                                        value="{{ old('max_stock') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_stock') border-red-500 @enderror"
                                        placeholder="0">
                                    @error('max_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- HS Code -->
                            <div class="mb-6">
                                <label for="hs_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    HS Code
                                </label>
                                <input type="text" id="hs_code" name="hs_code" value="{{ old('hs_code') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('hs_code') border-red-500 @enderror"
                                    placeholder="Enter HS Code">
                                @error('hs_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tracking Options -->
                            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-4">
                                <h4 class="text-md font-medium text-gray-900 mb-4">Tracking Options</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="track_batch" name="track_batch"
                                                value="1" {{ old('track_batch') ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <div class="ml-2">
                                                <label for="track_batch"
                                                    class="text-sm font-medium text-gray-700 flex items-center">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-cyan-100 text-cyan-800 text-xs font-medium mr-2">B</span>
                                                    Track Batch Numbers
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" id="track_expiry" name="track_expiry"
                                                value="1" {{ old('track_expiry') ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <div class="ml-2">
                                                <label for="track_expiry"
                                                    class="text-sm font-medium text-gray-700 flex items-center">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-amber-100 text-amber-800 text-xs font-medium mr-2">E</span>
                                                    Track Expiry Dates
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" id="track_serial" name="track_serial"
                                                value="1" {{ old('track_serial') ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <div class="ml-2">
                                                <label for="track_serial"
                                                    class="text-sm font-medium text-gray-700 flex items-center">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-gray-200 text-gray-800 text-xs font-medium mr-2">S</span>
                                                    Track Serial Numbers
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <!-- Active Status -->
                                        <div class="flex items-center">
                                            <input type="checkbox" id="is_active" name="is_active"
                                                value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                                Active Product
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4">
                        <a href="{{ route('inventory.products.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Cancel
                        </a>

                        <button type="submit" name="save"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-base font-medium text-white rounded-lg shadow-sm hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Save Product
                        </button>

                        <button type="submit" name="save_and_new" value="1"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white rounded-lg shadow-sm hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Save & New
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .image-preview-container {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .image-preview-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .image-preview {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .image-remove-btn {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background-color: rgba(239, 68, 68, 0.9);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        border: none;
        outline: none;
    }

    .image-remove-btn:hover {
        background-color: rgb(220, 38, 38);
        transform: scale(1.1);
    }

    .image-order-badge {
        position: absolute;
        top: 0.25rem;
        left: 0.25rem;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background-color: rgba(59, 130, 246, 0.9);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .image-file-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        color: white;
        padding: 0.25rem 0.5rem;
        font-size: 0.65rem;
    }

    #dropArea.drag-over {
        border-color: #3b82f6;
        background-color: #eff6ff;
        border-style: solid;
    }

    .file-size {
        font-size: 0.7rem;
        color: #6b7280;
    }
</style>
@endpush

@push('scripts')
<script>
    // Image upload functionality
    let selectedImages = [];
    let totalSize = 0;
    const maxFiles = 10;
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    document.addEventListener('DOMContentLoaded', function() {
        initializeImageUpload();

        // Your existing auto-generate code, price calculation, etc.
        // ... (keep your existing JavaScript code here) ...
    });

    function initializeImageUpload() {
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('images');

        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('drag-over');
        }

        function unhighlight() {
            dropArea.classList.remove('drag-over');
        }

        // Handle drop
        dropArea.addEventListener('drop', handleDrop, false);

        // Handle click
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file input change
        fileInput.addEventListener('change', handleFileSelect);
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFileSelect(e) {
        const files = e.target.files;
        handleFiles(files);
        // Reset input to allow selecting same files again
        e.target.value = '';
    }

    function handleFiles(files) {
        const validFiles = Array.from(files).filter(file => {
            // Check file type
            if (!file.type.startsWith('image/')) {
                showToast(`"${file.name}" is not an image file.`, 'error');
                return false;
            }

            // Check file size
            if (file.size > maxFileSize) {
                showToast(`"${file.name}" exceeds 5MB size limit.`, 'error');
                return false;
            }

            // Check if file already exists
            if (selectedImages.some(img => img.name === file.name && img.size === file.size)) {
                showToast(`"${file.name}" is already selected.`, 'warning');
                return false;
            }

            // Check maximum files limit
            if (selectedImages.length >= maxFiles) {
                showToast(`Maximum ${maxFiles} images allowed.`, 'error');
                return false;
            }

            return true;
        });

        // Add valid files
        validFiles.forEach(file => {
            selectedImages.push(file);
            totalSize += file.size;
        });

        updateImagePreviews();

        if (validFiles.length > 0) {
            showToast(`Added ${validFiles.length} image(s)`, 'success');
        }
    }

    function updateImagePreviews() {
        const container = document.getElementById('imagePreviewsContainer');
        const previewsDiv = document.getElementById('imagePreviews');
        const noImagesPlaceholder = document.getElementById('noImagesPlaceholder');
        const imageCount = document.getElementById('imageCount');
        const totalSizeSpan = document.getElementById('totalSize');
        const imageCounter = document.getElementById('imageCounter');

        // Clear existing previews
        previewsDiv.innerHTML = '';

        // Create preview for each image
        selectedImages.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'image-preview-container';

                col.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}" class="image-preview">
                    <span class="image-order-badge">${index + 1}</span>
                    <button type="button" class="image-remove-btn" onclick="removeImage(${index})" title="Remove image">
                        ×
                    </button>
                    <div class="image-file-info">
                        <div class="truncate">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                `;

                previewsDiv.appendChild(col);
            };

            reader.readAsDataURL(file);
        });

        // Update counters
        const imageCountText = `${selectedImages.length} image${selectedImages.length !== 1 ? 's' : ''}`;
        imageCount.textContent = imageCountText;
        totalSizeSpan.textContent = formatFileSize(totalSize);
        imageCounter.textContent = selectedImages.length;

        // Show/hide elements
        if (selectedImages.length > 0) {
            container.classList.remove('hidden');
            noImagesPlaceholder.classList.add('hidden');
        } else {
            container.classList.add('hidden');
            noImagesPlaceholder.classList.remove('hidden');
        }
    }

    function removeImage(index) {
        totalSize -= selectedImages[index].size;
        selectedImages.splice(index, 1);
        updateImagePreviews();
        showToast('Image removed', 'info');
    }

    function clearAllImages() {
        if (selectedImages.length === 0) return;

        if (confirm('Are you sure you want to remove all images?')) {
            selectedImages = [];
            totalSize = 0;
            updateImagePreviews();
            showToast('All images cleared', 'info');
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.custom-toast').forEach(toast => toast.remove());

        const toast = document.createElement('div');
        toast.className = `custom-toast fixed bottom-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-600' :
            type === 'error' ? 'bg-red-600' :
            type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600'
        }`;
        toast.textContent = message;

        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        // Remove after 4 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    // Form validation before submit
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('productForm');

        form.addEventListener('submit', function(e) {
            // Update the file input with selected images
            const fileInput = document.getElementById('images');
            const dataTransfer = new DataTransfer();

            selectedImages.forEach(file => {
                dataTransfer.items.add(file);
            });

            fileInput.files = dataTransfer.files;

            // Optional: Validate at least one image is required
            // Uncomment if you want to make images mandatory
            if (selectedImages.length === 0) {
                e.preventDefault();
                showToast('Please upload at least one product image', 'error');
                document.getElementById('dropArea').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Add visual feedback
                const dropArea = document.getElementById('dropArea');
                dropArea.classList.add('border-red-500', 'bg-red-50');
                setTimeout(() => {
                    dropArea.classList.remove('border-red-500', 'bg-red-50');
                }, 2000);
            }
        });
    });
</script>
@endpush
