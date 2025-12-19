<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - {{ config('app.name') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Print-specific styles -->
    <style>
        @media print {
            @page {
                margin: 0.5in;
                size: A4;
            }

            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            .page-break {
                page-break-before: always;
                page-break-inside: avoid;
            }

            .avoid-break {
                page-break-inside: avoid;
            }

            .print-border {
                border-color: #000 !important;
            }

            .watermark {
                opacity: 0.1 !important;
            }

            .shadow-none {
                box-shadow: none !important;
            }
        }

        /* General styles for screen */
        @media screen {
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 2rem;
                min-height: 100vh;
            }

            .invoice-container {
                animation: slideUp 0.3s ease-out;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }

        /* Watermark styles */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 6rem;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.05);
            z-index: 0;
            pointer-events: none;
            opacity: 0.3;
        }

        /* Invoice specific styles */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .signature-line {
            border-top: 1px dashed #666;
            width: 200px;
            margin-top: 2rem;
        }

        /* Grid layout for invoice */
        .invoice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Print Controls -->
    <div class="no-print fixed top-4 right-4 z-50">
        <div class="bg-white rounded-xl shadow-xl p-4 space-x-3">
            <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                <i class="fas fa-print mr-2"></i>Print Invoice
            </button>
            <button onclick="window.close()"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md">
                <i class="fas fa-times mr-2"></i>Close
            </button>
            <button onclick="downloadAsPDF()"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-md">
                <i class="fas fa-download mr-2"></i>Save PDF
            </button>
        </div>
    </div>

    <!-- Watermark -->
    @if (in_array($invoice->status, ['draft', 'paid']))
        <div class="watermark print-only">
            {{ strtoupper($invoice->status) }}
        </div>
    @endif

    <!-- Invoice Container -->
    <div class="invoice-container bg-white rounded-2xl shadow-2xl max-w-4xl mx-auto overflow-hidden">
        <!-- Header -->
        <div class="p-8 border-b-4 border-blue-500 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        @if (isset($company) && $company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo"
                                class="h-16 object-contain">
                        @endif
                        <div>
                            <h1 class="text-4xl font-bold gradient-text">
                                {{ config('app.name', 'Your Company') }}
                            </h1>
                            <p class="text-gray-600 text-lg">Professional Services</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-map-marker-alt w-5 text-blue-500"></i>
                            <span class="ml-3">123 Business Street, City, State 12345</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-phone w-5 text-blue-500"></i>
                            <span class="ml-3">(123) 456-7890</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-envelope w-5 text-blue-500"></i>
                            <span class="ml-3">billing@company.com</span>
                        </div>
                        <div class="flex items-center text-gray-700 font-medium">
                            <i class="fas fa-id-card w-5 text-blue-500"></i>
                            <span class="ml-3">GSTIN: 22AAAAA0000A1Z5</span>
                        </div>
                    </div>
                </div>

                <!-- Invoice Title & Status -->
                <div class="text-right space-y-3">
                    <div>
                        <h2 class="text-5xl font-bold text-gray-900">INVOICE</h2>
                        <p class="text-2xl text-gray-600 mt-2">{{ $invoice->invoice_number }}</p>
                    </div>

                    <div class="inline-block">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-500',
                                'sent' => 'bg-blue-500',
                                'paid' => 'bg-green-500',
                                'overdue' => 'bg-red-500',
                            ];
                        @endphp
                        <span
                            class="inline-flex items-center px-4 py-2 rounded-full text-white font-bold {{ $statusColors[$invoice->status] }}">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            {{ strtoupper($invoice->status) }}
                        </span>
                    </div>

                    <!-- Dates -->
                    <div class="space-y-1">
                        <div class="text-gray-700">
                            <span class="font-semibold">Date:</span>
                            {{ $invoice->invoice_date->format('F d, Y') }}
                        </div>
                        <div class="text-gray-700">
                            <span class="font-semibold">Due Date:</span>
                            {{ $invoice->due_date->format('F d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill To & Invoice Details -->
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bill To -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <i class="fas fa-building text-blue-600 text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Bill To</h3>
                    </div>

                    <div class="space-y-3">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $invoice->customer->name }}</h4>

                        @if ($invoice->customer->address_line1)
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-gray-500 mt-1 mr-3"></i>
                                <div>
                                    <p class="text-gray-700">{{ $invoice->customer->address_line1 }}</p>
                                    @if ($invoice->customer->address_line2)
                                        <p class="text-gray-700">{{ $invoice->customer->address_line2 }}</p>
                                    @endif
                                    <p class="text-gray-700">
                                        {{ $invoice->customer->city }}, {{ $invoice->customer->state }}
                                        {{ $invoice->customer->pincode }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($invoice->customer->phone)
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-phone text-gray-500 mr-3"></i>
                                {{ $invoice->customer->phone }}
                            </div>
                        @endif

                        @if ($invoice->customer->email)
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-envelope text-gray-500 mr-3"></i>
                                {{ $invoice->customer->email }}
                            </div>
                        @endif

                        @if ($invoice->customer->gstin)
                            <div class="flex items-center font-medium text-gray-900 mt-2">
                                <i class="fas fa-id-card text-gray-500 mr-3"></i>
                                GSTIN: {{ $invoice->customer->gstin }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-gray-100 rounded-lg mr-3">
                            <i class="fas fa-file-invoice text-gray-600 text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Invoice Details</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Invoice Number:</span>
                            <span class="font-semibold">{{ $invoice->invoice_number }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Invoice Date:</span>
                            <span class="font-semibold">{{ $invoice->invoice_date->format('F d, Y') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Due Date:</span>
                            <span
                                class="font-semibold {{ $invoice->due_date->isPast() && $invoice->status != 'paid' ? 'text-red-600' : '' }}">
                                {{ $invoice->due_date->format('F d, Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Payment Terms:</span>
                            <span class="font-semibold">
                                Net {{ $invoice->due_date->diffInDays($invoice->invoice_date) }} Days
                            </span>
                        </div>

                        @if ($invoice->reference_number)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Reference:</span>
                                <span class="font-semibold">{{ $invoice->reference_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="px-8 pb-8">
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-indigo-600">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider w-12">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Description
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider w-24">
                                Qty
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider w-32">
                                Unit Price
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider w-24">
                                Tax %
                            </th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider w-32">
                                Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($invoice->items as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $item->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-700">
                                    BDT {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-700">
                                    {{ $item->tax_rate ?? 18 }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right text-gray-900">
                                    BDT {{ number_format($item->total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals Section -->
        <div class="px-8 pb-8">
            <div class="flex justify-end">
                <div class="w-full md:w-1/2">
                    <div class="space-y-3">
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="font-semibold">BDT {{ number_format($invoice->subtotal, 2) }}</span>
                        </div>

                        <!-- Discount -->
                        @if ($invoice->discount > 0)
                            <div class="flex justify-between items-center text-green-600">
                                <span>Discount</span>
                                <span class="font-semibold">- BDT {{ number_format($invoice->discount, 2) }}</span>
                            </div>

                            <!-- Taxable Amount -->
                            <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                                <span class="text-gray-700">Taxable Amount</span>
                                <span class="font-semibold">
                                    BDT
                                    {{ number_format($invoice->taxable_amount ?? $invoice->subtotal - $invoice->discount, 2) }}
                                </span>
                            </div>
                        @endif

                        <!-- Tax -->
                        @if ($invoice->tax_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">GST ({{ $invoice->tax_rate ?? 18 }}%)</span>
                                <span class="font-semibold">BDT {{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>
                        @endif

                        <!-- Shipping -->
                        @if ($invoice->shipping_charges > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Shipping Charges</span>
                                <span class="font-semibold">BDT
                                    {{ number_format($invoice->shipping_charges, 2) }}</span>
                            </div>
                        @endif

                        <!-- Adjustment -->
                        @if ($invoice->adjustment_amount != 0)
                            <div
                                class="flex justify-between items-center {{ $invoice->adjustment_amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span>Adjustment</span>
                                <span class="font-semibold">
                                    {{ $invoice->adjustment_amount > 0 ? '+' : '' }}BDT
                                    {{ number_format(abs($invoice->adjustment_amount), 2) }}
                                </span>
                            </div>
                        @endif

                        <!-- Total -->
                        <div
                            class="flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-100">
                            <span class="text-lg font-bold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-bold text-gray-900">
                                BDT {{ number_format($invoice->total_amount, 2) }}
                            </span>
                        </div>

                        <!-- Amount Paid & Balance -->
                        @if ($invoice->amount_paid > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Amount Paid</span>
                                <span class="font-semibold text-green-600">
                                    BDT {{ number_format($invoice->amount_paid, 2) }}
                                </span>
                            </div>

                            <div
                                class="flex justify-between items-center bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-lg border border-yellow-100">
                                <span class="text-lg font-bold text-gray-900">Balance Due</span>
                                <span class="text-2xl font-bold text-gray-900">
                                    BDT {{ number_format($invoice->balance_due, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="px-8 pb-8 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-credit-card text-blue-500 mr-3"></i>
                Payment Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <div class="flex items-center">
                        <i class="fas fa-university text-gray-500 w-5 mr-3"></i>
                        <div>
                            <p class="font-semibold text-gray-900">ABC Bank</p>
                            <p class="text-sm text-gray-600">Main Branch, City</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-500 w-5 mr-3"></i>
                        <p class="text-gray-700">Account Name: Your Company Name</p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-hashtag text-gray-500 w-5 mr-3"></i>
                        <p class="text-gray-700">Account No: 1234567890</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center">
                        <i class="fas fa-qrcode text-gray-500 w-5 mr-3"></i>
                        <p class="text-gray-700">IFSC: ABCB0123456</p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-mobile-alt text-gray-500 w-5 mr-3"></i>
                        <p class="text-gray-700">UPI: companyname@bank</p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-gray-500 w-5 mr-3"></i>
                        <p class="text-gray-700">SWIFT: ABCBUS33</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes & Terms -->
        @if ($invoice->notes || $invoice->terms)
            <div class="px-8 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if ($invoice->notes)
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-sticky-note text-blue-500 mr-3"></i>
                                Notes
                            </h4>
                            <div class="prose prose-blue max-w-none">
                                {!! nl2br(e($invoice->notes)) !!}
                            </div>
                        </div>
                    @endif

                    @if ($invoice->terms)
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-file-contract text-gray-600 mr-3"></i>
                                Terms & Conditions
                            </h4>
                            <div class="prose prose-gray max-w-none">
                                {!! nl2br(e($invoice->terms)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Signatures & Footer -->
        <div class="px-8 py-8 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
            <!-- Signatures -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div class="text-center">
                    <div class="signature-line mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-600">Authorized Signature</p>
                </div>
                <div class="text-center">
                    <div class="signature-line mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-600">Client Signature</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center space-y-2">
                <p class="text-gray-700 font-semibold">Thank you for your business!</p>
                <p class="text-sm text-gray-500">
                    This is a computer generated invoice. No signature required.
                </p>
                <p class="text-xs text-gray-400">
                    Generated on: {{ now()->format('F d, Y \a\t h:i A') }}
                </p>
            </div>

            <!-- Draft Notice -->
            @if ($invoice->status == 'draft')
                <div class="mt-6 p-4 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-bold text-red-700">DRAFT COPY - FOR INTERNAL USE ONLY</p>
                            <p class="text-sm text-red-600">This document is not valid for payment</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Additional Terms Page -->
    @if ($invoice->terms && strlen($invoice->terms) > 500)
        <div class="page-break mt-8"></div>
        <div class="invoice-container bg-white rounded-2xl shadow-2xl max-w-4xl mx-auto p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Terms & Conditions</h2>
            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($invoice->terms)) !!}
            </div>
        </div>
    @endif

    <script>
        // Auto-print option
        @if (request('autoprint'))
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                }, 1000);
            });
        @endif

        // Download as PDF function
        function downloadAsPDF() {
            // This is a placeholder - in a real application, you would:
            // 1. Use a PDF generation library (jsPDF, html2pdf, etc.)
            // 2. Or make an API call to your backend to generate PDF

            alert('PDF download would be implemented here. In production, use a PDF generation library or API call.');

            // Example using html2pdf.js (uncomment if you add the library)
            /*
            const element = document.querySelector('.invoice-container');
            html2pdf()
                .from(element)
                .set({
                    margin: 10,
                    filename: 'invoice-{{ $invoice->invoice_number }}.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                })
                .save();
            */
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + P to print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }

            // Escape to close
            if (e.key === 'Escape') {
                window.close();
            }

            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                downloadAsPDF();
            }
        });

        // Close after print (optional)
        window.onafterprint = function() {
            // Uncomment if you want to close window after printing
            // setTimeout(function() {
            //     if (!window.isDownloadingPDF) {
            //         window.close();
            //     }
            // }, 1000);
        };
    </script>

    <!-- Optional: Add PDF generation library -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script> -->
</body>

</html>
