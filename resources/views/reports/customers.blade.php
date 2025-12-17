@extends('layouts.app')

@section('title', 'Customer Report - Asia Enterprise')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Customer Report</h1>
                <p class="text-muted mb-0">Customer analysis and statistics</p>
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

        <!-- Customer Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $customers->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fa-2x text-gray-300"></i>
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
                                    Total Invoice Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    BDT{{ number_format($customers->sum('total_invoice_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-currency-taka fa-2x text-red-300">BDT</i>
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
                                    Total Order Amount</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    BDT{{ number_format($customers->sum('total_order_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-cart fa-2x text-gray-300"></i>
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
                                    Active Customers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $customers->where('status', 'active')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-person-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Customer Details</h5>
                <span class="badge bg-primary">{{ $customers->count() }} Customers</span>
            </div>
            <div class="card-body">
                @if ($customers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Type</th>
                                    <th>Phone</th>
                                    <th>Total Invoices</th>
                                    <th>Invoice Amount</th>
                                    <th>Total Orders</th>
                                    <th>Order Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $customer->name }}</strong><br>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($customer->customer_type) }}</span>
                                        </td>
                                        <td>{{ $customer->phone }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $customer->invoices_count }}</span>
                                        </td>
                                        <td class="text-end">
                                            BDT{{ number_format($customer->total_invoice_amount ?? 0, 2) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $customer->sales_orders_count }}</span>
                                        </td>
                                        <td class="text-end">
                                            BDT{{ number_format($customer->total_order_amount ?? 0, 2) }}
                                        </td>
                                        <td>
                                            @if ($customer->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @elseif($customer->status == 'inactive')
                                                <span class="badge bg-secondary">Inactive</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($customer->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('sales.customers.show', $customer->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end"><strong>Totals:</strong></td>
                                    <td class="text-center"><strong>{{ $customers->sum('invoices_count') }}</strong></td>
                                    <td class="text-end">
                                        <strong>BDT{{ number_format($customers->sum('total_invoice_amount'), 2) }}</strong>
                                    </td>
                                    <td class="text-center"><strong>{{ $customers->sum('sales_orders_count') }}</strong>
                                    </td>
                                    <td class="text-end">
                                        <strong>BDT{{ number_format($customers->sum('total_order_amount'), 2) }}</strong>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-people display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Customers Found</h5>
                        <p class="text-muted">No customer data available.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Customers -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top 10 Customers by Invoice Amount</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $topCustomers = $customers->sortByDesc('total_invoice_amount')->take(10);
                        @endphp

                        @if ($topCustomers->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($topCustomers as $customer)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $customer->name }}</strong><br>
                                            <small class="text-muted">{{ $customer->invoices_count }} invoices</small>
                                        </div>
                                        <span
                                            class="fw-bold">BDT{{ number_format($customer->total_invoice_amount, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No customer data available</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customer Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $customerTypes = $customers->groupBy('customer_type');
                            @endphp

                            @foreach ($customerTypes as $type => $typeCustomers)
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 mb-1">{{ $typeCustomers->count() }}</div>
                                        <small class="text-muted">{{ ucfirst($type) }} Customers</small>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $customers->where('status', 'active')->count() }}</div>
                                    <small class="text-muted">Active Customers</small>
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <div class="h4 mb-1">{{ $customers->where('status', 'inactive')->count() }}</div>
                                    <small class="text-muted">Inactive Customers</small>
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
