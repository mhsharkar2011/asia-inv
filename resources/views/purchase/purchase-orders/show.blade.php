@extends('layouts.admin')

@section('title', 'View Purchase Order')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 md:p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <nav class="mb-4">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('admin.dashboard') }}"
                            class="hover:text-primary-600 transition-colors">Dashboard</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li><a href="{{ route('purchase.purchase-orders.index') }}"
                            class="hover:text-primary-600 transition-colors">Purchase Orders</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li class="text-gray-900 font-medium">{{ $purchaseOrder->po_number }}</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                clip-rule="evenodd" />
                        </svg>
                        Purchase Order: {{ $purchaseOrder->po_number }}
                    </h1>
                    <p class="text-gray-600 mt-1">View and manage purchase order details</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-2">
                    @if ($purchaseOrder->status != 'completed' && $purchaseOrder->status != 'cancelled')
                        @if ($purchaseOrder->status == 'pending')
                            <form action="{{ route('purchase.purchase-orders.approve', $purchaseOrder) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Approve this purchase order?')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Approve
                                </button>
                            </form>
                        @endif

                        @if ($purchaseOrder->status == 'approved')
                            <button type="button" onclick="openReceiveModal()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path
                                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1h4v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H20a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                </svg>
                                Receive Items
                            </button>
                        @endif

                        <a href="{{ route('purchase.purchase-orders.edit', $purchaseOrder) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                    @endif

                    @if ($purchaseOrder->status != 'cancelled')
                        <button type="button" onclick="openCancelModal()"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </button>
                    @endif

                    <a href="{{ route('purchase.purchase-orders.pdf', $purchaseOrder) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Print PDF
                    </a>

                    <a href="{{ route('purchase.purchase-orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Banner -->
        <div
            class="mb-6 p-4 rounded-lg border-l-4
        {{ $purchaseOrder->status == 'pending' ? 'bg-yellow-50 border-yellow-500 text-yellow-800' : '' }}
        {{ $purchaseOrder->status == 'approved' ? 'bg-blue-50 border-blue-500 text-blue-800' : '' }}
        {{ $purchaseOrder->status == 'completed' ? 'bg-green-50 border-green-500 text-green-800' : '' }}
        {{ $purchaseOrder->status == 'cancelled' ? 'bg-red-50 border-red-500 text-red-800' : '' }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">
                        <span class="font-bold">Status:</span> {{ ucfirst($purchaseOrder->status) }}
                        @if ($purchaseOrder->status == 'pending')
                            - Awaiting approval
                        @elseif($purchaseOrder->status == 'approved')
                            - Ready for delivery
                        @elseif($purchaseOrder->status == 'completed')
                            - Delivered on
                            {{ $purchaseOrder->delivery_date ? $purchaseOrder->delivery_date->format('d M Y') : 'N/A' }}
                        @elseif($purchaseOrder->status == 'cancelled')
                            - Order cancelled
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- PO Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Purchase Order Information</h2>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $purchaseOrder->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $purchaseOrder->status == 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $purchaseOrder->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $purchaseOrder->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ strtoupper($purchaseOrder->status) }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">PO Number</label>
                                <p class="text-gray-900 font-semibold">{{ $purchaseOrder->po_number }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Supplier</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-gray-900 font-semibold">{{ $purchaseOrder->supplier->name ?? 'N/A' }}
                                    </p>
                                    @if ($purchaseOrder->supplier)
                                        <a href="{{ route('purchase.suppliers.show', $purchaseOrder->supplier) }}"
                                            class="text-primary-600 hover:text-primary-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                <path
                                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Company</label>
                                <p class="text-gray-900 font-semibold">{{ $purchaseOrder->company->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Warehouse</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-gray-900 font-semibold">{{ $purchaseOrder->warehouse->name ?? 'N/A' }}
                                    </p>
                                    @if ($purchaseOrder->warehouse)
                                        <a href="{{ route('inventory.warehouses.show', $purchaseOrder->warehouse) }}"
                                            class="text-primary-600 hover:text-primary-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                <path
                                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Order Date</label>
                                <p class="text-gray-900 font-semibold">{{ $purchaseOrder->order_date->format('d M Y') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Expected Delivery</label>
                                <div class="flex items-center gap-1">
                                    <p
                                        class="font-semibold {{ $purchaseOrder->expected_delivery_date && $purchaseOrder->expected_delivery_date->isPast() && $purchaseOrder->status != 'completed' ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('d M Y') : 'Not set' }}
                                    </p>
                                    @if (
                                        $purchaseOrder->expected_delivery_date &&
                                            $purchaseOrder->expected_delivery_date->isPast() &&
                                            $purchaseOrder->status != 'completed')
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 mb-2">Notes</label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-700">{{ $purchaseOrder->notes ?: 'No notes provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-500">
                        <div class="flex flex-col md:flex-row md:justify-between">
                            <div>Created: {{ $purchaseOrder->created_at->format('d M Y, h:i A') }}</div>
                            @if ($purchaseOrder->updated_at != $purchaseOrder->created_at)
                                <div class="mt-1 md:mt-0">Last Updated:
                                    {{ $purchaseOrder->updated_at->format('d M Y, h:i A') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Order Items
                                ({{ $purchaseOrder->items->count() }})</h2>
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
                                        Product</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SKU</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    @if ($purchaseOrder->status == 'approved' || $purchaseOrder->status == 'completed')
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Received</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($purchaseOrder->items as $index => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $item->product->description ? \Illuminate\Support\Str::limit($item->product->description, 50) : 'No description' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                {{ $item->product->sku }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="px-3 py-1 text-sm font-medium bg-primary-100 text-primary-800 rounded-full">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            ${{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                            ${{ number_format($item->total, 2) }}
                                        </td>
                                        @if ($purchaseOrder->status == 'approved' || $purchaseOrder->status == 'completed')
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($purchaseOrder->status == 'completed')
                                                    <span
                                                        class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                                        {{ $item->quantity_received ?? $item->quantity }}
                                                    </span>
                                                @else
                                                    <input type="number" name="received_qty[{{ $item->id }}]"
                                                        class="w-20 text-center px-2 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                        value="{{ $item->quantity_received ?? 0 }}" min="0"
                                                        max="{{ $item->quantity }}">
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $purchaseOrder->status == 'approved' || $purchaseOrder->status == 'completed' ? '7' : '6' }}"
                                            class="px-6 py-12 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="mt-2 text-sm">No items found in this purchase order</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Financial Summary Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Financial Summary</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal</span>
                                <span
                                    class="font-semibold text-gray-900">${{ number_format($purchaseOrder->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tax ({{ $purchaseOrder->tax_rate ?? 0 }}%)</span>
                                <span
                                    class="font-semibold text-gray-900">${{ number_format($purchaseOrder->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Discount</span>
                                <span
                                    class="font-semibold text-red-600">-${{ number_format($purchaseOrder->discount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Shipping</span>
                                <span
                                    class="font-semibold text-gray-900">${{ number_format($purchaseOrder->shipping_cost ?? 0, 2) }}</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Grand Total</span>
                                <span
                                    class="text-lg font-bold text-green-600">${{ number_format($purchaseOrder->final_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('purchase.purchase-orders.clone', $purchaseOrder) }}"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-primary-600 text-primary-600 hover:bg-primary-50 font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                                    <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
                                </svg>
                                Duplicate PO
                            </a>
                            <a href="{{ route('purchase.purchase-orders.email', $purchaseOrder) }}"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-blue-600 text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                Email to Supplier
                            </a>
                            <button onclick="window.print()"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-600 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Print Preview
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Attachments Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Attachments</h2>
                        </div>
                    </div>

                    <div class="p-6">
                        @if ($purchaseOrder->attachments && count($purchaseOrder->attachments) > 0)
                            <div class="space-y-2 mb-4">
                                @foreach ($purchaseOrder->attachments as $attachment)
                                    <a href="{{ Storage::url($attachment->path) }}" target="_blank"
                                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="text-sm font-medium text-gray-700 group-hover:text-primary-600 truncate">
                                                {{ $attachment->filename }}
                                            </span>
                                        </div>
                                        <span
                                            class="text-xs text-gray-500">{{ $attachment->created_at->format('d/m/Y') }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-gray-500">No attachments</p>
                            </div>
                        @endif

                        <!-- Upload Form -->
                        <form action="{{ route('purchase.purchase-orders.upload', $purchaseOrder) }}" method="POST"
                            enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <div class="space-y-2">
                                <input type="file" name="attachment"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                <p class="text-xs text-gray-400">Max: 5MB (PDF, Images, Docs)</p>
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Cancel Purchase Order</h3>
            </div>
            <form action="{{ route('purchase.purchase-orders.cancel', $purchaseOrder) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Are you sure you want to cancel this purchase order?</p>
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for cancellation <span class="text-red-500">*</span>
                        </label>
                        <textarea id="cancellation_reason" name="cancellation_reason" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            required></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeCancelModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Close
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        Confirm Cancellation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Receive Items Modal -->
    <div id="receiveModal"
        class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-200 flex-shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Receive Items</h3>
            </div>
            <form action="{{ route('purchase.purchase-orders.receive', $purchaseOrder) }}" method="POST"
                class="flex-1 overflow-hidden flex flex-col">
                @csrf
                @method('PATCH')
                <div class="p-6 overflow-y-auto flex-1">
                    <p class="text-gray-600 mb-4">Mark items as received and update inventory.</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ordered
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Received
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">To Receive
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($purchaseOrder->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-900">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-900">
                                            {{ $item->quantity_received ?? 0 }}</td>
                                        <td class="px-4 py-3">
                                            <input type="number" name="received[{{ $item->id }}]"
                                                class="w-24 mx-auto text-center px-2 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                value="{{ $item->quantity - ($item->quantity_received ?? 0) }}"
                                                min="0"
                                                max="{{ $item->quantity - ($item->quantity_received ?? 0) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="delivery_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Delivery Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="delivery_date" name="delivery_date" value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                        </div>
                        <div>
                            <label for="delivery_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Delivery Notes
                            </label>
                            <textarea id="delivery_notes" name="delivery_notes" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 flex-shrink-0">
                    <button type="button" onclick="closeReceiveModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        Mark as Received
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openCancelModal() {
                document.getElementById('cancelModal').classList.remove('hidden');
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden');
            }

            function openReceiveModal() {
                document.getElementById('receiveModal').classList.remove('hidden');
            }

            function closeReceiveModal() {
                document.getElementById('receiveModal').classList.add('hidden');
            }

            // Close modals on background click
            document.addEventListener('click', function(event) {
                if (event.target.id === 'cancelModal') {
                    closeCancelModal();
                }
                if (event.target.id === 'receiveModal') {
                    closeReceiveModal();
                }
            });

            // Close modals on Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeCancelModal();
                    closeReceiveModal();
                }
            });

            // Set today's date for delivery date field
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('delivery_date').value = new Date().toISOString().split('T')[0];

                // Auto-calculate to receive quantity
                document.querySelectorAll('input[name^="received["]').forEach(input => {
                    input.addEventListener('change', function() {
                        const max = parseInt(this.getAttribute('max'));
                        if (this.value > max) {
                            this.value = max;
                        }
                        if (this.value < 0) {
                            this.value = 0;
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection
