@extends('layouts.app')

@section('title', $product->product_name . ' - Asia Enterprise')

@section('content')
    <!-- Breadcrumb -->
    <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Home</a>
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <a href="{{ url('/shop') }}" class="ml-2 text-gray-500 hover:text-blue-600 transition-colors">Shop</a>
            </li>
            @if($product->category)
            <li class="flex items-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <a href="{{ url('/shop?category=' . ($product->category->slug ?? $product->category->id)) }}"
                   class="ml-2 text-gray-500 hover:text-blue-600 transition-colors">{{ $product->category->category_name }}</a>
            </li>
            @endif
            <li class="flex items-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span class="ml-2 text-gray-700 font-medium">{{ Str::limit($product->product_name, 30) }}</span>
            </li>
        </ol>
    </nav>

    <div class="space-y-8">
        <!-- Main Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div>
                <!-- Main Image -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
                    <div class="relative w-full h-96 bg-gray-50 rounded-lg overflow-hidden cursor-zoom-in" id="mainImageContainer">
                        @php
                            $images = collect();
                            if (isset($product->images) && $product->images instanceof \Illuminate\Database\Eloquent\Collection) {
                                $images = $product->images;
                            } elseif (isset($product->productImages) && $product->productImages instanceof \Illuminate\Database\Eloquent\Collection) {
                                $images = $product->productImages;
                            }
                            $hasImages = $images->isNotEmpty();
                            $mainImageUrl = $hasImages ? (isset($images->first()->image_path)
                                ? asset('storage/' . $images->first()->image_path)
                                : (isset($images->first()->image)
                                    ? asset('storage/' . $images->first()->image)
                                    : asset('images/product-placeholder.jpg'))) : asset('images/product-placeholder.jpg');
                        @endphp

                        <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $product->product_name }}"
                             class="w-full h-full object-contain p-2 transition-transform duration-300">

                        <!-- Stock Status Badge -->
                        <div class="absolute top-4 left-4">
                            @if(!$product->is_active || $product->stock_quantity <= 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 shadow-sm">
                                Out of Stock
                            </span>
                            @elseif($product->stock_quantity <= $product->reorder_level)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 shadow-sm">
                                Low Stock
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                In Stock
                            </span>
                            @endif
                        </div>

                        <!-- Image Navigation -->
                        @if($hasImages && $images->count() > 1)
                        <button type="button" onclick="prevImage()"
                                class="absolute left-2 top-1/2 transform -translate-y-1/2 p-2 bg-white/80 hover:bg-white rounded-full shadow-md transition-all hover:scale-110">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button" onclick="nextImage()"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 bg-white/80 hover:bg-white rounded-full shadow-md transition-all hover:scale-110">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Thumbnails -->
                @if($hasImages && $images->count() > 1)
                <div class="flex space-x-2 overflow-x-auto py-2">
                    @foreach($images as $index => $image)
                    @php
                        $thumbUrl = isset($image->image_path)
                            ? asset('storage/' . $image->image_path)
                            : (isset($image->image)
                                ? asset('storage/' . $image->image)
                                : '');
                    @endphp
                    <button type="button" onclick="changeMainImage('{{ $thumbUrl }}', {{ $index }})"
                            class="thumbnail-btn flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg border-2 border-transparent hover:border-blue-500 overflow-hidden transition-all duration-200 {{ $index === 0 ? 'border-blue-500' : '' }}">
                        <img src="{{ $thumbUrl }}" alt="{{ $product->product_name }} - Thumbnail {{ $index + 1 }}"
                             class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info & Actions -->
            <div class="space-y-6">
                <!-- Product Header -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->product_name }}</h1>
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-blue-600">৳{{ number_format($product->selling_price, 2) }}</span>
                            @if($product->mrp && $product->mrp > $product->selling_price)
                            <span class="ml-2 text-lg text-gray-400 line-through">৳{{ number_format($product->mrp, 2) }}</span>
                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">
                                Save ৳{{ number_format($product->mrp - $product->selling_price, 2) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Code & Category -->
                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                        <span>Code: <strong>{{ $product->product_code }}</strong></span>
                        @if($product->category)
                        <span>|</span>
                        <a href="{{ url('/shop?category=' . ($product->category->slug ?? $product->category->id)) }}"
                           class="text-blue-600 hover:text-blue-800 transition-colors">
                            {{ $product->category->category_name }}
                        </a>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if($product->is_active && $product->stock_quantity > 0)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ $product->stock_quantity }} items available</span>
                        </div>
                        @else
                        <div class="flex items-center text-red-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Currently out of stock</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Add to Cart Section -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add to Cart</h3>

                    <!-- Quantity Selector -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="decreaseQuantity()"
                                    class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="decreaseBtn">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock_quantity }}"
                                   value="1"
                                   class="w-20 text-center border border-gray-300 rounded-lg py-2 px-3 text-lg font-medium">
                            <button type="button" onclick="increaseQuantity()"
                                    class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="increaseBtn">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                            <span class="text-sm text-gray-500 ml-2">Max: {{ $product->stock_quantity }} units</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if($product->is_active && $product->stock_quantity > 0)
                        <button type="button" onclick="addToCart()"
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>

                        <button type="button" onclick="buyNow()"
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Buy Now
                        </button>
                        @else
                        <button type="button" disabled
                                class="w-full flex items-center justify-center px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.714-.833-2.484 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            Out of Stock
                        </button>

                        <button type="button" onclick="notifyMe()"
                                class="w-full flex items-center justify-center px-6 py-3 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Notify When Available
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Unit</p>
                            <p class="font-medium">{{ $product->unit_of_measure }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">HSN/SAC Code</p>
                            <p class="font-medium">{{ $product->hsn_sac_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tax Rate</p>
                            <p class="font-medium">{{ $product->tax_rate }}% GST</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">SKU</p>
                            <p class="font-medium">{{ $product->product_code }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description & Details Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button type="button" onclick="showTab('description')"
                            class="tab-btn py-4 px-6 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300 transition-colors active"
                            data-tab="description">
                        Description
                    </button>
                    <button type="button" onclick="showTab('specifications')"
                            class="tab-btn py-4 px-6 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300 transition-colors"
                            data-tab="specifications">
                        Specifications
                    </button>
                    <button type="button" onclick="showTab('shipping')"
                            class="tab-btn py-4 px-6 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-300 transition-colors"
                            data-tab="shipping">
                        Shipping & Returns
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- Description Tab -->
                <div id="descriptionTab" class="tab-content">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->description ?? 'No detailed description available for this product.' }}
                        </p>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="specificationsTab" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Product Details</h4>
                                <ul class="mt-2 space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Product Code:</span>
                                        <span class="font-medium">{{ $product->product_code }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Category:</span>
                                        <span class="font-medium">{{ $product->category->category_name ?? 'N/A' }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Unit:</span>
                                        <span class="font-medium">{{ $product->unit_of_measure }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Pricing Details</h4>
                                <ul class="mt-2 space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Selling Price:</span>
                                        <span class="font-medium">৳{{ number_format($product->selling_price, 2) }}</span>
                                    </li>
                                    @if($product->mrp)
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">MRP:</span>
                                        <span class="font-medium line-through">৳{{ number_format($product->mrp, 2) }}</span>
                                    </li>
                                    @endif
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Tax Rate:</span>
                                        <span class="font-medium">{{ $product->tax_rate }}% GST</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Tab -->
                <div id="shippingTab" class="tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Shipping Information</h4>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Free shipping on orders over ৳5000</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Delivery within 3-5 business days in Dhaka city</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>5-7 business days for outside Dhaka</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Return Policy</h4>
                            <p class="text-gray-700">We offer a 7-day return policy for unused products in original packaging. Contact our customer service for return requests.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                    <a href="{{ url('/products/' . $relatedProduct->id) }}" class="block">
                        <div class="p-4">
                            <div class="h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                                @php
                                    $relatedImage = $relatedProduct->images->first() ?? $relatedProduct->productImages->first();
                                    $relatedImageUrl = $relatedImage ? (isset($relatedImage->image_path)
                                        ? asset('storage/' . $relatedImage->image_path)
                                        : (isset($relatedImage->image)
                                            ? asset('storage/' . $relatedImage->image)
                                            : asset('images/product-placeholder.jpg'))) : asset('images/product-placeholder.jpg');
                                @endphp
                                <img src="{{ $relatedImageUrl }}" alt="{{ $relatedProduct->product_name }}"
                                     class="max-h-full max-w-full object-contain">
                            </div>
                            <h3 class="font-medium text-gray-900 mb-2 line-clamp-2">{{ $relatedProduct->product_name }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-blue-600">৳{{ number_format($relatedProduct->selling_price, 2) }}</span>
                                @if($relatedProduct->is_active && $relatedProduct->stock_quantity > 0)
                                <button type="button" onclick="event.preventDefault(); addRelatedToCart({{ $relatedProduct->id }})"
                                        class="text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                    Add to Cart
                                </button>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Image Gallery
    let currentImageIndex = 0;
    const imageUrls = @json($hasImages ? $images->map(function($image) {
        return isset($image->image_path)
            ? asset('storage/' . $image->image_path)
            : (isset($image->image)
                ? asset('storage/' . $image->image)
                : '');
    }) : []);

    function changeMainImage(imageUrl, index) {
        document.getElementById('mainImage').src = imageUrl;
        currentImageIndex = index;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
            btn.classList.toggle('border-blue-500', i === index);
            btn.classList.toggle('border-transparent', i !== index);
        });
    }

    function nextImage() {
        if (imageUrls.length > 1) {
            currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
            changeMainImage(imageUrls[currentImageIndex], currentImageIndex);
        }
    }

    function prevImage() {
        if (imageUrls.length > 1) {
            currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length;
            changeMainImage(imageUrls[currentImageIndex], currentImageIndex);
        }
    }

    // Quantity Controls
    function updateQuantityControls() {
        const quantityInput = document.getElementById('quantity');
        const currentQty = parseInt(quantityInput.value);
        const maxQty = parseInt(quantityInput.max);

        document.getElementById('decreaseBtn').disabled = currentQty <= 1;
        document.getElementById('increaseBtn').disabled = currentQty >= maxQty;
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        let currentQty = parseInt(quantityInput.value);
        if (currentQty > 1) {
            quantityInput.value = currentQty - 1;
            updateQuantityControls();
        }
    }

    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        let currentQty = parseInt(quantityInput.value);
        const maxQty = parseInt(quantityInput.max);
        if (currentQty < maxQty) {
            quantityInput.value = currentQty + 1;
            updateQuantityControls();
        }
    }

    // Initialize quantity controls
    document.addEventListener('DOMContentLoaded', function() {
        updateQuantityControls();

        // Quantity input change handler
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('change', function() {
                let value = parseInt(this.value);
                const max = parseInt(this.max);
                const min = parseInt(this.min);

                if (isNaN(value) || value < min) value = min;
                if (value > max) value = max;

                this.value = value;
                updateQuantityControls();
            });
        }
    });

    // Tab System
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active', 'border-blue-600', 'text-blue-600');
            btn.classList.add('text-gray-500');
        });

        // Show selected tab content
        document.getElementById(tabName + 'Tab').classList.remove('hidden');

        // Add active class to selected tab button
        const activeBtn = document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active', 'border-blue-600', 'text-blue-600');
            activeBtn.classList.remove('text-gray-500');
        }
    }

    // Cart Functions (Basic version without AJAX for now)
    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        const productId = {{ $product->id }};

        // Simple form submission
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("/cart/add") }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        form.appendChild(productInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        form.appendChild(quantityInput);

        document.body.appendChild(form);
        form.submit();
    }

    function buyNow() {
        const quantity = document.getElementById('quantity').value;
        const productId = {{ $product->id }};

        // First add to cart, then redirect to checkout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("/cart/add-and-checkout") }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        form.appendChild(productInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        form.appendChild(quantityInput);

        document.body.appendChild(form);
        form.submit();
    }

    function notifyMe() {
        const email = prompt('Please enter your email address to get notified when this product is back in stock:');
        if (email && validateEmail(email)) {
            // Simple form submission for notification
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("/product/notify") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = {{ $product->id }};
            form.appendChild(productInput);

            const emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email';
            emailInput.value = email;
            form.appendChild(emailInput);

            document.body.appendChild(form);
            form.submit();
        } else if (email) {
            alert('Please enter a valid email address.');
        }
    }

    function addRelatedToCart(productId) {
        // Simple form submission for related product
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("/cart/add") }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;
        form.appendChild(productInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = 1;
        form.appendChild(quantityInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Helper function
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>
@endpush

@push('styles')
<style>
    .thumbnail-btn {
        transition: all 0.2s ease;
    }

    .thumbnail-btn:hover {
        transform: scale(1.05);
    }

    .thumbnail-btn.active {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    .tab-btn.active {
        border-bottom-color: #2563eb;
        color: #2563eb;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom scrollbar for thumbnails */
    .overflow-x-auto::-webkit-scrollbar {
        height: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endpush
