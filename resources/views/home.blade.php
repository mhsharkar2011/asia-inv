@extends('layouts.app')

@section('title', 'Home - Asia Enterprise')

@section('content')
    <!-- Hero Section with Modern Gradient -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#f0f9ff_1px,transparent_1px),linear-gradient(to_bottom,#f0f9ff_1px,transparent_1px)] bg-[size:4rem_4rem] opacity-20">
        </div>

        <!-- Animated Circles -->
        <div
            class="absolute top-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div
            class="absolute bottom-10 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse animation-delay-4000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center">
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-6 animate-fade-in-up">
                    <svg class="w-4 h-4 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Premium Quality Products
                </span>

                <h1
                    class="text-5xl sm:text-6xl md:text-7xl font-bold text-gray-900 tracking-tight mb-6 animate-fade-in-up animation-delay-200">
                    Your One-Stop
                    <span
                        class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 animate-gradient">
                        Business Solution
                    </span>
                </h1>

                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10 animate-fade-in-up animation-delay-400">
                    Streamline your operations with our comprehensive inventory management system.
                    From procurement to sales, we've got you covered.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-600">
                    <a href="#featured-products"
                        class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition-all duration-300 hover:from-blue-700 hover:to-indigo-700">
                        <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Explore Products
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-blue-600 bg-white border-2 border-blue-200 rounded-xl shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transform transition-all duration-300">
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Dashboard Access
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div id="categories" class="relative bg-white py-20">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/50 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4 animate-fade-in-up">Browse by Category</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Organized inventory for efficient management</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach ([['name' => 'Electronics', 'icon' => '💻', 'count' => 45, 'color' => 'blue', 'bg' => 'from-blue-500 to-blue-600'], ['name' => 'Clothing', 'icon' => '👕', 'count' => 78, 'color' => 'purple', 'bg' => 'from-purple-500 to-purple-600'], ['name' => 'Home & Living', 'icon' => '🏠', 'count' => 32, 'color' => 'green', 'bg' => 'from-emerald-500 to-emerald-600'], ['name' => 'Office Supplies', 'icon' => '📎', 'count' => 56, 'color' => 'amber', 'bg' => 'from-amber-500 to-amber-600']] as $category)
                    <a href="{{ route('inventory.products.index') }}?category={{ $category['name'] }}"
                        class="group relative bg-white p-6 rounded-2xl border border-gray-200 hover:border-transparent hover:shadow-2xl hover:-translate-y-2 transform transition-all duration-300 overflow-hidden">
                        <!-- Gradient Background -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br {{ $category['bg'] }} opacity-0 group-hover:opacity-5 transition-opacity duration-300">
                        </div>

                        <!-- Floating Icon -->
                        <div
                            class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-{{ $category['color'] }}-50 group-hover:bg-{{ $category['color'] }}-100 transition-colors duration-300 flex items-center justify-center opacity-10 group-hover:opacity-20">
                            <span class="text-4xl">{{ $category['icon'] }}</span>
                        </div>

                        <!-- Content -->
                        <div class="relative">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-14 w-14 rounded-xl bg-gradient-to-br {{ $category['bg'] }} flex items-center justify-center shadow-lg group-hover:scale-110 transform transition-transform duration-300">
                                    <span class="text-2xl">{{ $category['icon'] }}</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $category['name'] }}</h3>
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm font-medium text-gray-600">{{ $category['count'] }}
                                            items</span>
                                        <span class="mx-2 text-gray-300">•</span>
                                        <span
                                            class="text-xs px-2 py-1 rounded-full bg-{{ $category['color'] }}-100 text-{{ $category['color'] }}-800 font-medium">
                                            Active
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-between">
                                <span class="text-sm text-gray-500">View inventory</span>
                                <div
                                    class="h-10 w-10 rounded-full bg-gray-100 group-hover:bg-{{ $category['color'] }}-100 flex items-center justify-center transform group-hover:translate-x-2 transition-all duration-300">
                                    <svg class="w-5 h-5 text-gray-600 group-hover:text-{{ $category['color'] }}-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div id="featured-products" class="bg-gradient-to-b from-white to-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Stats -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-3">Featured Products</h2>
                    <p class="text-lg text-gray-600">Premium selection for your business needs</p>
                </div>

                <!-- Quick Stats -->
                <div class="flex items-center space-x-6 mt-6 lg:mt-0">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $products->total() ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Total Items</div>
                    </div>
                    <div class="h-12 w-px bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $activeProducts ?? 0 }}</div>
                        <div class="text-sm text-gray-500">In Stock</div>
                    </div>
                    <div class="h-12 w-px bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-amber-600">{{ $lowStockCount ?? 8 }}</div>
                        <div class="text-sm text-gray-500">Low Stock</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-3 mb-8">
                <button data-filter="all"
                    class="filter-btn active px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    All Products
                </button>
                <button data-filter="in-stock"
                    class="filter-btn px-5 py-2.5 rounded-xl bg-white text-gray-700 border border-gray-200 hover:border-blue-300 text-sm font-medium hover:shadow-md hover:bg-blue-50 transition-all duration-200">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        In Stock
                    </span>
                </button>
                <button data-filter="low-stock"
                    class="filter-btn px-5 py-2.5 rounded-xl bg-white text-gray-700 border border-gray-200 hover:border-amber-300 text-sm font-medium hover:shadow-md hover:bg-amber-50 transition-all duration-200">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>
                        Low Stock
                    </span>
                </button>
                <button data-filter="out-stock"
                    class="filter-btn px-5 py-2.5 rounded-xl bg-white text-gray-700 border border-gray-200 hover:border-red-300 text-sm font-medium hover:shadow-md hover:bg-red-50 transition-all duration-200">
                    <span class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                        Out of Stock
                    </span>
                </button>
                <button data-filter="new"
                    class="filter-btn px-5 py-2.5 rounded-xl bg-white text-gray-700 border border-gray-200 hover:border-purple-300 text-sm font-medium hover:shadow-md hover:bg-purple-50 transition-all duration-200">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        New Arrivals
                    </span>
                </button>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    @php
                        $totalStock = $product->inventories->sum('quantity_available');
                        $isLowStock = $totalStock <= ($product->reorder_level ?? 10) && $totalStock > 0;
                        $isOutOfStock = $totalStock <= 0;
                        $isInStock = $totalStock > ($product->reorder_level ?? 10);

                        // Stock status badge styling
                        $statusConfig = [
                            'in-stock' => [
                                'text' => 'In Stock',
                                'color' => 'green',
                                'bg' => 'bg-green-100',
                                'textColor' => 'text-green-800',
                            ],
                            'low-stock' => [
                                'text' => 'Low Stock',
                                'color' => 'amber',
                                'bg' => 'bg-amber-100',
                                'textColor' => 'text-amber-800',
                            ],
                            'out-stock' => [
                                'text' => 'Out of Stock',
                                'color' => 'red',
                                'bg' => 'bg-red-100',
                                'textColor' => 'text-red-800',
                            ],
                        ];

                        $status = $isOutOfStock ? 'out-stock' : ($isLowStock ? 'low-stock' : 'in-stock');
                        $statusInfo = $statusConfig[$status];

                        // Stock percentage for progress bar
                        $maxStock = max($product->reorder_level * 3 ?? 30, $totalStock);
                        $stockPercentage = $totalStock > 0 ? min(100, ($totalStock / $maxStock) * 100) : 0;

                        // Get first product image or use placeholder
                        $productImage = $product->productImages->where('is_primary', true)->first() ?? $product->productImages->first();
                        $imageUrl = $productImage ? asset('storage/' . $productImage->image_path) : null;
                    @endphp

                    <div class="product-card group bg-white rounded-2xl border border-gray-200 hover:border-blue-300 overflow-hidden hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
                        data-status="{{ $status }}" data-stock="{{ $totalStock }}"
                        data-new="{{ $product->created_at->gt(now()->subDays(7)) ? 'true' : 'false' }}">

                        <!-- Product Image Area -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusInfo['bg'] }} {{ $statusInfo['textColor'] }} shadow-sm">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-{{ $statusInfo['color'] }}-500 mr-1.5"></span>
                                    {{ $statusInfo['text'] }}
                                </span>
                            </div>

                            <!-- New Badge -->
                            @if ($product->created_at->gt(now()->subDays(7)))
                                <div class="absolute top-4 right-4 z-20">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-100 to-purple-50 text-purple-800 border border-purple-200 shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        New
                                    </span>
                                </div>
                            @endif

                            <!-- Product Image -->
                            <div class="relative w-full h-full">
                                @if ($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $product->product_name }}" loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <!-- Fallback with category icon -->
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-gradient-to-br
                                        @switch($product->category->category_name ?? 'General')
                                            @case('Electronics') from-blue-100 to-cyan-100 @break
                                            @case('Clothing') from-purple-100 to-pink-100 @break
                                            @case('Home & Living') from-emerald-100 to-teal-100 @break
                                            @case('Office Supplies') from-amber-100 to-orange-100 @break
                                            @default from-gray-100 to-gray-200
                                        @endswitch">
                                        <div class="text-center">
                                            <div class="text-5xl mb-2">
                                                @switch($product->category->category_name ?? 'General')
                                                    @case('Electronics')
                                                        💻
                                                    @break

                                                    @case('Clothing')
                                                        👕
                                                    @break

                                                    @case('Home & Living')
                                                        🏠
                                                    @break

                                                    @case('Office Supplies')
                                                        📎
                                                    @break

                                                    @default
                                                        📦
                                                @endswitch
                                            </div>
                                            <div class="text-sm font-medium text-gray-600">{{ $product->product_name }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Image Count Badge (if multiple images) -->
                                @if ($product->productImages->count() > 1)
                                    <div class="absolute bottom-4 right-4 z-20">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-black/70 text-white">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $product->productImages->count() }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <!-- Product Name & Category -->
                            <div class="mb-4">
                                <h3
                                    class="text-lg font-bold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                    {{ $product->product_name }}
                                </h3>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    <span
                                        class="text-sm text-gray-500">{{ $product->category->category_name ?? 'Uncategorized' }}</span>
                                </div>
                            </div>

                            <!-- Stock Information -->
                            <div class="mb-5">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Stock Level</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $totalStock }} units</span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r
                                    @if ($status == 'in-stock') from-green-400 to-green-500
                                    @elseif($status == 'low-stock') from-amber-400 to-amber-500
                                    @else from-red-400 to-red-500 @endif
                                    rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $stockPercentage }}%">
                                    </div>
                                </div>

                                <!-- Stock Indicator Dots -->
                                <div class="flex justify-between mt-1">
                                    <span class="text-xs text-gray-400">Min</span>
                                    @if ($product->reorder_level)
                                        <span class="text-xs text-amber-600 font-medium">Reorder:
                                            {{ $product->reorder_level }}</span>
                                    @endif
                                    <span class="text-xs text-gray-400">Max</span>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="mb-5">
                                <div class="flex items-baseline justify-between">
                                    <div>
                                        <span
                                            class="text-2xl font-bold text-gray-900">৳{{ number_format($product->selling_price, 2) }}</span>
                                        @if ($product->mrp && $product->mrp > $product->selling_price)
                                            <span
                                                class="ml-2 text-sm text-gray-400 line-through">৳{{ number_format($product->mrp, 2) }}</span>
                                            <span
                                                class="ml-2 text-xs font-semibold text-green-600 bg-green-100 px-1.5 py-0.5 rounded">
                                                -{{ number_format((($product->mrp - $product->selling_price) / $product->mrp) * 100, 0) }}%
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">SKU</div>
                                        <div class="text-sm font-mono font-semibold text-gray-700">
                                            {{ $product->product_code }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('home.products.show', $product->id) }}"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 group/view transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2 text-gray-400 group-hover/view:text-blue-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Details
                                </a>

                                @if ($product->is_active && $totalStock > 0)
                                    <button onclick="quickAddToStock({{ $product->id }})"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 group/add">
                                        <svg class="w-4 h-4 mr-2 group-hover/add:rotate-12 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="mx-auto h-32 w-32 text-gray-300 mb-6">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No products available</h3>
                            <p class="text-gray-600 mb-8">Start adding products to your inventory</p>
                            <a href="{{ route('inventory.products.create') }}"
                                class="inline-flex items-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Product
                            </a>
                        </div>
                    @endforelse
                </div>

                @if ($products->hasPages())
                    <div class="mt-12 flex justify-center">
                        <div class="inline-flex rounded-xl border border-gray-200 bg-white p-1 shadow-sm">
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats Dashboard -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-3">Inventory Overview</h2>
                    <p class="text-gray-300">Real-time insights into your stock levels</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ([['label' => 'Total Products', 'value' => $products->total() ?? 0, 'icon' => '📦', 'color' => 'blue', 'trend' => '+12%'], ['label' => 'In Stock Items', 'value' => $activeProducts ?? 0, 'icon' => '✅', 'color' => 'green', 'trend' => '+8%'], ['label' => 'Low Stock Alert', 'value' => $lowStockCount ?? 8, 'icon' => '⚠️', 'color' => 'amber', 'trend' => '-3%'], ['label' => 'Out of Stock', 'value' => $outOfStockCount ?? 5, 'icon' => '⛔', 'color' => 'red', 'trend' => '+2%']] as $stat)
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-gray-700 p-6 hover:bg-gray-800/70 hover:border-gray-600 transition-all duration-300 group">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="text-2xl font-bold">{{ $stat['value'] }}</div>
                                    <div class="text-sm text-gray-300 mt-1">{{ $stat['label'] }}</div>
                                </div>
                                <div
                                    class="h-12 w-12 rounded-xl bg-gradient-to-br from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
                                    {{ $stat['icon'] }}
                                </div>
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="text-{{ $stat['color'] }}-400 font-medium">{{ $stat['trend'] }}</span>
                                <span class="text-gray-400 ml-2">from last month</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 relative overflow-hidden">
            <!-- Animated Background Pattern -->
            <div class="absolute inset-0">
                <div
                    class="absolute inset-0 bg-[linear-gradient(45deg,transparent_25%,rgba(255,255,255,0.1)_50%,transparent_75%)] bg-[length:400px_400px] animate-shimmer">
                </div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-white mb-6">Ready to Optimize Your Inventory?</h2>
                    <p class="text-xl text-blue-100 mb-10 max-w-3xl mx-auto">
                        Join hundreds of businesses that trust our inventory management system for seamless operations and
                        growth.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}"
                            class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-blue-600 bg-white rounded-xl shadow-2xl hover:shadow-3xl hover:scale-105 transform transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Get Started Free
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <a href="{{ route('dashboard') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white border-2 border-white/30 rounded-xl hover:bg-white/10 hover:border-white/50 backdrop-blur-sm transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Go to Dashboard
                        </a>
                    </div>

                    <p class="mt-8 text-sm text-blue-200">
                        No credit card required • 14-day free trial • Cancel anytime
                    </p>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            // Product filtering with enhanced animations
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        btn.classList.remove('active', 'bg-gradient-to-r', 'from-blue-600',
                            'to-blue-700', 'text-white', 'shadow-lg');
                        btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');

                        // Reset specific button styles
                        const filter = btn.getAttribute('data-filter');
                        const colorMap = {
                            'in-stock': 'blue',
                            'low-stock': 'amber',
                            'out-stock': 'red',
                            'new': 'purple'
                        };

                        if (colorMap[filter]) {
                            btn.classList.remove(`hover:border-${colorMap[filter]}-300`,
                                `hover:bg-${colorMap[filter]}-50`);
                        }
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
                    this.classList.add('active', 'bg-gradient-to-r', 'from-blue-600', 'to-blue-700',
                        'text-white', 'shadow-lg');

                    // Get filter value
                    const filter = this.getAttribute('data-filter');
                    const products = document.querySelectorAll('.product-card');

                    // Add fade out animation
                    products.forEach(product => {
                        product.style.opacity = '0.5';
                        product.style.transform = 'translateY(10px)';
                    });

                    // Filter products after animation
                    setTimeout(() => {
                        let visibleCount = 0;

                        products.forEach(product => {
                            let shouldShow = false;
                            const stock = parseInt(product.getAttribute('data-stock'));
                            const status = product.getAttribute('data-status');
                            const isNew = product.getAttribute('data-new') === 'true';

                            switch (filter) {
                                case 'all':
                                    shouldShow = true;
                                    break;
                                case 'in-stock':
                                    shouldShow = status === 'in-stock';
                                    break;
                                case 'low-stock':
                                    shouldShow = status === 'low-stock';
                                    break;
                                case 'out-stock':
                                    shouldShow = status === 'out-stock';
                                    break;
                                case 'new':
                                    shouldShow = isNew;
                                    break;
                            }

                            if (shouldShow) {
                                product.style.display = '';
                                product.style.opacity = '0';
                                product.style.transform = 'translateY(20px)';
                                setTimeout(() => {
                                    product.style.opacity = '1';
                                    product.style.transform = 'translateY(0)';
                                }, visibleCount * 50);
                                visibleCount++;
                            } else {
                                product.style.display = 'none';
                            }
                        });

                        // Show message if no products
                        const productsGrid = document.querySelector('.grid');
                        let noProductsMsg = productsGrid.querySelector('.no-products-message');

                        if (visibleCount === 0) {
                            if (!noProductsMsg) {
                                noProductsMsg = document.createElement('div');
                                noProductsMsg.className =
                                    'no-products-message col-span-full py-16 text-center';
                                noProductsMsg.innerHTML = `
                            <div class="mx-auto h-24 w-24 text-gray-300 mb-6">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-600">Try selecting a different filter</p>
                        `;
                                productsGrid.appendChild(noProductsMsg);
                            }
                        } else if (noProductsMsg) {
                            noProductsMsg.remove();
                        }
                    }, 200);
                });
            });

            // Quick add to stock functionality
            function quickAddToStock(productId) {
                const button = event.target.closest('button');
                const originalContent = button.innerHTML;

                // Show loading state
                button.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Processing...
        `;
                button.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    // Success state
                    button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Added!
            `;
                    button.classList.remove('from-blue-600', 'to-blue-700', 'hover:from-blue-700', 'hover:to-blue-800');
                    button.classList.add('from-green-600', 'to-green-700', 'hover:from-green-700',
                        'hover:to-green-800');

                    // Show success toast
                    showToast('Stock added successfully! Inventory updated.', 'success');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.disabled = false;
                        button.classList.remove('from-green-600', 'to-green-700', 'hover:from-green-700',
                            'hover:to-green-800');
                        button.classList.add('from-blue-600', 'to-blue-700', 'hover:from-blue-700',
                            'hover:to-blue-800');
                    }, 2000);
                }, 1500);
            }

            // Enhanced toast notification
            function showToast(message, type = 'success') {
                const toastId = 'toast-' + Date.now();
                const toast = document.createElement('div');
                toast.id = toastId;
                toast.className = `fixed top-6 right-6 z-50 w-96 transform transition-all duration-300 translate-x-full`;
                toast.innerHTML = `
            <div class="bg-white rounded-xl shadow-2xl border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full ${type === 'success' ? 'bg-green-100' : 'bg-red-100'} flex items-center justify-center">
                            <svg class="h-5 w-5 ${type === 'success' ? 'text-green-600' : 'text-red-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z'}"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-gray-900">${type === 'success' ? 'Success' : 'Error'}</h3>
                        <p class="mt-1 text-sm text-gray-600">${message}</p>
                    </div>
                    <button onclick="closeToast('${toastId}')" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-2 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} animate-progress"></div>
                </div>
            </div>
        `;

                document.body.appendChild(toast);

                // Show toast
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                    toast.classList.add('translate-x-0');
                }, 10);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    closeToast(toastId);
                }, 5000);
            }

            function closeToast(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.remove(), 300);
                }
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Animate progress bars
                        const progressBar = entry.target.querySelector('.bg-gradient-to-r');
                        if (progressBar) {
                            const width = progressBar.style.width;
                            progressBar.style.width = '0%';
                            setTimeout(() => {
                                progressBar.style.width = width;
                            }, 300);
                        }

                        // Add visible class for other animations
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all product cards
            document.querySelectorAll('.product-card').forEach(card => {
                observer.observe(card);
            });

            // Initialize tooltips
            document.querySelectorAll('[data-tooltip]').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className =
                        'absolute z-50 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    document.body.appendChild(tooltip);

                    const rect = this.getBoundingClientRect();
                    tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
                    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';

                    this.tooltip = tooltip;
                });

                element.addEventListener('mouseleave', function() {
                    if (this.tooltip) {
                        this.tooltip.remove();
                        this.tooltip = null;
                    }
                });
            });
        </script>

        @push('styles')
            <style>
                /* Custom Animations */
                @keyframes fade-in-up {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                @keyframes gradient {

                    0%,
                    100% {
                        background-position: 0% 50%;
                    }

                    50% {
                        background-position: 100% 50%;
                    }
                }

                @keyframes shimmer {
                    0% {
                        background-position: -400px 0;
                    }

                    100% {
                        background-position: 400px 0;
                    }
                }

                @keyframes progress {
                    from {
                        width: 100%;
                    }

                    to {
                        width: 0;
                    }
                }

                @keyframes spin-slow {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }

                .animate-fade-in-up {
                    animation: fade-in-up 0.6s ease-out forwards;
                }

                .animation-delay-200 {
                    animation-delay: 200ms;
                }

                .animation-delay-400 {
                    animation-delay: 400ms;
                }

                .animation-delay-600 {
                    animation-delay: 600ms;
                }

                .animation-delay-2000 {
                    animation-delay: 2s;
                }

                .animation-delay-4000 {
                    animation-delay: 4s;
                }

                .animate-gradient {
                    background-size: 200% auto;
                    animation: gradient 3s ease infinite;
                }

                .animate-shimmer {
                    animation: shimmer 2s infinite linear;
                }

                .animate-progress {
                    animation: progress 5s linear forwards;
                }

                .animate-spin-slow {
                    animation: spin-slow 3s linear infinite;
                }

                /* Custom Scrollbar */
                ::-webkit-scrollbar {
                    width: 10px;
                }

                ::-webkit-scrollbar-track {
                    background: #f1f5f9;
                    border-radius: 5px;
                }

                ::-webkit-scrollbar-thumb {
                    background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
                    border-radius: 5px;
                }

                ::-webkit-scrollbar-thumb:hover {
                    background: linear-gradient(to bottom, #2563eb, #7c3aed);
                }

                /* Selection Color */
                ::selection {
                    background-color: rgba(59, 130, 246, 0.3);
                    color: #1e293b;
                }

                /* Glass Effect */
                .glass-effect {
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    background: rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }

                /* Gradient Text */
                .gradient-text {
                    background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }

                /* Image Loading */
                .image-placeholder {
                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                    background-size: 200% 100%;
                    animation: loading 1.5s infinite;
                }

                @keyframes loading {
                    0% {
                        background-position: 200% 0;
                    }

                    100% {
                        background-position: -200% 0;
                    }
                }
            </style>
        @endpush
    @endpush
