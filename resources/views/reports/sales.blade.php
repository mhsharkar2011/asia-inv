@extends('layouts.app')

@section('title', 'Sales Report - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Sales Report</h1>
                <p class="text-muted mb-0">Analyze sales and revenue data</p>
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
                <form action="{{ route('reports.sales') }}" method="GET">
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
                        <a href="{{ route('reports.sales', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}"
                            class="btn btn-outline-secondary btn-sm">This Month</a>
                        <a href="{{ route('reports.sales', ['start_date' => date('Y-m-d', strtotime('-30 days')), 'end_date' => date('Y-m-d')]) }}"
                            class="btn btn-outline-secondary btn-sm">Last 30 Days</a>
                        <a href="{{ route('reports.sales', ['start_date' => date('Y-01-01'), 'end_date' => date('Y-12-31')]) }}"
                            class="btn btn-outline-secondary btn-sm">This Year</a>
                        <a href="{{ route('reports.sales', ['start_date' => date('Y-m-d', strtotime('-7 days')), 'end_date' => date('Y-m-d')]) }}"
                            class="btn btn-outline-secondary btn-sm">Last 7 Days</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Invoice Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    BDT{{ number_format($totalInvoiceAmount, 2) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Sales (Invoices + Orders)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    BDT{{ number_format($totalSales, 2) }}
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

        <!-- Invoice Report -->
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Invoices Report</h5>
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
                                    <th>Amount</th>
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
                                        <td>BDT{{ number_format($invoice->total_amount, 2) }}</td>
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
                                            <a href="{{ route('sales.invoices.show', $invoice->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>BDT{{ number_format($totalInvoiceAmount, 2) }}</strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-file-text display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Invoices Found</h5>
                        <p class="text-muted">No invoices were generated in the selected date range.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sales Orders Report -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Sales Orders Report</h5>
                <span class="badge bg-primary">{{ $salesOrders->count() }} Orders</span>
            </div>
            <div class="card-body">
                @if ($salesOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salesOrders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>{{ $order->order_date->format('d M, Y') }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>BDT{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            @if ($order->status == 'draft')
                                                <span class="badge bg-secondary">Draft</span>
                                            @elseif($order->status == 'confirmed')
                                                <span class="badge bg-primary">Confirmed</span>
                                            @elseif($order->status == 'shipped')
                                                <span class="badge bg-info">Shipped</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.sales-orders.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>BDT{{ number_format($totalOrdersAmount, 2) }}</strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-cart display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Sales Orders Found</h5>
                        <p class="text-muted">No sales orders were created in the selected date range.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Summary -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Report Period:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($startDate)->format('d M, Y') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Invoices:</span>
                                <span class="badge bg-primary rounded-pill">{{ $invoices->count() }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Invoice Amount:</span>
                                <span class="fw-bold">BDT{{ number_format($totalInvoiceAmount, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Sales Orders:</span>
                                <span class="badge bg-primary rounded-pill">{{ $salesOrders->count() }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total Orders Amount:</span>
                                <span class="fw-bold">BDT{{ number_format($totalOrdersAmount, 2) }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                <span class="fw-bold">Total Sales:</span>
                                <span class="fw-bold text-success">BDT{{ number_format($totalSales, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $invoices->where('status', 'paid')->count() }}</div>
                                    <small class="text-muted">Paid Invoices</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $invoices->where('status', 'pending')->count() }}</div>
                                    <small class="text-muted">Pending Invoices</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $salesOrders->where('status', 'delivered')->count() }}</div>
                                    <small class="text-muted">Delivered Orders</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">
                                        {{ $salesOrders->whereIn('status', ['draft', 'confirmed'])->count() }}</div>
                                    <small class="text-muted">Pending Orders</small>
                                </div>
                            </div>
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
                font-size: 12px;
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
    </style>

@endsection
