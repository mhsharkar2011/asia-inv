@extends('layouts.admin')

@section('title', 'GST/Tax Report - Asia Enterprise')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="p-2.5 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">GST/Tax Compliance Report</h1>
                                <p class="text-gray-600 mt-1">Tax collection, analysis, and compliance tracking</p>
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
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-amber-100">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Report Filters</h2>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('reports.tax') }}" method="GET">
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
                                    class="w-full bg-gradient-to-r from-amber-600 to-amber-700 text-white font-medium py-2.5 px-4 rounded-lg hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 flex items-center justify-center">
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
                            <a href="{{ route('reports.tax', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-amber-200 text-amber-700 font-medium rounded-lg hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                This Month
                            </a>
                            <a href="{{ route('reports.tax', ['start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-amber-200 text-amber-700 font-medium rounded-lg hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7v10m4-10v10m4-10v10m3-13H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                </svg>
                                This Year
                            </a>
                            <a href="{{ route('reports.tax', ['start_date' => date('Y-m-d', strtotime('-30 days')), 'end_date' => date('Y-m-d')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-amber-200 text-amber-700 font-medium rounded-lg hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Last 30 Days
                            </a>
                            <a href="{{ route('reports.tax', ['start_date' => date('Y-m-d', strtotime('-7 days')), 'end_date' => date('Y-m-d')]) }}"
                                class="inline-flex items-center px-4 py-2 border border-amber-200 text-amber-700 font-medium rounded-lg hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 text-sm">
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

            <!-- Tax KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
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
                            <span class="ml-2 text-sm text-gray-600">taxable invoices</span>
                        </div>
                    </div>
                </div>

                <!-- Taxable Amount Card -->
                <div
                    class="bg-gradient-to-br from-white to-emerald-50 rounded-2xl shadow-lg border border-emerald-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">TAXABLE</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Taxable Amount</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT {{ number_format($invoices->sum('taxable_amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- GST Collected Card -->
                <div
                    class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg border border-purple-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">GST</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total GST Collected</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT {{ number_format($invoices->sum('tax_amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Total Invoice Amount Card -->
                <div
                    class="bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-lg border border-amber-100 hover:shadow-xl transition-shadow duration-300 group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="p-3 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-amber-600 bg-amber-100 px-3 py-1 rounded-full">TOTAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Total Invoice Amount</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">
                                BDT {{ number_format($invoices->sum('total_amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- GST Summary by Rate -->
                <div>
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">GST Summary by Rate</h2>
                                </div>
                                <span
                                    class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full">{{ $gstSummary->count() }}
                                    GST Rates</span>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($gstSummary->count() > 0)
                                <div class="overflow-x-auto rounded-xl border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                    GST Rate
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-28">
                                                    Invoices
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Taxable Amt
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Total GST
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Total Amt
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @php
                                                $totalInvoices = 0;
                                                $totalTaxable = 0;
                                                $totalCGST = 0;
                                                $totalSGST = 0;
                                                $totalGST = 0;
                                                $totalAmount = 0;
                                            @endphp

                                            @foreach ($gstSummary as $rate => $summary)
                                                @php
                                                    $cgst = $summary['tax_amount'] / 2;
                                                    $sgst = $summary['tax_amount'] / 2;

                                                    $totalInvoices += $summary['count'];
                                                    $totalTaxable += $summary['taxable_amount'];
                                                    $totalCGST += $cgst;
                                                    $totalSGST += $sgst;
                                                    $totalGST += $summary['tax_amount'];
                                                    $totalAmount += $summary['total_amount'];
                                                @endphp
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                            {{ $rate }}% GST
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <span
                                                            class="text-sm font-medium text-gray-900">{{ $summary['count'] }}</span>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        BDT {{ number_format($summary['taxable_amount'], 2) }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-700">
                                                        BDT {{ number_format($summary['tax_amount'], 2) }}
                                                        <div class="text-xs text-gray-500">
                                                            (CGST: {{ number_format($cgst, 2) }} | SGST:
                                                            {{ number_format($sgst, 2) }})
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                        BDT {{ number_format($summary['total_amount'], 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                    Totals
                                                </td>
                                                <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">
                                                    {{ $totalInvoices }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($totalTaxable, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-purple-700">
                                                    BDT {{ number_format($totalGST, 2) }}
                                                    <div class="text-xs text-gray-500">
                                                        (CGST: {{ number_format($totalCGST, 2) }} | SGST:
                                                        {{ number_format($totalSGST, 2) }})
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                                    BDT {{ number_format($totalAmount, 2) }}
                                                </td>
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
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No GST Data Found</h3>
                                    <p class="text-gray-600">No paid invoices with tax data in the selected date range.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- GST Distribution & Summary -->
                <div class="space-y-8">
                    <!-- GST Distribution -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-emerald-100">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-emerald-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">GST Distribution</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($gstSummary->count() > 0)
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($gstSummary as $rate => $summary)
                                        <div
                                            class="bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border border-blue-200 rounded-xl p-4 text-center transition-all duration-200 group">
                                            <div class="text-2xl font-bold text-blue-700 mb-1">{{ $rate }}%</div>
                                            <div class="text-sm text-gray-600 mb-1">{{ $summary['count'] }} invoices</div>
                                            <div class="text-sm font-semibold text-blue-700">
                                                BDT {{ number_format($summary['tax_amount'], 2) }} GST
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ round(($summary['tax_amount'] / max($invoices->sum('tax_amount'), 1)) * 100, 1) }}%
                                                of total
                                            </div>
                                        </div>
                                    @endforeach

                                    <div
                                        class="bg-gradient-to-br from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border border-emerald-200 rounded-xl p-4 text-center transition-all duration-200 group">
                                        <div class="text-2xl font-bold text-emerald-700 mb-1">
                                            {{ $invoices->where('status', 'paid')->count() }}
                                        </div>
                                        <div class="text-sm text-gray-600">Paid Invoices</div>
                                        <div class="text-xs text-emerald-600 mt-1">
                                            {{ round(($invoices->where('status', 'paid')->count() / max($invoices->count(), 1)) * 100, 1) }}%
                                            collection
                                        </div>
                                    </div>

                                    <div
                                        class="bg-gradient-to-br from-amber-50 to-amber-100 hover:from-amber-100 hover:to-amber-200 border border-amber-200 rounded-xl p-4 text-center transition-all duration-200 group">
                                        <div class="text-2xl font-bold text-amber-700 mb-1">
                                            {{ $invoices->where('status', '!=', 'paid')->count() }}
                                        </div>
                                        <div class="text-sm text-gray-600">Pending Invoices</div>
                                        <div class="text-xs text-amber-600 mt-1">
                                            {{ round(($invoices->where('status', '!=', 'paid')->count() / max($invoices->count(), 1)) * 100, 1) }}%
                                            pending
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <p class="text-gray-500">No GST data available for analysis</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick GST Summary -->
                    <div
                        class="bg-gradient-to-r from-amber-50 to-amber-100 rounded-2xl shadow-lg border border-amber-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Quick GST Summary
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-amber-200">
                                <span class="text-sm text-gray-700">Report Period:</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($startDate)->format('d M, Y') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-amber-200">
                                <span class="text-sm text-gray-700">CGST Collected:</span>
                                <span class="text-sm font-semibold text-blue-700">
                                    BDT {{ number_format($invoices->sum('tax_amount') / 2, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-amber-200">
                                <span class="text-sm text-gray-700">SGST Collected:</span>
                                <span class="text-sm font-semibold text-blue-700">
                                    BDT {{ number_format($invoices->sum('tax_amount') / 2, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-amber-200">
                                <span class="text-sm text-gray-700">GST as % of Total:</span>
                                <span class="text-sm font-semibold text-purple-700">
                                    {{ round(($invoices->sum('tax_amount') / max($invoices->sum('total_amount'), 1)) * 100, 2) }}%
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-3">
                                <span class="text-sm font-semibold text-gray-900">Tax Compliance:</span>
                                <span class="text-sm font-semibold text-emerald-700">
                                    {{ round(($invoices->where('status', 'paid')->count() / max($invoices->count(), 1)) * 100, 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="mt-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h2 class="text-xl font-bold text-gray-900">Invoice Details</h2>
                            </div>
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">{{ $invoices->count() }}
                                Invoices</span>
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
                                                Customer
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                GST %
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                Taxable Amt
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                                GST Amt
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach ($invoices as $invoice)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-blue-700">
                                                        {{ $invoice->invoice_number }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $invoice->invoice_date->format('d M, Y') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $invoice->customer->name ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $invoice->customer->gstin ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span
                                                        class="px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $invoice->tax_rate ?? 18 }}%
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    BDT
                                                    {{ number_format($invoice->taxable_amount ?? $invoice->total_amount - $invoice->tax_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-purple-700">
                                                    BDT {{ number_format($invoice->tax_amount, 2) }}
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
                                            </tr>
                                        @endforeach
                                    </tbody>
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
                                <p class="text-gray-600">No paid invoices in the selected date range.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- GST Information -->
            <div
                class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-blue-200 bg-gradient-to-r from-blue-100 to-indigo-100">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">GST Information & Notes</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Current GST Rates in India</h3>
                            <div class="space-y-2">
                                <div class="flex items-center p-2 bg-white rounded-lg border border-blue-100">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-emerald-700 font-bold">0%</span>
                                    </div>
                                    <span class="text-sm text-gray-700">Essential goods (food grains, milk, etc.)</span>
                                </div>
                                <div class="flex items-center p-2 bg-white rounded-lg border border-blue-100">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-blue-700 font-bold">5%</span>
                                    </div>
                                    <span class="text-sm text-gray-700">Household necessities (sugar, tea, coffee,
                                        etc.)</span>
                                </div>
                                <div class="flex items-center p-2 bg-white rounded-lg border border-blue-100">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-indigo-700 font-bold">12%</span>
                                    </div>
                                    <span class="text-sm text-gray-700">Processed foods, computers, phones</span>
                                </div>
                                <div class="flex items-center p-2 bg-white rounded-lg border border-blue-100">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-purple-700 font-bold">18%</span>
                                    </div>
                                    <span class="text-sm text-gray-700">Most goods and services (standard rate)</span>
                                </div>
                                <div class="flex items-center p-2 bg-white rounded-lg border border-blue-100">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-red-100 to-red-200 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-red-700 font-bold">28%</span>
                                    </div>
                                    <span class="text-sm text-gray-700">Luxury items, sin goods (cars, tobacco,
                                        etc.)</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">GST Components</h3>
                            <div class="space-y-4">
                                <div class="bg-white rounded-lg p-4 border border-blue-100">
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-blue-700 font-bold text-sm">CG</span>
                                        </div>
                                        <h4 class="text-base font-semibold text-gray-900">Central GST (CGST)</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Collected by Central Government on intra-state sales
                                    </p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-blue-100">
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-emerald-100 to-emerald-200 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-emerald-700 font-bold text-sm">SG</span>
                                        </div>
                                        <h4 class="text-base font-semibold text-gray-900">State GST (SGST)</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Collected by State Government on intra-state sales</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-blue-100">
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-purple-700 font-bold text-sm">IG</span>
                                        </div>
                                        <h4 class="text-base font-semibold text-gray-900">Integrated GST (IGST)</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">Collected by Central Government on inter-state
                                        transactions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-gradient-to-r from-amber-50 to-amber-100 rounded-lg border border-amber-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-amber-800">
                                    <strong>Important Note:</strong> For intra-state sales, GST is equally divided between
                                    CGST and SGST.
                                    For example, 18% GST = 9% CGST + 9% SGST. All amounts shown in this report are for
                                    intra-state transactions.
                                </p>
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

            .lg\:col-span-2 {
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
            .border-gray-200,
            .border-indigo-200 {
                border-color: #e5e7eb !important;
            }

            .bg-blue-50,
            .bg-emerald-50,
            .bg-purple-50,
            .bg-amber-50,
            .bg-gray-50,
            .bg-indigo-50 {
                background: #f9fafb !important;
            }

            table {
                font-size: 0.75rem !important;
                width: 100% !important;
            }

            .overflow-x-auto {
                overflow: visible !important;
            }

            .text-blue-600,
            .text-emerald-600,
            .text-purple-600,
            .text-amber-600,
            .text-indigo-600 {
                color: black !important;
            }

            .bg-blue-100,
            .bg-emerald-100,
            .bg-purple-100,
            .bg-amber-100,
            .bg-red-100 {
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

        /* GST Rate color coding */
        .bg-blue-100 {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        }

        .bg-emerald-100 {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        }

        .bg-purple-100 {
            background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
        }

        .bg-amber-100 {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }
    </style>
@endsection
