@extends('layouts.admin')

@section('title', 'Reports Dashboard')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl mr-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Reports Dashboard</h1>
                                <p class="text-gray-600 mt-1">Generate and analyze business insights</p>
                            </div>
                        </div>
                    </div>
                    <button onclick="openQuickReportModal()"
                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Quick Report
                    </button>
                </div>
            </div>

            <!-- Report Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Sales Report Card -->
                <div
                    class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">REVENUE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sales Analytics</h3>
                        <p class="text-gray-600 text-sm mb-6">Detailed revenue analysis and sales performance metrics</p>
                        <a href="{{ route('reports.sales') }}"
                            class="inline-flex items-center text-blue-600 font-medium hover:text-blue-700 group-hover:translate-x-1 transition-transform duration-300">
                            View Report
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Customer Report Card -->
                <div
                    class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1.205a21.037 21.037 0 01-3.566 2.939M15.5 3.205A21.037 21.037 0 0118.966 6M15.5 3.205c-1.23-.617-2.57-.967-3.966-.967a10.458 10.458 0 00-3.966.967m11.5 0a21.037 21.037 0 00-3.566-2.939M15.5 3.205a21.038 21.038 0 013.566-2.939M4.5 3.205c1.23-.617 2.57-.967 3.966-.967a10.458 10.458 0 013.966.967" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2.5 py-1 rounded-full">CLIENTS</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Customer Insights</h3>
                        <p class="text-gray-600 text-sm mb-6">Customer behavior, demographics, and lifetime value</p>
                        <a href="{{ route('reports.customers') }}"
                            class="inline-flex items-center text-emerald-600 font-medium hover:text-emerald-700 group-hover:translate-x-1 transition-transform duration-300">
                            View Report
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product Report Card -->
                <div
                    class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">INVENTORY</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Product Performance</h3>
                        <p class="text-gray-600 text-sm mb-6">Stock analysis, best sellers, and inventory metrics</p>
                        <a href="{{ route('reports.products') }}"
                            class="inline-flex items-center text-purple-600 font-medium hover:text-purple-700 group-hover:translate-x-1 transition-transform duration-300">
                            View Report
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Tax Report Card -->
                <div
                    class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-amber-600 bg-amber-100 px-2.5 py-1 rounded-full">COMPLIANCE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">GST/Tax Analysis</h3>
                        <p class="text-gray-600 text-sm mb-6">Tax collection, compliance, and filing reports</p>
                        <a href="{{ route('reports.tax') }}"
                            class="inline-flex items-center text-amber-600 font-medium hover:text-amber-700 group-hover:translate-x-1 transition-transform duration-300">
                            View Report
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Quick Reports Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Quick Reports Generator</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Sales Report Form -->
                            <div
                                class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 mb-6 border border-blue-100">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Sales Report
                                </h3>
                                <form action="{{ route('reports.sales') }}" method="GET">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <input type="date" name="start_date"
                                                    class="pl-10 w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    value="{{ date('Y-m-01') }}">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <input type="date" name="end_date"
                                                    class="pl-10 w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    value="{{ date('Y-m-t') }}">
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            <button type="submit"
                                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium py-2.5 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Generate
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Quick Action Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Today's Summary -->
                                <a href="{{ route('reports.sales') }}?start_date={{ date('Y-m-d') }}&end_date={{ date('Y-m-d') }}"
                                    class="group bg-gradient-to-r from-gray-50 to-gray-100 hover:from-blue-50 hover:to-blue-100 border border-gray-200 hover:border-blue-200 rounded-xl p-5 transition-all duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="p-2 bg-blue-100 group-hover:bg-blue-200 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">NOW</span>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-900 mb-2">Today's Sales</h4>
                                    <p class="text-sm text-gray-600 mb-3">Real-time sales data for today</p>
                                    <div
                                        class="inline-flex items-center text-blue-600 font-medium text-sm group-hover:translate-x-1 transition-transform duration-200">
                                        View Report
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                </a>

                                <!-- This Month -->
                                <a href="{{ route('reports.sales') }}?start_date={{ date('Y-m-01') }}&end_date={{ date('Y-m-t') }}"
                                    class="group bg-gradient-to-r from-gray-50 to-gray-100 hover:from-emerald-50 hover:to-emerald-100 border border-gray-200 hover:border-emerald-200 rounded-xl p-5 transition-all duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="p-2 bg-emerald-100 group-hover:bg-emerald-200 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">MONTHLY</span>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-900 mb-2">Monthly Report</h4>
                                    <p class="text-sm text-gray-600 mb-3">Complete monthly performance analysis</p>
                                    <div
                                        class="inline-flex items-center text-emerald-600 font-medium text-sm group-hover:translate-x-1 transition-transform duration-200">
                                        View Report
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export & Tools Sidebar -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Export Options</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-6">Download reports in your preferred format for analysis and
                                sharing
                            </p>

                            <div class="space-y-3">
                                <!-- Excel Export -->
                                <button
                                    class="w-full group flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border border-emerald-200 rounded-xl transition-all duration-200"
                                    disabled>
                                    <div class="flex items-center">
                                        <div
                                            class="p-2 bg-emerald-100 group-hover:bg-emerald-200 rounded-lg mr-4 transition-colors duration-200">
                                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h4 class="font-semibold text-gray-900">Excel Export</h4>
                                            <p class="text-sm text-gray-600">.xlsx format</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-semibold text-emerald-600 bg-white px-2 py-1 rounded-full border border-emerald-200">Soon</span>
                                </button>

                                <!-- PDF Export -->
                                <button
                                    class="w-full group flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 border border-red-200 rounded-xl transition-all duration-200"
                                    disabled>
                                    <div class="flex items-center">
                                        <div
                                            class="p-2 bg-red-100 group-hover:bg-red-200 rounded-lg mr-4 transition-colors duration-200">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h4 class="font-semibold text-gray-900">PDF Export</h4>
                                            <p class="text-sm text-gray-600">Print-ready format</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-semibold text-red-600 bg-white px-2 py-1 rounded-full border border-red-200">Soon</span>
                                </button>

                                <!-- CSV Export -->
                                <button
                                    class="w-full group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 border border-gray-200 rounded-xl transition-all duration-200"
                                    disabled>
                                    <div class="flex items-center">
                                        <div
                                            class="p-2 bg-gray-100 group-hover:bg-gray-200 rounded-lg mr-4 transition-colors duration-200">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <h4 class="font-semibold text-gray-900">CSV Export</h4>
                                            <p class="text-sm text-gray-600">Data analysis format</p>
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-semibold text-gray-600 bg-white px-2 py-1 rounded-full border border-gray-200">Soon</span>
                                </button>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-blue-700">
                                        Export features require additional packages to be installed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Report Modal -->
    <div id="quickReportModal"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 overflow-y-auto transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0"
                id="modalContent">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-xl font-bold text-white">Quick Report Generator</h3>
                        </div>
                        <button onclick="closeQuickReportModal()"
                            class="text-white hover:text-gray-200 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="quickReportForm">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <select name="report_type"
                                        class="pl-10 w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="sales">Sales Report</option>
                                        <option value="customers">Customer Report</option>
                                        <option value="products">Product Report</option>
                                        <option value="tax">Tax Report</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="date" name="start_date"
                                        class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        value="{{ date('Y-m-01') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="date" name="end_date"
                                        class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        value="{{ date('Y-m-t') }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                                <select name="format"
                                    class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="view">View in Browser</option>
                                    <option value="pdf" disabled>PDF (Coming Soon)</option>
                                    <option value="excel" disabled>Excel (Coming Soon)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeQuickReportModal()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="button" onclick="generateQuickReport()"
                            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openQuickReportModal() {
            const modal = document.getElementById('quickReportModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeQuickReportModal() {
            const modal = document.getElementById('quickReportModal');
            const modalContent = document.getElementById('modalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);

            document.body.style.overflow = 'auto';
        }

        function generateQuickReport() {
            const form = document.getElementById('quickReportForm');
            const formData = new FormData(form);
            const reportType = formData.get('report_type');
            const format = formData.get('format');
            const startDate = formData.get('start_date');
            const endDate = formData.get('end_date');

            // Close modal
            closeQuickReportModal();

            // Redirect based on report type
            let url = '';
            switch (reportType) {
                case 'sales':
                    url = '{{ route('reports.sales') }}';
                    break;
                case 'customers':
                    url = '{{ route('reports.customers') }}';
                    break;
                case 'products':
                    url = '{{ route('reports.products') }}';
                    break;
                case 'tax':
                    url = '{{ route('reports.tax') }}';
                    break;
            }

            // Add query parameters
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }

            // Redirect to report
            window.location.href = url;
        }

        // Close modal when clicking outside
        document.getElementById('quickReportModal').addEventListener('click', function(e) {
            if (e.target.id === 'quickReportModal') {
                closeQuickReportModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuickReportModal();
            }
        });
    </script>
@endpush
