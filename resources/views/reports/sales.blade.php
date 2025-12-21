@extends('layouts.admin')

@section('title', 'Sales Report - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Sales Analytics Report</h1>
                                <p class="text-gray-600 mt-1">Comprehensive sales performance and revenue analysis</p>
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

            <!-- Filters Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-10">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Report Filters</h2>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('reports.sales') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date"
                                        class="pl-10 w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        id="start_date" name="start_date" value="{{ $startDate }}" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date"
                                        class="pl-10 w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        id="end_date" name="end_date" value="{{ $endDate }}" required>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium py-2.5 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Quick Date Range Buttons -->
                    <div class="mt-6">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('reports.sales', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                This Month
                            </a>
                            <a href="{{ route('reports.sales', ['start_date' => date('Y-m-d', strtotime('-30 days')), 'end_date' => date('Y-m-d')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Last 30 Days
                            </a>
                            <a href="{{ route('reports.sales', ['start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7v10m4-10v10m4-10v10m3-13H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                </svg>
                                This Year
                            </a>
                            <a href="{{ route('reports.sales', ['start_date' => date('Y-m-d', strtotime('-7 days')), 'end_date' => date('Y-m-d')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Last 7 Days
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Total Invoices Card -->
                <div
                    class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">INVOICES</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total Invoices</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">{{ $invoices->count() }}</span>
                            <span class="ml-2 text-sm text-gray-600">invoices generated</span>
                        </div>
                    </div>
                </div>

                <!-- Invoice Revenue Card -->
                <div
                    class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">REVENUE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Invoice Revenue</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">BDT
                                {{ number_format($totalInvoiceAmount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Sales Card -->
                <div
                    class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">TOTAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total Sales</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">BDT {{ number_format($totalSales, 2) }}</span>
                            <span class="ml-2 text-sm text-gray-600">(invoices + orders)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Invoices Report -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Invoices Report</h2>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                    {{ $invoices->count() }} Invoices
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($invoices->count() > 0)
                                <div class="overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Invoice #
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Date
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Customer
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($invoices as $invoice)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-semibold text-blue-700">
                                                            {{ $invoice->invoice_number }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $invoice->invoice_date->format('d M, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $invoice->customer->name ?? 'N/A' }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $invoice->customer->email ?? '' }}</div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                        BDT {{ number_format($invoice->total_amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($invoice->status == 'paid')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                                Paid
                                                            </span>
                                                        @elseif($invoice->status == 'overdue')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                Overdue
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                                                Pending
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('sales.invoices.show', $invoice->id) }}"
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
                                                    Total:
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($totalInvoiceAmount, 2) }}
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
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Invoices Found</h3>
                                    <p class="text-gray-600">No invoices were generated in the selected date range.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sales Orders Report -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-emerald-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Sales Orders</h2>
                                </div>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full">
                                    {{ $salesOrders->count() }} Orders
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($salesOrders->count() > 0)
                                <div class="overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Order #
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                                                    View
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($salesOrders as $order)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-semibold text-emerald-700">
                                                            {{ $order->order_number }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $order->order_date->format('d M, Y') }}</div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                        BDT {{ number_format($order->total_amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($order->status == 'draft')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                Draft
                                                            </span>
                                                        @elseif($order->status == 'confirmed')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                Confirmed
                                                            </span>
                                                        @elseif($order->status == 'shipped')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                                Shipped
                                                            </span>
                                                        @elseif($order->status == 'delivered')
                                                            <span
                                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                                Delivered
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                            class="text-emerald-600 hover:text-emerald-900 transition-colors duration-200">
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
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">
                                                    Total:
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($totalOrdersAmount, 2) }}
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
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Sales Orders Found</h3>
                                    <p class="text-gray-600">No sales orders were created in the selected date range.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Detailed Summary -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Report Summary</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Report Period:</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($startDate)->format('d M, Y') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}
                                </span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Total Invoices:</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                    {{ $invoices->count() }}
                                </span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Invoice Revenue:</span>
                                <span class="text-sm font-semibold text-gray-900">BDT
                                    {{ number_format($totalInvoiceAmount, 2) }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Total Orders:</span>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-sm font-semibold rounded-full">
                                    {{ $salesOrders->count() }}
                                </span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Orders Value:</span>
                                <span class="text-sm font-semibold text-gray-900">BDT
                                    {{ number_format($totalOrdersAmount, 2) }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                                <span class="text-sm font-medium text-gray-900 font-semibold">Total Sales:</span>
                                <span class="text-lg font-bold text-purple-700">BDT
                                    {{ number_format($totalSales, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Quick Statistics</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-emerald-700 mb-1">
                                    {{ $invoices->where('status', 'paid')->count() }}</div>
                                <div class="text-sm text-gray-600">Paid Invoices</div>
                                @if ($invoices->count() > 0)
                                    <div class="text-xs text-emerald-600 mt-1">
                                        {{ round(($invoices->where('status', 'paid')->count() / $invoices->count()) * 100, 1) }}%
                                    </div>
                                @endif
                            </div>
                            <div
                                class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-amber-700 mb-1">
                                    {{ $invoices->where('status', 'pending')->count() }}</div>
                                <div class="text-sm text-gray-600">Pending Invoices</div>
                                @if ($invoices->count() > 0)
                                    <div class="text-xs text-amber-600 mt-1">
                                        {{ round(($invoices->where('status', 'pending')->count() / $invoices->count()) * 100, 1) }}%
                                    </div>
                                @endif
                            </div>
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-indigo-700 mb-1">
                                    {{ $salesOrders->where('status', 'delivered')->count() }}</div>
                                <div class="text-sm text-gray-600">Delivered Orders</div>
                                @if ($salesOrders->count() > 0)
                                    <div class="text-xs text-indigo-600 mt-1">
                                        {{ round(($salesOrders->where('status', 'delivered')->count() / $salesOrders->count()) * 100, 1) }}%
                                    </div>
                                @endif
                            </div>
                            <div
                                class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-blue-700 mb-1">
                                    {{ $salesOrders->whereIn('status', ['draft', 'confirmed'])->count() }}
                                </div>
                                <div class="text-sm text-gray-600">Pending Orders</div>
                                @if ($salesOrders->count() > 0)
                                    <div class="text-xs text-blue-600 mt-1">
                                        {{ round(($salesOrders->whereIn('status', ['draft', 'confirmed'])->count() / $salesOrders->count()) * 100, 1) }}%
                                    </div>
                                @endif
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
            .border-emerald-100,
            .border-purple-100,
            .border-gray-200,
            .border-indigo-200,
            .border-amber-200 {
                border-color: #e5e7eb !important;
            }

            .bg-blue-50,
            .bg-emerald-50,
            .bg-purple-50,
            .bg-gray-50,
            .bg-indigo-50,
            .bg-amber-50 {
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
            .text-emerald-600,
            .text-purple-600,
            .text-indigo-600,
            .text-amber-600 {
                color: black !important;
            }

            .bg-blue-100,
            .bg-emerald-100,
            .bg-purple-100,
            .bg-gray-100,
            .bg-indigo-100,
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
