@extends('layouts.app')

@section('title', 'GST/Tax Report - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">GST/Tax Report</h1>
                <p class="text-muted mb-0">Tax collection and analysis</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-outline-primary me-2">
                    <i class="bi bi-printer"></i> Print
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Report Filters</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.tax') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $startDate }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $endDate }}" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter"></i> Apply Filters
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Quick Date Range Buttons -->
                <div class="mt-3">
                    <div class="btn-group" role="group">
                        <a href="{{ route('reports.tax', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}"
                            class="btn btn-outline-secondary btn-sm">This Month</a>
                        <a href="{{ route('reports.tax', ['start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) }}"
                            class="btn btn-outline-secondary btn-sm">This Year</a>
                        <a href="{{ route('reports.tax', ['start_date' => date('Y-m-d', strtotime('-30 days')), 'end_date' => date('Y-m-d')]) }}"
                            class="btn btn-outline-secondary btn-sm">Last 30 Days</a>
                        <a href="{{ route('reports.tax', ['start_date' => date('Y-m-d', strtotime('-7 days')), 'end_date' => date('Y-m-d')]) }}"
                            class="btn btn-outline-secondary btn-sm">Last 7 Days</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Invoices</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $invoices->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-file-text fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Taxable Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₹{{ number_format($invoices->sum('taxable_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-calculator fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total GST Collected</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₹{{ number_format($invoices->sum('tax_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-currency-rupee fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Invoice Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ₹{{ number_format($invoices->sum('total_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-graph-up fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GST Summary by Rate -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">GST Summary by Rate</h5>
                <span class="badge bg-primary">{{ $gstSummary->count() }} GST Rates</span>
            </div>
            <div class="card-body">
                @if ($gstSummary->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>GST Rate</th>
                                    <th>No. of Invoices</th>
                                    <th>Taxable Amount</th>
                                    <th>CGST
                                        ({{ array_key_exists('18', $gstSummary->toArray()) ? '9%' : 'Half of GST Rate' }})
                                    </th>
                                    <th>SGST
                                        ({{ array_key_exists('18', $gstSummary->toArray()) ? '9%' : 'Half of GST Rate' }})
                                    </th>
                                    <th>Total GST</th>
                                    <th>Total Invoice Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalInvoices = 0;
                                    $totalTaxable = 0;
                                    $totalCGST = 0;
                                    $totalSGST = 0;
                                    $totalGST = 0;
                                    $totalAmount = 0;
                                @endphp

                                @foreach ($gstSummary as $rate => $summary)
                                    @php
                                        $cgst = $summary['tax_amount'] / 2;
                                        $sgst = $summary['tax_amount'] / 2;

                                        $totalInvoices += $summary['count'];
                                        $totalTaxable += $summary['taxable_amount'];
                                        $totalCGST += $cgst;
                                        $totalSGST += $sgst;
                                        $totalGST += $summary['tax_amount'];
                                        $totalAmount += $summary['total_amount'];
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $rate }}%</span>
                                        </td>
                                        <td class="text-center">{{ $summary['count'] }}</td>
                                        <td class="text-end">₹{{ number_format($summary['taxable_amount'], 2) }}</td>
                                        <td class="text-end">₹{{ number_format($cgst, 2) }}</td>
                                        <td class="text-end">₹{{ number_format($sgst, 2) }}</td>
                                        <td class="text-end">₹{{ number_format($summary['tax_amount'], 2) }}</td>
                                        <td class="text-end">₹{{ number_format($summary['total_amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td><strong>Total</strong></td>
                                    <td class="text-center"><strong>{{ $totalInvoices }}</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($totalTaxable, 2) }}</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($totalCGST, 2) }}</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($totalSGST, 2) }}</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($totalGST, 2) }}</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($totalAmount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-percent display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No GST Data Found</h5>
                        <p class="text-muted">No paid invoices with tax data in the selected date range.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Invoice Details</h5>
                <span class="badge bg-primary">{{ $invoices->count() }} Invoices</span>
            </div>
            <div class="card-body">
                @if ($invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>GSTIN</th>
                                    <th>Taxable Amount</th>
                                    <th>GST Rate</th>
                                    <th>GST Amount</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <strong>{{ $invoice->invoice_number }}</strong>
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('d M, Y') }}</td>
                                        <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                                        <td>
                                            <small>{{ $invoice->customer->gstin ?? 'N/A' }}</small>
                                        </td>
                                        <td class="text-end">
                                            ₹{{ number_format($invoice->taxable_amount ?? $invoice->total_amount - $invoice->tax_amount, 2) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $invoice->tax_rate ?? 18 }}%</span>
                                        </td>
                                        <td class="text-end">₹{{ number_format($invoice->tax_amount, 2) }}</td>
                                        <td class="text-end">₹{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            @if ($invoice->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($invoice->status == 'overdue')
                                                <span class="badge bg-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Invoices Found</h5>
                        <p class="text-muted">No paid invoices in the selected date range.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- GST Summary -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">GST Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Report Period:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($startDate)->format('d M, Y') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Paid Invoices:</span>
                                <span class="badge bg-primary rounded-pill">{{ $invoices->count() }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Taxable Amount:</span>
                                <span class="fw-bold">₹{{ number_format($invoices->sum('taxable_amount'), 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total CGST Collected:</span>
                                <span class="fw-bold">₹{{ number_format($invoices->sum('tax_amount') / 2, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total SGST Collected:</span>
                                <span class="fw-bold">₹{{ number_format($invoices->sum('tax_amount') / 2, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <span class="fw-bold">Total GST Collected:</span>
                                <span
                                    class="fw-bold text-success">₹{{ number_format($invoices->sum('tax_amount'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">GST Distribution</h5>
                    </div>
                    <div class="card-body">
                        @if ($gstSummary->count() > 0)
                            <div class="row">
                                @foreach ($gstSummary as $rate => $summary)
                                    <div class="col-6 mb-3">
                                        <div class="text-center p-3 border rounded">
                                            <div class="h4 mb-1">{{ $rate }}%</div>
                                            <small class="text-muted">
                                                {{ $summary['count'] }} invoices<br>
                                                ₹{{ number_format($summary['tax_amount'], 2) }} GST
                                            </small>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 mb-1">{{ $invoices->where('status', 'paid')->count() }}</div>
                                        <small class="text-muted">Paid Invoices</small>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 mb-1">{{ $invoices->where('status', '!=', 'paid')->count() }}</div>
                                        <small class="text-muted">Pending Invoices</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted text-center">No GST data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- GST Notes -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>GST Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Current GST Rates in India:</h6>
                        <ul class="list-unstyled">
                            <li><strong>0%:</strong> Essential goods (food grains, milk, etc.)</li>
                            <li><strong>5%:</strong> Household necessities (sugar, tea, coffee, etc.)</li>
                            <li><strong>12%:</strong> Processed foods, computers</li>
                            <li><strong>18%:</strong> Most goods and services (standard rate)</li>
                            <li><strong>28%:</strong> Luxury items, sin goods (cars, tobacco, etc.)</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>GST Components:</h6>
                        <ul class="list-unstyled">
                            <li><strong>CGST:</strong> Central GST (collected by Central Government)</li>
                            <li><strong>SGST:</strong> State GST (collected by State Government)</li>
                            <li><strong>IGST:</strong> Integrated GST (inter-state transactions)</li>
                        </ul>
                        <div class="alert alert-info mt-3">
                            <small>
                                <i class="bi bi-lightbulb"></i>
                                <strong>Note:</strong> For intra-state sales, GST is equally divided between CGST and SGST.
                                For example, 18% GST = 9% CGST + 9% SGST.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                border: 1px solid #dee2e6 !important;
            }

            .table {
                font-size: 11px;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: #000 !important;
            }

            .badge {
                border: 1px solid #000;
                color: #000 !important;
                background-color: transparent !important;
            }

            .alert {
                border: 1px solid #000 !important;
                background-color: transparent !important;
            }
        }

        .card-header {
            background-color: #f8f9fa;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }
    </style>

@endsection
