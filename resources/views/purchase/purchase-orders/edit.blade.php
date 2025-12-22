@extends('layouts.admin')

@section('title', 'Edit Purchase Order')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 md:p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                                    Edit Purchase Order
                                </h1>
                                <p class="text-gray-600 text-sm">
                                    PO #<span class="font-semibold text-blue-600">{{ $purchaseOrder->po_number }}</span>
                                    • Created: {{ $purchaseOrder->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('purchase.purchase-orders.show', $purchaseOrder->id) }}"
                           class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            View PO
                        </a>
                        <a href="{{ route('purchase.purchase-orders.index') }}"
                           class="px-4 py-2.5 border border-gray-300 rounded-lg font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('purchase.purchase-orders.update', $purchaseOrder->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-8">
                        <!-- Basic Information -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-1.5 bg-blue-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">
                                        Basic Information
                                    </h2>
                                    <p class="text-sm text-gray-500">Essential details about this purchase order</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- PO Number -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="po_number" class="block text-sm font-medium text-gray-700">
                                            PO Number <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <input type="text"
                                               id="po_number"
                                               name="po_number"
                                               value="{{ old('po_number', $purchaseOrder->po_number) }}"
                                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition duration-200 @error('po_number') border-red-500 @enderror"
                                               placeholder="Enter PO number"
                                               required>
                                    </div>
                                    @error('po_number')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Company -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="company_id" class="block text-sm font-medium text-gray-700">
                                            Company <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select id="company_id"
                                                name="company_id"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 appearance-none transition duration-200 @error('company_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id', $purchaseOrder->company_id) == $company->id ? 'selected' : '' }}
                                                    class="py-2">
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('company_id')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Dates -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="order_date" class="block text-sm font-medium text-gray-700">
                                            Order Date <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date"
                                               id="order_date"
                                               name="order_date"
                                               value="{{ old('order_date', $purchaseOrder->order_date->format('Y-m-d')) }}"
                                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition duration-200 @error('order_date') border-red-500 @enderror"
                                               required>
                                    </div>
                                    @error('order_date')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="expected_delivery_date" class="block text-sm font-medium text-gray-700">
                                            Expected Delivery Date
                                        </label>
                                        <span class="text-xs text-blue-600">Optional</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="date"
                                               id="expected_delivery_date"
                                               name="expected_delivery_date"
                                               value="{{ old('expected_delivery_date', optional($purchaseOrder->expected_delivery_date)->format('Y-m-d')) }}"
                                               class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition duration-200 @error('expected_delivery_date') border-red-500 @enderror">
                                    </div>
                                    @error('expected_delivery_date')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Supplier & Warehouse -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-1.5 bg-indigo-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">
                                        Supplier & Warehouse
                                    </h2>
                                    <p class="text-sm text-gray-500">Vendor and delivery location details</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Supplier -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="supplier_id" class="block text-sm font-medium text-gray-700">
                                            Supplier <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <select id="supplier_id"
                                                name="supplier_id"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 appearance-none transition duration-200 @error('supplier_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('supplier_id')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Warehouse -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="warehouse_id" class="block text-sm font-medium text-gray-700">
                                            Warehouse <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <select id="warehouse_id"
                                                name="warehouse_id"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 appearance-none transition duration-200 @error('warehouse_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Select Warehouse</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ old('warehouse_id', $purchaseOrder->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('warehouse_id')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label for="status" class="block text-sm font-medium text-gray-700">
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-xs text-gray-400">Required</span>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <select id="status"
                                                name="status"
                                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 appearance-none transition duration-200 @error('status') border-red-500 @enderror"
                                                required>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $purchaseOrder->status) == $status ? 'selected' : '' }}
                                                    class="py-2">
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('status')
                                        <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-1.5 bg-emerald-600 rounded-full"></div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">
                                        Financial Information
                                    </h2>
                                    <p class="text-sm text-gray-500">Payment details and calculations</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @php
                                    $financialFields = [
                                        'total_amount' => ['label' => 'Total Amount', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'tax_amount' => ['label' => 'Tax Amount', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        'discount' => ['label' => 'Discount', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                                        'final_amount' => ['label' => 'Final Amount', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
                                    ];
                                @endphp

                                @foreach ($financialFields as $field => $data)
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">
                                                {{ $data['label'] }} <span class="text-red-500">*</span>
                                            </label>
                                            <span class="text-xs text-gray-400">Required</span>
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}" />
                                                </svg>
                                            </div>
                                            <div class="absolute inset-y-0 left-10 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">$</span>
                                            </div>
                                            <input type="number"
                                                   step="0.01"
                                                   id="{{ $field }}"
                                                   name="{{ $field }}"
                                                   value="{{ old($field, $purchaseOrder->$field) }}"
                                                   class="pl-20 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition duration-200 @error($field) border-red-500 @enderror"
                                                   required>
                                        </div>
                                        @error($field)
                                            <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <!-- Notes -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">
                                        Notes
                                    </label>
                                    <span class="text-xs text-blue-600">Optional</span>
                                </div>
                                <div class="relative">
                                    <div class="absolute top-3 left-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                    </div>
                                    <textarea id="notes"
                                              name="notes"
                                              rows="4"
                                              class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900 transition duration-200 resize-none @error('notes') border-red-500 @enderror"
                                              placeholder="Add any additional notes or instructions...">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                                </div>
                                @error('notes')
                                    <p class="text-sm text-red-600 flex items-center gap-1 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-8 border-t border-gray-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Last updated: {{ $purchaseOrder->updated_at->format('M d, Y \a\t H:i') }}</span>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('purchase.purchase-orders.show', $purchaseOrder->id) }}"
                                       class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 flex items-center justify-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Update Purchase Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-calculate final amount
        document.addEventListener('DOMContentLoaded', function() {
            const totalInput = document.getElementById('total_amount');
            const taxInput = document.getElementById('tax_amount');
            const discountInput = document.getElementById('discount');
            const finalInput = document.getElementById('final_amount');

            function calculateFinalAmount() {
                const total = parseFloat(totalInput.value) || 0;
                const tax = parseFloat(taxInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const final = total + tax - discount;
                finalInput.value = final.toFixed(2);
            }

            [totalInput, taxInput, discountInput].forEach(input => {
                input.addEventListener('input', calculateFinalAmount);
                input.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });

            // Set minimum dates
            const today = new Date().toISOString().split('T')[0];
            const orderDateInput = document.getElementById('order_date');
            const expectedDateInput = document.getElementById('expected_delivery_date');

            if (orderDateInput) orderDateInput.setAttribute('min', today);
            if (expectedDateInput) expectedDateInput.setAttribute('min', today);

            // Format currency inputs on page load
            [totalInput, taxInput, discountInput, finalInput].forEach(input => {
                if (input.value) {
                    input.value = parseFloat(input.value).toFixed(2);
                }
            });
        });
    </script>
@endpush
