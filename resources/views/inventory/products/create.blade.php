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

                <form action="{{ route('inventory.products.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Basic Information -->
                        <div class="space-y-6">
                            <!-- Basic Information Header -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Basic
                                    Information</h3>

                                <!-- Product Code Section -->
                                <div class="mb-4">
                                    <label for="product_code" class="block text-sm font-medium text-gray-700 mb-1">
                                        Product Code <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center space-x-2">
                                        <input type="text" id="product_code" name="product_code"
                                            value="{{ old('product_code', $productCode) }}" required readonly
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_code') border-red-500 @enderror">
                                        <button type="button" onclick="regenerateProductCode()"
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                                            title="Generate new product code">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span class="ml-1 hidden sm:inline">Regenerate</span>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Auto-generated product code based on pattern:
                                        PROD-YYYYMM-0001</p>
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
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_name') border-red-500 @enderror"
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
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
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
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                        placeholder="Product description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- HS Code -->
                                <div class="mb-4">
                                    <label for="hs_code" class="block text-sm font-medium text-gray-700 mb-1">
                                        HS Code
                                    </label>
                                    <input type="text" id="hs_code" name="hs_code" value="{{ old('hs_code') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('hs_code') border-red-500 @enderror"
                                        placeholder="Enter HS Code">
                                    @error('hs_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Pricing & Stock Information -->
                        <div class="space-y-6">
                            <!-- Pricing & Units Header -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Pricing &
                                    Units</h3>

                                <!-- Unit of Measure & Tax Rate -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="unit_of_measure" class="block text-sm font-medium text-gray-700 mb-1">
                                            Unit of Measure <span class="text-red-500">*</span>
                                        </label>
                                        <select id="unit_of_measure" name="unit_of_measure" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('unit_of_measure') border-red-500 @enderror">
                                            <option value="">-- Select Unit --</option>
                                            <option value="PCS"
                                                {{ old('unit_of_measure') == 'PCS' ? 'selected' : '' }}>
                                                Pieces</option>
                                            <option value="KG" {{ old('unit_of_measure') == 'KG' ? 'selected' : '' }}>
                                                Kilogram</option>
                                            <option value="LTR"
                                                {{ old('unit_of_measure') == 'LTR' ? 'selected' : '' }}>
                                                Liter</option>
                                            <option value="MTR"
                                                {{ old('unit_of_measure') == 'MTR' ? 'selected' : '' }}>
                                                Meter</option>
                                            <option value="DOZ"
                                                {{ old('unit_of_measure') == 'DOZ' ? 'selected' : '' }}>
                                                Dozen</option>
                                            <option value="BOX"
                                                {{ old('unit_of_measure') == 'BOX' ? 'selected' : '' }}>Box</option>
                                            <option value="CASE"
                                                {{ old('unit_of_measure') == 'CASE' ? 'selected' : '' }}>Case</option>
                                            <option value="PKT"
                                                {{ old('unit_of_measure') == 'PKT' ? 'selected' : '' }}>Packet</option>
                                        </select>
                                        @error('unit_of_measure')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-1">
                                            GST Rate (%) <span class="text-red-500">*</span>
                                        </label>
                                        <select id="tax_rate" name="tax_rate" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tax_rate') border-red-500 @enderror">
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

                                <!-- Pricing Row -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div>
                                        <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                            Purchase Price (BDT)
                                        </label>
                                        <input type="number" step="0.01" id="purchase_price" name="purchase_price"
                                            value="{{ old('purchase_price') }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purchase_price') border-red-500 @enderror"
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
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('selling_price') border-red-500 @enderror"
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
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mrp') border-red-500 @enderror"
                                            placeholder="0.00">
                                        @error('mrp')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Stock Management Header -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Stock
                                        Management</h3>

                                    <!-- Stock Levels -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <label for="reorder_level"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Reorder Level <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" id="reorder_level" name="reorder_level"
                                                value="{{ old('reorder_level', 0) }}" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reorder_level') border-red-500 @enderror"
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
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('min_stock') border-red-500 @enderror"
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
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_stock') border-red-500 @enderror"
                                                placeholder="0">
                                            @error('max_stock')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Tracking Options Card -->
                                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-4">
                                        <h4 class="text-md font-medium text-gray-900 mb-4">Tracking Options</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Left Column - Tracking Options -->
                                            <div class="space-y-3">
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="track_batch" name="track_batch"
                                                        value="1" {{ old('track_batch') ? 'checked' : '' }}
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <div class="ml-2">
                                                        <label for="track_batch"
                                                            class="text-sm font-medium text-gray-700 flex items-center">
                                                            <span
                                                                class="inline-flex items-center justify-center w-6 h-6 rounded bg-cyan-100 text-cyan-800 text-xs font-medium mr-2">B</span>
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
                                                            <span
                                                                class="inline-flex items-center justify-center w-6 h-6 rounded bg-amber-100 text-amber-800 text-xs font-medium mr-2">E</span>
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
                                                            <span
                                                                class="inline-flex items-center justify-center w-6 h-6 rounded bg-gray-200 text-gray-800 text-xs font-medium mr-2">S</span>
                                                            Track Serial Numbers
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column - Stock Management & Status -->
                                            <div class="space-y-3">
                                                <!-- Stock Management Switches -->
                                                <div class="space-y-2 mb-4">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm font-medium text-gray-700">Manage Stock
                                                            Levels</span>
                                                        <input type="checkbox" id="manage_stock" name="manage_stock"
                                                            value="1"
                                                            {{ old('manage_stock', true) ? 'checked' : '' }}
                                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600">
                                                    </div>

                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm font-medium text-gray-700">Allow
                                                            Backorders</span>
                                                        <input type="checkbox" id="allow_backorder"
                                                            name="allow_backorder" value="1"
                                                            {{ old('allow_backorder') ? 'checked' : '' }}
                                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200">
                                                    </div>

                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm font-medium text-gray-700">Allow Negative
                                                            Stock</span>
                                                        <input type="checkbox" id="allow_negative" name="allow_negative"
                                                            value="1" {{ old('allow_negative') ? 'checked' : '' }}
                                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200">
                                                    </div>
                                                </div>

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

                                        <!-- Error messages for checkboxes -->
                                        <div class="mt-4 space-y-1">
                                            @error('track_batch')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            @error('track_expiry')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            @error('track_serial')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            @error('is_active')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
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

@push('scripts')
    <script>
        // Auto-generate product code from name
        document.addEventListener('DOMContentLoaded', function() {
            const productNameInput = document.getElementById('product_name');
            const productCodeInput = document.getElementById('product_code');

            if (productNameInput && productCodeInput) {
                productNameInput.addEventListener('blur', function() {
                    // Only generate code if code field is empty or only contains default value
                    if (productCodeInput.value.trim() === '' && productNameInput.value.trim() !== '') {
                        const productName = productNameInput.value.trim();
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

                        productCodeInput.value = code;
                    }
                });
            }

            // Auto-calculate selling price if purchase price entered
            const purchasePriceInput = document.getElementById('purchase_price');
            const sellingPriceInput = document.getElementById('selling_price');
            const mrpInput = document.getElementById('mrp');

            if (purchasePriceInput && sellingPriceInput && mrpInput) {
                purchasePriceInput.addEventListener('blur', function() {
                    const purchasePrice = parseFloat(this.value) || 0;

                    if (purchasePrice > 0 && (!sellingPriceInput.value || sellingPriceInput.value ===
                            '0')) {
                        // Add 20% margin
                        const sellingPrice = purchasePrice * 1.2;
                        sellingPriceInput.value = sellingPrice.toFixed(2);

                        // Set MRP as 30% above purchase price
                        if (!mrpInput.value || mrpInput.value === '0') {
                            mrpInput.value = (purchasePrice * 1.3).toFixed(2);
                        }
                    }
                });
            }

            // Toggle switches styling
            const switches = document.querySelectorAll('input[type="checkbox"][class*="inline-flex"]');
            switches.forEach(switchEl => {
                switchEl.addEventListener('change', function() {
                    if (this.checked) {
                        this.classList.remove('bg-gray-200');
                        this.classList.add('bg-blue-600');
                    } else {
                        this.classList.remove('bg-blue-600');
                        this.classList.add('bg-gray-200');
                    }
                });

                // Initialize switch colors
                if (switchEl.checked) {
                    switchEl.classList.add('bg-blue-600');
                } else {
                    switchEl.classList.add('bg-gray-200');
                }
            });

            // Validate price relationships
            function validatePrices() {
                const purchasePrice = parseFloat(purchasePriceInput?.value) || 0;
                const sellingPrice = parseFloat(sellingPriceInput?.value) || 0;
                const mrp = parseFloat(mrpInput?.value) || 0;

                if (purchasePrice > 0 && sellingPrice > 0 && sellingPrice < purchasePrice) {
                    sellingPriceInput.classList.add('border-red-500');
                    showError(sellingPriceInput, 'Selling price should be higher than purchase price.');
                } else {
                    sellingPriceInput.classList.remove('border-red-500');
                    removeError(sellingPriceInput);
                }

                if (mrp > 0 && sellingPrice > 0 && mrp < sellingPrice) {
                    mrpInput.classList.add('border-red-500');
                    showError(mrpInput, 'MRP should be higher than or equal to selling price.');
                } else {
                    mrpInput.classList.remove('border-red-500');
                    removeError(mrpInput);
                }
            }

            function showError(input, message) {
                removeError(input);
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

            if (purchasePriceInput && sellingPriceInput && mrpInput) {
                purchasePriceInput.addEventListener('blur', validatePrices);
                sellingPriceInput.addEventListener('blur', validatePrices);
                mrpInput.addEventListener('blur', validatePrices);
            }
        });

      // Define the function in global scope FIRST
    async function regenerateProductCode() {
        const productCodeInput = document.getElementById("product_code");
        const regenerateBtn = document.querySelector('[onclick="regenerateProductCode()"]');

        if (!productCodeInput) {
            console.error("Product code input not found");
            return;
        }

        // Show loading state
        const originalText = regenerateBtn.innerHTML;
        regenerateBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span class="ml-1 hidden sm:inline">Generating...</span>
        `;
        regenerateBtn.disabled = true;

        try {
            // Check if route exists
            const routeUrl = '{{ route('inventory.products.generate-code') }}';
            if (!routeUrl.includes('inventory.products.generate-code')) {
                // Fallback: Generate client-side code if route doesn't exist
                const timestamp = new Date().toISOString().slice(0, 10).replace(/-/g, '');
                const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
                productCodeInput.value = `PROD-${timestamp}-${random}`;
                showToast("New product code generated successfully!", "success");
                return;
            }

            const response = await fetch(routeUrl, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            });

            if (response.ok) {
                const data = await response.json();
                productCodeInput.value = data.product_code;
                showToast("New product code generated successfully!", "success");
            } else {
                throw new Error("Failed to generate product code");
            }
        } catch (error) {
            console.error("Error:", error);
            // Fallback to client-side generation
            const timestamp = new Date().toISOString().slice(0, 10).replace(/-/g, '');
            const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            productCodeInput.value = `PROD-${timestamp}-${random}`;
            showToast("Generated product code locally", "info");
        } finally {
            // Restore button state
            regenerateBtn.innerHTML = originalText;
            regenerateBtn.disabled = false;
        }
    }

    // Toast notification function
    function showToast(message, type = "info") {
        const toast = document.createElement("div");
        toast.className = `fixed bottom-4 right-4 max-w-xs w-full px-4 py-3 rounded-lg shadow-lg text-white ${
            type === "success" ? "bg-green-600" :
            type === "error" ? "bg-red-600" : "bg-blue-600"
        }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 4000);
    }

    // DOMContentLoaded events
    document.addEventListener('DOMContentLoaded', function() {
        
    });
    </script>
@endpush
