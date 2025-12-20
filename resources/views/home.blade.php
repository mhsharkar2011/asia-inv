@extends('layouts.app')

@section('title', 'Home - Asia Enterprise')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-50 to-indigo-100 overflow-hidden">
    <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 tracking-tight">
                Premium Products for
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Every Need</span>
            </h1>
            <p class="mt-6 text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our carefully curated collection of high-quality products. From essentials to luxury items, we have everything you need.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#featured-products"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Shop Now
                </a>
                <a href="#categories"
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Browse Categories
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div id="categories" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Shop by Category</h2>
            <p class="mt-4 text-lg text-gray-600">Find exactly what you're looking for in our organized categories</p>
        </div>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                // Sample categories - in real app, you'd fetch from database
                $categories = [
                    ['name' => 'Electronics', 'icon' => '💻', 'count' => 45, 'color' => 'blue'],
                    ['name' => 'Clothing', 'icon' => '👕', 'count' => 78, 'color' => 'purple'],
                    ['name' => 'Home & Living', 'icon' => '🏠', 'count' => 32, 'color' => 'green'],
                    ['name' => 'Office Supplies', 'icon' => '📎', 'count' => 56, 'color' => 'yellow'],
                ];
            @endphp

            @foreach($categories as $category)
                <a href="{{ route('inventory.products.index') }}?category={{ $category['name'] }}"
                   class="group relative bg-white p-6 rounded-xl border border-gray-200 hover:border-{{ $category['color'] }}-300 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-lg bg-{{ $category['color'] }}-100 flex items-center justify-center text-2xl">
                            {{ $category['icon'] }}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category['name'] }}</h3>
                            <p class="text-sm text-gray-500">{{ $category['count'] }} products</p>
                        </div>
                    </div>
                    <div class="absolute right-4 top-6 opacity-0 group-hover:opacity-100 transform group-hover:translate-x-0 translate-x-2 transition-all duration-200">
                        <svg class="w-5 h-5 text-{{ $category['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div id="featured-products" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                <p class="mt-2 text-lg text-gray-600">Our handpicked selection of premium products</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('inventory.products.index') }}"
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    View all products
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Product Filters -->
        <div class="mt-8 flex flex-wrap gap-3">
            <button data-filter="all" class="product-filter active px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-medium">
                All Products
            </button>
            <button data-filter="in-stock" class="product-filter px-4 py-2 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium">
                In Stock
            </button>
            <button data-filter="new" class="product-filter px-4 py-2 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium">
                New Arrivals
            </button>
            <button data-filter="popular" class="product-filter px-4 py-2 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 text-sm font-medium">
                Most Popular
            </button>
        </div>

        <!-- Products Grid -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="product-card group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-200"
                     data-status="{{ $product->is_active ? 'active' : 'inactive' }}"
                     data-stock="{{ $product->inventories->sum('quantity_available') > 0 ? 'in-stock' : 'out-of-stock' }}">
                    <!-- Product Image -->
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        <div class="absolute top-3 left-3 z-10">
                            @if($product->is_active && $product->inventories->sum('quantity_available') > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    In Stock
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                        <div class="absolute top-3 right-3 z-10">
                            @if($product->created_at->gt(now()->subDays(7)))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    New
                                </span>
                            @endif
                        </div>
                        <div class="w-full h-full flex items-center justify-center">
                            @php
                                $productColors = ['bg-blue-100', 'bg-purple-100', 'bg-green-100', 'bg-yellow-100'];
                                $randomColor = $productColors[array_rand($productColors)];
                            @endphp
                            <div class="{{ $randomColor }} h-32 w-32 rounded-full flex items-center justify-center text-4xl">
                                @switch($product->category->category_name ?? 'General')
                                    @case('Electronics')
                                        💻
                                        @break
                                    @case('Clothing')
                                        👕
                                        @break
                                    @case('Home')
                                        🏠
                                        @break
                                    @default
                                        📦
                                @endswitch
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->product_name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $product->category->category_name ?? 'Uncategorized' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold text-gray-900">
                                    ৳{{ number_format($product->selling_price, 2) }}
                                </span>
                                @if($product->cost_price && $product->selling_price > $product->cost_price)
                                    <div class="text-xs text-gray-500 line-through">
                                        ৳{{ number_format($product->cost_price, 2) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Info -->
                        <div class="mt-4">
                            @php
                                $totalStock = $product->inventories->sum('quantity_available');
                                $stockLevel = $totalStock > ($product->reorder_level ?? 10) ? 'high' : ($totalStock > 0 ? 'low' : 'none');
                            @endphp
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Available Stock:</span>
                                <span class="font-medium">{{ $totalStock }} units</span>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                @if($stockLevel == 'high')
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                @elseif($stockLevel == 'low')
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 30%"></div>
                                @else
                                    <div class="bg-red-500 h-2 rounded-full" style="width: 0%"></div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Code & Description -->
                        <div class="mt-4">
                            <div class="text-xs text-gray-500 mb-2">SKU: <span class="font-mono">{{ $product->product_code }}</span></div>
                            @if($product->description)
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $product->description }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex items-center justify-between">
                            <a href="{{ route('inventory.products.show', $product->id) }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </a>

                            @if($product->is_active && $totalStock > 0)
                                <button onclick="addToCart({{ $product->id }})"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-300">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No products found</h3>
                    <p class="mt-2 text-gray-500">Check back soon for new arrivals!</p>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $products->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600">
                    {{ $products->total() ?? 0 }}+
                </div>
                <div class="mt-2 text-lg font-medium text-gray-900">Products Available</div>
                <p class="mt-2 text-gray-600">Wide selection for every need</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600">
                    {{ $activeProducts ?? 0 }}+
                </div>
                <div class="mt-2 text-lg font-medium text-gray-900">Active Products</div>
                <p class="mt-2 text-gray-600">Ready for immediate purchase</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600">
                    {{ $categoriesCount ?? 0 }}+
                </div>
                <div class="mt-2 text-lg font-medium text-gray-900">Categories</div>
                <p class="mt-2 text-gray-600">Organized for easy browsing</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white">Ready to Shop?</h2>
            <p class="mt-4 text-xl text-blue-100">Join thousands of satisfied customers who trust our products</p>
            <div class="mt-8">
                <a href="{{ route('inventory.products.index') }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Start Shopping
                </a>
                <a href="{{ route('dashboard') }}"
                   class="ml-4 inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-blue-600 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Manage Inventory
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Product filtering
    document.querySelectorAll('.product-filter').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.product-filter').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });

            // Add active class to clicked button
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            this.classList.add('active', 'bg-blue-600', 'text-white');

            const filter = this.getAttribute('data-filter');
            const products = document.querySelectorAll('.product-card');

            products.forEach(product => {
                switch(filter) {
                    case 'all':
                        product.style.display = '';
                        break;
                    case 'in-stock':
                        product.style.display = product.getAttribute('data-stock') === 'in-stock' ? '' : 'none';
                        break;
                    case 'new':
                        // In real app, you'd check creation date
                        const isNew = product.querySelector('.bg-blue-100');
                        product.style.display = isNew ? '' : 'none';
                        break;
                    case 'popular':
                        // In real app, you'd check popularity metrics
                        product.style.display = Math.random() > 0.5 ? '' : 'none';
                        break;
                }
            });
        });
    });

    // Add to cart functionality
    function addToCart(productId) {
        // In a real app, this would make an AJAX call to add to cart
        const button = event.target.closest('button');
        const originalText = button.innerHTML;

        // Visual feedback
        button.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Adding...
        `;
        button.disabled = true;

        setTimeout(() => {
            button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Added!
            `;
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');

            // Show success message
            showToast('Product added to cart successfully!', 'success');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
        }, 1000);
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z'
                    }"></path>
                </svg>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Animate progress bars on scroll
    const observerOptions = {
        threshold: 0.2
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                const progressBar = entry.target.querySelector('.bg-green-500, .bg-yellow-500, .bg-red-500');
                if(progressBar) {
                    const width = progressBar.style.width;
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = width;
                    }, 300);
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });
</script>

@push('styles')
<style>
    .bg-grid-slate-100 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(241 245 249 / 0.5)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-4px);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }
        to {
            transform: translateX(0);
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(100%);
        }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush
@endpush
