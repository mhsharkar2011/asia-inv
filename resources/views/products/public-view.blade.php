@extends('layouts.app') {{-- Changed from admin to app --}}

@section('title', $product->product_name . ' - Product Details - Asia Enterprise')

@section('content') {{-- Removed breadcrumb section --}}
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
                            In Stock
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Out of Stock
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ url('/') }}#featured-products" {{-- Changed to home page --}}
                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Products
                </a>

            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Product Images & Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Enhanced Product Images Card with Lightbox -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Product Images</h2>
                    </div>
                    <div class="p-6">
                        @php
                            // Handle image display
                            $images = collect();

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
                            }

                            $hasImages = $images->isNotEmpty();
                        @endphp

                        @if ($hasImages)
                            <!-- Main Large Image Display with Zoom -->
                            <div class="mb-6">
                                <div class="relative w-full h-96 bg-gray-100 rounded-lg overflow-hidden cursor-zoom-in"
                                    id="mainImageContainer">
                                    @if ($images->first())
                                        @php
                                            $firstImage = $images->first();
                                            $mainImageUrl = isset($firstImage->image_path)
                                                ? asset('storage/' . $firstImage->image_path)
                                                : (isset($firstImage->image)
                                                    ? asset('storage/' . $firstImage->image)
                                                    : '');
                                        @endphp
                                        <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $product->product_name }}"
                                            class="w-full h-full object-contain p-4 transition-transform duration-300">
                                    @endif

                                    <!-- Zoom Controls -->
                                    <div class="absolute bottom-4 right-4 flex space-x-2">
                                        <button type="button" onclick="zoomIn()"
                                            class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="zoomOut()"
                                            class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="resetZoom()"
                                            class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Image Counter -->
                                    <div class="absolute bottom-4 left-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-black/70 text-white">
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

                            <!-- Thumbnail Images Gallery -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">View All Images</h3>
                                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                                    @foreach ($images as $index => $image)
                                        @php
                                            $imageUrl = isset($image->image_path)
                                                ? asset('storage/' . $image->image_path)
                                                : (isset($image->image)
                                                    ? asset('storage/' . $image->image)
                                                    : '');
                                        @endphp
                                        <button type="button" onclick="changeMainImage('{{ $imageUrl }}', this)"
                                            class="thumbnail-btn relative h-20 bg-gray-100 rounded-lg border-2 border-transparent hover:border-blue-500 overflow-hidden group transition-all duration-200 {{ $index === 0 ? 'border-blue-500' : '' }}">
                                            <img src="{{ $imageUrl }}"
                                                alt="{{ $product->product_name }} - Image {{ $index + 1 }}"
                                                class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-110">
                                            <div
                                                class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors">
                                            </div>
                                            <div
                                                class="absolute top-1 right-1 w-5 h-5 rounded-full bg-blue-500 text-white text-xs flex items-center justify-center font-bold">
                                                {{ $index + 1 }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Lightbox Modal -->
                            <div id="lightboxModal"
                                class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center p-4">
                                <div class="relative w-full max-w-6xl">
                                    <button type="button" onclick="closeLightbox()"
                                        class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <img id="lightboxImage" src="" alt=""
                                        class="w-full max-h-[80vh] object-contain">

                                    <!-- Lightbox Navigation -->
                                    <div class="absolute top-1/2 left-4 transform -translate-y-1/2">
                                        <button type="button" onclick="prevLightboxImage()"
                                            class="p-3 bg-black/50 text-white rounded-full hover:bg-black/70 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="absolute top-1/2 right-4 transform -translate-y-1/2">
                                        <button type="button" onclick="nextLightboxImage()"
                                            class="p-3 bg-black/50 text-white rounded-full hover:bg-black/70 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Lightbox Image Counter -->
                                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-lg">
                                        <span id="lightboxCounter">1 / {{ $images->count() }}</span>
                                    </div>
                                </div>
                            </div>
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
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No product images available</h3>
                                <p class="text-gray-500">Images will be added soon</p>
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
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $product->product_code }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Product Name</h3>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->product_name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Category</h3>
                                    @if ($product->category)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mt-1">
                                            {{ $product->category->category_name }}
                                        </span>
                                    @else
                                        <p class="mt-1 text-gray-900">N/A</p>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                    <p class="mt-1 text-gray-900 leading-relaxed">
                                        {{ $product->description ?? 'No description available' }}</p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Unit of Measure</h3>
                                    <p class="mt-1 text-gray-900">{{ $product->unit_of_measure }}</p>
                                </div>
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
                                        @if ($product->is_active && $product->stock_quantity > 0)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Available
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Unavailable
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Stock & Availability</h2>
                    </div>
                    <div class="p-6">
                        <!-- Stock Stats Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <!-- Current Stock -->
                            <div
                                class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-4 text-center">
                                <div
                                    class="text-2xl md:text-3xl font-bold mb-2
                                {{ $product->stock_quantity <= 0 ? 'text-red-600' : ($product->stock_quantity <= $product->reorder_level ? 'text-amber-600' : 'text-green-600') }}">
                                    {{ $product->stock_quantity }}
                                </div>
                                <div class="text-sm font-medium text-blue-700">Available Stock</div>
                            </div>

                            <!-- Reorder Level -->
                            <div
                                class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border border-amber-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-amber-700 mb-2">
                                    {{ $product->reorder_level }}</div>
                                <div class="text-sm font-medium text-amber-700">Reorder Level</div>
                            </div>

                            <!-- Minimum Stock -->
                            <div
                                class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-orange-700 mb-2">{{ $product->min_stock }}
                                </div>
                                <div class="text-sm font-medium text-orange-700">Minimum Stock</div>
                            </div>

                            <!-- Maximum Stock -->
                            <div
                                class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl border border-cyan-200 p-4 text-center">
                                <div class="text-2xl md:text-3xl font-bold text-cyan-700 mb-2">
                                    {{ $product->max_stock ?? 'N/A' }}</div>
                                <div class="text-sm font-medium text-cyan-700">Maximum Stock</div>
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
                                    $statusIcon =
                                        'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z';
                                } elseif ($product->stock_quantity <= $product->reorder_level) {
                                    $progressClass = 'bg-amber-500';
                                    $statusText = 'Low Stock';
                                    $statusColor = 'text-amber-600';
                                    $statusIcon =
                                        'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z';
                                } else {
                                    $progressClass = 'bg-green-600';
                                    $statusText = 'In Stock';
                                    $statusColor = 'text-green-600';
                                    $statusIcon = 'M5 13l4 4L19 7';
                                }
                            @endphp

                            <div class="mb-2 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Stock Level</span>
                                <span class="text-sm font-medium text-gray-900">{{ $product->stock_quantity }} /
                                    {{ $maxStock }} units</span>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden mb-4">
                                <div class="{{ $progressClass }} h-full rounded-full transition-all duration-500 ease-out"
                                    style="width: {{ $stockPercent }}%"></div>
                            </div>

                            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg">
                                <svg class="w-6 h-6 {{ $statusColor }} mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $statusIcon }}" />
                                </svg>
                                <div>
                                    <span class="text-lg font-bold {{ $statusColor }}">{{ $statusText }}</span>
                                    @if ($product->stock_quantity <= $product->reorder_level && $product->stock_quantity > 0)
                                        <p class="text-sm text-gray-600 mt-1">Consider restocking soon</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Pricing & Actions -->
            <div class="space-y-6">
                <!-- Pricing Information Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Pricing</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Purchase Price -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Cost Price</span>
                                <span
                                    class="font-medium text-gray-900">৳{{ number_format($product->purchase_price, 2) }}</span>
                            </div>

                            <!-- Selling Price -->
                            <div class="flex justify-between items-center pt-3 pb-3 border-t border-gray-100">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Your Price</span>
                                    <p class="text-xs text-gray-500">Including all taxes</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="text-2xl md:text-3xl font-bold text-blue-600">৳{{ number_format($product->selling_price, 2) }}</span>
                                    @if ($product->mrp && $product->mrp > $product->selling_price)
                                        <p class="text-sm text-gray-400 line-through">MRP:
                                            ৳{{ number_format($product->mrp, 2) }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Discount Badge -->
                            @if ($product->mrp && $product->mrp > $product->selling_price)
                                <div
                                    class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-green-800">You Save</span>
                                        <span class="text-lg font-bold text-green-700">
                                            ৳{{ number_format($product->mrp - $product->selling_price, 2) }}
                                            <span class="text-sm font-medium">
                                                ({{ number_format((($product->mrp - $product->selling_price) / $product->mrp) * 100, 0) }}%
                                                off)
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            @endif

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
                                <span class="text-sm font-medium text-gray-700">Total Stock Value</span>
                                <span class="font-bold text-cyan-600">
                                    ৳{{ number_format($product->stock_quantity * $product->selling_price, 2) }}
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
                            <!-- Contact for Purchase -->
                            <button type="button" onclick="contactForPurchase()"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact for Purchase
                            </button>

                            <!-- Request Quote -->
                            <button type="button" onclick="requestQuote()"
                                class="w-full inline-flex items-center justify-center px-4 py-3 border-2 border-blue-600 text-blue-600 text-sm font-semibold rounded-lg bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Request Quote
                            </button>

                            <!-- Share Product -->
                            <button type="button" onclick="shareProduct()"
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Share Product
                            </button>

                            <!-- Download Specs -->
                            <button type="button" onclick="downloadSpecs()"
                                class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Specifications
                            </button>


                        </div>
                    </div>
                </div>

                <!-- Additional Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Additional Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Product Created</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $product->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Last Updated</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $product->updated_at->format('d M, Y h:i A') }}</span>
                            </div>
                            @if ($product->track_batch)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Batch Tracking Enabled
                                </div>
                            @endif
                            @if ($product->track_expiry)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Expiry Date Tracking
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        // Image Gallery Functions
        let currentImageIndex = 0;
        let imageUrls = @json(
            $hasImages
                ? $images->map(function ($image) {
                    return isset($image->image_path)
                        ? asset('storage/' . $image->image_path)
                        : (isset($image->image)
                            ? asset('storage/' . $image->image)
                            : '');
                })
                : []
        );

        function changeMainImage(imageUrl, clickedElement) {
            // Update main image
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.src = imageUrl;
            }

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-blue-500', 'border-2');
                btn.classList.add('border-transparent');
            });

            if (clickedElement) {
                clickedElement.classList.remove('border-transparent');
                clickedElement.classList.add('border-blue-500', 'border-2');

                // Update current image index
                const thumbnails = Array.from(document.querySelectorAll('.thumbnail-btn'));
                currentImageIndex = thumbnails.indexOf(clickedElement);
            }
        }

        // Image Zoom Functions
        let currentScale = 1;
        const maxScale = 3;
        const minScale = 1;
        const scaleStep = 0.2;

        function zoomIn() {
            if (currentScale < maxScale) {
                currentScale += scaleStep;
                updateImageScale();
            }
        }

        function zoomOut() {
            if (currentScale > minScale) {
                currentScale -= scaleStep;
                updateImageScale();
            }
        }

        function resetZoom() {
            currentScale = 1;
            updateImageScale();
        }

        function updateImageScale() {
            const mainImage = document.getElementById('mainImage');
            if (mainImage) {
                mainImage.style.transform = `scale(${currentScale})`;
                mainImage.style.transformOrigin = 'center';
            }
        }

        // Lightbox Functions
        function openLightbox(imageIndex = currentImageIndex) {
            currentImageIndex = imageIndex;
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxCounter = document.getElementById('lightboxCounter');

            if (lightboxModal && lightboxImage && imageUrls.length > 0) {
                lightboxImage.src = imageUrls[currentImageIndex];
                lightboxCounter.textContent = `${currentImageIndex + 1} / ${imageUrls.length}`;
                lightboxModal.classList.remove('hidden');
                lightboxModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeLightbox() {
            const lightboxModal = document.getElementById('lightboxModal');
            if (lightboxModal) {
                lightboxModal.classList.add('hidden');
                lightboxModal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        function prevLightboxImage() {
            if (imageUrls.length > 0) {
                currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length;
                updateLightbox();
            }
        }

        function nextLightboxImage() {
            if (imageUrls.length > 0) {
                currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
                updateLightbox();
            }
        }

        function updateLightbox() {
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxCounter = document.getElementById('lightboxCounter');

            if (lightboxImage && lightboxCounter) {
                lightboxImage.src = imageUrls[currentImageIndex];
                lightboxCounter.textContent = `${currentImageIndex + 1} / ${imageUrls.length}`;
            }
        }

        // Make main image clickable for lightbox
        document.addEventListener('DOMContentLoaded', function() {
            const mainImageContainer = document.getElementById('mainImageContainer');
            if (mainImageContainer) {
                mainImageContainer.addEventListener('click', function() {
                    openLightbox(currentImageIndex);
                });
            }

            // Keyboard navigation for lightbox
            document.addEventListener('keydown', function(e) {
                const lightboxModal = document.getElementById('lightboxModal');
                if (!lightboxModal.classList.contains('hidden')) {
                    switch (e.key) {
                        case 'Escape':
                            closeLightbox();
                            break;
                        case 'ArrowLeft':
                            prevLightboxImage();
                            break;
                        case 'ArrowRight':
                            nextLightboxImage();
                            break;
                    }
                }
            });

            // Click outside lightbox to close
            document.getElementById('lightboxModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLightbox();
                }
            });
        });

        // Action Button Functions
        function contactForPurchase() {
            alert('Contact our sales team at sales@asiaenterprise.com or call +880 XXXX XXXXXX');
        }

        function requestQuote() {
            alert('Quote request submitted! Our team will contact you shortly.');
        }

        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product->product_name }}',
                    text: 'Check out this product from Asia Enterprise',
                    url: window.location.href,
                });
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Product link copied to clipboard!');
                });
            }
        }

        function downloadSpecs() {
            alert('Product specifications PDF will be downloaded shortly.');
            // In a real app, you would trigger a file download here
        }

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
            transition: transform 0.3s ease;
        }

        #mainImage.loading {
            opacity: 0.5;
        }

        /* Lightbox styles */
        #lightboxModal {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive image gallery */
        @media (max-width: 640px) {
            .thumbnail-btn {
                height: 60px;
            }

            #mainImageContainer {
                height: 300px;
            }
        }

        @media (max-width: 768px) {
            #mainImageContainer {
                height: 350px;
            }
        }

        /* Smooth transitions */
        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Price card hover effect */
        .shadow-lg {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .shadow-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush
