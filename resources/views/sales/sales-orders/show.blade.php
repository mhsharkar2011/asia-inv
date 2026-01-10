{{-- resources/views/sales/sales-orders/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Sales Order - ' . $salesOrder->order_number)

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <!-- Header -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('sales.sales-orders.index') }}"
                                class="text-gray-500 hover:text-gray-700">Sales Orders</a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li class="text-gray-900 font-medium">{{ $salesOrder->order_number }}</li>
                    </ol>
                </nav>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Sales Order</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $salesOrder->order_number }}</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <!-- Status Badge -->
                        <div class="flex items-center">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $salesOrder->status === 'draft' ? 'bg-gray-100 text-gray-800' : ($salesOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($salesOrder->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($salesOrder->status === 'processing' ? 'bg-blue-100 text-blue-800' : ($salesOrder->status === 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800')))) }}">
                                {{ ucfirst($salesOrder->status) }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="relative inline-block text-left">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>

                            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden"
                                id="actionMenu">
                                <div class="py-1">
                                    <a href="{{ route('sales.sales-orders.edit', $salesOrder) }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="{{ route('sales.sales-orders.print', $salesOrder) }}" target="_blank"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Print
                                    </a>
                                    <a href="#" onclick="printInvoice()"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Download PDF
                                    </a>

                                    @if ($salesOrder->status == 'draft')
                                        <a href="#" onclick="confirmOrder()"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Confirm Order
                                        </a>
                                    @endif

                                    @if ($salesOrder->status == 'confirmed')
                                        <a href="{{ route('sales.invoices.create', ['order_id' => $salesOrder->id]) }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="h-4 w-4 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 2a1 1 0 11-2 0 1 1 0 012 0zM4 8a1 1 0 100 2h4a1 1 0 100-2H4zm8 0a1 1 0 100 2h4a1 1 0 100-2h-4zm-4 5a1 1 0 011-1h6a1 1 0 110 2H9a1 1 0 01-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Create Invoice
                                        </a>
                                    @endif

                                    <div class="border-t border-gray-100 my-1"></div>

                                    <button type="button" onclick="confirmDelete()"
                                        class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <svg class="h-4 w-4 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('sales.sales-orders.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-6">
                <div class="rounded-lg bg-green-50 p-4 border border-green-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button type="button"
                                class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-6">
                <div class="rounded-lg bg-red-50 p-4 border border-red-200 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Order Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white">Order Details</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Order Number</h3>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">
                                            {{ $salesOrder->order_number }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Order Date</h3>
                                        <p class="mt-1 text-gray-900">{{ $salesOrder->order_date->format('d M, Y') }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Delivery Date</h3>
                                        <p class="mt-1 text-gray-900">{{ $salesOrder->delivery_date->format('d M, Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Customer</h3>
                                        <p class="mt-1 text-gray-900">
                                            <span class="font-semibold">{{ $salesOrder->customer->customer_name }}</span>
                                            @if ($salesOrder->customer->company_name)
                                                <br>
                                                <span
                                                    class="text-sm text-gray-600">{{ $salesOrder->customer->company_name }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Sales Person</h3>
                                        <p class="mt-1 text-gray-900">{{ $salesOrder->sales_person ?? 'Not specified' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Reference</h3>
                                        <p class="mt-1 text-gray-900">{{ $salesOrder->reference_number ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Payment Terms</h3>
                                        <p class="mt-1 text-gray-900">
                                            {{ $salesOrder->payment_terms ? ucfirst(str_replace('_', ' ', $salesOrder->payment_terms)) : 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                                        <p class="mt-1">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salesOrder->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($salesOrder->payment_status === 'partial' ? 'bg-blue-100 text-blue-800' : ($salesOrder->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst($salesOrder->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Due Date</h3>
                                        <p class="mt-1 text-gray-900">
                                            {{ \Carbon\Carbon::parse($salesOrder->due_date)->format('d M, Y') ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Created By</h3>
                                        <p class="mt-1 text-gray-900">{{ $salesOrder->createdBy->name ?? 'System' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Created On</h3>
                                        <p class="mt-1 text-gray-900">
                                            {{ $salesOrder->created_at->format('d M, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">
                                            Shipping Address</h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 whitespace-pre-line">
                                                {!! nl2br(e($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified'))) !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">
                                            Billing Address</h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 whitespace-pre-line">
                                                {!! nl2br(
                                                    e(
                                                        $salesOrder->billing_address ??
                                                            ($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified')),
                                                    ),
                                                ) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Method -->
                            @if ($salesOrder->shipping_method)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h3 class="text-sm font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">
                                        Shipping Information</h3>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path
                                                d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h4v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H20a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7h-3v5h3V7z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Shipping Method</p>
                                            <p class="text-sm text-gray-600">{{ ucfirst($salesOrder->shipping_method) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-600 to-cyan-700">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875z" />
                                    <path
                                        d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 001.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 001.897 1.384C6.809 12.164 9.315 12.75 12 12.75z" />
                                    <path
                                        d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 001.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 001.897 1.384C6.809 15.914 9.315 16.5 12 16.5z" />
                                    <path
                                        d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 001.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 001.897 1.384C6.809 19.664 9.315 20.25 12 20.25z" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white">Order Items</h2>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Description</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                            Quantity</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-end">
                                            Unit Price</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-end">
                                            Discount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-end">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($salesOrder->items as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loop->iteration }}</td>
                                            <td class="px-6 py-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->product_name ?? $item->description }}</p>
                                                    @if ($item->product)
                                                        <div
                                                            class="mt-1 flex items-center space-x-2 text-xs text-gray-500">
                                                            <span>Code: {{ $item->product->product_code }}</span>
                                                            @if ($item->product->unit_of_measure)
                                                                <span class="text-gray-300">•</span>
                                                                <span>Unit: {{ $item->product->unit_of_measure }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ number_format($item->quantity, 4) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-end">
                                                ৳{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-end">
                                                @if ($item->discount_percentage > 0)
                                                    <div>
                                                        <span class="text-red-600 font-medium">
                                                            {{ number_format($item->discount_percentage, 2) }}%
                                                        </span>
                                                        <div class="text-xs text-red-500">
                                                            (-৳{{ number_format($item->discount_amount, 2) }})
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">0%</span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-end">
                                                ৳{{ number_format($item->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 border-t border-gray-200">
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">Subtotal:</td>
                                        <td colspan="2" class="px-6 py-3 text-sm text-gray-900 text-end">
                                            ৳{{ number_format($salesOrder->subtotal, 2) }}
                                        </td>
                                    </tr>
                                    @if ($salesOrder->total_discount > 0)
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-3 text-right text-sm font-medium text-gray-900"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">Discount:
                                            </td>
                                            <td colspan="2" class="px-6 py-3 text-sm text-red-600 text-end">
                                                -৳{{ number_format($salesOrder->total_discount, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">Taxable Amount:
                                        </td>
                                        <td colspan="2" class="px-6 py-3 text-sm text-gray-900 text-end">
                                            ৳{{ number_format($salesOrder->taxable_amount, 2) }}
                                        </td>
                                    </tr>
                                    @if ($salesOrder->tax_amount > 0)
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-3 text-right text-sm font-medium text-gray-900"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                Tax ({{ number_format($salesOrder->tax_rate, 2) }}%):
                                            </td>
                                            <td colspan="2" class="px-6 py-3 text-sm text-gray-900 text-end">
                                                +৳{{ number_format($salesOrder->tax_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($salesOrder->shipping_charges > 0)
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-3 text-right text-sm font-medium text-gray-900"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">Shipping:
                                            </td>
                                            <td colspan="2" class="px-6 py-3 text-sm text-gray-900 text-end">
                                                +৳{{ number_format($salesOrder->shipping_charges, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($salesOrder->adjustment != 0)
                                        <tr>
                                            <td colspan="3"
                                                class="px-6 py-3 text-right text-sm font-medium text-gray-900"></td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">Adjustment:
                                            </td>
                                            <td colspan="2"
                                                class="px-6 py-3 text-sm {{ $salesOrder->adjustment > 0 ? 'text-green-600' : 'text-red-600' }} text-end">
                                                {{ $salesOrder->adjustment > 0 ? '+' : '' }}৳{{ number_format($salesOrder->adjustment, 2) }}
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $salesOrder->adjustment > 0 ? 'Additional' : 'Deduction' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="bg-gray-100">
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">Total Amount:</td>
                                        <td colspan="2" class="px-6 py-3 text-sm font-bold text-gray-900 text-end">
                                            ৳{{ number_format($salesOrder->total_amount, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes & Terms Card -->
                    @if ($salesOrder->notes || $salesOrder->terms_conditions)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-600 to-gray-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M19.902 4.098a3.75 3.75 0 00-5.304 0l-4.5 4.5a3.75 3.75 0 001.035 6.037.75.75 0 01-.646 1.353 5.25 5.25 0 01-1.449-8.45l4.5-4.5a5.25 5.25 0 117.424 7.424l-1.757 1.757a.75.75 0 11-1.06-1.06l1.757-1.757a3.75 3.75 0 000-5.304zm-7.389 4.267a.75.75 0 011-.353 5.25 5.25 0 011.449 8.45l-4.5 4.5a5.25 5.25 0 11-7.424-7.424l1.757-1.757a.75.75 0 111.06 1.06l-1.757 1.757a3.75 3.75 0 105.304 5.304l4.5-4.5a3.75 3.75 0 00-1.035-6.037.75.75 0 01-.354-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Additional Information</h2>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                @if ($salesOrder->notes)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">
                                            Notes</h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $salesOrder->notes }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($salesOrder->terms_conditions)
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 mb-3 pb-2 border-b border-gray-200">
                                            Terms & Conditions</h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 whitespace-pre-line">
                                                {{ $salesOrder->terms_conditions }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-4 space-y-6 mt-6 lg:mt-0">
                    <!-- Order Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white">Order Summary</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Order Status:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salesOrder->status === 'draft' ? 'bg-gray-100 text-gray-800' : ($salesOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($salesOrder->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($salesOrder->status === 'processing' ? 'bg-blue-100 text-blue-800' : ($salesOrder->status === 'completed' ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800')))) }}">
                                        {{ ucfirst($salesOrder->status) }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Payment Status:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salesOrder->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($salesOrder->payment_status === 'partial' ? 'bg-blue-100 text-blue-800' : ($salesOrder->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($salesOrder->payment_status) }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Currency:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $salesOrder->currency }}</span>
                                </div>

                                <hr class="my-4">

                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Subtotal:</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">৳{{ number_format($salesOrder->subtotal, 2) }}</span>
                                    </div>

                                    @if ($salesOrder->total_discount > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Discount:</span>
                                            <span
                                                class="text-sm font-medium text-red-600">-৳{{ number_format($salesOrder->total_discount, 2) }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Taxable Amount:</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">৳{{ number_format($salesOrder->taxable_amount, 2) }}</span>
                                    </div>

                                    @if ($salesOrder->tax_amount > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Tax
                                                ({{ number_format($salesOrder->tax_rate, 2) }}%):</span>
                                            <span
                                                class="text-sm font-medium text-gray-900">+৳{{ number_format($salesOrder->tax_amount, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($salesOrder->shipping_charges > 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Shipping Charges:</span>
                                            <span
                                                class="text-sm font-medium text-gray-900">+৳{{ number_format($salesOrder->shipping_charges, 2) }}</span>
                                        </div>
                                    @endif

                                    @if ($salesOrder->adjustment != 0)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Adjustment:</span>
                                            <span
                                                class="text-sm font-medium {{ $salesOrder->adjustment > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $salesOrder->adjustment > 0 ? '+' : '' }}৳{{ number_format($salesOrder->adjustment, 2) }}
                                            </span>
                                        </div>
                                    @endif

                                    <hr class="my-4">

                                    <div class="flex justify-between items-center">
                                        <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                                        <span
                                            class="text-lg font-bold text-gray-900">৳{{ number_format($salesOrder->total_amount, 2) }}</span>
                                    </div>
                                </div>

                                <div class="mt-6 bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center space-x-1 text-blue-800 mb-2">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-medium">Order Details</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-blue-700">
                                        <div class="flex justify-between">
                                            <span>Total Items:</span>
                                            <span class="font-medium">{{ $salesOrder->items->count() }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Total Quantity:</span>
                                            <span
                                                class="font-medium">{{ number_format($salesOrder->items->sum('quantity'), 4) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-600 to-emerald-700">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white">Customer Information</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">
                                        {{ $salesOrder->customer->customer_name }}</h3>
                                    @if ($salesOrder->customer->company_name)
                                        <p class="text-xs text-gray-600">
                                            <span class="font-medium">Company:</span>
                                            {{ $salesOrder->customer->company_name }}
                                        </p>
                                    @endif
                                </div>

                                @if ($salesOrder->customer->email)
                                    <div class="flex items-start space-x-2">
                                        <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Email</p>
                                            <a href="mailto:{{ $salesOrder->customer->email }}"
                                                class="text-xs text-blue-600 hover:text-blue-800">{{ $salesOrder->customer->email }}</a>
                                        </div>
                                    </div>
                                @endif

                                @if ($salesOrder->customer->phone)
                                    <div class="flex items-start space-x-2">
                                        <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Phone</p>
                                            <a href="tel:{{ $salesOrder->customer->phone }}"
                                                class="text-xs text-blue-600 hover:text-blue-800">{{ $salesOrder->customer->phone }}</a>
                                        </div>
                                    </div>
                                @endif

                                @if ($salesOrder->customer->address)
                                    <div class="flex items-start space-x-2">
                                        <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900">Address</p>
                                            <p class="text-xs text-gray-600 whitespace-pre-line">
                                                {{ $salesOrder->customer->address }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('sales.companies.show', $salesOrder->customer) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-emerald-300 shadow-sm text-sm font-medium rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-150">
                                    <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    View Customer Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline / History Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-slate-800 to-slate-900">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white">Order Timeline</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="relative pl-8 space-y-6">
                                <div class="relative">
                                    <div
                                        class="absolute left-[-8px] top-2 w-4 h-4 bg-blue-500 rounded-full border-4 border-white">
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">Order Created</h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $salesOrder->created_at->format('d M, Y h:i A') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">By:
                                            {{ $salesOrder->createdBy->name ?? 'System' }}</p>
                                    </div>
                                </div>

                                @if ($salesOrder->updated_at != $salesOrder->created_at)
                                    <div class="relative">
                                        <div
                                            class="absolute left-[-8px] top-2 w-4 h-4 bg-cyan-500 rounded-full border-4 border-white">
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Last Updated</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $salesOrder->updated_at->format('d M, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($salesOrder->status != 'draft')
                                    <div class="relative">
                                        <div
                                            class="absolute left-[-8px] top-2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white">
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">Order Confirmed</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                @php
                                                    $confirmedAt = $salesOrder->updated_at;
                                                    if ($salesOrder->status == 'confirmed') {
                                                        $confirmedAt = $salesOrder->updated_at;
                                                    }
                                                    if (
                                                        isset($salesOrder->statusHistories) &&
                                                        $salesOrder->statusHistories
                                                            ->where('status', 'confirmed')
                                                            ->count() > 0
                                                    ) {
                                                        $confirmedAt = $salesOrder->statusHistories
                                                            ->where('status', 'confirmed')
                                                            ->first()->created_at;
                                                    }
                                                @endphp
                                                {{ $confirmedAt->format('d M, Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('sales.sales-orders.destroy', $salesOrder) }}" method="POST"
        class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
    <style>
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #3b82f6, #10b981, #8b5cf6);
        }

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

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Action menu toggle
            const actionButton = document.querySelector('[type="button"]');
            const actionMenu = document.getElementById('actionMenu');

            if (actionButton && actionMenu) {
                actionButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    actionMenu.classList.toggle('hidden');
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!actionMenu.contains(e.target) && !actionButton.contains(e.target)) {
                        actionMenu.classList.add('hidden');
                    }
                });
            }
        });

        function printInvoice() {
            window.open('{{ route('sales.sales-orders.print', $salesOrder) }}', '_blank');
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this sales order? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        function confirmOrder() {
            if (confirm('Are you sure you want to confirm this order? Once confirmed, it cannot be edited.')) {
                // You can implement AJAX confirmation here
                window.location.href = '{{ route('sales.sales-orders.confirm', $salesOrder) }}';
            }
        }
    </script>
@endpush
