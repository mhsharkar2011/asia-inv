{{-- resources/views/sales/sales-orders/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create Sales Order')

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <!-- Error Display -->
        @if ($errors->any())
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
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ml-auto pl-3">
                            <button type="button"
                                class="inline-flex rounded-md bg-red-50 p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 focus:ring-offset-red-50">
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
                        <li class="text-gray-900 font-medium">Create</li>
                    </ol>
                </nav>

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Create Sales Order</h1>
                        <p class="mt-1 text-sm text-gray-500">Create a new sales order for your customer</p>
                    </div>
                    <div>
                        <a href="{{ route('sales.sales-orders.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('sales.sales-orders.store') }}" method="POST" id="salesOrderForm">
            @csrf

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <!-- Left Column -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Order Information -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Order Information</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Number</label>
                                        <div class="relative">
                                            <input type="text" name="order_number"
                                                value="{{ old('order_number', $order_number) }}" readonly
                                                class="w-full bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Auto-generated</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Date *</label>
                                        <input type="date" name="order_date"
                                            value="{{ old('order_date', date('Y-m-d')) }}" required
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order_date') border-red-300 @enderror">
                                        @error('order_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer *</label>
                                        <select name="customer_id" id="customerSelect" required
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_id') border-red-300 @enderror">
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                                    data-name="{{ $customer->name ?? '' }}"
                                                    data-address="{{ $customer->address ?? '' }}"
                                                    data-phone="{{ $customer->phone ?? '' }}"
                                                    data-email="{{ $customer->email ?? '' }}">
                                                    {{ $customer->code }}
                                                    @if ($customer->code && $customer->name)
                                                        ({{ $customer->name }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Date *</label>
                                        <input type="date" name="delivery_date"
                                            value="{{ old('delivery_date', date('Y-m-d', strtotime('+7 days'))) }}"
                                            required
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('delivery_date') border-red-300 @enderror">
                                        @error('delivery_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sales Person</label>
                                        <input type="text" name="sales_person"
                                            value="{{ old('sales_person', auth()->user()->name) }}"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference
                                            Number</label>
                                        <input type="text" name="reference_number"
                                            value="{{ old('reference_number') }}" placeholder="Customer PO/Reference"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Shipping
                                            Address</label>
                                        <textarea name="shipping_address" id="shippingAddress" rows="2"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('shipping_address') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Leave blank to use customer's default address
                                        </p>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Billing Address</label>
                                        <textarea name="billing_address" id="billingAddress" rows="2"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('billing_address') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Leave blank to use shipping address</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="status"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="draft"
                                                {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="confirmed"
                                                {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="processing"
                                                {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                                        <select name="currency"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="BDT" selected>BDT - Bangladeshi Taka</option>
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="EUR">EUR - Euro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-cyan-600 to-cyan-700">
                                <div class="flex items-center justify-between">
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
                                    <button type="button" id="addItemBtn"
                                        class="inline-flex items-center px-3 py-1.5 bg-white text-cyan-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                                        <svg class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Add Item
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="overflow-x-auto rounded-lg border border-gray-200">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Product *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Quantity *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Unit Price *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Discount %</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Amount</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody" class="bg-white divide-y divide-gray-200">
                                            @php
                                                $oldItems = old('items', [
                                                    [
                                                        'product_id' => '',
                                                        'quantity' => 1,
                                                        'unit_price' => 0,
                                                        'discount' => 0,
                                                    ],
                                                ]);
                                            @endphp

                                            @foreach ($oldItems as $index => $item)
                                                <tr class="item-row hover:bg-gray-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $loop->iteration }}</td>
                                                    <td class="px-6 py-4">
                                                        <div>
                                                            <select name="items[{{ $index }}][product_id]"
                                                                class="product-select w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm @error('items.' . $index . '.product_id') border-red-300 @enderror"
                                                                required data-index="{{ $index }}">
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        data-price="{{ $product->selling_price }}"
                                                                        data-stock="{{ $product->stock_quantity }}"
                                                                        data-unit="{{ $product->unit_of_measure ?? 'pcs' }}"
                                                                        {{ old('items.' . $index . '.product_id', $item['product_id']) == $product->id ? 'selected' : '' }}>
                                                                        {{ $product->product_name }}
                                                                        ({{ $product->product_code }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('items.' . $index . '.product_id')
                                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                            @enderror
                                                            <div class="mt-1">
                                                                <span class="text-xs text-gray-500 stock-info"
                                                                    id="stock-info-{{ $index }}"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <input type="number"
                                                                name="items[{{ $index }}][quantity]"
                                                                value="{{ old('items.' . $index . '.quantity', $item['quantity']) }}"
                                                                min="0.0001" step="0.0001" required
                                                                data-index="{{ $index }}"
                                                                class="item-quantity w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm @error('items.' . $index . '.quantity') border-red-300 @enderror">
                                                            <div
                                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                                <span
                                                                    class="text-gray-500 text-sm unit-text">{{ $products->first()->unit_of_measure ?? 'pcs' }}</span>
                                                            </div>
                                                        </div>
                                                        @error('items.' . $index . '.quantity')
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">৳</span>
                                                            </div>
                                                            <input type="number"
                                                                name="items[{{ $index }}][unit_price]"
                                                                value="{{ old('items.' . $index . '.unit_price', $item['unit_price']) }}"
                                                                min="0" step="0.01" required
                                                                data-index="{{ $index }}"
                                                                class="item-price w-full border border-gray-300 rounded-md py-2 pl-8 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm @error('items.' . $index . '.unit_price') border-red-300 @enderror">
                                                        </div>
                                                        @error('items.' . $index . '.unit_price')
                                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <input type="number"
                                                                name="items[{{ $index }}][discount]"
                                                                value="{{ old('items.' . $index . '.discount', $item['discount'] ?? 0) }}"
                                                                min="0" max="100" step="0.01"
                                                                data-index="{{ $index }}"
                                                                class="item-discount w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                            <div
                                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">%</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">৳</span>
                                                            </div>
                                                            <input type="text"
                                                                class="item-amount w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm"
                                                                value="0.00" readonly>
                                                            <input type="hidden"
                                                                name="items[{{ $index }}][amount]"
                                                                class="item-amount-hidden" value="0">
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        @if ($loop->first)
                                                            <button type="button"
                                                                class="remove-item text-red-400 hover:text-red-600 opacity-50 cursor-not-allowed"
                                                                disabled>
                                                                <svg class="h-5 w-5" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="remove-item text-red-400 hover:text-red-600 transition-colors duration-150">
                                                                <svg class="h-5 w-5" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50 border-t border-gray-200">
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Subtotal:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="text" id="subtotal"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm"
                                                            value="0.00" readonly>
                                                        <input type="hidden" name="subtotal" id="subtotal-hidden"
                                                            value="0">
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Discount:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="text" id="totalDiscount"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm"
                                                            value="0.00" readonly>
                                                        <input type="hidden" name="total_discount"
                                                            id="total-discount-hidden" value="0">
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Taxable Amount:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="text" id="taxableAmount"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm"
                                                            value="0.00" readonly>
                                                        <input type="hidden" name="taxable_amount"
                                                            id="taxable-amount-hidden" value="0">
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <label for="taxRate" class="text-sm">Tax %:</label>
                                                        <input type="number" name="tax_rate" id="taxRate"
                                                            value="{{ old('tax_rate', 15) }}" min="0"
                                                            max="100" step="0.01"
                                                            class="w-24 border border-gray-300 rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm @error('tax_rate') border-red-300 @enderror">
                                                        @error('tax_rate')
                                                            <p class="text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="text" id="taxAmount"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm"
                                                            value="0.00" readonly>
                                                        <input type="hidden" name="tax_amount" id="tax-amount-hidden"
                                                            value="0">
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Shipping Charges:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="number" name="shipping_charges"
                                                            id="shippingChargesInput"
                                                            value="{{ old('shipping_charges', 0) }}" min="0"
                                                            step="0.01"
                                                            class="w-full border border-gray-300 rounded-md py-2 pl-8 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm @error('shipping_charges') border-red-300 @enderror">
                                                    </div>
                                                    @error('shipping_charges')
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Adjustment:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm">৳</span>
                                                        </div>
                                                        <input type="number" name="adjustment" id="adjustmentInput"
                                                            value="{{ old('adjustment', 0) }}" step="0.01"
                                                            class="w-full border border-gray-300 rounded-md py-2 pl-8 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">+/- adjustment</p>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-gray-100">
                                                <td colspan="5"
                                                    class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                                                    Total Amount:
                                                </td>
                                                <td class="px-6 py-3">
                                                    <div class="relative">
                                                        <div
                                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 text-sm font-bold">৳</span>
                                                        </div>
                                                        <input type="text" id="totalAmount"
                                                            class="w-full bg-gray-100 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-900 font-bold text-sm"
                                                            value="0.00" readonly>
                                                        <input type="hidden" name="total_amount"
                                                            id="total-amount-hidden" value="0">
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-600 to-gray-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Additional Information</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Method</label>
                                        <select name="shipping_method"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select Method</option>
                                            <option value="pickup"
                                                {{ old('shipping_method') == 'pickup' ? 'selected' : '' }}>Customer Pickup
                                            </option>
                                            <option value="delivery"
                                                {{ old('shipping_method') == 'delivery' ? 'selected' : '' }}>Delivery
                                            </option>
                                            <option value="courier"
                                                {{ old('shipping_method') == 'courier' ? 'selected' : '' }}>Courier
                                            </option>
                                            <option value="transport"
                                                {{ old('shipping_method') == 'transport' ? 'selected' : '' }}>Transport
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Terms</label>
                                        <select name="payment_terms"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select Terms</option>
                                            <option value="advance"
                                                {{ old('payment_terms') == 'advance' ? 'selected' : '' }}>100% Advance
                                            </option>
                                            <option value="delivery"
                                                {{ old('payment_terms') == 'delivery' ? 'selected' : '' }}>On Delivery
                                            </option>
                                            <option value="7days"
                                                {{ old('payment_terms', '7days') == '7days' ? 'selected' : '' }}>7 Days
                                            </option>
                                            <option value="15days"
                                                {{ old('payment_terms') == '15days' ? 'selected' : '' }}>15 Days</option>
                                            <option value="30days"
                                                {{ old('payment_terms') == '30days' ? 'selected' : '' }}>30 Days</option>
                                            <option value="custom"
                                                {{ old('payment_terms') == 'custom' ? 'selected' : '' }}>Custom</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                        <select name="payment_status"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="pending"
                                                {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="partial"
                                                {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                            <option value="paid"
                                                {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="overdue"
                                                {{ old('payment_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                                        <input type="date" name="due_date"
                                            value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                        <textarea name="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Any special instructions or notes...">{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Terms &
                                            Conditions</label>
                                        <textarea name="terms_conditions" rows="3"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('terms_conditions') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="lg:col-span-4 space-y-6 mt-6 lg:mt-0">
                        <!-- Customer Details -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div
                                class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-600 to-emerald-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Customer Details</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div id="customerDetails" class="text-gray-600">
                                    <div class="flex items-start space-x-2">
                                        <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm">Select a customer to view details</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
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
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Subtotal:</span>
                                        <span id="summarySubtotal" class="text-sm font-medium text-gray-900">৳0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Discount:</span>
                                        <span id="summaryDiscount" class="text-sm font-medium text-red-600">-৳0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Taxable Amount:</span>
                                        <span id="summaryTaxable" class="text-sm font-medium text-gray-900">৳0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Tax (<span
                                                id="summaryTaxRate">15</span>%):</span>
                                        <span id="summaryTax" class="text-sm font-medium text-gray-900">৳0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Shipping Charges:</span>
                                        <span id="summaryShipping" class="text-sm font-medium text-gray-900">৳0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Adjustment:</span>
                                        <span id="summaryAdjustment"
                                            class="text-sm font-medium text-gray-900">+৳0.00</span>
                                    </div>

                                    <div class="border-t border-gray-200 pt-3 mt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                                            <span id="summaryTotal" class="text-lg font-bold text-gray-900">৳0.00</span>
                                        </div>
                                    </div>

                                    <div class="bg-blue-50 rounded-lg p-3 mt-4">
                                        <div class="flex items-center space-x-1 text-blue-800">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs font-medium">Order Details</span>
                                        </div>
                                        <div class="mt-1 text-xs text-blue-700">
                                            <div class="grid grid-cols-2 gap-1">
                                                <span>Total Items:</span>
                                                <span id="totalItemsCount" class="font-medium">0</span>
                                                <span>Total Quantity:</span>
                                                <span id="totalQuantity" class="font-medium">0</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3 mt-6">
                                        <button type="submit" name="action" value="draft"
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                            <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                                            </svg>
                                            Save as Draft
                                        </button>
                                        <button type="submit" name="action" value="confirm"
                                            class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-150">
                                            <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Save & Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-slate-800 to-slate-900">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M14.615 1.595a.75.75 0 01.359.852L12.982 9.75h7.268a.75.75 0 01.548 1.262l-10.5 11.25a.75.75 0 01-1.272-.71l1.992-7.302H3.75a.75.75 0 01-.548-1.262l10.5-11.25a.75.75 0 01.913-.143z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Quick Actions</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    <button type="button" id="addSampleItems"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-cyan-300 shadow-sm text-sm font-medium rounded-lg text-cyan-700 bg-cyan-50 hover:bg-cyan-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors duration-150">
                                        <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M15.98 1.804a1 1 0 00-1.96 0l-.24 1.192a1 1 0 01-.784.785l-1.192.238a1 1 0 000 1.962l1.192.238a1 1 0 01.785.785l.238 1.192a1 1 0 001.962 0l.238-1.192a1 1 0 01.785-.785l1.192-.238a1 1 0 000-1.962l-1.192-.238a1 1 0 01-.785-.785l-.238-1.192zM6.949 5.684a1 1 0 00-1.898 0l-.683 2.051a1 1 0 01-.633.633l-2.051.683a1 1 0 000 1.898l2.051.684a1 1 0 01.633.632l.683 2.051a1 1 0 001.898 0l.683-2.051a1 1 0 01.633-.633l2.051-.683a1 1 0 000-1.898l-2.051-.683a1 1 0 01-.633-.633L6.95 5.684zM13.949 13.684a1 1 0 00-1.898 0l-.184.551a1 1 0 01-.632.633l-.551.183a1 1 0 000 1.898l.551.183a1 1 0 01.633.633l.183.551a1 1 0 001.898 0l.184-.551a1 1 0 01.632-.633l.551-.183a1 1 0 000-1.898l-.551-.184a1 1 0 01-.633-.632l-.183-.551z" />
                                        </svg>
                                        Add Sample Items
                                    </button>
                                    <button type="button" id="clearForm"
                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-amber-300 shadow-sm text-sm font-medium rounded-lg text-amber-700 bg-amber-50 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-150">
                                        <svg class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Clear Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .item-row {
            transition: background-color 0.15s ease-in-out;
        }

        .product-select option {
            padding: 8px;
        }

        .stock-warning {
            color: #dc2626;
            font-weight: 500;
        }

        .stock-ok {
            color: #059669;
        }

        /* Custom scrollbar for table */
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

        /* Smooth transitions */
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
            console.log('Sales Order Form - Initializing...');

            let itemCount = {{ count(old('items', [0])) }};
            let taxRate = {{ old('tax_rate', 15) }};
            let shippingCharges = {{ old('shipping_charges', 0) }};
            let adjustment = {{ old('adjustment', 0) }};

            // Initialize elements
            const elements = {
                customerSelect: document.getElementById('customerSelect'),
                customerDetails: document.getElementById('customerDetails'),
                shippingAddress: document.getElementById('shippingAddress'),
                billingAddress: document.getElementById('billingAddress'),
                taxRateInput: document.getElementById('taxRate'),
                shippingChargesInput: document.getElementById('shippingChargesInput'),
                adjustmentInput: document.getElementById('adjustmentInput'),
                form: document.getElementById('salesOrderForm'),
                addItemBtn: document.getElementById('addItemBtn'),
                addSampleItemsBtn: document.getElementById('addSampleItems'),
                clearFormBtn: document.getElementById('clearForm')
            };

            // Initialize
            updateCustomerDetails();
            attachEventListeners();
            calculateTotals();

            function attachEventListeners() {
                // Customer select change
                if (elements.customerSelect) {
                    elements.customerSelect.addEventListener('change', updateCustomerDetails);
                }

                // Add item
                if (elements.addItemBtn) {
                    elements.addItemBtn.addEventListener('click', addItemRow);
                }

                // Add sample items
                if (elements.addSampleItemsBtn) {
                    elements.addSampleItemsBtn.addEventListener('click', addSampleItems);
                }

                // Clear form
                if (elements.clearFormBtn) {
                    elements.clearFormBtn.addEventListener('click', clearForm);
                }

                // Tax rate change
                if (elements.taxRateInput) {
                    elements.taxRateInput.addEventListener('input', function() {
                        taxRate = parseFloat(this.value) || 0;
                        document.getElementById('summaryTaxRate').textContent = taxRate.toFixed(2);
                        calculateTotals();
                    });
                }

                // Shipping charges change
                if (elements.shippingChargesInput) {
                    elements.shippingChargesInput.addEventListener('input', function() {
                        shippingCharges = parseFloat(this.value) || 0;
                        document.getElementById('summaryShipping').textContent = formatCurrency(
                            shippingCharges);
                        calculateTotals();
                    });
                }

                // Adjustment change
                if (elements.adjustmentInput) {
                    elements.adjustmentInput.addEventListener('input', function() {
                        adjustment = parseFloat(this.value) || 0;
                        const sign = adjustment >= 0 ? '+' : '';
                        document.getElementById('summaryAdjustment').textContent = sign + formatCurrency(
                            adjustment);
                        calculateTotals();
                    });
                }

                // Remove item event delegation
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-item')) {
                        const row = e.target.closest('.item-row');
                        if (row && document.querySelectorAll('.item-row').length > 1) {
                            row.remove();
                            renumberRows();
                            calculateTotals();
                        }
                    }
                });

                // Product select change
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('product-select')) {
                        const index = e.target.dataset.index;
                        updateProductDetails(index);
                    }
                });

                // Quantity/Price/Discount change
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('item-quantity') ||
                        e.target.classList.contains('item-price') ||
                        e.target.classList.contains('item-discount')) {
                        const index = e.target.dataset.index;
                        updateStockInfo(index);
                        calculateItemTotal(index);
                        calculateTotals();
                    }
                });

                // Form submission validation
                if (elements.form) {
                    elements.form.addEventListener('submit', function(e) {
                        // Validate customer selection
                        if (!elements.customerSelect || !elements.customerSelect.value) {
                            e.preventDefault();
                            showAlert('Please select a customer', 'error');
                            elements.customerSelect.focus();
                            return false;
                        }

                        // Validate at least one item with product selected
                        let validItems = 0;
                        document.querySelectorAll('.product-select').forEach(select => {
                            if (select.value) validItems++;
                        });

                        if (validItems === 0) {
                            e.preventDefault();
                            showAlert('Please add at least one item with a product selected', 'error');
                            return false;
                        }

                        return true;
                    });
                }
            }

            function updateCustomerDetails() {
                if (!elements.customerSelect || !elements.customerDetails) return;

                const selectedOption = elements.customerSelect.options[elements.customerSelect.selectedIndex];

                if (selectedOption.value) {
                    const name = selectedOption.getAttribute('data-name');
                    const address = selectedOption.getAttribute('data-address');
                    const phone = selectedOption.getAttribute('data-phone');
                    const email = selectedOption.getAttribute('data-email');

                    elements.customerDetails.innerHTML = `
                        <div class="space-y-3">

                            <div class="flex items-start space-x-2">
                                <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${name || 'Not Available'}</p>
                                    <p class="text-xs text-gray-500">Name</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-2">
                                <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                    <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${email || 'Not Available'}</p>
                                    <p class="text-xs text-gray-500">Email</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-2">
                                <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${phone || 'Not Available'}</p>
                                    <p class="text-xs text-gray-500">Phone</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-2">
                                <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">${address || 'Not Available'}</p>
                                    <p class="text-xs text-gray-500">Address</p>
                                </div>
                            </div>
                        </div>
                    `;

                    if (address && elements.shippingAddress && !elements.shippingAddress.value) {
                        elements.shippingAddress.value = address;
                    }

                    if (address && elements.billingAddress && !elements.billingAddress.value) {
                        elements.billingAddress.value = address;
                    }
                } else {
                    elements.customerDetails.innerHTML = `
                        <div class="flex items-start space-x-2">
                            <svg class="h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-600">Select a customer to view details</p>
                        </div>
                    `;
                }
            }

            function addItemRow() {
                const tbody = document.getElementById('itemsBody');
                if (!tbody) return;

                const newRow = document.createElement('tr');
                newRow.className = 'item-row hover:bg-gray-50 transition-colors duration-150';
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${itemCount + 1}</td>
                    <td class="px-6 py-4">
                        <div>
                            <select name="items[${itemCount}][product_id]"
                                   class="product-select w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   required data-index="${itemCount}">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        data-price="{{ $product->selling_price }}"
                                        data-stock="{{ $product->stock_quantity }}"
                                        data-unit="{{ $product->unit_of_measure ?? 'pcs' }}">
                                        {{ $product->product_name }} ({{ $product->product_code }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-1">
                                <span class="text-xs text-gray-500 stock-info" id="stock-info-${itemCount}"></span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <input type="number" name="items[${itemCount}][quantity]"
                                   class="item-quantity w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   value="1" min="0.0001" step="0.0001" required data-index="${itemCount}">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 text-sm unit-text">pcs</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">৳</span>
                            </div>
                            <input type="number" name="items[${itemCount}][unit_price]"
                                   class="item-price w-full border border-gray-300 rounded-md py-2 pl-8 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   value="0" min="0" step="0.01" required data-index="${itemCount}">
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <input type="number" name="items[${itemCount}][discount]"
                                   class="item-discount w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   value="0" min="0" max="100" step="0.01" data-index="${itemCount}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">%</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">৳</span>
                            </div>
                            <input type="text" class="item-amount w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-8 pr-3 text-gray-700 text-sm" value="0.00" readonly>
                            <input type="hidden" name="items[${itemCount}][amount]" class="item-amount-hidden" value="0">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="remove-item text-red-400 hover:text-red-600 transition-colors duration-150">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                `;

                tbody.appendChild(newRow);
                itemCount++;

                // Enable first remove button if multiple rows
                const firstRemoveBtn = document.querySelector('.item-row:first-child .remove-item');
                if (firstRemoveBtn && document.querySelectorAll('.item-row').length > 1) {
                    firstRemoveBtn.disabled = false;
                    firstRemoveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    firstRemoveBtn.classList.add('cursor-pointer');
                }

                renumberRows();
                calculateTotals();
            }

            function addSampleItems() {
                if ({{ $products->count() }} === 0) {
                    showAlert('No products available. Please add products first.', 'error');
                    return;
                }

                // Clear existing items except first
                const rows = document.querySelectorAll('.item-row');
                for (let i = 1; i < rows.length; i++) {
                    rows[i].remove();
                }
                itemCount = 1;

                // Get first product
                const firstProduct = {!! $products->count() > 0 ? json_encode($products->first()) : 'null' !!};
                if (!firstProduct) return;

                // Update first row
                const firstRow = document.querySelector('.item-row');
                if (firstRow) {
                    const productSelect = firstRow.querySelector('.product-select');
                    const unitText = firstRow.querySelector('.unit-text');

                    if (productSelect) {
                        productSelect.value = firstProduct.id;
                        updateProductDetails(0);
                    }

                    if (unitText) {
                        unitText.textContent = firstProduct.unit_of_measure || 'pcs';
                    }

                    firstRow.querySelector('.item-quantity').value = 2;
                    firstRow.querySelector('.item-price').value = firstProduct.selling_price || 0;
                    firstRow.querySelector('.item-discount').value = 5;
                }

                // Add 2 more sample items if available
                const sampleProducts = {!! json_encode($products->take(3)) !!};
                for (let i = 1; i < sampleProducts.length; i++) {
                    addItemRow();
                    const newRow = document.querySelector('.item-row:last-child');
                    const product = sampleProducts[i];

                    if (newRow && product) {
                        const productSelect = newRow.querySelector('.product-select');
                        const unitText = newRow.querySelector('.unit-text');

                        if (productSelect) {
                            productSelect.value = product.id;
                            updateProductDetails(itemCount - 1);
                        }

                        if (unitText) {
                            unitText.textContent = product.unit_of_measure || 'pcs';
                        }

                        newRow.querySelector('.item-quantity').value = 3;
                        newRow.querySelector('.item-price').value = product.selling_price || 0;
                        newRow.querySelector('.item-discount').value = i * 2;
                    }
                }

                calculateTotals();
                showAlert('Sample items added successfully!', 'success');
            }

            function clearForm() {
                if (confirm('Are you sure you want to clear the form? All data will be lost.')) {
                    // Reset form fields
                    if (elements.form) {
                        elements.form.reset();
                        // Manually reset select elements
                        document.querySelectorAll('select').forEach(select => {
                            select.selectedIndex = 0;
                        });
                    }

                    // Reset customer selection
                    if (elements.customerSelect) {
                        elements.customerSelect.selectedIndex = 0;
                        updateCustomerDetails();
                    }

                    // Clear items
                    const rows = document.querySelectorAll('.item-row');
                    for (let i = 1; i < rows.length; i++) {
                        rows[i].remove();
                    }

                    // Reset first row
                    const firstRow = document.querySelector('.item-row');
                    if (firstRow) {
                        const productSelect = firstRow.querySelector('.product-select');
                        if (productSelect) productSelect.selectedIndex = 0;
                        firstRow.querySelector('.item-quantity').value = 1;
                        firstRow.querySelector('.item-price').value = 0;
                        firstRow.querySelector('.item-discount').value = 0;
                        const firstRemoveBtn = firstRow.querySelector('.remove-item');
                        if (firstRemoveBtn) {
                            firstRemoveBtn.disabled = true;
                            firstRemoveBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            firstRemoveBtn.classList.remove('cursor-pointer');
                        }

                        // Clear stock info
                        const stockInfo = firstRow.querySelector('.stock-info');
                        if (stockInfo) stockInfo.textContent = '';

                        // Reset unit text
                        const unitText = firstRow.querySelector('.unit-text');
                        if (unitText) unitText.textContent = 'pcs';
                    }

                    itemCount = 1;
                    taxRate = 15;
                    shippingCharges = 0;
                    adjustment = 0;

                    // Reset tax, shipping, and adjustment
                    if (elements.taxRateInput) elements.taxRateInput.value = 15;
                    if (elements.shippingChargesInput) elements.shippingChargesInput.value = 0;
                    if (elements.adjustmentInput) elements.adjustmentInput.value = 0;

                    document.getElementById('summaryTaxRate').textContent = '15.00';
                    document.getElementById('summaryShipping').textContent = formatCurrency(0);
                    document.getElementById('summaryAdjustment').textContent = '+৳0.00';

                    renumberRows();
                    calculateTotals();
                    showAlert('Form cleared successfully!', 'success');
                }
            }

            function updateProductDetails(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const productSelect = row.querySelector('.product-select');
                const priceInput = row.querySelector('.item-price');
                const unitText = row.querySelector('.unit-text');
                const selectedOption = productSelect.options[productSelect.selectedIndex];

                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const unit = selectedOption.getAttribute('data-unit');

                    if (price && priceInput) {
                        priceInput.value = parseFloat(price).toFixed(2);
                    }

                    if (unit && unitText) {
                        unitText.textContent = unit;
                    }

                    updateStockInfo(index);
                }

                calculateItemTotal(index);
                calculateTotals();
            }

            function updateStockInfo(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.item-quantity');
                const stockInfo = row.querySelector('.stock-info');

                if (!productSelect || !quantityInput || !stockInfo) return;

                const selectedOption = productSelect.options[productSelect.selectedIndex];

                if (selectedOption.value) {
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
                    const quantity = parseFloat(quantityInput.value) || 0;

                    if (stock < quantity) {
                        stockInfo.textContent = `Insufficient stock! Available: ${stock}`;
                        stockInfo.className = 'text-xs stock-warning';
                    } else {
                        stockInfo.textContent = `Stock available: ${stock}`;
                        stockInfo.className = 'text-xs stock-ok';
                    }
                } else {
                    stockInfo.textContent = '';
                }
            }

            function calculateItemTotal(index) {
                const row = document.querySelector(`.item-row:nth-child(${parseInt(index) + 1})`);
                if (!row) return;

                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const discount = parseFloat(row.querySelector('.item-discount').value) || 0;

                const itemTotal = quantity * price;
                const itemDiscount = itemTotal * (discount / 100);
                const itemAmount = itemTotal - itemDiscount;

                const amountInput = row.querySelector('.item-amount');
                const amountHidden = row.querySelector('.item-amount-hidden');

                if (amountInput) amountInput.value = formatCurrency(itemAmount, false);
                if (amountHidden) amountHidden.value = itemAmount.toFixed(2);
            }

            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalItems = 0;
                let totalQuantity = 0;

                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const discount = parseFloat(row.querySelector('.item-discount').value) || 0;

                    const itemTotal = quantity * price;
                    const itemDiscount = itemTotal * (discount / 100);
                    const itemAmount = itemTotal - itemDiscount;

                    subtotal += itemTotal;
                    totalDiscount += itemDiscount;

                    if (quantity > 0) totalItems++;
                    totalQuantity += quantity;

                    calculateItemTotal(index);
                });

                const taxableAmount = subtotal - totalDiscount;
                const taxAmount = taxableAmount * (taxRate / 100);
                const totalAmount = taxableAmount + taxAmount + shippingCharges + adjustment;

                // Update table
                document.getElementById('subtotal').value = formatCurrency(subtotal, false);
                document.getElementById('totalDiscount').value = formatCurrency(totalDiscount, false);
                document.getElementById('taxableAmount').value = formatCurrency(taxableAmount, false);
                document.getElementById('taxAmount').value = formatCurrency(taxAmount, false);
                document.getElementById('totalAmount').value = formatCurrency(totalAmount, false);

                // Update hidden fields
                document.getElementById('subtotal-hidden').value = subtotal.toFixed(2);
                document.getElementById('total-discount-hidden').value = totalDiscount.toFixed(2);
                document.getElementById('taxable-amount-hidden').value = taxableAmount.toFixed(2);
                document.getElementById('tax-amount-hidden').value = taxAmount.toFixed(2);
                document.getElementById('total-amount-hidden').value = totalAmount.toFixed(2);

                // Update summary
                document.getElementById('summarySubtotal').textContent = formatCurrency(subtotal);
                document.getElementById('summaryDiscount').textContent = '- ' + formatCurrency(totalDiscount);
                document.getElementById('summaryTaxable').textContent = formatCurrency(taxableAmount);
                document.getElementById('summaryTax').textContent = formatCurrency(taxAmount);
                document.getElementById('summaryTotal').textContent = formatCurrency(totalAmount);

                // Update counters
                document.getElementById('totalItemsCount').textContent = totalItems;
                document.getElementById('totalQuantity').textContent = totalQuantity.toFixed(4);
            }

            function renumberRows() {
                document.querySelectorAll('.item-row').forEach((row, index) => {
                    const firstTd = row.querySelector('td:first-child');
                    if (firstTd) firstTd.textContent = index + 1;

                    // Update all input names
                    const inputs = row.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && name.includes('items[')) {
                            input.name = name.replace(/items\[\d+\]/, `items[${index}]`);
                            input.dataset.index = index;
                        }
                    });

                    // Update stock info ID
                    const stockInfo = row.querySelector('.stock-info');
                    if (stockInfo) stockInfo.id = `stock-info-${index}`;
                });
                itemCount = document.querySelectorAll('.item-row').length;
            }

            function formatCurrency(amount, withSymbol = true) {
                const formatted = parseFloat(amount).toLocaleString('en-BD', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                return withSymbol ? `৳${formatted}` : formatted;
            }

            function showAlert(message, type = 'info') {
                // You can implement a custom alert/notification system here
                // For now, using browser alert
                if (type === 'error') {
                    alert('Error: ' + message);
                } else if (type === 'success') {
                    alert('Success: ' + message);
                } else {
                    alert(message);
                }
            }

            console.log('Sales Order Form - Initialization complete');
        });
    </script>
@endpush
