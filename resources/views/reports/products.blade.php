@extends('layouts.admin')

@section('title', 'Product Report - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Product Inventory Report</h1>
                                <p class="text-gray-600 mt-1">Comprehensive stock analysis and inventory insights</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2.5 border border-blue-200 text-blue-700 font-medium rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Report
                        </button>
                        <a href="{{ route('reports.index') }}"
                            class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventory KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Products Card -->
                <div
                    class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">TOTAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total Products</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">{{ $products->count() }}</span>
                            <span class="ml-2 text-sm text-gray-600">unique items</span>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products Card -->
                <div
                    class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.196 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-amber-600 bg-amber-100 px-3 py-1 rounded-full">ALERT</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Low Stock</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">{{ $lowStockProducts->count() }}</span>
                            <span class="ml-2 text-sm text-gray-600">need reordering</span>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock Card -->
                <div
                    class="bg-gradient-to-br from-white to-red-50 rounded-2xl shadow-lg border border-red-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-red-500 to-red-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">CRITICAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Out of Stock</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                {{ $products->where('stock_quantity', '<=', 0)->count() }}
                            </span>
                            <span class="ml-2 text-sm text-gray-600">urgent restock</span>
                        </div>
                    </div>
                </div>

                <!-- In Stock Value Card -->
                <div
                    class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">VALUE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Inventory Value</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT
                                {{ number_format(
                                    $products->sum(function ($product) {
                                        return $product->stock_quantity * $product->cost_price;
                                    }),
                                    2,
                                ) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Products Table -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Product Inventory</h2>
                                </div>
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">{{ $products->count() }}
                                    Products</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($products->count() > 0)
                                <div class="overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-12">
                                                    #
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Product
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                    Category
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                    Stock
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                    Cost Price
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                    Selling Price
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                    Stock Value
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($products as $index => $product)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div>
                                                            <div class="text-sm font-semibold text-gray-900">
                                                                {{ $product->product_code }}
                                                            </div>
                                                            <div class="text-sm text-gray-600">{{ $product->product_name }}
                                                            </div>
                                                            <div class="text-xs text-gray-400 mt-1">
                                                                Reorder: {{ $product->reorder_level }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            {{ $product->category->category_name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($product->stock_quantity <= 0)
                                                            <span
                                                                class="px-3 py-1 text-sm font-semibold bg-red-100 text-red-800 rounded-full">
                                                                {{ $product->stock_quantity }}
                                                            </span>
                                                        @elseif($product->stock_quantity <= $product->reorder_level)
                                                            <span
                                                                class="px-3 py-1 text-sm font-semibold bg-amber-100 text-amber-800 rounded-full">
                                                                {{ $product->stock_quantity }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-3 py-1 text-sm font-semibold bg-emerald-100 text-emerald-800 rounded-full">
                                                                {{ $product->stock_quantity }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        BDT {{ number_format($product->cost_price, 2) }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        BDT {{ number_format($product->selling_price, 2) }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                        BDT
                                                        {{ number_format($product->stock_quantity * $product->cost_price, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($product->is_active == '1')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                                Active
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                                <td colspan="6"
                                                    class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">
                                                    Total Stock Value:
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT
                                                    {{ number_format(
                                                        $products->sum(function ($product) {
                                                            return $product->stock_quantity * $product->cost_price;
                                                        }),
                                                        2,
                                                    ) }}
                                                </td>
                                                <td class="px-6 py-4"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div
                                        class="mx-auto w-20 h-20 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Products Found</h3>
                                    <p class="text-gray-600">No product data available in inventory.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Alerts & Analytics -->
                <div class="space-y-8">
                    <!-- Low Stock Products -->
                    <div class="bg-white rounded-2xl shadow-lg border border-amber-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-amber-200 bg-gradient-to-r from-amber-50 to-amber-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-amber-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.196 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Low Stock Alerts</h2>
                                </div>
                                <span
                                    class="px-3 py-1 bg-amber-100 text-amber-800 text-sm font-semibold rounded-full">{{ $lowStockProducts->count() }}
                                    Products</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($lowStockProducts->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($lowStockProducts->take(8) as $product)
                                        <a href="{{ route('inventory.products.edit', $product->id) }}"
                                            class="group block p-3 bg-gradient-to-r from-amber-50 to-amber-100 hover:from-amber-100 hover:to-amber-200 border border-amber-200 rounded-xl transition-all duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-gradient-to-r from-amber-100 to-amber-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                                        <svg class="w-4 h-4 text-amber-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.196 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $product->product_code }}
                                                        </div>
                                                        <div class="text-xs text-gray-600 truncate max-w-[180px]">
                                                            {{ $product->product_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-bold text-amber-700">
                                                        {{ $product->stock_quantity }}
                                                        <span
                                                            class="text-xs text-amber-600">/{{ $product->reorder_level }}</span>
                                                    </div>
                                                    <div class="text-xs text-amber-600">
                                                        Deficit:
                                                        {{ max(0, $product->reorder_level - $product->stock_quantity) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between">
                                                <span
                                                    class="text-xs text-gray-500">{{ $product->category->category_name ?? 'N/A' }}</span>
                                                <span
                                                    class="text-xs font-medium text-amber-600 group-hover:text-amber-700 flex items-center">
                                                    Update Stock
                                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                    @if ($lowStockProducts->count() > 8)
                                        <div class="text-center pt-2">
                                            <span class="text-sm text-amber-600">
                                                +{{ $lowStockProducts->count() - 8 }} more products need attention
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div
                                        class="mx-auto w-16 h-16 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-emerald-700 mb-1">Stock Level Optimal</h4>
                                    <p class="text-gray-600">All products have sufficient stock levels.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Distribution -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Stock Distribution</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            @php
                                $inStockCount = $products->where('stock_quantity', '>', 0)->count();
                                $lowStockCount = $lowStockProducts->count();
                                $outOfStockCount = $products->where('stock_quantity', '<=', 0)->count();
                                $inactiveCount = $products->where('status', 'inactive')->count();
                                $totalCount = $products->count();
                            @endphp

                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="bg-gradient-to-br from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border border-emerald-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $inStockCount }}</div>
                                        <div class="text-sm text-gray-600">In Stock</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-emerald-600 mt-1">
                                                {{ round(($inStockCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-amber-50 to-amber-100 hover:from-amber-100 hover:to-amber-200 border border-amber-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $lowStockCount }}</div>
                                        <div class="text-sm text-gray-600">Low Stock</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-amber-600 mt-1">
                                                {{ round(($lowStockCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 border border-red-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $outOfStockCount }}</div>
                                        <div class="text-sm text-gray-600">Out of Stock</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-red-600 mt-1">
                                                {{ round(($outOfStockCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border border-gray-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $inactiveCount }}</div>
                                        <div class="text-sm text-gray-600">Inactive</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-gray-600 mt-1">
                                                {{ round(($inactiveCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Products by Value -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Top Products by Value
                        </h3>
                        <div class="space-y-3">
                            @php
                                $topProducts = $products
                                    ->sortByDesc(function ($product) {
                                        return $product->stock_quantity * $product->cost_price;
                                    })
                                    ->take(5);
                            @endphp

                            @if ($topProducts->count() > 0)
                                @foreach ($topProducts as $index => $product)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-gray-100 hover:to-gray-200 transition-all duration-200 group">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                                <span class="text-blue-700 font-bold text-sm">{{ $index + 1 }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $product->product_code }}</div>
                                                <div class="text-xs text-gray-500 truncate max-w-[140px]">
                                                    {{ $product->product_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-bold text-blue-700">
                                                BDT {{ number_format($product->stock_quantity * $product->cost_price, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $product->stock_quantity }} units
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <p class="text-gray-500 text-sm">No product data available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div
                class="mt-8 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-2xl shadow-lg border border-emerald-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Inventory Summary Statistics
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-4 border border-emerald-200">
                        <div class="text-sm text-gray-600 mb-1">Average Cost Price</div>
                        <div class="text-xl font-bold text-emerald-700">
                            BDT {{ number_format($products->avg('cost_price') ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-emerald-200">
                        <div class="text-sm text-gray-600 mb-1">Average Selling Price</div>
                        <div class="text-xl font-bold text-emerald-700">
                            BDT {{ number_format($products->avg('selling_price') ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-emerald-200">
                        <div class="text-sm text-gray-600 mb-1">Average Stock Level</div>
                        <div class="text-xl font-bold text-emerald-700">
                            {{ number_format($products->avg('stock_quantity') ?? 0, 1) }} units
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 border border-emerald-200">
                        <div class="text-sm text-gray-600 mb-1">Average Margin</div>
                        <div class="text-xl font-bold text-emerald-700">
                            {{ number_format(((($products->avg('selling_price') ?? 0) - ($products->avg('cost_price') ?? 0)) / max($products->avg('cost_price') ?? 1, 1)) * 100, 1) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .bg-gradient-to-br,
            .bg-gradient-to-r,
            .bg-gradient-to-b {
                background: white !important;
            }

            .shadow-lg,
            .shadow-sm,
            .shadow-xl {
                box-shadow: none !important;
            }

            .rounded-2xl,
            .rounded-xl,
            .rounded-lg {
                border-radius: 0.25rem !important;
            }

            .grid {
                display: block !important;
            }

            .lg\:col-span-2,
            .lg\:col-span-3 {
                width: 100% !important;
                margin-bottom: 1rem !important;
            }

            .space-y-8 {
                margin-top: 1rem !important;
            }

            .hover\:shadow-xl {
                box-shadow: none !important;
            }

            .border-blue-100,
            .border-amber-100,
            .border-red-100,
            .border-emerald-100,
            .border-gray-200 {
                border-color: #e5e7eb !important;
            }

            .bg-blue-50,
            .bg-amber-50,
            .bg-red-50,
            .bg-emerald-50,
            .bg-purple-50,
            .bg-gray-50 {
                background: #f9fafb !important;
            }

            table {
                font-size: 0.875rem !important;
                width: 100% !important;
            }

            .overflow-x-auto {
                overflow: visible !important;
            }

            .text-blue-600,
            .text-amber-600,
            .text-red-600,
            .text-emerald-600,
            .text-purple-600 {
                color: black !important;
            }

            .bg-blue-100,
            .bg-amber-100,
            .bg-red-100,
            .bg-emerald-100,
            .bg-purple-100 {
                background: #f9fafb !important;
                border: 1px solid #e5e7eb !important;
            }
        }

        /* Custom scrollbar */
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

        /* Stock level color coding */
        .bg-red-100 {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        }

        .bg-amber-100 {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }

        .bg-emerald-100 {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }
    </style>
@endsection
