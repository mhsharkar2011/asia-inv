@extends('layouts.app')

@section('title', 'Customer Report - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Customer Analytics</h1>
                                <p class="text-gray-600 mt-1">Comprehensive customer insights and performance metrics</p>
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

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Customers Card -->
                <div
                    class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">TOTAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total Customers</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">{{ $customers->count() }}</span>
                            <span class="ml-2 text-sm text-gray-600">registered customers</span>
                        </div>
                    </div>
                </div>

                <!-- Total Invoice Amount Card -->
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
                                class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">REVENUE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Invoice Revenue</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT {{ number_format($customers->sum('total_invoice_amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Order Amount Card -->
                <div
                    class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">ORDERS</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Order Value</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT {{ number_format($customers->sum('total_order_amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Active Customers Card -->
                <div
                    class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-amber-600 bg-amber-100 px-3 py-1 rounded-full">ACTIVE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Active Customers</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                {{ $customers->where('status', 'active')->count() }}
                            </span>
                            <span class="ml-2 text-sm text-gray-600">
                                ({{ round(($customers->where('status', 'active')->count() / max($customers->count(), 1)) * 100, 1) }}%)
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Customers Table -->
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
                                    <h2 class="text-xl font-bold text-gray-900">Customer Details</h2>
                                </div>
                                <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">{{ $customers->count() }}
                                    Customers</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($customers->count() > 0)
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
                                                    Customer
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                    Type
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                    Invoices
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-36">
                                                    Invoice Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-36">
                                                    Order Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($customers as $index => $customer)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                                                <span class="text-blue-600 font-semibold">
                                                                    {{ substr($customer->name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $customer->name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">{{ $customer->email }}
                                                                </div>
                                                                <div class="text-xs text-gray-400 mt-1">
                                                                    {{ $customer->phone }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            {{ ucfirst($customer->customer_type) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-center">
                                                            <span
                                                                class="px-3 py-1 text-sm font-medium bg-blue-50 text-blue-700 rounded-full">
                                                                {{ $customer->invoices_count }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        BDT {{ number_format($customer->total_invoice_amount ?? 0, 2) }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        BDT {{ number_format($customer->total_order_amount ?? 0, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($customer->status == 'active')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                                Active
                                                            </span>
                                                        @elseif($customer->status == 'inactive')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                Inactive
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                {{ ucfirst($customer->status) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('sales.customers.show', $customer->id) }}"
                                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                                <td colspan="3"
                                                    class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">
                                                    Totals:
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span
                                                        class="px-3 py-1 text-sm font-bold bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $customers->sum('invoices_count') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($customers->sum('total_invoice_amount'), 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($customers->sum('total_order_amount'), 2) }}
                                                </td>
                                                <td colspan="2" class="px-6 py-4"></td>
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
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Customers Found</h3>
                                    <p class="text-gray-600">No customer data available for reporting.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Analytics -->
                <div class="space-y-8">
                    <!-- Top Customers -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-emerald-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Top Customers</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            @php
                                $topCustomers = $customers->sortByDesc('total_invoice_amount')->take(5);
                            @endphp

                            @if ($topCustomers->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($topCustomers as $index => $customer)
                                        <div
                                            class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg hover:from-gray-100 hover:to-gray-200 transition-all duration-200 group">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                                    <span
                                                        class="text-emerald-700 font-bold text-sm">{{ $index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $customer->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">{{ $customer->invoices_count }}
                                                        invoices</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-bold text-emerald-700">
                                                    BDT {{ number_format($customer->total_invoice_amount, 2) }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ round(($customer->total_invoice_amount / max($customers->sum('total_invoice_amount'), 1)) * 100, 1) }}%
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <p class="text-gray-500">No customer data available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Distribution -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Customer Distribution</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                @php
                                    $customerTypes = $customers->groupBy('customer_type');
                                    $activeCount = $customers->where('status', 'active')->count();
                                    $inactiveCount = $customers->where('status', 'inactive')->count();
                                    $totalCount = $customers->count();
                                @endphp

                                @foreach ($customerTypes as $type => $typeCustomers)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-gray-100 hover:from-blue-50 hover:to-blue-100 border border-gray-200 rounded-xl p-4 transition-all duration-200 group">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-gray-900 mb-1">
                                                {{ $typeCustomers->count() }}</div>
                                            <div class="text-sm text-gray-600">{{ ucfirst($type) }} Customers</div>
                                            @if ($totalCount > 0)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ round(($typeCustomers->count() / $totalCount) * 100, 1) }}%
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <div
                                    class="bg-gradient-to-br from-gray-50 to-gray-100 hover:from-emerald-50 hover:to-emerald-100 border border-gray-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $activeCount }}</div>
                                        <div class="text-sm text-gray-600">Active Customers</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ round(($activeCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="bg-gradient-to-br from-gray-50 to-gray-100 hover:from-gray-200 hover:to-gray-300 border border-gray-200 rounded-xl p-4 transition-all duration-200 group">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">{{ $inactiveCount }}</div>
                                        <div class="text-sm text-gray-600">Inactive Customers</div>
                                        @if ($totalCount > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ round(($inactiveCount / $totalCount) * 100, 1) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Summary Statistics
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-blue-100">
                                <span class="text-sm text-gray-600">Average Invoice Value</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    BDT
                                    {{ number_format($customers->sum('total_invoice_amount') / max($customers->count(), 1), 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-blue-100">
                                <span class="text-sm text-gray-600">Avg Invoices per Customer</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ number_format($customers->sum('invoices_count') / max($customers->count(), 1), 1) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-blue-100">
                                <span class="text-sm text-gray-600">Avg Orders per Customer</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ number_format($customers->sum('sales_orders_count') / max($customers->count(), 1), 1) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Customer Retention Rate</span>
                                <span class="text-sm font-semibold text-emerald-600">
                                    {{ round(($activeCount / max($totalCount, 1)) * 100, 1) }}%
                                </span>
                            </div>
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
            .hover\:from-blue-50,
            .hover\:to-blue-100 {
                background: white !important;
                border: 1px solid #e5e7eb !important;
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

            .text-3xl {
                font-size: 1.5rem !important;
            }

            .text-2xl {
                font-size: 1.25rem !important;
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
            .border-emerald-100,
            .border-purple-100,
            .border-amber-100,
            .border-gray-200 {
                border-color: #e5e7eb !important;
            }

            table {
                font-size: 0.875rem !important;
                width: 100% !important;
            }

            .overflow-x-auto {
                overflow: visible !important;
            }

            .bg-gradient-to-r {
                background: #f9fafb !important;
            }

            .text-blue-600,
            .text-emerald-600,
            .text-purple-600,
            .text-amber-600 {
                color: black !important;
            }

            .bg-blue-100,
            .bg-emerald-100,
            .bg-purple-100,
            .bg-amber-100 {
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
    </style>
@endsection
