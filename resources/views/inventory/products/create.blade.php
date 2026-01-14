@extends('layouts.admin')

@section('title', 'Create Product - Asia Enterprise')

@section('breadcrumb', 'Create Product')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 shadow-sm">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Create New Product</h1>
                            <p class="text-gray-600 mt-1">Add a new product to inventory system</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('inventory.products.index') }}"
                            class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-xl text-sm font-medium
                                   text-gray-700 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   transition-all duration-200 shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Products
                        </a>

                        @can('manage product categories')
                            <a href="{{ route('inventory.categories.create') }}"
                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600
                                       text-white font-medium rounded-xl hover:from-green-600 hover:to-emerald-700
                                       transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Category
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-6">
            <div class="max-w-7xl mx-auto">
                <!-- Admin Quick Actions -->
                @canany(['manage products', 'view product reports', 'manage inventory'])
                    <div class="mb-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-gradient-to-r from-purple-100 to-violet-100 rounded-lg">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Admin Quick Actions</h3>
                                        <p class="text-xs text-gray-500">Available only for administrators</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @can('manage product categories')
                                        <a href="{{ route('inventory.categories.index') }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-700
                                                   bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                                            Manage Categories
                                        </a>
                                    @endcan

                                    @can('view product reports')
                                        <a href="{{ route('reports.products') }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700
                                                   bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                            View Reports
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endcanany

                <!-- Form Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Card Header with Permissions Badge -->
                    <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="p-3 bg-white rounded-xl shadow-sm">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Product Information</h2>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-sm text-gray-600">Fill in all required fields</span>
                                        @can('create products')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Create Permission
                                            </span>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                            @can('manage product settings')
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm
                                           font-medium text-gray-700 bg-white hover:bg-gray-50 focus:ring-2
                                           focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Advanced Settings
                                </button>
                            @endcan
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="p-8">
                        @if ($errors->any())
                            <div
                                class="mb-8 p-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-red-800">Validation Errors</h3>
                                        <div class="mt-2">
                                            <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Permission Alert -->
                        @cannot('create products')
                            <div
                                class="mb-8 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-amber-800">Permission Required</h3>
                                        <div class="mt-2 text-sm text-amber-700">
                                            <p>You need the <span class="font-semibold">"create products"</span> permission to
                                                add new products.</p>
                                            <p class="mt-1">Please contact your administrator if you believe you should have
                                                this access.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcannot

                        @can('create products')
                            <form action="{{ route('inventory.products.store') }}" method="POST" id="productForm"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <!-- Left Column - Basic Information -->
                                    <div class="lg:col-span-2 space-y-8">
                                        <!-- Basic Information Card -->
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6">
                                            <div class="flex items-center mb-6">
                                                <div class="p-2.5 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-lg mr-3">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                                                    <p class="text-sm text-gray-500">Core product details</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <!-- Product Code Section -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="space-y-2">
                                                        <label for="product_code"
                                                            class="block text-sm font-medium text-gray-900">
                                                            Product Code <span class="text-red-500">*</span>
                                                        </label>
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-1 relative">
                                                                <input type="text" id="product_code" name="product_code"
                                                                    value="{{ old('product_code', $productCode) }}" required
                                                                    readonly
                                                                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-xl
                                                                           bg-gray-50 text-gray-900 focus:ring-2 focus:ring-blue-500
                                                                           focus:border-blue-500 transition-all duration-200">
                                                                <div
                                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <svg class="h-5 w-5 text-gray-400" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            @can('manage product settings')
                                                                <button type="button" onclick="regenerateProductCode()"
                                                                    class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50
                                                                           border border-gray-300 rounded-xl text-sm font-medium text-gray-700
                                                                           hover:from-blue-100 hover:to-indigo-100 focus:ring-2 focus:ring-blue-500
                                                                           transition-all duration-200 shadow-sm hover:shadow">
                                                                    <svg class="w-4 h-4 mr-2" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                    </svg>
                                                                    Regenerate
                                                                </button>
                                                            @endcan
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Auto-generated unique identifier
                                                        </p>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <label for="product_name"
                                                            class="block text-sm font-medium text-gray-900">
                                                            Product Name <span class="text-red-500">*</span>
                                                        </label>
                                                        <input type="text" id="product_name" name="product_name"
                                                            value="{{ old('product_name') }}" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                   focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            placeholder="Enter product name">
                                                    </div>
                                                </div>

                                                <!-- Category & HS Code -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="space-y-2">
                                                        <label for="category_id"
                                                            class="block text-sm font-medium text-gray-900">
                                                            Category <span class="text-red-500">*</span>
                                                        </label>
                                                        <div class="relative">
                                                            <select id="category_id" name="category_id" required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                       focus:ring-blue-500 focus:border-blue-500 appearance-none
                                                                       transition-all duration-200">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $cat)
                                                                    <option value="{{ $cat->id }}"
                                                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                                        {{ $cat->category_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div
                                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <label for="hs_code" class="block text-sm font-medium text-gray-900">
                                                            HS Code
                                                        </label>
                                                        <input type="text" id="hs_code" name="hs_code"
                                                            value="{{ old('hs_code') }}"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                   focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                            placeholder="Enter HS Code">
                                                    </div>
                                                </div>

                                                <!-- Product Images Section -->
                                                <div class="space-y-4">
                                                    <label class="block text-sm font-medium text-gray-900">
                                                        Product Images
                                                    </label>
                                                    <div id="imageUploadArea"
                                                        class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors duration-200 bg-gradient-to-br from-gray-50 to-white">
                                                        <input type="file" id="imageInput" name="images[]" multiple
                                                            accept="image/*" class="hidden"
                                                            onchange="handleImageSelect(event)">

                                                        <div class="space-y-4">
                                                            <div
                                                                class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-8 h-8 text-blue-500" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-900">Drop images here
                                                                    or click to upload</p>
                                                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 2MB
                                                                    each (Max 5 images)</p>
                                                            </div>
                                                            <button type="button"
                                                                onclick="document.getElementById('imageInput').click()"
                                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-500
                                                                           text-white font-medium rounded-lg hover:from-blue-600 hover:to-indigo-600
                                                                           transition-all duration-200 shadow-sm hover:shadow-md">
                                                                <svg class="w-4 h-4 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                                Select Images
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Image Preview Container -->
                                                    <div id="imagePreviewContainer"
                                                        class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                                        <!-- Preview images will be added here dynamically -->
                                                    </div>

                                                    <!-- Max Images Warning -->
                                                    <div id="maxImagesWarning"
                                                        class="hidden bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 p-4 rounded-lg mt-4">
                                                        <div class="flex items-start">
                                                            <svg class="h-5 w-5 text-amber-500 mr-3 mt-0.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                            </svg>
                                                            <p class="text-sm text-amber-700">Maximum 5 images allowed. Remove
                                                                some images to add more.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                <div class="space-y-2">
                                                    <label for="description" class="block text-sm font-medium text-gray-900">
                                                        Description
                                                    </label>
                                                    <textarea id="description" name="description" rows="3"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                               focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                        placeholder="Product description...">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pricing & Units Card -->
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6">
                                            <div class="flex items-center mb-6">
                                                <div
                                                    class="p-2.5 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg mr-3">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Pricing & Units</h3>
                                                    <p class="text-sm text-gray-500">Cost, price, and measurement details</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <!-- Unit of Measure & Tax Rate -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="space-y-2">
                                                        <label for="unit_of_measure"
                                                            class="block text-sm font-medium text-gray-900">
                                                            Unit of Measure <span class="text-red-500">*</span>
                                                        </label>
                                                        <select id="unit_of_measure" name="unit_of_measure" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                   focus:ring-blue-500 focus:border-blue-500 appearance-none
                                                                   transition-all duration-200">
                                                            <option value="">Select Unit</option>
                                                            <option value="PCS"
                                                                {{ old('unit_of_measure') == 'PCS' ? 'selected' : '' }}>Pieces
                                                            </option>
                                                            <option value="KG"
                                                                {{ old('unit_of_measure') == 'KG' ? 'selected' : '' }}>Kilogram
                                                            </option>
                                                            <option value="LTR"
                                                                {{ old('unit_of_measure') == 'LTR' ? 'selected' : '' }}>Liter
                                                            </option>
                                                            <option value="MTR"
                                                                {{ old('unit_of_measure') == 'MTR' ? 'selected' : '' }}>Meter
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="space-y-2">
                                                        <label for="tax_rate" class="block text-sm font-medium text-gray-900">
                                                            AIT Rate (%) <span class="text-red-500">*</span>
                                                        </label>
                                                        <select id="tax_rate" name="tax_rate" required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                   focus:ring-blue-500 focus:border-blue-500 appearance-none
                                                                   transition-all duration-200">
                                                            <option value="">Select Tax Rate</option>
                                                            @for ($i = 0; $i <= 30; $i += 5)
                                                                <option value="{{ $i }}"
                                                                    {{ old('tax_rate') == $i ? 'selected' : '' }}>
                                                                    {{ $i }}%
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Pricing Section -->
                                                <div class="space-y-4">
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                                        <div class="space-y-2">
                                                            <label for="purchase_price"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Purchase Price (BDT)
                                                            </label>
                                                            <div class="relative">
                                                                <div
                                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500">৳</span>
                                                                </div>
                                                                <input type="number" step="0.01" id="purchase_price"
                                                                    name="purchase_price" value="{{ old('purchase_price') }}"
                                                                    class="w-full px-4 py-3 pl-8 border border-gray-300 rounded-xl focus:ring-2
                                                                           focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                    placeholder="0.00">
                                                            </div>
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label for="selling_price"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Selling Price (BDT)
                                                            </label>
                                                            <div class="relative">
                                                                <div
                                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500">৳</span>
                                                                </div>
                                                                <input type="number" step="0.01" id="selling_price"
                                                                    name="selling_price" value="{{ old('selling_price') }}"
                                                                    class="w-full px-4 py-3 pl-8 border border-gray-300 rounded-xl focus:ring-2
                                                                           focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                    placeholder="0.00">
                                                            </div>
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label for="mrp"
                                                                class="block text-sm font-medium text-gray-900">
                                                                MRP (BDT)
                                                            </label>
                                                            <div class="relative">
                                                                <div
                                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                    <span class="text-gray-500">৳</span>
                                                                </div>
                                                                <input type="number" step="0.01" id="mrp"
                                                                    name="mrp" value="{{ old('mrp') }}"
                                                                    class="w-full px-4 py-3 pl-8 border border-gray-300 rounded-xl focus:ring-2
                                                                           focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                    placeholder="0.00">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Price Alert -->
                                                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 p-4 rounded-lg hidden"
                                                        id="priceAlert">
                                                        <div class="flex">
                                                            <svg class="h-5 w-5 text-amber-500 mr-3" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                            </svg>
                                                            <p class="text-sm text-amber-700" id="priceAlertMessage"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Stock & Status -->
                                    <div class="space-y-8">
                                        <!-- Stock Management Card -->
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6">
                                            <div class="flex items-center mb-6">
                                                <div class="p-2.5 bg-gradient-to-r from-cyan-100 to-blue-100 rounded-lg mr-3">
                                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Stock Management</h3>
                                                    <p class="text-sm text-gray-500">Inventory control settings</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <!-- Stock Levels -->
                                                <div class="space-y-4">
                                                    <div class="grid grid-cols-1 gap-4">
                                                        <div class="space-y-2">
                                                            <label for="reorder_level"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Reorder Level <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number" id="reorder_level" name="reorder_level"
                                                                value="{{ old('reorder_level', 0) }}" required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                       focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                placeholder="0">
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label for="min_stock"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Min Stock <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="number" id="min_stock" name="min_stock"
                                                                value="{{ old('min_stock', 0) }}" required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                       focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                placeholder="0">
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label for="max_stock"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Max Stock
                                                            </label>
                                                            <input type="number" id="max_stock" name="max_stock"
                                                                value="{{ old('max_stock') }}"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2
                                                                       focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                                                placeholder="0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tracking Options -->
                                                <div class="space-y-4">
                                                    <h4 class="text-sm font-medium text-gray-900">Tracking Options</h4>
                                                    <div class="space-y-3">
                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="track_batch" name="track_batch"
                                                                value="1" {{ old('track_batch') ? 'checked' : '' }}
                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                            <label for="track_batch" class="ml-3 text-sm text-gray-700">
                                                                Track Batch Numbers
                                                            </label>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="track_expiry" name="track_expiry"
                                                                value="1" {{ old('track_expiry') ? 'checked' : '' }}
                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                            <label for="track_expiry" class="ml-3 text-sm text-gray-700">
                                                                Track Expiry Dates
                                                            </label>
                                                        </div>

                                                        <div class="flex items-center">
                                                            <input type="checkbox" id="track_serial" name="track_serial"
                                                                value="1" {{ old('track_serial') ? 'checked' : '' }}
                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                            <label for="track_serial" class="ml-3 text-sm text-gray-700">
                                                                Track Serial Numbers
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Advanced Options (Admin Only) -->
                                                @can('manage inventory')
                                                    <div class="pt-4 border-t border-gray-200">
                                                        <h4 class="text-sm font-medium text-gray-900 mb-3">Advanced Options</h4>
                                                        <div class="space-y-3">
                                                            <div class="flex items-center justify-between">
                                                                <label for="manage_stock" class="text-sm text-gray-700">Manage
                                                                    Stock</label>
                                                                <input type="checkbox" id="manage_stock" name="manage_stock"
                                                                    value="1"
                                                                    {{ old('manage_stock', true) ? 'checked' : '' }}
                                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600">
                                                            </div>

                                                            <div class="flex items-center justify-between">
                                                                <label for="allow_backorder" class="text-sm text-gray-700">Allow
                                                                    Backorders</label>
                                                                <input type="checkbox" id="allow_backorder"
                                                                    name="allow_backorder" value="1"
                                                                    {{ old('allow_backorder') ? 'checked' : '' }}
                                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200">
                                                            </div>

                                                            <div class="flex items-center justify-between">
                                                                <label for="allow_negative" class="text-sm text-gray-700">Allow
                                                                    Negative Stock</label>
                                                                <input type="checkbox" id="allow_negative" name="allow_negative"
                                                                    value="1" {{ old('allow_negative') ? 'checked' : '' }}
                                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-gray-200">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>

                                        <!-- Status & Actions Card -->
                                        <div
                                            class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6">
                                            <div class="flex items-center mb-6">
                                                <div
                                                    class="p-2.5 bg-gradient-to-r from-purple-100 to-violet-100 rounded-lg mr-3">
                                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Status & Actions</h3>
                                                    <p class="text-sm text-gray-500">Product status and quick actions</p>
                                                </div>
                                            </div>

                                            <div class="space-y-6">
                                                <!-- Active Status -->
                                                <div class="space-y-3">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <label for="is_active"
                                                                class="block text-sm font-medium text-gray-900">
                                                                Product Status
                                                            </label>
                                                            <p class="text-xs text-gray-500 mt-1">Set product as active or
                                                                inactive</p>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <span
                                                                class="text-sm font-medium text-gray-700 mr-3">Inactive</span>
                                                            <input type="checkbox" id="is_active" name="is_active"
                                                                value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 bg-blue-600">
                                                            <span class="text-sm font-medium text-gray-700 ml-3">Active</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="pt-4 border-t border-gray-200">
                                                    <div class="space-y-3">
                                                        <button type="submit" name="save"
                                                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600
                                                                   text-white font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                                                                   transition-all duration-200 shadow-lg hover:shadow-xl">
                                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Save Product
                                                        </button>

                                                        <button type="submit" name="save_and_new" value="1"
                                                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600
                                                                   text-white font-medium rounded-xl hover:from-green-700 hover:to-emerald-700
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                                                                   transition-all duration-200 shadow-sm hover:shadow-md">
                                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                            </svg>
                                                            Save & New
                                                        </button>

                                                        <a href="{{ route('inventory.products.index') }}"
                                                            class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300
                                                                   text-gray-700 font-medium rounded-xl hover:bg-gray-50 focus:outline-none
                                                                   focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- User Permissions Info (Admin Only) -->
                                        @can('view user permissions')
                                            <div
                                                class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 p-6">
                                                <div class="flex items-center mb-4">
                                                    <div class="p-2 bg-gradient-to-r from-amber-100 to-orange-100 rounded-lg mr-3">
                                                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    </div>
                                                    <h4 class="text-sm font-medium text-gray-900">User Permissions</h4>
                                                </div>
                                                <div class="space-y-2">
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-600">Your Role:</span>
                                                        <span
                                                            class="font-medium text-gray-900">{{ auth()->user()->getRoleNames()->first() }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-600">Create Products:</span>
                                                        <span
                                                            class="font-medium {{ auth()->user()->can('create products') ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ auth()->user()->can('create products') ? 'Allowed' : 'Not Allowed' }}
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-600">Manage Inventory:</span>
                                                        <span
                                                            class="font-medium {{ auth()->user()->can('manage inventory') ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ auth()->user()->can('manage inventory') ? 'Allowed' : 'Not Allowed' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .image-preview-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .image-preview-item:hover {
            transform: translateY(-2px);
        }

        .image-preview-item.dragging {
            opacity: 0.5;
        }

        .remove-image-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            background: #ef4444;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid white;
            z-index: 10;
        }

        .remove-image-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .drop-zone-active {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .image-order-badge {
            position: absolute;
            top: -8px;
            left: -8px;
            width: 24px;
            height: 24px;
            background: #3b82f6;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
            z-index: 10;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let selectedImages = [];
        const maxImages = 5;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize drop zone
            const dropZone = document.getElementById('imageUploadArea');
            const imageInput = document.getElementById('imageInput');

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropZone.classList.add('drop-zone-active');
            }

            function unhighlight() {
                dropZone.classList.remove('drop-zone-active');
            }

            // Handle drop
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            // Make drop zone clickable
            dropZone.addEventListener('click', function(e) {
                if (e.target !== this && !e.target.closest('button')) {
                    return;
                }
                imageInput.click();
            });
        });

        function handleImageSelect(event) {
            const files = event.target.files;
            handleFiles(files);
            // Reset input to allow selecting same file again
            event.target.value = '';
        }

        function handleFiles(files) {
            if (selectedImages.length + files.length > maxImages) {
                showMaxImagesWarning();
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // Validate file type
                if (!file.type.match('image.*')) {
                    showNotification('Only image files are allowed', 'error');
                    continue;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification(`File ${file.name} exceeds 2MB limit`, 'error');
                    continue;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = {
                        id: Date.now() + i,
                        file: file,
                        preview: e.target.result,
                        name: file.name,
                        size: formatFileSize(file.size)
                    };
                    selectedImages.push(image);
                    addImagePreview(image);
                };
                reader.readAsDataURL(file);
            }
        }

        function addImagePreview(image) {
            const container = document.getElementById('imagePreviewContainer');
            const maxImagesWarning = document.getElementById('maxImagesWarning');

            if (selectedImages.length >= maxImages) {
                maxImagesWarning.classList.remove('hidden');
            }

            const previewDiv = document.createElement('div');
            previewDiv.className =
                'image-preview-item group relative bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200';
            previewDiv.setAttribute('data-id', image.id);

            // Determine order number
            const order = selectedImages.indexOf(image) + 1;

            previewDiv.innerHTML = `
                <div class="aspect-square overflow-hidden bg-gray-100">
                    <img src="${image.preview}" alt="Preview" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                </div>
                <div class="image-order-badge">${order}</div>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="flex space-x-2">
                        <button type="button" onclick="removeImage(${image.id})" class="remove-image-btn">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                    <p class="text-xs text-white truncate">${image.name}</p>
                    <p class="text-xs text-gray-300">${image.size}</p>
                </div>
            `;

            container.appendChild(previewDiv);
            updateImageOrderBadges();
        }

        function removeImage(id) {
            const index = selectedImages.findIndex(img => img.id === id);
            if (index > -1) {
                selectedImages.splice(index, 1);
            }

            const preview = document.querySelector(`[data-id="${id}"]`);
            if (preview) {
                preview.remove();
            }

            const maxImagesWarning = document.getElementById('maxImagesWarning');
            if (selectedImages.length < maxImages) {
                maxImagesWarning.classList.add('hidden');
            }

            updateImageOrderBadges();
        }

        function updateImageOrderBadges() {
            const previews = document.querySelectorAll('.image-preview-item');
            previews.forEach((preview, index) => {
                const badge = preview.querySelector('.image-order-badge');
                if (badge) {
                    badge.textContent = index + 1;
                }
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showMaxImagesWarning() {
            const maxImagesWarning = document.getElementById('maxImagesWarning');
            maxImagesWarning.classList.remove('hidden');

            setTimeout(() => {
                maxImagesWarning.classList.add('hidden');
            }, 3000);
        }

        // Update form submission to handle images
        document.getElementById('productForm')?.addEventListener('submit', function(e) {
            // Validate images count
            if (selectedImages.length === 0) {
                showNotification('Please upload at least one product image', 'error');
                e.preventDefault();
                return;
            }

            // Add hidden input for image order
            const imageOrderInput = document.createElement('input');
            imageOrderInput.type = 'hidden';
            imageOrderInput.name = 'image_order';
            imageOrderInput.value = JSON.stringify(selectedImages.map(img => img.id));
            this.appendChild(imageOrderInput);
        });

        // Permission-based UI modifications
        // ... keep your existing permission and validation code ...

        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existing = document.querySelectorAll('.custom-notification');
            existing.forEach(el => el.remove());

            // Create notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg custom-notification
            ${type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' :
              type === 'error' ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white' :
              'bg-gradient-to-r from-blue-500 to-indigo-600 text-white'}`;

            notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />' :
                        type === 'error' ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                </svg>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(notification);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }
    </script>
@endpush
