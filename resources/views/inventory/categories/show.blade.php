@extends('layouts.app')

@section('title', $category->category_name . ' - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="h-10 w-1.5 bg-blue-600 rounded-full mr-3"></div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $category->category_name }}</h1>
                            <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                {{ $category->category_code }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 ml-4">
                            <span class="font-medium">Full Path:</span> {{ $category->full_path }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('inventory.categories.edit', $category->id) }}"
                            class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Category
                        </a>
                        <form action="{{ route('inventory.categories.destroy', $category->id) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this category?')"
                                class="inline-flex items-center px-4 py-2.5 bg-white border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Delete
                            </button>
                        </form>
                        <a href="{{ route('inventory.categories.index') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Categories
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Category Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Category Details</h2>
                                    <p class="text-sm text-gray-500">Complete information about this category</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Left Column -->
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-3">Basic Information</h3>
                                        <div class="space-y-4">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Category Code</p>
                                                    <p class="text-lg font-bold text-blue-600">
                                                        {{ $category->category_code }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Category Name</p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ $category->category_name }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Parent Category</p>
                                                    @if ($category->parent)
                                                        <a href="{{ route('inventory.categories.show', $category->parent->id) }}"
                                                            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium group">
                                                            {{ $category->parent->category_name }}
                                                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <p class="text-gray-500">Top Level Category</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($category->description)
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-500 mb-3">Description</h3>
                                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                                <p class="text-gray-700">{{ $category->description }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-3">Statistics</h3>
                                        <div class="space-y-4">
                                            <div
                                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Default Tax Rate</p>
                                                        @if ($category->tax_rate_applicable)
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                {{ $category->tax_rate_applicable }}%
                                                            </span>
                                                        @else
                                                            <span class="text-gray-500 text-sm">Not set</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                            <span
                                                                class="text-sm font-bold text-blue-700">{{ $category->products->count() }}</span>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Products</p>
                                                            <p class="text-xs text-gray-500">In this category</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                                            <span
                                                                class="text-sm font-bold text-purple-700">{{ $category->children->count() }}</span>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Subcategories</p>
                                                            <p class="text-xs text-gray-500">Nested categories</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Created</p>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $category->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-green-100 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-lg font-semibold text-gray-900">Products in this Category</h2>
                                        <p class="text-sm text-gray-500">{{ $category->products->count() }} products found
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                                    class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Product
                                </a>
                            </div>
                        </div>

                        <div class="p-6">
                            @if ($category->products->count() > 0)
                                <div class="overflow-x-auto rounded-lg border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Product</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Stock</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            
                                            @foreach ($products as $product)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $product->product_name }}</div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $product->product_code }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $totalStock = $product->inventories->sum(
                                                                'quantity_available',
                                                            );
                                                            $status =
                                                                $totalStock > $product->reorder_level
                                                                    ? 'success'
                                                                    : ($totalStock == 0
                                                                        ? 'danger'
                                                                        : 'warning');
                                                            $statusClass = [
                                                                'success' => 'bg-green-100 text-green-800',
                                                                'warning' => 'bg-yellow-100 text-yellow-800',
                                                                'danger' => 'bg-red-100 text-red-800',
                                                            ][$status];
                                                        @endphp
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                            {{ $totalStock }} units
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('inventory.products.show', $product->id) }}"
                                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                                        <svg class="w-full h-full" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                    <p class="text-gray-500 mb-6">Get started by adding your first product to this
                                        category.</p>
                                    <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                                        class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add First Product
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Subcategories Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900">Subcategories</h3>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $category->children->count() }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            @if ($category->children->count() > 0)
                                <div class="space-y-3">
                                    @foreach ($category->children as $subcategory)
                                        <a href="{{ route('inventory.categories.show', $subcategory->id) }}"
                                            class="group flex items-center justify-between p-3 bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-300 rounded-lg transition-all duration-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                                    <svg class="w-4 h-4 text-purple-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p
                                                        class="text-sm font-medium text-gray-900 group-hover:text-purple-700">
                                                        {{ $subcategory->category_name }}</p>
                                                    <p class="text-xs text-gray-500 group-hover:text-purple-500">
                                                        {{ $subcategory->category_code }}</p>
                                                </div>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white group-hover:bg-purple-100 text-gray-700 group-hover:text-purple-700 border border-gray-300 group-hover:border-purple-300">
                                                {{ $subcategory->products->count() }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="mx-auto h-16 w-16 text-gray-300 mb-3">
                                        <svg class="w-full h-full" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 mb-4">No subcategories created yet</p>
                                </div>
                            @endif

                            <div class="mt-6 pt-5 border-t border-gray-200">
                                <a href="{{ route('inventory.categories.create') }}?parent={{ $category->id }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-purple-300 text-purple-700 bg-white hover:bg-purple-50 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Subcategory
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="space-y-3">
                                <a href="{{ route('inventory.products.create') }}?category={{ $category->id }}"
                                    class="group flex items-center justify-between p-3 bg-white hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 group-hover:text-blue-700">Add
                                                Product</p>
                                            <p class="text-xs text-gray-500 group-hover:text-blue-500">Create new product
                                            </p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('inventory.categories.create') }}?parent={{ $category->id }}"
                                    class="group flex items-center justify-between p-3 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-lg transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-lg bg-green-100 flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 group-hover:text-green-700">Add
                                                Subcategory</p>
                                            <p class="text-xs text-gray-500 group-hover:text-green-500">Create nested
                                                category</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('inventory.products.index') }}?category={{ $category->id }}"
                                    class="group flex items-center justify-between p-3 bg-white hover:bg-indigo-50 border border-gray-200 hover:border-indigo-300 rounded-lg transition-all duration-200">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h7"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-700">View
                                                All Products</p>
                                            <p class="text-xs text-gray-500 group-hover:text-indigo-500">Browse complete
                                                list</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900">System Information</h3>
                            </div>
                        </div>

                        <div class="p-5">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Created</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Last Updated</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">{{ $category->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="text-xs text-gray-500">
                                        <p>Category ID: <span class="font-medium">{{ $category->id }}</span></p>
                                        <p class="mt-1">Changes to this category affect all associated products and
                                            subcategories.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Confirm delete with better UI
            document.querySelectorAll('form[method="DELETE"] button[type="submit"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('form');
                    const modal = document.createElement('div');
                    modal.className =
                        'fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4';
                    modal.innerHTML = `
                <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100 mr-3">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Delete Category</h3>
                            <p class="text-sm text-gray-500">This action cannot be undone</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">
                        Are you sure you want to delete <span class="font-semibold">"{{ $category->category_name }}"</span>?
                        This will also affect <span class="font-semibold">{{ $category->products->count() }} products</span>
                        and <span class="font-semibold">{{ $category->children->count() }} subcategories</span>.
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="this.closest('.fixed').remove()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="button" onclick="form.submit()"
                                class="px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            Delete Category
                        </button>
                    </div>
                </div>
            `;

                    document.body.appendChild(modal);
                });
            });
        </script>
    @endpush
@endsection
