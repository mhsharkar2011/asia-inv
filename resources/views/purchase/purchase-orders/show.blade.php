@extends('layouts.admin')

@section('title', 'Purchase Order Details')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-indigo-50">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Purchase Order</h1>
                                <p class="text-sm text-gray-600 mt-1">PO# {{ $purchaseOrder->po_number }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('purchase.purchase-orders.edit', $purchaseOrder) }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('purchase.purchase-orders.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Order Details</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Company Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span>Company</span>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $purchaseOrder->company->name ?? 'N/A' }}</p>
                                </div>

                                <!-- Supplier Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>Supplier</span>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $purchaseOrder->supplier->name ?? 'N/A' }}</p>
                                </div>
                                <!-- Warehouse Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                        <span>Warehouse</span>
                                    </div>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $purchaseOrder->warehouse->warehouse_name ?? 'N/A' }}</p>
                                </div>

                                <!-- Status -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Status</span>
                                    </div>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                            'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                        ];
                                        $statusColor =
                                            $statusColors[$purchaseOrder->status] ??
                                            'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border {{ $statusColor }}">
                                        {{ ucfirst($purchaseOrder->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                            Unit Price</th>
                                        <th
                                            class="py-3 px-6 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($purchaseOrder->items as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product->name }}</div>
                                                        <div class="text-sm text-gray-500">SKU:
                                                            {{ $item->product->sku ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="text-sm text-gray-900">
                                                    ${{ number_format($item->unit_price, 2) }}</div>
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    ${{ number_format($item->total, 2) }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="py-4 px-6 text-right text-sm font-medium text-gray-900">
                                            Subtotal</td>
                                        <td class="py-4 px-6 text-sm font-semibold text-gray-900">
                                            ${{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes Card -->
                    @if ($purchaseOrder->notes)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-lg font-semibold text-gray-900">Notes</h2>
                            </div>
                            <div class="p-6">
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $purchaseOrder->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Timeline Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Timeline</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Order Created</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $purchaseOrder->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Order Date</p>
                                        <p class="text-sm text-gray-500">{{ $purchaseOrder->order_date->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if ($purchaseOrder->expected_delivery_date)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Expected Delivery</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $purchaseOrder->expected_delivery_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Financial Summary</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Subtotal</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">${{ number_format($purchaseOrder->total_amount, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tax</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">${{ number_format($purchaseOrder->tax_amount, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Discount</span>
                                    <span
                                        class="text-sm font-medium text-red-600">-${{ number_format($purchaseOrder->discount, 2) }}</span>
                                </div>

                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-base font-semibold text-gray-900">Total Amount</span>
                                        <span
                                            class="text-xl font-bold text-gray-900">${{ number_format($purchaseOrder->final_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-3">
                                <a href="#"
                                    class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-blue-900">Print PO</span>
                                </a>

                                <a href="#"
                                    class="flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-green-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-green-900">Mark Received</span>
                                </a>

                                <a href="#"
                                    class="flex flex-col items-center justify-center p-4 bg-red-50 hover:bg-red-100 rounded-lg border border-red-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-red-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="text-sm font-medium text-red-900">Cancel Order</span>
                                </a>

                                <a href="#"
                                    class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors duration-200">
                                    <svg class="w-6 h-6 text-purple-600 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-purple-900">Duplicate</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .prose {
            color: #374151;
        }

        .prose p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
        }
    </style>
@endsection
