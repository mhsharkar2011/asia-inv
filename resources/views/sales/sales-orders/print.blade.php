{{-- resources/views/sales/sales-orders/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Order - {{ $salesOrder->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, 'Segoe UI', Roboto, sans-serif;
            background: white;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.4;
        }

        /* Print Styles */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .no-break {
                page-break-inside: avoid;
            }

            .page-break {
                page-break-before: always;
            }

            @page {
                size: A4;
                margin: 1.5cm;
            }
        }

        /* Container */
        .invoice-container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
        }

        /* Header Section */
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .company-details {
            font-size: 11px;
            color: #4b5563;
            line-height: 1.5;
        }

        .document-title {
            text-align: center;
            margin: 20px 0;
        }

        .document-title h1 {
            font-size: 24px;
            color: #1f2937;
            font-weight: bold;
        }

        .document-title p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-box {
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .info-box-title {
            font-weight: bold;
            font-size: 12px;
            color: #374151;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row {
            display: flex;
            margin-bottom: 6px;
            font-size: 11px;
        }

        .info-label {
            width: 100px;
            font-weight: 600;
            color: #6b7280;
        }

        .info-value {
            flex: 1;
            color: #1f2937;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-draft {
            background: #f3f4f6;
            color: #374151;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background: #f3e8ff;
            color: #5b21b6;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-partial {
            background: #dbeafe;
            color: #1e40af;
        }

        .payment-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .payment-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Address Section */
        .address-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .address-box {
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .address-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 8px;
            color: #374151;
        }

        .address-content {
            font-size: 10px;
            color: #4b5563;
            line-height: 1.5;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #374151;
        }

        .items-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            font-size: 11px;
            vertical-align: top;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        /* Summary Section */
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .summary-box {
            width: 320px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 11px;
        }

        .summary-row.total {
            border-top: 2px solid #e5e7eb;
            margin-top: 6px;
            padding-top: 10px;
            font-weight: bold;
            font-size: 14px;
            color: #1f2937;
        }

        /* Notes Section */
        .notes-section {
            margin-top: 25px;
            background: #fefce8;
            border-left: 3px solid #eab308;
            padding: 12px;
            border-radius: 4px;
        }

        .notes-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 6px;
            color: #854d0e;
        }

        .notes-content {
            font-size: 10px;
            color: #713f12;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        /* Utility Classes */
        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .text-bold {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-name">{{ config('app.name', 'Your Company Name') }}</div>
                <div class="company-details">
                    {{ config('company.address', '123 Business Street, City, Country') }}<br>
                    {{ config('company.phone', 'Phone: +123 456 7890') }} |
                    {{ config('company.email', 'Email: info@company.com') }}<br>
                    {{ config('company.tax_id', 'GST/VAT: XX1234567890') }}
                </div>
            </div>

            <div class="document-title">
                <h1>SALES ORDER</h1>
                <p>{{ $salesOrder->order_number }}</p>
            </div>
        </div>

        <!-- Information Grid -->
        <div class="info-grid">
            <div class="info-box">
                <div class="info-box-title">ORDER INFORMATION</div>
                <div class="info-row">
                    <span class="info-label">Order No:</span>
                    <span class="info-value">{{ $salesOrder->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $salesOrder->order_date->format('d M, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Delivery Date:</span>
                    <span class="info-value">{{ $salesOrder->delivery_date->format('d M, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Due Date:</span>
                    <span
                        class="info-value">{{ isset($salesOrder->due_date) ? \Carbon\Carbon::parse($salesOrder->due_date)->format('d M, Y') : 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Reference:</span>
                    <span class="info-value">{{ $salesOrder->reference_number ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="info-box">
                <div class="info-box-title">STATUS</div>
                <div class="info-row">
                    <span class="info-label">Order Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $salesOrder->status }}">
                            {{ ucfirst($salesOrder->status) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value">
                        <span class="status-badge payment-{{ $salesOrder->payment_status }}">
                            {{ ucfirst($salesOrder->payment_status) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Terms:</span>
                    <span
                        class="info-value">{{ $salesOrder->payment_terms ? ucfirst(str_replace('_', ' ', $salesOrder->payment_terms)) : 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Currency:</span>
                    <span class="info-value">{{ $salesOrder->currency }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sales Person:</span>
                    <span class="info-value">{{ $salesOrder->sales_person ?? 'Not specified' }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="info-box mb-2">
            <div class="info-box-title">CUSTOMER INFORMATION</div>
            <div class="info-row">
                <span class="info-label">Customer:</span>
                <span class="info-value">
                    <strong>{{ $salesOrder->customer->customer_name }}</strong>
                    @if ($salesOrder->customer->company_name)
                        <br>({{ $salesOrder->customer->company_name }})
                    @endif
                </span>
            </div>
            @if ($salesOrder->customer->email)
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $salesOrder->customer->email }}</span>
                </div>
            @endif
            @if ($salesOrder->customer->phone)
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $salesOrder->customer->phone }}</span>
                </div>
            @endif
        </div>

        <!-- Addresses -->
        <div class="address-section">
            <div class="address-box">
                <div class="address-title">SHIPPING ADDRESS</div>
                <div class="address-content">
                    {!! nl2br(e($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified'))) !!}
                </div>
            </div>
            <div class="address-box">
                <div class="address-title">BILLING ADDRESS</div>
                <div class="address-content">
                    {!! nl2br(
                        e(
                            $salesOrder->billing_address ??
                                ($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified')),
                        ),
                    ) !!}
                </div>
            </div>
        </div>

        @if ($salesOrder->shipping_method)
            <div class="info-box mb-2">
                <div class="info-box-title">SHIPPING METHOD</div>
                <div class="info-value">{{ ucfirst($salesOrder->shipping_method) }}</div>
            </div>
        @endif

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Description</th>
                    <th width="10%" class="text-center">Quantity</th>
                    <th width="15%" class="text-right">Unit Price</th>
                    <th width="15%" class="text-right">Discount</th>
                    <th width="15%" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesOrder->items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $item->product->product_name ?? $item->description }}</strong>
                            @if ($item->product && $item->product->product_code)
                                <br><span style="font-size: 9px; color: #6b7280;">Code:
                                    {{ $item->product->product_code }}</span>
                            @endif
                            @if ($item->product && $item->product->unit_of_measure)
                                <br><span style="font-size: 9px; color: #6b7280;">Unit:
                                    {{ $item->product->unit_of_measure }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($item->quantity, 4) }}</td>
                        <td class="text-right">{{ $salesOrder->currency }} {{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="text-right">
                            @if ($item->discount_percentage > 0)
                                {{ number_format($item->discount_percentage, 2) }}%<br>
                                <span style="font-size: 9px; color: #ef4444;">(-{{ $salesOrder->currency }}
                                    {{ number_format($item->discount_amount, 2) }})</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right"><strong>{{ $salesOrder->currency }}
                                {{ number_format($item->total_amount, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                    <td colspan="3" class="text-right">{{ $salesOrder->currency }}
                        {{ number_format($salesOrder->subtotal, 2) }}</td>
                </tr>
                @if ($salesOrder->total_discount > 0)
                    <tr>
                        <td colspan="3" class="text-right">Discount:</td>
                        <td colspan="3" class="text-right" style="color: #ef4444;">-{{ $salesOrder->currency }}
                            {{ number_format($salesOrder->total_discount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="text-right">Taxable Amount:</td>
                    <td colspan="3" class="text-right">{{ $salesOrder->currency }}
                        {{ number_format($salesOrder->taxable_amount, 2) }}</td>
                </tr>
                @if ($salesOrder->tax_amount > 0)
                    <tr>
                        <td colspan="3" class="text-right">Tax ({{ number_format($salesOrder->tax_rate, 2) }}%):
                        </td>
                        <td colspan="3" class="text-right">+{{ $salesOrder->currency }}
                            {{ number_format($salesOrder->tax_amount, 2) }}</td>
                    </tr>
                @endif
                @if ($salesOrder->shipping_charges > 0)
                    <tr>
                        <td colspan="3" class="text-right">Shipping Charges:</td>
                        <td colspan="3" class="text-right">+{{ $salesOrder->currency }}
                            {{ number_format($salesOrder->shipping_charges, 2) }}</td>
                    </tr>
                @endif
                @if ($salesOrder->adjustment != 0)
                    <tr>
                        <td colspan="3" class="text-right">Adjustment:</td>
                        <td colspan="3" class="text-right"
                            style="color: {{ $salesOrder->adjustment > 0 ? '#10b981' : '#ef4444' }};">
                            {{ $salesOrder->adjustment > 0 ? '+' : '-' }}{{ $salesOrder->currency }}
                            {{ number_format(abs($salesOrder->adjustment), 2) }}
                        </td>
                    </tr>
                @endif
                <tr class="total">
                    <td colspan="3" class="text-right"><strong>TOTAL AMOUNT:</strong></td>
                    <td colspan="3" class="text-right"><strong>{{ $salesOrder->currency }}
                            {{ number_format($salesOrder->total_amount, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Amount in Words -->
        <div style="margin-top: 10px; font-size: 10px; color: #6b7280; text-align: right;">
            Amount in Words:
            <strong>{{ ucfirst($amountInWords ?? numberToWords($salesOrder->total_amount)) }}</strong>
        </div>

        <!-- Notes and Terms -->
        @if ($salesOrder->notes || $salesOrder->terms_conditions)
            <div class="notes-section">
                @if ($salesOrder->notes)
                    <div class="notes-title">NOTES:</div>
                    <div class="notes-content">{{ $salesOrder->notes }}</div>
                @endif
                @if ($salesOrder->terms_conditions)
                    <div class="notes-title mt-2">TERMS & CONDITIONS:</div>
                    <div class="notes-content">{{ $salesOrder->terms_conditions }}</div>
                @endif
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated document and requires no signature.</p>
            <p>Generated on: {{ now()->format('d M, Y h:i A') }}</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>
