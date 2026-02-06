@extends('layouts.admin')

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
            <!-- Left Column - Product Images & Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Images Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Product Images</h2>
                    </div>
                    <div class="p-6">
                        @php
                            // Handle image display - check different possible image sources
                            $images = collect();

                            // Check if images is a relationship
                            if (
                                isset($product->images) &&
                                $product->images instanceof \Illuminate\Database\Eloquent\Collection
                            ) {
                                $images = $product->images;
                            } elseif (
                                isset($product->productImages) &&
                                $product->productImages instanceof \Illuminate\Database\Eloquent\Collection
                            ) {
                                $images = $product->productImages;
                            } elseif (isset($product->image) && is_string($product->image) && !empty($product->image)) {
                                // If there's a single image column in products table
                                $images = collect([(object) ['image_path' => $product->image]]);
                            }
                            $hasImages = $images->isNotEmpty();
                        @endphp

                        @if ($hasImages)
                            <!-- Main Image Display -->
                            <div class="mb-6">
                                <div class="relative w-full h-64 md:h-80 bg-gray-100 rounded-lg overflow-hidden">
                                    @if ($images->first())
                                        @php
                                            $firstImage = $images->first();
                                            $mainImageUrl = isset($firstImage->image_path) ? asset('storage/' . $firstImage->image_path) : (isset($firstImage->image) ? asset('storage/' . $firstImage->image) : '');
                                        @endphp
                                        <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $product->product_name }}"
                                            class="w-full h-full object-contain p-4">
                                    @endif
                                    <div class="absolute bottom-4 right-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-black/70 text-white">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $images->count() }} image{{ $images->count() > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnail Images -->
                            @if ($images->count() > 1)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-3">Other Images</h3>
                                    <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                                        @foreach ($images as $index => $image)
                                            @php
                                                $imageUrl = isset($image->image_path) ? asset('storage/' . $image->image_path) : (isset($image->image)
                                                        ? asset('storage/' . $image->image) : '');
                                            @endphp
                                            <button type="button" onclick="changeMainImage('{{ $imageUrl }}', this)"
                                                class="thumbnail-btn relative h-20 bg-gray-100 rounded-lg border-2 border-transparent hover:border-blue-500 overflow-hidden group {{ $index === 0 ? 'border-blue-500' : '' }}">
                                                <img src="{{ $imageUrl }}" alt="{{ $product->product_name }} - Image {{ $index + 1 }}"  class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors">
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <!-- No Images Placeholder -->
                            <div class="text-center py-12">
                                <div class="mx-auto h-32 w-32 text-gray-300 mb-4">
                                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No product images</h3>
                                <p class="text-gray-500 mb-4">Add images to showcase your product</p>
                                <a href="{{ route('inventory.products.edit', $product->id) }}#images"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Add Images
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

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
                                <span class="font-medium text-blue-600">৳{{ number_format($product->selling_price, 2) }}</span>
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

                            <!-- Manage Images -->
                            <a href="{{ route('inventory.products.edit', $product->id) }}#images"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-purple-300 text-purple-700 text-sm font-medium rounded-lg bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Manage Images
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
                    <strong>{{ $product->product_name }}</strong>?
                </p>
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

        // Image Gallery Functions
        function changeMainImage(imageUrl, clickedElement) {
            // Update main image
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = imageUrl;
            }

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-blue-500');
                btn.classList.add('border-transparent');
            });

            if (clickedElement) {
                clickedElement.classList.remove('border-transparent');
                clickedElement.classList.add('border-blue-500');
            }
        }

        // Image preview on hover (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.thumbnail-btn img');
            const mainImage = document.getElementById('mainImage');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('mouseenter', function() {
                    const tempSrc = mainImage.src;
                    mainImage.src = this.src;
                    mainImage.dataset.original = tempSrc;
                });

                thumbnail.addEventListener('mouseleave', function() {
                    if (mainImage.dataset.original) {
                        mainImage.src = mainImage.dataset.original;
                    }
                });
            });
        });

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

@push('styles')
    <style>
        /* Custom styles for image gallery */
        .thumbnail-btn {
            transition: all 0.2s ease-in-out;
        }

        .thumbnail-btn:hover {
            transform: scale(1.05);
        }

        .thumbnail-btn.active {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        /* Image loading animation */
        #mainImage {
            transition: opacity 0.3s ease;
        }

        #mainImage.loading {
            opacity: 0.5;
        }

        /* Responsive image gallery */
        @media (max-width: 640px) {
            .thumbnail-btn {
                height: 60px;
            }
        }
    </style>
@endpush
