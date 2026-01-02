@extends('layouts.admin')

@section('title', 'Create Category - Asia Enterprise')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Create New Category</h1>
                    <p class="mt-2 text-sm text-gray-600">Add a new product category to organize your inventory</p>
                </div>
                <div>
                    <a href="{{ route('inventory.categories.index') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Categories
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-gray-900">Category Information</h2>
                                <p class="text-sm text-gray-500">Fill in the details for the new category</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('inventory.categories.store') }}" method="POST" class="p-6 space-y-6">
                        @csrf

                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-base font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Category Code -->
                                <div>
                                    <label for="category_code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Category Code <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text"
                                               id="category_code"
                                               name="category_code"
                                               value="{{ old('category_code') }}"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('category_code') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="e.g., ELEC, CLOTH, FOOD"
                                               required>
                                        @error('category_code')
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Unique code for the category</p>
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
                                        <input type="text"
                                               id="category_name"
                                               name="category_name"
                                               value="{{ old('category_name') }}"
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('category_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                               placeholder="e.g., Electronics, Clothing"
                                               required>
                                        @error('category_name')
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('category_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Parent Category & Tax Rate -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Parent Category -->
                            <div>
                                <label for="parent_category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Parent Category
                                </label>
                                <div class="relative">
                                    <select id="parent_category_id"
                                            name="parent_category_id"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('parent_category_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                        <option value="">-- Select Parent Category --</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_category_id') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->category_name }} ({{ $parent->category_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Leave empty for main category</p>
                                @error('parent_category_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tax Rate -->
                            <div>
                                <label for="tax_rate_applicable" class="block text-sm font-medium text-gray-700 mb-2">
                                    Default Tax Rate
                                </label>
                                <div class="relative">
                                    <select id="tax_rate_applicable"
                                            name="tax_rate_applicable"
                                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('tax_rate_applicable') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                                        <option value="">-- Select Tax Rate --</option>
                                        <option value="0" {{ old('tax_rate_applicable') == 0 ? 'selected' : '' }}>0% (Exempt)</option>
                                        <option value="5" {{ old('tax_rate_applicable') == 5 ? 'selected' : '' }}>5%</option>
                                        <option value="12" {{ old('tax_rate_applicable') == 12 ? 'selected' : '' }}>12%</option>
                                        <option value="18" {{ old('tax_rate_applicable') == 18 ? 'selected' : '' }}>18%</option>
                                        <option value="28" {{ old('tax_rate_applicable') == 28 ? 'selected' : '' }}>28%</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Default GST rate for products in this category</p>
                                @error('tax_rate_applicable')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('description') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                      placeholder="Describe this category...">{{ old('description') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">Optional description for the category</p>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-end gap-3">
                                <a href="{{ route('inventory.categories.index') }}"
                                   class="inline-flex justify-center items-center px-5 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="inline-flex justify-center items-center px-5 py-3 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="lg:col-span-1">
                <!-- Hierarchy Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="px-5 py-4 border-b border-gray-200 bg-blue-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Category Hierarchy Guide
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Flat Structure</h4>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <ul class="space-y-2 text-sm text-gray-700">
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Electronics</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Clothing</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Furniture</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Hierarchical Structure</h4>
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                    <ul class="space-y-2 text-sm text-gray-700">
                                        <li class="flex items-start">
                                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Electronics (Parent)</span>
                                        </li>
                                        <li class="flex items-start ml-4">
                                            <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Mobile Phones (Child)</span>
                                        </li>
                                        <li class="flex items-start ml-8">
                                            <span class="inline-block w-2 h-2 bg-blue-300 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Smartphones (Sub-child)</span>
                                        </li>
                                        <li class="flex items-start ml-8">
                                            <span class="inline-block w-2 h-2 bg-blue-300 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Feature Phones (Sub-child)</span>
                                        </li>
                                        <li class="flex items-start ml-4">
                                            <span class="inline-block w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                                            <span>Laptops (Child)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Tip:</span> Use hierarchical structures for better Company of related products.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips Card -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-blue-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Quick Tips
                        </h3>
                    </div>
                    <div class="p-5">
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-blue-800">1</span>
                                </span>
                                <p class="text-sm text-gray-700">Keep category codes short and memorable (max 4-5 characters)</p>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-blue-800">2</span>
                                </span>
                                <p class="text-sm text-gray-700">Use parent categories to create logical hierarchies</p>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-blue-800">3</span>
                                </span>
                                <p class="text-sm text-gray-700">Set appropriate tax rates to simplify product setup</p>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-blue-800">4</span>
                                </span>
                                <p class="text-sm text-gray-700">Clear descriptions help other team members understand category purpose</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate category code from name
    document.getElementById('category_name').addEventListener('blur', function() {
        const nameInput = this;
        const codeInput = document.getElementById('category_code');

        // Only generate code if code field is empty
        if (codeInput.value.trim() === '' && nameInput.value.trim() !== '') {
            const categoryName = nameInput.value.trim();
            const words = categoryName.split(' ');
            let code = '';

            if (words.length === 1) {
                code = words[0].substring(0, 4).toUpperCase();
            } else {
                code = words.map(word => word.charAt(0)).join('').toUpperCase();
            }

            // Add numbers if needed to make it unique
            if (code.length > 4) {
                code = code.substring(0, 4);
            }

            codeInput.value = code;

            // Add visual feedback
            codeInput.classList.add('border-blue-300', 'bg-blue-50');
            setTimeout(() => {
                codeInput.classList.remove('border-blue-300', 'bg-blue-50');
            }, 1000);
        }
    });

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
</script>
@endpush
