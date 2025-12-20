@extends('layouts.app')

@section('title', $product->product_name . ' - Product Details - Asia Enterprise')

@section('breadcrumb', 'Product Details')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->product_name }}</h1>
                <div class="flex items-center mt-2 space-x-4">
                    <span class="text-gray-600">Code: {{ $product->product_code }}</span>
                    @if ($product->is_active)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Inactive
                        </span>
                    @endif
                </div>
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
                <a href="{{ route('inventory.products.edit', $product->id) }}"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <button type="button" onclick="openDeleteModal()"
                    class="inline-flex items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Product Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Product Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Product Code</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->product_code }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Product Name</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->product_name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Category</h3>
                                    @if ($product->category)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 mt-1">
                                            {{ $product->category->category_name }}
                                        </span>
                                    @else
                                        <p class="mt-1 text-gray-900">N/A</p>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->description ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Unit of Measure</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->unit_of_measure }}</p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">HSN/SAC Code</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->hsn_sac_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Tax Rate</h3>
                                    <div class="flex items-center mt-1">
                                        <span class="text-gray-900">{{ $product->tax_rate }}%</span>
                                        <span
                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            GST
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                                    <div class="mt-1">
                                        @if ($product->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Created</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->created_at->format('d M, Y') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->updated_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Stock Information</h2>
                    </div>
                    <div class="p-6">
                        <!-- Stock Stats Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <!-- Current Stock -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 text-center">
                                <div
                                    class="text-2xl md:text-3xl font-bold mb-2
                                {{ $product->stock_quantity <= 0 ? 'text-red-600' : ($product->stock_quantity <= $product->reorder_level ? 'text-amber-600' : 'text-green-600') }}">
                                    {{ $product->stock_quantity }}
                                </div>
                                <div class="text-sm text-gray-500">Current Stock</div>
                            </div>

                            <!-- Reorder Level -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-amber-600 mb-2">
                                    {{ $product->reorder_level }}</div>
                                <div class="text-sm text-gray-500">Reorder Level</div>
                            </div>

                            <!-- Minimum Stock -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-2">{{ $product->min_stock }}
                                </div>
                                <div class="text-sm text-gray-500">Minimum Stock</div>
                            </div>

                            <!-- Maximum Stock -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-blue-600 mb-2">
                                    {{ $product->max_stock ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">Maximum Stock</div>
                            </div>
                        </div>

                        <!-- Stock Progress Bar -->
                        <div>
                            @php
                                $maxStock = $product->max_stock ?? $product->reorder_level * 3;
                                $stockPercent =
                                    $maxStock > 0 ? min(100, ($product->stock_quantity / $maxStock) * 100) : 0;

                                if ($product->stock_quantity <= 0) {
                                    $progressClass = 'bg-red-600';
                                    $statusText = 'Out of Stock';
                                    $statusColor = 'text-red-600';
                                } elseif ($product->stock_quantity <= $product->reorder_level) {
                                    $progressClass = 'bg-amber-500';
                                    $statusText = 'Low Stock - Reorder Now';
                                    $statusColor = 'text-amber-600';
                                } else {
                                    $progressClass = 'bg-green-600';
                                    $statusText = 'Stock Level OK';
                                    $statusColor = 'text-green-600';
                                }
                            @endphp

                            <div class="mb-2 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Stock Level</span>
                                <span class="text-sm font-medium text-gray-900">{{ $product->stock_quantity }} /
                                    {{ $maxStock }}</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="{{ $progressClass }} h-full rounded-full transition-all duration-500 ease-out"
                                    style="width: {{ $stockPercent }}%"></div>
                            </div>

                            <div class="mt-3 flex items-center justify-center">
                                @if ($product->stock_quantity <= 0)
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @elseif($product->stock_quantity <= $product->reorder_level)
                                    <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @endif
                                <span class="text-sm font-medium {{ $statusColor }}">{{ $statusText }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Information -->
                @if ($product->track_batch || $product->track_expiry)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Tracking Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($product->track_batch)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">Batch Tracking</h3>
                                            <p class="mt-1 text-sm text-gray-500">This product tracks batch numbers for
                                                better inventory management.</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->track_expiry)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">Expiry Tracking</h3>
                                            <p class="mt-1 text-sm text-gray-500">This product tracks expiry dates to
                                                prevent selling expired items.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Pricing & Actions -->
            <div class="space-y-6">
                <!-- Pricing Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Pricing Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Purchase Price -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Purchase Price</span>
                                <span
                                    class="font-medium text-gray-900">৳{{ number_format($product->purchase_price, 2) }}</span>
                            </div>

                            <!-- Selling Price -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Selling Price</span>
                                <span
                                    class="font-medium text-blue-600">৳{{ number_format($product->selling_price, 2) }}</span>
                            </div>

                            <!-- MRP -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">MRP</span>
                                <span class="font-medium text-gray-900">৳{{ number_format($product->mrp, 2) }}</span>
                            </div>

                            <!-- Profit Margin -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-sm font-medium text-gray-700">Profit Margin</span>
                                <span class="font-medium text-green-600">
                                    @if ($product->purchase_price > 0)
                                        {{ number_format((($product->selling_price - $product->purchase_price) / $product->purchase_price) * 100, 2) }}%
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>

                            <!-- Stock Value -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-sm font-medium text-gray-700">Stock Value (at cost)</span>
                                <span class="font-bold text-cyan-600">
                                    ৳{{ number_format($product->stock_quantity * $product->purchase_price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Edit Product -->
                            <a href="{{ route('inventory.products.edit', $product->id) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Product
                            </a>

                            <!-- Update Stock -->
                            <button type="button" onclick="openUpdateStockModal()"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Update Stock
                            </button>

                            <!-- Create Purchase Order -->
                            <a href="#"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Purchase Order
                            </a>

                            <!-- Toggle Status -->
                            <form action="{{ route('inventory.products.toggle-status', $product->id) }}" method="POST"
                                class="w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border
                                           {{ $product->is_active ? 'border-amber-300 text-amber-700 hover:bg-amber-50 focus:ring-amber-500' : 'border-green-300 text-green-700 hover:bg-green-50 focus:ring-green-500' }}
                                           text-sm font-medium rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                                    @if ($product->is_active)
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Deactivate Product
                                    @else
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Activate Product
                                    @endif
                                </button>
                            </form>
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
                <p class="text-sm text-red-600 mb-6">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    This action cannot be undone.
                </p>
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
                        <input type="text" value="{{ $product->stock_quantity }}" readonly
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


                    <!-- resources/views/products/show.blade.php -->
<!-- Display images in product show page -->
@if($product->images->count() > 0)
    <div class="row">
        <!-- Main Image (First image) -->
        <div class="col-md-12 mb-4">
            <div class="text-center">
                <img src="{{ $product->getFirstMediaUrl('products') }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded"
                     style="max-height: 400px;">
                <p class="text-muted mt-2">Featured Image</p>
            </div>
        </div>

        <!-- Additional Images -->
        @if($product->images->count() > 1)
            <h5 class="mt-4 mb-3">Additional Images</h5>
            <div class="row">
                @foreach($product->images as $index => $image)
                    @if($index > 0)
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card">
                                <img src="{{ $image->getUrl() }}"
                                     alt="Product Image {{ $index + 1 }}"
                                     class="card-img-top"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body text-center p-2">
                                    <small class="text-muted">Image {{ $index + 1 }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="alert alert-info">
        No images uploaded for this product.
    </div>
@endif
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


@if($mediaItems && $mediaItems->count() > 0)
    <div class="row">
        <!-- Main Image (First image) -->
        <div class="col-md-12 mb-4">
            <div class="text-center">
                <img src="{{ $product->getFirstMediaUrl('products') }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded"
                     style="max-height: 400px;">
                <p class="text-muted mt-2">Featured Image</p>
            </div>
        </div>

        <!-- Additional Images -->
        @if($mediaItems->count() > 1)
            <h5 class="mt-4 mb-3">Additional Images</h5>
            <div class="row">
                @foreach($mediaItems as $index => $image)
                    @if($index > 0)
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card">
                                <img src="{{ $image->getUrl() }}"
                                     alt="Product Image {{ $index + 1 }}"
                                     class="card-img-top"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body text-center p-2">
                                    <small class="text-muted">Image {{ $index + 1 }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="alert alert-info">
        No images uploaded for this product.
    </div>
@endif
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

                // Initialize with default values
                adjustmentType.dispatchEvent(new Event('change'));
            }
        }

        // Calculate profit margin
        document.addEventListener('DOMContentLoaded', function() {
            const profitMargin = document.querySelector('[class*="text-green-600"]:last-child');
            if (profitMargin) {
                console.log('Profit margin calculated:', profitMargin.textContent);
            }
        });
    </script>
@endpush
