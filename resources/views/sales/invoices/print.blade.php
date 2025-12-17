{{-- resources/views/sales/invoices/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} - Print</title>
    <style>
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 20px;
                font-family: 'DejaVu Sans', 'Arial', sans-serif;
                color: #000;
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-before: always;
            }

            .invoice-container {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .table-bordered th,
            .table-bordered td {
                border-color: #000 !important;
            }

            .text-primary {
                color: #000 !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* General Styles */
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            color: #333;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-logo {
            max-height: 80px;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
        }

        .invoice-number {
            font-size: 20px;
            color: #666;
            margin: 5px 0 0 0;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-draft {
            background: #6c757d;
            color: white;
        }

        .status-sent {
            background: #17a2b8;
            color: white;
        }

        .status-paid {
            background: #28a745;
            color: white;
        }

        .status-overdue {
            background: #dc3545;
            color: white;
        }

        .address-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .address-title {
            font-weight: 600;
            color: #007bff;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .py-3 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .border-top {
            border-top: 1px solid #dee2e6;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6;
        }

        .total-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .terms-conditions {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #007bff;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0, 0, 0, 0.1);
            z-index: -1;
            font-weight: bold;
            pointer-events: none;
        }

        /* Print Controls */
        .print-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .print-controls button {
            margin: 0 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-download {
            background: #28a745;
            color: white;
        }

        .btn-close {
            background: #dc3545;
            color: white;
        }
    </style>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Print Controls -->
    <div class="print-controls no-print">
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print me-2"></i>Print
        </button>
        <button onclick="window.close()" class="btn-close">
            <i class="fas fa-times me-2"></i>Close
        </button>
    </div>

    <!-- Watermark (Conditional) -->
    @if ($invoice->status == 'draft')
        <div class="watermark">DRAFT</div>
    @elseif($invoice->status == 'paid')
        <div class="watermark">PAID</div>
    @endif

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    @if (isset($company) && $company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="company-logo">
                    @else
                        <h1 class="invoice-title">{{ config('app.name', 'Your Company') }}</h1>
                    @endif

                    <div style="margin-top: 10px;">
                        <p style="margin: 2px 0;">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            123 Business Street, City, State 12345
                        </p>
                        <p style="margin: 2px 0;">
                            <i class="fas fa-phone text-primary"></i>
                            (123) 456-7890
                        </p>
                        <p style="margin: 2px 0;">
                            <i class="fas fa-envelope text-primary"></i>
                            billing@company.com
                        </p>
                        <p style="margin: 2px 0;">
                            <i class="fas fa-file-invoice text-primary"></i>
                            GSTIN: 22AAAAA0000A1Z5
                        </p>
                    </div>
                </div>

                <div style="text-align: right;">
                    <h1 class="invoice-title">INVOICE</h1>
                    <p class="invoice-number">{{ $invoice->invoice_number }}</p>
                    <div style="margin-top: 10px;">
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ strtoupper($invoice->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
            <div style="flex: 1; margin-right: 20px;">
                <div class="address-box">
                    <div class="address-title">
                        <i class="fas fa-building me-2"></i>BILL TO
                    </div>
                    <p style="margin: 0 0 5px 0; font-weight: 600;">{{ $invoice->customer->name }}</p>
                    @if ($invoice->customer->address_line1)
                        <p style="margin: 0 0 5px 0;">{{ $invoice->customer->address_line1 }}</p>
                    @endif
                    @if ($invoice->customer->address_line2)
                        <p style="margin: 0 0 5px 0;">{{ $invoice->customer->address_line2 }}</p>
                    @endif
                    <p style="margin: 0 0 5px 0;">
                        {{ $invoice->customer->city }},
                        {{ $invoice->customer->state }} -
                        {{ $invoice->customer->pincode }}
                    </p>
                    <p style="margin: 0 0 5px 0;">
                        <i class="fas fa-phone fa-sm"></i> {{ $invoice->customer->phone }}
                    </p>
                    <p style="margin: 0 0 5px 0;">
                        <i class="fas fa-envelope fa-sm"></i> {{ $invoice->customer->email }}
                    </p>
                    @if ($invoice->customer->gstin)
                        <p style="margin: 5px 0 0 0; font-weight: 600;">
                            GSTIN: {{ $invoice->customer->gstin }}
                        </p>
                    @endif
                </div>
            </div>

            <div style="flex: 1;">
                <div class="address-box">
                    <div class="address-title">
                        <i class="fas fa-info-circle me-2"></i>INVOICE DETAILS
                    </div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 5px 0; font-weight: 600;">Invoice Date:</td>
                            <td style="padding: 5px 0; text-align: right;">
                                {{ $invoice->invoice_date->format('d M, Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; font-weight: 600;">Due Date:</td>
                            <td style="padding: 5px 0; text-align: right;">
                                {{ $invoice->due_date->format('d M, Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0; font-weight: 600;">Payment Terms:</td>
                            <td style="padding: 5px 0; text-align: right;">
                                Net {{ $invoice->due_date->diffInDays($invoice->invoice_date) }} Days
                            </td>
                        </tr>
                        @if ($invoice->reference_number)
                            <tr>
                                <td style="padding: 5px 0; font-weight: 600;">Reference:</td>
                                <td style="padding: 5px 0; text-align: right;">
                                    {{ $invoice->reference_number }}
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Invoice Items Table -->
        <div class="mb-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 45%;">Description</th>
                        <th style="width: 15%; text-align: center;">Quantity</th>
                        <th style="width: 15%; text-align: right;">Unit Price</th>
                        <th style="width: 10%; text-align: right;">Tax %</th>
                        <th style="width: 15%; text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $item->description }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">BDT{{ number_format($item->unit_price, 2) }}</td>
                            <td style="text-align: right;">{{ $item->tax_rate ?? 18 }}%</td>
                            <td style="text-align: right;">BDT{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals Section -->
        <div style="display: flex; justify-content: flex-end;">
            <div style="width: 50%;">
                <table class="table" style="margin: 0;">
                    <tbody>
                        <tr>
                            <td style="text-align: right; font-weight: 600; padding: 10px;">Subtotal:</td>
                            <td style="text-align: right; padding: 10px; width: 150px;">
                                BDT{{ number_format($invoice->subtotal, 2) }}
                            </td>
                        </tr>

                        @if ($invoice->discount_amount > 0)
                            <tr>
                                <td style="text-align: right; font-weight: 600; padding: 10px;">Discount:</td>
                                <td style="text-align: right; color: #dc3545; padding: 10px;">
                                    -BDT{{ number_format($invoice->discount_amount, 2) }}
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td style="text-align: right; font-weight: 600; padding: 10px;">Taxable Amount:</td>
                            <td style="text-align: right; padding: 10px;">
                                BDT{{ number_format($invoice->taxable_amount ?? $invoice->subtotal - ($invoice->discount_amount ?? 0), 2) }}
                            </td>
                        </tr>

                        @if ($invoice->tax_amount > 0)
                            <tr>
                                <td style="text-align: right; font-weight: 600; padding: 10px;">GST
                                    ({{ $invoice->tax_rate ?? 18 }}%):</td>
                                <td style="text-align: right; padding: 10px;">
                                    BDT{{ number_format($invoice->tax_amount, 2) }}
                                </td>
                            </tr>
                        @endif

                        @if ($invoice->shipping_charges > 0)
                            <tr>
                                <td style="text-align: right; font-weight: 600; padding: 10px;">Shipping Charges:</td>
                                <td style="text-align: right; padding: 10px;">
                                    BDT{{ number_format($invoice->shipping_charges, 2) }}
                                </td>
                            </tr>
                        @endif

                        @if ($invoice->adjustment_amount != 0)
                            <tr>
                                <td style="text-align: right; font-weight: 600; padding: 10px;">Adjustment:</td>
                                <td
                                    style="text-align: right; padding: 10px; color: {{ $invoice->adjustment_amount > 0 ? '#28a745' : '#dc3545' }};">
                                    {{ $invoice->adjustment_amount > 0 ? '+' : '' }}BDT{{ number_format($invoice->adjustment_amount, 2) }}
                                </td>
                            </tr>
                        @endif

                        <tr style="background: #f8f9fa;">
                            <td style="text-align: right; font-weight: 700; padding: 12px; font-size: 16px;">Total
                                Amount:</td>
                            <td style="text-align: right; padding: 12px; font-size: 16px; font-weight: 700;">
                                BDT{{ number_format($invoice->total_amount, 2) }}
                            </td>
                        </tr>

                        @if ($invoice->amount_paid > 0)
                            <tr>
                                <td style="text-align: right; font-weight: 600; padding: 10px;">Amount Paid:</td>
                                <td style="text-align: right; color: #28a745; padding: 10px;">
                                    BDT{{ number_format($invoice->amount_paid, 2) }}
                                </td>
                            </tr>

                            <tr style="background: #fff3cd;">
                                <td style="text-align: right; font-weight: 700; padding: 12px;">Balance Due:</td>
                                <td style="text-align: right; padding: 12px; font-weight: 700;">
                                    BDT{{ number_format($invoice->balance_due, 2) }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="mt-4 py-3 border-top">
            <h4 style="margin-bottom: 15px; color: #007bff;">
                <i class="fas fa-credit-card me-2"></i>Payment Information
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div>
                    <p style="margin: 5px 0;"><strong>Bank Name:</strong> ABC Bank</p>
                    <p style="margin: 5px 0;"><strong>Account Name:</strong> Your Company Name</p>
                    <p style="margin: 5px 0;"><strong>Account Number:</strong> 1234567890</p>
                </div>
                <div>
                    <p style="margin: 5px 0;"><strong>IFSC Code:</strong> ABCB0123456</p>
                    <p style="margin: 5px 0;"><strong>Branch:</strong> Main Branch, City</p>
                    <p style="margin: 5px 0;"><strong>UPI ID:</strong> companyname@bank</p>
                </div>
            </div>
        </div>

        <!-- Notes & Terms -->
        @if ($invoice->notes || $invoice->terms)
            <div class="mt-4">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    @if ($invoice->notes)
                        <div class="terms-conditions">
                            <h5 style="margin-bottom: 10px; color: #007bff;">
                                <i class="fas fa-sticky-note me-2"></i>Notes
                            </h5>
                            <p style="margin: 0; white-space: pre-line;">{{ $invoice->notes }}</p>
                        </div>
                    @endif

                    @if ($invoice->terms)
                        <div class="terms-conditions">
                            <h5 style="margin-bottom: 10px; color: #007bff;">
                                <i class="fas fa-file-contract me-2"></i>Terms & Conditions
                            </h5>
                            <p style="margin: 0; white-space: pre-line;">{{ $invoice->terms }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                Thank you for your business!
            </p>
            <p style="margin: 0; font-size: 12px;">
                This is a computer generated invoice. No signature required.
            </p>
            <p style="margin: 10px 0 0 0; font-size: 12px;">
                Generated on: {{ now()->format('d M, Y h:i A') }}
            </p>
        </div>

        <!-- For Internal Use Only (Conditional) -->
        @if ($invoice->status == 'draft')
            <div class="mt-4 py-2 border-top" style="border-top: 2px dashed #dc3545 !important;">
                <p style="text-align: center; color: #dc3545; font-weight: 600; margin: 0;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    DRAFT COPY - FOR INTERNAL USE ONLY
                </p>
            </div>
        @endif
    </div>

    <!-- Additional page for terms if needed -->
    @if ($invoice->terms && strlen($invoice->terms) > 500)
        <div class="page-break"></div>
        <div class="invoice-container">
            <h2 style="color: #007bff; margin-bottom: 20px;">Terms & Conditions</h2>
            <div style="white-space: pre-line; line-height: 1.6;">
                {{ $invoice->terms }}
            </div>
        </div>
    @endif

    <script>
        // Auto-print option (optional)
        @if (request('autoprint'))
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 1000);
            }
        @endif

        // Close window after print (optional)
        window.onafterprint = function() {
            // Uncomment below if you want to close window after printing
            // setTimeout(function() {
            //     window.close();
            // }, 1000);
        };

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + P or Cmd + P
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            // Escape key to close
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>

</html>
