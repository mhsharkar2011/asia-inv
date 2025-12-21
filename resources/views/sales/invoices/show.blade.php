@extends('layouts.admin')

@section('title', 'Invoice - ' . $invoice->invoice_number)

@section('content')
    <div class="min-h-screen bg-gray-50 py-6">
        <!-- Header Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <nav class="flex mb-4" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2">
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li>
                                    <a href="{{ route('sales.invoices.index') }}" class="text-gray-500 hover:text-gray-700">
                                        Invoices
                                    </a>
                                </li>
                                <li>
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </li>
                                <li class="text-gray-900 font-medium">{{ $invoice->invoice_number }}</li>
                            </ol>
                        </nav>
                        <h1 class="text-2xl font-bold text-gray-900">Invoice Details</h1>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($invoice->status == 'draft')
                            <a href="{{ route('sales.invoices.edit', $invoice->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        @endif
                        <a href="{{ route('sales.invoices.print', $invoice->id) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print
                        </a>
                        <a href="{{ route('sales.invoices.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Banner -->
            <div class="mb-6">
                @php
                    $statusColors = [
                        'draft' => 'bg-gray-100 border-gray-300 text-gray-800',
                        'sent' => 'bg-blue-50 border-blue-200 text-blue-800',
                        'paid' => 'bg-green-50 border-green-200 text-green-800',
                        'overdue' => 'bg-red-50 border-red-200 text-red-800',
                    ];

                    $statusIcons = [
                        'draft' => 'fa-edit',
                        'sent' => 'fa-paper-plane',
                        'paid' => 'fa-check-circle',
                        'overdue' => 'fa-exclamation-triangle',
                    ];
                @endphp

                <div class="rounded-lg border {{ $statusColors[$invoice->status] }} p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas {{ $statusIcons[$invoice->status] }} text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">
                                    Invoice {{ $invoice->invoice_number }} -
                                    <span class="uppercase">{{ $invoice->status }}</span>
                                </h3>
                                <p class="mt-1">
                                    @if ($invoice->status == 'draft')
                                        This invoice is in draft mode. Edit or send to customer.
                                    @elseif($invoice->status == 'sent')
                                        Invoice sent to customer on {{ $invoice->updated_at->format('d M, Y') }}.
                                    @elseif($invoice->status == 'paid')
                                        Invoice paid in full. Thank you!
                                    @elseif($invoice->status == 'overdue')
                                        This invoice is overdue by {{ now()->diffInDays($invoice->due_date) }} days.
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if ($invoice->status == 'draft')
                            <form action="{{ route('sales.invoices.send', $invoice->id) }}" method="POST"
                                class="flex-shrink-0">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Send Invoice
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Invoice Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Invoice</h2>
                                    <p class="text-gray-600">{{ $invoice->invoice_number }}</p>
                                </div>
                                <div class="mt-2 md:mt-0 md:text-right">
                                    <div class="text-2xl font-bold text-gray-900">
                                        BDT{{ number_format($invoice->total_amount, 2) }}
                                    </div>
                                    <p class="text-gray-600">Total Amount</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- From/To Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- From -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">From</h3>
                                    <address class="not-italic">
                                        <div class="font-semibold text-gray-900 mb-1">Your Company Name</div>
                                        <div class="text-gray-600 space-y-1">
                                            <div>123 Business Street</div>
                                            <div>City, State 12345</div>
                                            <div>Phone: (123) 456-7890</div>
                                            <div>Email: billing@company.com</div>
                                            <div class="mt-2 font-medium">GSTIN: 22AAAAA0000A1Z5</div>
                                        </div>
                                    </address>
                                </div>

                                <!-- To -->
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Bill To
                                    </h3>
                                    <address class="not-italic">
                                        <div class="font-semibold text-gray-900 mb-1">{{ $invoice->customer->name }}</div>
                                        <div class="text-gray-600 space-y-1">
                                            @if ($invoice->customer->address_line1)
                                                <div>{{ $invoice->customer->address_line1 }}</div>
                                                @if ($invoice->customer->address_line2)
                                                    <div>{{ $invoice->customer->address_line2 }}</div>
                                                @endif
                                                <div>{{ $invoice->customer->city }}, {{ $invoice->customer->state }}
                                                    {{ $invoice->customer->pincode }}</div>
                                            @endif
                                            @if ($invoice->customer->phone)
                                                <div>Phone: {{ $invoice->customer->phone }}</div>
                                            @endif
                                            @if ($invoice->customer->email)
                                                <div>Email: {{ $invoice->customer->email }}</div>
                                            @endif
                                            @if ($invoice->customer->gstin)
                                                <div class="mt-2 font-medium">GSTIN: {{ $invoice->customer->gstin }}</div>
                                            @endif
                                        </div>
                                    </address>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="overflow-hidden rounded-lg border border-gray-200 mb-8">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                #</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Qty</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Unit Price</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($invoice->items as $index => $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-900">{{ $item->description }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-right">
                                                    {{ $item->quantity }}</td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-right">
                                                    BDT{{ number_format($item->unit_price, 2) }}</td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                    BDT{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Subtotal:
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">
                                                BDT{{ number_format($invoice->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Tax (18%):
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">
                                                BDT{{ number_format($invoice->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr class="bg-gray-100">
                                            <td colspan="4"
                                                class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Total Amount:
                                            </td>
                                            <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">
                                                BDT{{ number_format($invoice->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-3 text-sm font-medium text-gray-900 text-right">Amount Paid:
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 text-right">
                                                BDT{{ number_format($invoice->amount_paid, 2) }}</td>
                                        </tr>
                                        <tr class="bg-yellow-50">
                                            <td colspan="4"
                                                class="px-4 py-3 text-sm font-bold text-gray-900 text-right">Balance Due:
                                            </td>
                                            <td
                                                class="px-4 py-3 text-sm font-bold {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-green-600' }} text-right">
                                                BDT{{ number_format($invoice->balance_due, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Notes & Terms -->
                            @if ($invoice->notes || $invoice->terms)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if ($invoice->notes)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Notes</h4>
                                            <p class="text-gray-600 text-sm">{{ $invoice->notes }}</p>
                                        </div>
                                    @endif
                                    @if ($invoice->terms)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Terms & Conditions</h4>
                                            <p class="text-gray-600 text-sm">{{ $invoice->terms }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div
                                class="flex flex-col md:flex-row md:items-center md:justify-between text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Invoice Date: {{ $invoice->invoice_date->format('d M, Y') }}
                                </div>
                                <div class="mt-2 md:mt-0 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Due Date: {{ $invoice->due_date->format('d M, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    @if ($invoice->amount_paid > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payment History
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-center text-gray-500 py-4">Payment history will be displayed here</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Record Payment Card -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-sm border border-green-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-green-700">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Record Payment
                            </h3>
                        </div>
                        <div class="p-4">
                            @if ($invoice->balance_due > 0)
                                <form action="{{ route('sales.invoices.payment', $invoice->id) }}" method="POST"
                                    class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Payment Amount *
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">BDT</span>
                                            </div>
                                            <input type="number" name="amount"
                                                class="pl-12 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                                max="{{ $invoice->balance_due }}" min="0.01" step="0.01"
                                                value="{{ $invoice->balance_due }}" required>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Balance Due: BDT{{ number_format($invoice->balance_due, 2) }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Payment Date *
                                        </label>
                                        <input type="date" name="payment_date"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Payment Method *
                                        </label>
                                        <select name="payment_method"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                            required>
                                            <option value="cash">Cash</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="upi">UPI</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Reference Number
                                        </label>
                                        <input type="text" name="reference"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                            placeholder="Cheque/Transaction number">
                                    </div>

                                    <button type="submit"
                                        class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Record Payment
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-6">
                                    <div
                                        class="mx-auto w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-green-700">Invoice Paid in Full</h4>
                                    <p class="text-green-600 mt-1">No payment required</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Actions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Invoice Actions
                            </h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <a href="{{ route('sales.invoices.print', $invoice->id) }}" target="_blank"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Invoice
                            </a>

                            <a href="#"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download PDF
                            </a>

                            @if ($invoice->status == 'draft')
                                <a href="{{ route('sales.invoices.edit', $invoice->id) }}"
                                    class="flex items-center justify-center w-full px-4 py-2.5 border border-yellow-300 rounded-lg text-sm font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Invoice
                                </a>

                                <form action="{{ route('sales.invoices.destroy', $invoice->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this invoice?')"
                                        class="flex items-center justify-center w-full px-4 py-2.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Invoice
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('sales.customers.show', $invoice->customer_id) }}"
                                class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                View Customer
                            </a>
                        </div>
                    </div>

                    <!-- Invoice Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700">
                            <h3 class="text-lg font-semibold text-white flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Invoice Summary
                            </h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Invoice Number:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Status:</span>
                                @php
                                    $statusBadgeColors = [
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        'sent' => 'bg-blue-100 text-blue-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'overdue' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusBadgeColors[$invoice->status] }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Invoice Date:</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $invoice->invoice_date->format('d M, Y') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Due Date:</span>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $invoice->due_date->format('d M, Y') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Days Overdue:</span>
                                <span
                                    class="text-sm font-medium {{ $invoice->due_date < now() && $invoice->status != 'paid' ? 'text-red-600' : 'text-gray-900' }}">
                                    @if ($invoice->due_date < now() && $invoice->status != 'paid')
                                        {{ now()->diffInDays($invoice->due_date) }} days
                                    @else
                                        0 days
                                    @endif
                                </span>
                            </div>

                            <hr class="my-2">

                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Subtotal:</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">BDT{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tax Amount:</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">BDT{{ number_format($invoice->tax_amount, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-sm font-semibold text-gray-900">Total Amount:</span>
                                    <span
                                        class="text-sm font-semibold text-gray-900">BDT{{ number_format($invoice->total_amount, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Amount Paid:</span>
                                    <span
                                        class="text-sm font-medium text-gray-900">BDT{{ number_format($invoice->amount_paid, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center pt-2 border-t">
                                    <span class="text-sm font-semibold text-gray-900">Balance Due:</span>
                                    <span
                                        class="text-sm font-semibold {{ $invoice->balance_due > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        BDT{{ number_format($invoice->balance_due, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
