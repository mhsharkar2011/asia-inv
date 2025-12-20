@extends('layouts.app')

@section('title', 'Edit Category - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="h-8 w-1 bg-blue-600 rounded-full mr-3"></div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit Category</h1>
                        </div>
                        <p class="text-sm text-gray-600 ml-4">Update details for {{ $category->category_name }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('inventory.categories.show', $category->id) }}"
                            class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            View Category
                        </a>
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
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Edit Form Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Edit Category Information</h2>
                                    <p class="text-sm text-gray-500">Update the category details below</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('inventory.categories.update', $category->id) }}" method="POST"
                            class="p-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-base font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Basic
                                        Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Category Code -->
                                        <div>
                                            <label for="category_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                Category Code <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <input type="text" id="category_code" name="category_code"
                                                    value="{{ old('category_code', $category->category_code) }}"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('category_code') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                                    placeholder="e.g., ELEC, CLOTH, FOOD" required>
                                                @error('category_code')
                                                    <div
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-red-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @enderror
                                            </div>
                                            @error('category_code')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Category Name -->
                                        <div>
                                            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                Category Name <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <input type="text" id="category_name" name="category_name"
                                                    value="{{ old('category_name', $category->category_name) }}"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('category_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                                    placeholder="e.g., Electronics, Clothing" required>
                                                @error('category_name')
                                                    <div
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                        <svg class="h-5 w-5 text-red-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @enderror
                                            </div>
                                            @error('category_name')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Parent Category -->
                                    <div class="mt-6">
                                        <label for="parent_category_id"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Parent Category
                                        </label>
                                        <div class="relative">
                                            <select id="parent_category_id" name="parent_category_id"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('parent_category_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                                <option value="">-- Select Parent Category --</option>
                                                @foreach ($parentCategories as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ old('parent_category_id', $category->parent_category_id) == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->category_name }} ({{ $parent->category_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">Leave empty for main category</p>
                                        @error('parent_category_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tax Rate -->
                                <div>
                                    <h3 class="text-base font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Tax
                                        & Description</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Tax Rate -->
                                        <div>
                                            <label for="tax_rate_applicable"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Default Tax Rate
                                            </label>
                                            <div class="relative">
                                                <select id="tax_rate_applicable" name="tax_rate_applicable"
                                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('tax_rate_applicable') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                                    <option value="">-- Select Tax Rate --</option>
                                                    <option value="0"
                                                        {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 0 ? 'selected' : '' }}>
                                                        0% (Exempt)</option>
                                                    <option value="5"
                                                        {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 5 ? 'selected' : '' }}>
                                                        5%</option>
                                                    <option value="12"
                                                        {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 12 ? 'selected' : '' }}>
                                                        12%</option>
                                                    <option value="18"
                                                        {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 18 ? 'selected' : '' }}>
                                                        18%</option>
                                                    <option value="28"
                                                        {{ old('tax_rate_applicable', $category->tax_rate_applicable) == 28 ? 'selected' : '' }}>
                                                        28%</option>
                                                </select>
                                                <div
                                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">Default GST rate for products</p>
                                            @error('tax_rate_applicable')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="md:col-span-2">
                                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                                Description
                                            </label>
                                            <textarea id="description" name="description" rows="4"
                                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                                placeholder="Describe this category...">{{ old('description', $category->description) }}</textarea>
                                            <p class="mt-2 text-sm text-gray-500">Optional description for the category</p>
                                            @error('description')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="pt-6 border-t border-gray-200">
                                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                                        <a href="{{ route('inventory.categories.show', $category->id) }}"
                                            class="inline-flex justify-center items-center px-5 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="inline-flex justify-center items-center px-5 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                                </path>
                                            </svg>
                                            Update Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Current Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Current Information</h2>
                                    <p class="text-sm text-gray-500">Details about this category</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Category Path</h3>
                                        <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100">
                                            <svg class="w-5 h-5 text-blue-500 mr-2 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $category->full_path }}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Subcategories</h3>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                            <div
                                                class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                <span
                                                    class="text-sm font-bold text-blue-700">{{ $category->children->count() }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $category->children->count() }}
                                                    subcategories</span>
                                                @if ($category->children->count() > 0)
                                                    <p class="text-xs text-gray-500 mt-1">Changes may affect subcategories
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Products in Category</h3>
                                        <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100">
                                            <div
                                                class="h-9 w-9 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <span
                                                    class="text-sm font-bold text-green-700">{{ $category->products->count() }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-sm font-medium text-gray-900">{{ $category->products->count() }}
                                                    products</span>
                                                @if ($category->products->count() > 0)
                                                    <p class="text-xs text-gray-500 mt-1">Tax rate changes apply to all
                                                        products</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 mb-1">Created</h3>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                            <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Impact Alert -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Update Impact</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Changes to this category will affect:</p>
                                    <ul class="mt-1 list-disc list-inside space-y-1">
                                        <li>All products in this category</li>
                                        <li>Product tax calculations</li>
                                        <li>Reporting and analytics</li>
                                        <li>Inventory organization</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Category Statistics</h3>
                        </div>
                        <div class="p-5">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Current Tax Rate:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->tax_rate_applicable == 0 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $category->tax_rate_applicable ?? 0 }}%
                                    </span>
                                </div>

                                <div class="pt-3 border-t border-gray-100">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Last Updated:</h4>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $category->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Related Actions</h3>
                        </div>
                        <div class="p-5">
                            <div class="space-y-3">
                                <a href="{{ route('inventory.categories.show', $category->id) }}"
                                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">View Category</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                @if ($category->children->count() > 0)
                                    <a href="#"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors duration-200">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">View Subcategories</span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif

                                @if ($category->products->count() > 0)
                                    <a href="#"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors duration-200">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">View Products</span>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form validation and feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-300', 'bg-red-50');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-300', 'bg-red-50');
                }
            });

            if (!isValid) {
                e.preventDefault();

                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center';
                errorDiv.innerHTML = `
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span class="text-red-800 font-medium">Please fill in all required fields marked with *</span>
            `;

                const form = document.querySelector('form');
                form.insertBefore(errorDiv, form.firstChild);

                // Scroll to error
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        // Show field edit status
        const originalValues = {
            category_code: "{{ old('category_code', $category->category_code) }}",
            category_name: "{{ old('category_name', $category->category_name) }}",
            tax_rate_applicable: "{{ old('tax_rate_applicable', $category->tax_rate_applicable) }}",
            description: "{{ old('description', $category->description) }}"
        };

        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const currentValue = this.value;
                const originalValue = originalValues[this.name] || '';

                if (currentValue !== originalValue) {
                    this.classList.add('border-yellow-300', 'bg-yellow-50');
                } else {
                    this.classList.remove('border-yellow-300', 'bg-yellow-50');
                }
            });
        });
    </script>
@endpush
