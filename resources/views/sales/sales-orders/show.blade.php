{{-- resources/views/sales/sales-orders/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Sales Order - ' . $salesOrder->order_number)

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.sales-orders.index') }}">Sales Orders</a></li>
                        <li class="breadcrumb-item active">{{ $salesOrder->order_number }}</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Sales Order</h1>
                <p class="text-muted mb-0">{{ $salesOrder->order_number }}</p>
            </div>
            <div class="d-flex gap-2">
                <!-- Status Badge -->
                <div class="d-flex align-items-center">
                    <span class="badge bg-{{ $salesOrder->status_color }} fs-6">
                        {{ ucfirst($salesOrder->status) }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('sales.sales-orders.edit', $salesOrder) }}">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('sales.sales-orders.print', $salesOrder) }}"
                                target="_blank">
                                <i class="fas fa-print me-2"></i>Print
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="printInvoice()">
                                <i class="fas fa-file-pdf me-2"></i>Download PDF
                            </a>
                        </li>
                        @if ($salesOrder->status == 'draft')
                            <li>
                                <a class="dropdown-item" href="#" onclick="confirmOrder()">
                                    <i class="fas fa-check-circle me-2"></i>Confirm Order
                                </a>
                            </li>
                        @endif
                        @if ($salesOrder->status == 'confirmed')
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('sales.invoices.create', ['order_id' => $salesOrder->id]) }}">
                                    <i class="fas fa-file-invoice me-2"></i>Create Invoice
                                </a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form id="deleteForm" action="{{ route('sales.sales-orders.destroy', $salesOrder) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('sales.sales-orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Order Details Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Order Number:</th>
                                        <td>{{ $salesOrder->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date:</th>
                                        <td>{{ $salesOrder->order_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Date:</th>
                                        <td>{{ $salesOrder->delivery_date->format('d M, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer:</th>
                                        <td>
                                            <strong>{{ $salesOrder->customer->customer_name }}</strong>
                                            @if ($salesOrder->customer->company_name)
                                                <br><small
                                                    class="text-muted">{{ $salesOrder->customer->company_name }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sales Person:</th>
                                        <td>{{ $salesOrder->sales_person ?? 'Not specified' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Reference:</th>
                                        <td>{{ $salesOrder->reference_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Terms:</th>
                                        <td>{{ $salesOrder->payment_terms ? ucfirst(str_replace('_', ' ', $salesOrder->payment_terms)) : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status:</th>
                                        <td>
                                            <span class="badge bg-{{ $salesOrder->payment_status_color }}">
                                                {{ ucfirst($salesOrder->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Due Date:</th>
                                        <td>
                                            {{ \Carbon\Carbon::parse($salesOrder->due_date)->format('d M, Y') ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created By:</th>
                                        <td>{{ $salesOrder->createdBy->name ?? 'System' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created On:</th>
                                        <td>{{ $salesOrder->created_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-2">Shipping Address</h6>
                                <address class="mb-0">
                                    {!! nl2br(e($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified'))) !!}
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6 class="border-bottom pb-2 mb-2">Billing Address</h6>
                                <address class="mb-0">
                                    {!! nl2br(
                                        e(
                                            $salesOrder->billing_address ??
                                                ($salesOrder->shipping_address ?? ($salesOrder->customer->address ?? 'Not specified')),
                                        ),
                                    ) !!}
                                </address>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        @if ($salesOrder->shipping_method)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-2">Shipping Information</h6>
                                    <p class="mb-0">
                                        <strong>Method:</strong> {{ ucfirst($salesOrder->shipping_method) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Order Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#</th>
                                        <th>Description</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Discount</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salesOrder->items as $item)
                                        <tr>
                                            <td class="ps-3">{{ $loop->iteration }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $item->product->product_name ?? $item->description }}</strong>
                                                    @if ($item->product)
                                                        <br>
                                                        <small class="text-muted">
                                                            Code: {{ $item->product->product_code }}
                                                            @if ($item->product->unit_of_measure)
                                                                | Unit: {{ $item->product->unit_of_measure }}
                                                            @endif
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($item->quantity, 4) }}
                                            </td>
                                            <td class="text-end">
                                                ৳{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="text-end">
                                                @if ($item->discount_percentage > 0)
                                                    <span class="text-danger">
                                                        {{ number_format($item->discount_percentage, 2) }}%
                                                        <br>
                                                        <small>(-৳{{ number_format($item->discount_amount, 2) }})</small>
                                                    </span>
                                                @else
                                                    <span class="text-muted">0%</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold">
                                                ৳{{ number_format($item->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr>
                                        <td colspan="4" class="text-end border-0"></td>
                                        <td class="text-end border-0"><strong>Subtotal:</strong></td>
                                        <td class="text-end border-0">৳{{ number_format($salesOrder->subtotal, 2) }}</td>
                                    </tr>
                                    @if ($salesOrder->total_discount > 0)
                                        <tr>
                                            <td colspan="4" class="text-end border-0"></td>
                                            <td class="text-end border-0"><strong>Discount:</strong></td>
                                            <td class="text-end border-0 text-danger">
                                                -৳{{ number_format($salesOrder->total_discount, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="4" class="text-end border-0"></td>
                                        <td class="text-end border-0"><strong>Taxable Amount:</strong></td>
                                        <td class="text-end border-0">৳{{ number_format($salesOrder->taxable_amount, 2) }}
                                        </td>
                                    </tr>
                                    @if ($salesOrder->tax_amount > 0)
                                        <tr>
                                            <td colspan="4" class="text-end border-0"></td>
                                            <td class="text-end border-0">
                                                <strong>Tax ({{ number_format($salesOrder->tax_rate, 2) }}%):</strong>
                                            </td>
                                            <td class="text-end border-0">৳{{ number_format($salesOrder->tax_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($salesOrder->shipping_charges > 0)
                                        <tr>
                                            <td colspan="4" class="text-end border-0"></td>
                                            <td class="text-end border-0"><strong>Shipping:</strong></td>
                                            <td class="text-end border-0">
                                                +৳{{ number_format($salesOrder->shipping_charges, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if ($salesOrder->adjustment != 0)
                                        <tr>
                                            <td colspan="4" class="text-end border-0"></td>
                                            <td class="text-end border-0">
                                                <strong>Adjustment:</strong>
                                                <br>
                                                <small
                                                    class="text-muted">{{ $salesOrder->adjustment > 0 ? 'Additional' : 'Deduction' }}</small>
                                            </td>
                                            <td
                                                class="text-end border-0 {{ $salesOrder->adjustment > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $salesOrder->adjustment > 0 ? '+' : '' }}৳{{ number_format($salesOrder->adjustment, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="table-active">
                                        <td colspan="4" class="text-end border-0"></td>
                                        <td class="text-end border-0"><strong>Total Amount:</strong></td>
                                        <td class="text-end border-0 fw-bold">
                                            ৳{{ number_format($salesOrder->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Notes & Terms Card -->
                @if ($salesOrder->notes || $salesOrder->terms_conditions)
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            @if ($salesOrder->notes)
                                <div class="mb-4">
                                    <h6 class="border-bottom pb-2 mb-2">Notes</h6>
                                    <div class="bg-light p-3 rounded">
                                        {!! nl2br(e($salesOrder->notes)) !!}
                                    </div>
                                </div>
                            @endif

                            @if ($salesOrder->terms_conditions)
                                <div>
                                    <h6 class="border-bottom pb-2 mb-2">Terms & Conditions</h6>
                                    <div class="bg-light p-3 rounded">
                                        {!! nl2br(e($salesOrder->terms_conditions)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Order Summary Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Order Status:</span>
                            <span class="badge bg-{{ $salesOrder->status_color }} fs-6">
                                {{ ucfirst($salesOrder->status) }}
                            </span>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Payment Status:</span>
                            <span class="badge bg-{{ $salesOrder->payment_status_color }}">
                                {{ ucfirst($salesOrder->payment_status) }}
                            </span>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Currency:</span>
                            <span class="fw-medium">{{ $salesOrder->currency }}</span>
                        </div>

                        <hr>

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Subtotal:</span>
                            <span>৳{{ number_format($salesOrder->subtotal, 2) }}</span>
                        </div>

                        @if ($salesOrder->total_discount > 0)
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Discount:</span>
                                <span class="text-danger">-৳{{ number_format($salesOrder->total_discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Taxable Amount:</span>
                            <span>৳{{ number_format($salesOrder->taxable_amount, 2) }}</span>
                        </div>

                        @if ($salesOrder->tax_amount > 0)
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Tax ({{ number_format($salesOrder->tax_rate, 2) }}%):</span>
                                <span>+৳{{ number_format($salesOrder->tax_amount, 2) }}</span>
                            </div>
                        @endif

                        @if ($salesOrder->shipping_charges > 0)
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Shipping Charges:</span>
                                <span>+৳{{ number_format($salesOrder->shipping_charges, 2) }}</span>
                            </div>
                        @endif

                        @if ($salesOrder->adjustment != 0)
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="text-muted">Adjustment:</span>
                                <span class="{{ $salesOrder->adjustment > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $salesOrder->adjustment > 0 ? '+' : '' }}৳{{ number_format($salesOrder->adjustment, 2) }}
                                </span>
                            </div>
                        @endif

                        <hr>

                        <div class="mb-3 d-flex justify-content-between fw-bold">
                            <span>Total Amount:</span>
                            <span>৳{{ number_format($salesOrder->total_amount, 2) }}</span>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Total Items: {{ $salesOrder->items->count() }}
                                <br>
                                Total Quantity: {{ number_format($salesOrder->items->sum('quantity'), 4) }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Customer Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="border-bottom pb-2 mb-2">{{ $salesOrder->customer->customer_name }}</h6>
                            @if ($salesOrder->customer->company_name)
                                <p class="mb-1">
                                    <strong>Company:</strong> {{ $salesOrder->customer->company_name }}
                                </p>
                            @endif
                            @if ($salesOrder->customer->email)
                                <p class="mb-1">
                                    <strong>Email:</strong>
                                    <a
                                        href="mailto:{{ $salesOrder->customer->email }}">{{ $salesOrder->customer->email }}</a>
                                </p>
                            @endif
                            @if ($salesOrder->customer->phone)
                                <p class="mb-1">
                                    <strong>Phone:</strong>
                                    <a
                                        href="tel:{{ $salesOrder->customer->phone }}">{{ $salesOrder->customer->phone }}</a>
                                </p>
                            @endif
                            @if ($salesOrder->customer->address)
                                <p class="mb-1">
                                    <strong>Address:</strong><br>
                                    {!! nl2br(e($salesOrder->customer->address)) !!}
                                </p>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('sales.customers.show', $salesOrder->customer) }}"
                                class="btn btn-outline-success btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i>View Customer Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Timeline / History Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Order Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Order Created</h6>
                                    <p class="text-muted mb-0">{{ $salesOrder->created_at->format('d M, Y h:i A') }}</p>
                                    <small>By: {{ $salesOrder->createdBy->name ?? 'System' }}</small>
                                </div>
                            </div>

                            @if ($salesOrder->updated_at != $salesOrder->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Last Updated</h6>
                                        <p class="text-muted mb-0">{{ $salesOrder->updated_at->format('d M, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($salesOrder->status != 'draft')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Order Confirmed</h6>
                                        <p class="text-muted mb-0">
                                            @php
                                                // Use the updated_at as default for when it was confirmed
                                                $confirmedAt = $salesOrder->updated_at;

                                                // If you have a status_changed_at field or similar
                                                if ($salesOrder->status == 'confirmed') {
                                                    $confirmedAt = $salesOrder->updated_at;
                                                }

                                                // If you have a status history relationship
                                                // Assuming you have a statusHistories relationship
                                                if (
                                                    isset($salesOrder->statusHistories) &&
                                                    $salesOrder->statusHistories
                                                        ->where('status', 'confirmed')
                                                        ->count() > 0
                                                ) {
                                                    $confirmedAt = $salesOrder->statusHistories
                                                        ->where('status', 'confirmed')
                                                        ->first()->created_at;
                                                }
                                            @endphp
                                            {{ $confirmedAt->format('d M, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .timeline-content {
            margin-left: 10px;
        }

        .table tfoot tr:last-child td {
            border-top: 2px solid #333;
            font-size: 1.1em;
        }

        .card-header {
            border-bottom: none;
        }

        .address {
            white-space: pre-line;
            line-height: 1.6;
        }

        .badge.bg-draft {
            background-color: #6c757d;
        }

        .badge.bg-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge.bg-confirmed {
            background-color: #198754;
        }

        .badge.bg-processing {
            background-color: #0dcaf0;
        }

        .badge.bg-completed {
            background-color: #6f42c1;
        }

        .badge.bg-cancelled {
            background-color: #dc3545;
        }

        .badge.bg-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge.bg-partial {
            background-color: #fd7e14;
        }

        .badge.bg-paid {
            background-color: #198754;
        }

        .badge.bg-overdue {
            background-color: #dc3545;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function printInvoice() {
            window.open('{{ route('sales.sales-orders.print', $salesOrder) }}', '_blank');
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this sales order? This action cannot be undone.')) {
                document.getElementById('deleteForm').submit();
            }
        }

        function confirmOrder() {
            if (confirm('Are you sure you want to confirm this order? Once confirmed, it cannot be edited.')) {
                // You can implement AJAX confirmation here
                window.location.href = '{{ route('sales.sales-orders.confirm', $salesOrder) }}';
            }
        }

        // Status colors based on status
        document.addEventListener('DOMContentLoaded', function() {
            const statusColors = {
                'draft': 'secondary',
                'pending': 'warning',
                'confirmed': 'success',
                'processing': 'info',
                'completed': 'primary',
                'cancelled': 'danger'
            };

            const paymentStatusColors = {
                'pending': 'warning',
                'partial': 'info',
                'paid': 'success',
                'overdue': 'danger'
            };

            // You can use these colors in your JavaScript if needed
        });
    </script>
@endpush
