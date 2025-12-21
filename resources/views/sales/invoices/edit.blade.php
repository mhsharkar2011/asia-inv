@extends('layouts.admin')

@section('title', 'Edit Invoice')

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
                            <a href="{{ route('sales.invoices.index') }}"
                                class="text-gray-500 hover:text-gray-700">Invoices</a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('sales.invoices.show', $invoice) }}"
                                class="text-gray-500 hover:text-gray-700">#{{ $invoice->invoice_number }}</a>
                        </li>
                        <li>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li class="text-gray-900 font-medium">Edit</li>
                    </ol>
                </nav>

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Invoice #{{ $invoice->invoice_number }}</h1>
                        <p class="mt-1 text-sm text-gray-500">Update customer invoice details</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('sales.invoices.show', $invoice) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                    clip-rule="evenodd" />
                            </svg>
                            Back
                        </a>
                        <button type="button" onclick="showDeleteModal()"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <form action="{{ route('sales.invoices.update', $invoice) }}" method="POST" id="invoiceForm">
            @csrf
            @method('PUT')

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <!-- Left Column - Invoice Details -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Customer & Basic Info Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Customer Information</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Customer Selection -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer *</label>
                                        <select name="customer_id" id="customer_id"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required onchange="loadCustomerDetails(this.value)">
                                            <option value="">Select a Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" data-email="{{ $customer->email }}"
                                                    data-phone="{{ $customer->phone }}"
                                                    data-address="{{ $customer->address_line1 }}"
                                                    data-city="{{ $customer->city }}" data-state="{{ $customer->state }}"
                                                    data-pincode="{{ $customer->pincode }}"
                                                    data-gstin="{{ $customer->gstin ?? '' }}"
                                                    {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} -
                                                    {{ $customer->customer_code ?? $customer->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Customer Details Display -->
                                    <div class="md:col-span-2">
                                        <div id="customerDetails"
                                            class="{{ $invoice->customer ? '' : 'hidden' }} bg-blue-50 rounded-lg p-4 border border-blue-100">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-2">Contact Information</h4>
                                                    <div class="space-y-1">
                                                        <p id="customerEmail" class="text-sm text-gray-600">
                                                            {{ $invoice->customer->email ?? '' }}</p>
                                                        <p id="customerPhone" class="text-sm text-gray-600">
                                                            {{ $invoice->customer->phone ?? '' }}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-900 mb-2">Address & GST</h4>
                                                    <div class="space-y-1">
                                                        <p id="customerAddress" class="text-sm text-gray-600">
                                                            @if ($invoice->customer)
                                                                {{ $invoice->customer->address_line1 }},
                                                                {{ $invoice->customer->city }},
                                                                {{ $invoice->customer->state }} -
                                                                {{ $invoice->customer->pincode }}
                                                            @endif
                                                        </p>
                                                        <p id="customerGSTIN" class="text-sm font-medium text-gray-700">
                                                            {{ $invoice->customer->gstin ? 'GSTIN: ' . $invoice->customer->gstin : 'GSTIN not provided' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Invoice Dates -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Date *</label>
                                        <input type="date" name="invoice_date"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date *</label>
                                        <input type="date" name="due_date"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required>
                                    </div>

                                    <!-- Invoice Status -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <div class="flex items-center space-x-4">
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-gray-100 text-gray-800',
                                                    'sent' => 'bg-blue-100 text-blue-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'overdue' => 'bg-red-100 text-red-800',
                                                    'cancelled' => 'bg-gray-100 text-gray-800',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                            @if ($invoice->status == 'paid')
                                                <span class="text-sm text-gray-500">
                                                    Paid on {{ $invoice->paid_at->format('M d, Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Items Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-600 to-green-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h2 class="text-lg font-semibold text-white">Invoice Items</h2>
                                    </div>
                                    <button type="button" id="addItemBtn"
                                        class="inline-flex items-center px-4 py-2 bg-white text-green-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
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
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                                    #</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                                                    Quantity *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                                                    Unit Price *</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                                                    Total</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsBody" class="bg-white divide-y divide-gray-200">
                                            @foreach ($invoice->items as $index => $item)
                                                <tr class="item-row hover:bg-gray-50 transition">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $index + 1 }}</td>
                                                    <td class="px-6 py-4">
                                                        <input type="text"
                                                            name="items[{{ $index }}][description]"
                                                            class="item-description w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                                            value="{{ old('items.' . $index . '.description', $item->description) }}"
                                                            placeholder="Item description" required>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <input type="number" name="items[{{ $index }}][quantity]"
                                                            class="item-quantity w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                                            value="{{ old('items.' . $index . '.quantity', $item->quantity) }}"
                                                            min="1" step="0.01" required>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">BDT</span>
                                                            </div>
                                                            <input type="number"
                                                                name="items[{{ $index }}][unit_price]"
                                                                class="item-price w-full border border-gray-300 rounded-md py-2 pl-10 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                                                value="{{ old('items.' . $index . '.unit_price', $item->unit_price) }}"
                                                                min="0" step="0.01" required>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="relative">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">BDT</span>
                                                            </div>
                                                            <input type="text"
                                                                class="item-total w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-10 pr-3 text-gray-700 text-sm"
                                                                value="{{ number_format($item->quantity * $item->unit_price, 2) }}"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <button type="button"
                                                            class="remove-item text-red-400 hover:text-red-600 transition {{ $loop->first && count($invoice->items) == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                            {{ $loop->first && count($invoice->items) == 1 ? 'disabled' : '' }}>
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50 border-t border-gray-200">
                                            <tr>
                                                <td colspan="3"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                    Subtotal:</td>
                                                <td colspan="2" class="px-6 py-3">
                                                    <div class="flex items-center">
                                                        <span class="text-gray-500 mr-2">BDT</span>
                                                        <input type="text" id="subtotal"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 text-gray-700 text-sm font-medium"
                                                            value="{{ number_format($invoice->subtotal, 2) }}" readonly>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"
                                                    class="px-6 py-3 text-right text-sm font-medium text-gray-900">Tax
                                                    (18%):</td>
                                                <td colspan="2" class="px-6 py-3">
                                                    <div class="flex items-center">
                                                        <span class="text-gray-500 mr-2">BDT</span>
                                                        <input type="text" id="taxAmount"
                                                            class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 text-gray-700 text-sm font-medium"
                                                            value="{{ number_format($invoice->tax_amount, 2) }}" readonly>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="bg-gray-100">
                                                <td colspan="3"
                                                    class="px-6 py-3 text-right text-sm font-bold text-gray-900">Total
                                                    Amount:</td>
                                                <td colspan="2" class="px-6 py-3">
                                                    <div class="flex items-center">
                                                        <span class="text-gray-500 mr-2 font-bold">BDT</span>
                                                        <input type="text" id="totalAmount"
                                                            class="w-full bg-gray-100 border border-gray-300 rounded-md py-2 px-3 text-gray-900 font-bold text-sm"
                                                            value="{{ number_format($invoice->total_amount, 2) }}"
                                                            readonly>
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
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-600 to-purple-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Additional Information</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes
                                            (Optional)</label>
                                        <textarea name="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                            placeholder="Add any notes or special instructions...">{{ old('notes', $invoice->notes) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Terms & Conditions
                                            (Optional)</label>
                                        <textarea name="terms" rows="3"
                                            class="w-full border border-gray-300 rounded-lg py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                                            placeholder="Add payment terms and conditions...">{{ old('terms', $invoice->terms) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Summary & Actions -->
                    <div class="lg:col-span-4 mt-6 lg:mt-0">
                        <!-- Summary Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-amber-600 to-amber-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Invoice Summary</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <!-- Invoice Number -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Invoice Number:</span>
                                        <span class="text-sm font-medium text-gray-900" id="invoiceNumberDisplay">
                                            {{ $invoice->invoice_number }}
                                        </span>
                                    </div>

                                    <!-- Status -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        @php
                                            $statusColors = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'sent' => 'bg-blue-100 text-blue-800',
                                                'paid' => 'bg-green-100 text-green-800',
                                                'overdue' => 'bg-red-100 text-red-800',
                                                'cancelled' => 'bg-gray-100 text-gray-800',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$invoice->status] }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>

                                    <hr class="my-4">

                                    <!-- Amounts -->
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Subtotal:</span>
                                            <span class="text-sm font-medium text-gray-900" id="summarySubtotal">
                                                BDT {{ number_format($invoice->subtotal, 2) }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Tax (18%):</span>
                                            <span class="text-sm font-medium text-gray-900" id="summaryTax">
                                                BDT {{ number_format($invoice->tax_amount, 2) }}
                                            </span>
                                        </div>

                                        <hr class="my-3">

                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                                            <span class="text-xl font-bold text-gray-900" id="summaryTotal">
                                                BDT {{ number_format($invoice->total_amount, 2) }}
                                            </span>
                                        </div>

                                        @if ($invoice->paid_amount > 0)
                                            <div class="pt-3 border-t border-gray-200">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm text-gray-600">Paid Amount:</span>
                                                    <span class="text-sm font-medium text-green-600">
                                                        BDT {{ number_format($invoice->paid_amount, 2) }}
                                                    </span>
                                                </div>
                                                <div class="flex justify-between items-center mt-1">
                                                    <span class="text-sm text-gray-600">Balance Due:</span>
                                                    <span class="text-sm font-medium text-red-600">
                                                        BDT
                                                        {{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Hidden Fields for Calculations -->
                                    <input type="hidden" name="subtotal" id="hiddenSubtotal"
                                        value="{{ $invoice->subtotal }}">
                                    <input type="hidden" name="tax_amount" id="hiddenTaxAmount"
                                        value="{{ $invoice->tax_amount }}">
                                    <input type="hidden" name="total_amount" id="hiddenTotalAmount"
                                        value="{{ $invoice->total_amount }}">
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-indigo-700">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h2 class="text-lg font-semibold text-white">Update Invoice</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    <button type="submit" name="action" value="update"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Update Invoice
                                    </button>

                                    @if ($invoice->status == 'draft')
                                        <button type="submit" name="action" value="update_and_send"
                                            class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            Update & Send
                                        </button>
                                    @endif

                                    <a href="{{ route('sales.invoices.show', $invoice) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 text-center">
                                        Created: {{ \Carbon\Carbon::parse($invoice->created_at)->format('M d, Y') }}<br>
                                        Last Updated: {{ \Carbon\Carbon::parse($invoice->updated_at)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.072 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Invoice
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete invoice #{{ $invoice->invoice_number }}? This action
                                    cannot be undone.
                                </p>
                                @if ($invoice->status == 'paid')
                                    <p class="mt-2 text-sm text-red-600 font-medium">
                                        Warning: This invoice has been paid. Deleting it may affect your financial records.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('sales.invoices.destroy', $invoice) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="hideDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .item-row {
            transition: background-color 0.15s ease-in-out;
        }

        .item-row:hover {
            background-color: #f9fafb;
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

        /* Smooth transitions */
        .transition {
            transition: all 0.15s ease-in-out;
        }

        /* Focus styles */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Invoice Edit Form - Initializing...');

            // Constants
            const TAX_RATE = 0.18; // 18% GST
            let itemCount = {{ count($invoice->items) }};

            // DOM Elements
            const itemsBody = document.getElementById('itemsBody');
            const addItemBtn = document.getElementById('addItemBtn');
            const invoiceForm = document.getElementById('invoiceForm');

            // Event Listeners
            if (addItemBtn) {
                addItemBtn.addEventListener('click', addNewItemRow);
            }

            if (invoiceForm) {
                invoiceForm.addEventListener('submit', validateForm);
            }

            // Add item row event delegation
            itemsBody.addEventListener('input', function(e) {
                if (e.target.classList.contains('item-quantity') ||
                    e.target.classList.contains('item-price')) {
                    calculateItemTotal(e.target.closest('.item-row'));
                    calculateTotals();
                }
            });

            // Remove item event delegation
            itemsBody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const row = e.target.closest('.item-row');
                    if (row && document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                        renumberRows();
                        calculateTotals();
                    }
                }
            });

            // Functions
            function addNewItemRow() {
                const row = document.createElement('tr');
                row.className = 'item-row hover:bg-gray-50 transition';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">${itemCount + 1}</td>
                    <td class="px-6 py-4">
                        <input type="text"
                               name="items[${itemCount}][description]"
                               class="item-description w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                               placeholder="Item description"
                               required>
                    </td>
                    <td class="px-6 py-4">
                        <input type="number"
                               name="items[${itemCount}][quantity]"
                               class="item-quantity w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                               value="1"
                               min="1"
                               step="0.01"
                               required>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">BDT</span>
                            </div>
                            <input type="number"
                                   name="items[${itemCount}][unit_price]"
                                   class="item-price w-full border border-gray-300 rounded-md py-2 pl-10 pr-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   value="0"
                                   min="0"
                                   step="0.01"
                                   required>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">BDT</span>
                            </div>
                            <input type="text"
                                   class="item-total w-full bg-gray-50 border border-gray-300 rounded-md py-2 pl-10 pr-3 text-gray-700 text-sm"
                                   value="0.00"
                                   readonly>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button type="button"
                                class="remove-item text-red-400 hover:text-red-600 transition"
                                >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                `;

                itemsBody.appendChild(row);
                itemCount++;

                // Focus on new item description
                row.querySelector('.item-description')?.focus();
            }

            function calculateItemTotal(row) {
                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const total = quantity * price;

                row.querySelector('.item-total').value = total.toFixed(2);
                return total;
            }

            function calculateTotals() {
                let subtotal = 0;

                document.querySelectorAll('.item-row').forEach(row => {
                    subtotal += calculateItemTotal(row);
                });

                const taxAmount = subtotal * TAX_RATE;
                const totalAmount = subtotal + taxAmount;

                // Update display
                updateElementValue('subtotal', subtotal.toFixed(2));
                updateElementValue('taxAmount', taxAmount.toFixed(2));
                updateElementValue('totalAmount', totalAmount.toFixed(2));

                document.getElementById('summarySubtotal').textContent = 'BDT ' + subtotal.toFixed(2);
                document.getElementById('summaryTax').textContent = 'BDT ' + taxAmount.toFixed(2);
                document.getElementById('summaryTotal').textContent = 'BDT ' + totalAmount.toFixed(2);

                // Update hidden fields for form submission
                document.getElementById('hiddenSubtotal').value = subtotal.toFixed(2);
                document.getElementById('hiddenTaxAmount').value = taxAmount.toFixed(2);
                document.getElementById('hiddenTotalAmount').value = totalAmount.toFixed(2);
            }

            function renumberRows() {
                document.querySelectorAll('.item-row').forEach((row, index) => {
                    // Update row number
                    const rowNumberCell = row.querySelector('td:first-child');
                    if (rowNumberCell) {
                        rowNumberCell.textContent = index + 1;
                    }

                    // Update input names
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && name.includes('items[')) {
                            input.name = name.replace(/items\[\d+\]/, `items[${index}]`);
                        }
                    });
                });

                itemCount = document.querySelectorAll('.item-row').length;
            }

            function updateElementValue(id, value) {
                const element = document.getElementById(id);
                if (element) {
                    element.value = value;
                }
            }

            function loadCustomerDetails(customerId) {
                const customerDetails = document.getElementById('customerDetails');
                const customerSelect = document.querySelector(`option[value="${customerId}"]`);

                if (!customerSelect || customerId === '') {
                    customerDetails.classList.add('hidden');
                    return;
                }

                // Extract customer data from data attributes
                const email = customerSelect.dataset.email || '';
                const phone = customerSelect.dataset.phone || '';
                const address = customerSelect.dataset.address || '';
                const city = customerSelect.dataset.city || '';
                const state = customerSelect.dataset.state || '';
                const pincode = customerSelect.dataset.pincode || '';
                const gstin = customerSelect.dataset.gstin || '';

                // Update display
                document.getElementById('customerEmail').textContent = email;
                document.getElementById('customerPhone').textContent = phone;

                const fullAddress = address + (city ? ', ' + city : '') + (state ? ', ' + state : '') + (pincode ?
                    ' - ' + pincode : '');
                document.getElementById('customerAddress').textContent = fullAddress || 'Address not available';

                document.getElementById('customerGSTIN').textContent = gstin ? `GSTIN: ${gstin}` :
                    'GSTIN not provided';

                // Show details
                customerDetails.classList.remove('hidden');
            }

            function validateForm(e) {
                // Validate customer selection
                const customerSelect = document.getElementById('customer_id');
                if (!customerSelect || !customerSelect.value) {
                    e.preventDefault();
                    showAlert('Please select a customer.', 'error');
                    customerSelect.focus();
                    return false;
                }

                // Validate at least one valid item
                const validItems = Array.from(document.querySelectorAll('.item-row')).filter(row => {
                    const description = row.querySelector('.item-description')?.value.trim();
                    const quantity = parseFloat(row.querySelector('.item-quantity')?.value) || 0;
                    const price = parseFloat(row.querySelector('.item-price')?.value) || 0;

                    return description && quantity > 0 && price > 0;
                });

                if (validItems.length === 0) {
                    e.preventDefault();
                    showAlert('Please add at least one valid item with description, quantity, and price.', 'error');
                    return false;
                }

                // Validate dates
                const invoiceDate = document.querySelector('input[name="invoice_date"]');
                const dueDate = document.querySelector('input[name="due_date"]');

                if (new Date(dueDate.value) < new Date(invoiceDate.value)) {
                    e.preventDefault();
                    showAlert('Due date must be after invoice date.', 'error');
                    dueDate.focus();
                    return false;
                }

                return true;
            }

            function showAlert(message, type = 'info') {
                // Create alert element
                const alert = document.createElement('div');
                alert.className =
                    `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg ${type === 'error' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-blue-50 border border-blue-200 text-blue-700'}`;
                alert.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'error' ?
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />' :
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'}
                        </svg>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(alert);

                // Remove alert after 5 seconds
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            }

            function showDeleteModal() {
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            function hideDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            // Initialize calculations
            calculateTotals();

            console.log('Invoice Edit Form - Initialization complete');
        });
    </script>
@endpush
