@extends('layouts.admin')

@section('title', 'Categories - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Product Categories</h1>
                                <p class="text-gray-600 mt-1">Organize and manage your product categories</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('inventory.categories.create') }}"
                        class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Category
                    </a>
                </div>
            </div>

            <!-- Search Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Search Categories</h2>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('inventory.categories.index') }}" method="GET">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                        class="pl-10 w-full border border-gray-300 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        name="search" placeholder="Search by category code or name..."
                                        value="{{ $search }}">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                <a href="{{ route('inventory.categories.index') }}"
                                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">All Categories</h2>
                        </div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-semibold rounded-full">
                            {{ $categories->total() }} Categories
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if ($categories->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Category Code
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Category Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-48">
                                            Parent Category
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                            Tax Rate
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                            Products
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-36">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($categories as $category)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-indigo-700">
                                                    {{ $category->category_code }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $category->category_name }}</div>
                                                @if ($category->description)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ Str::limit($category->description, 60) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($category->parent)
                                                    <div class="flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-gradient-to-r from-blue-100 to-blue-200 rounded-full flex items-center justify-center mr-2">
                                                            <svg class="w-4 h-4 text-blue-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                            {{ $category->parent->category_name }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span
                                                        class="px-2.5 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                                        Parent Category
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($category->tax_rate_applicable)
                                                    <div class="flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-full flex items-center justify-center mr-2">
                                                            <span class="text-emerald-700 font-bold text-sm">%</span>
                                                        </div>
                                                        <span
                                                            class="px-2.5 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800 rounded-full">
                                                            {{ $category->tax_rate_applicable }}%
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500">N/A</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-gradient-to-r from-purple-100 to-purple-200 rounded-full flex items-center justify-center mr-2">
                                                        <svg class="w-4 h-4 text-purple-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                        </svg>
                                                    </div>
                                                    <span
                                                        class="px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 rounded-full">
                                                        {{ $category->products_count ?? $category->products->count() }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('inventory.categories.show', $category->id) }}"
                                                        class="inline-flex items-center p-2 text-gray-500 hover:text-blue-600 bg-gray-100 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                        title="View">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('inventory.categories.edit', $category->id) }}"
                                                        class="inline-flex items-center p-2 text-gray-500 hover:text-indigo-600 bg-gray-100 hover:bg-indigo-50 rounded-lg transition-colors duration-200"
                                                        title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form
                                                        action="{{ route('inventory.categories.destroy', $category->id) }}"
                                                        method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center p-2 text-gray-500 hover:text-red-600 bg-gray-100 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            onclick="return confirm('Are you sure you want to delete this category?')"
                                                            title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $categories->links('vendor.pagination.tailwind') }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div
                                class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Categories Found</h3>
                            <p class="text-gray-600 mb-6">Get started by organizing your products into categories.</p>
                            <a href="{{ route('inventory.categories.create') }}"
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Create First Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            @if ($categories->count() > 0)
                <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div
                        class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</div>
                                <div class="text-sm text-gray-600">Total Categories</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $categories->where('parent_id', null)->count() }}
                                </div>
                                <div class="text-sm text-gray-600">Parent Categories</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg border border-purple-100 p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <div>
                                @php
                                    $totalProducts = 0;
                                    foreach ($categories as $category) {
                                        $totalProducts += $category->products_count ?? $category->products->count();
                                    }
                                @endphp
                                <div class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</div>
                                <div class="text-sm text-gray-600">Total Products</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 p-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                @php
                                    $categoriesWithTax = $categories->where('tax_rate_applicable', '>', 0);
                                @endphp
                                <div class="text-2xl font-bold text-gray-900">{{ $categoriesWithTax->count() }}</div>
                                <div class="text-sm text-gray-600">Taxable Categories</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Custom scrollbar -->
    <style>
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Action button hover effects */
        .bg-gray-100 {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        .bg-blue-100 {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        }

        .bg-emerald-100 {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }

        .bg-purple-100 {
            background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
        }

        .bg-indigo-100 {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        }

        .bg-red-100 {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }

        .hover\:bg-blue-50:hover {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }

        .hover\:bg-indigo-50:hover {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        }

        .hover\:bg-red-50:hover {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }
    </style>
@endsection
