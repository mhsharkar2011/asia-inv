@extends('layouts.admin')

@section('title', 'View Purchase Order')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-cart-check text-primary"></i>
                            Purchase Order: {{ $purchaseOrder->po_number }}
                        </h5>
                        <div class="btn-group">
                            <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Header Information -->
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h6>Supplier</h6>
                                                <p class="fw-bold">{{ $purchaseOrder->supplier->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <h6>Company</h6>
                                                <p class="fw-bold">{{ $purchaseOrder->company->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <h6>Warehouse</h6>
                                                <p class="fw-bold">{{ $purchaseOrder->warehouse->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <h6>Status</h6>
                                                <span class="badge status-{{ $purchaseOrder->status }} px-3 py-2">
                                                    {{ ucfirst($purchaseOrder->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates Information -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Dates</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Order Date:</strong><br>
                                                    {{ $purchaseOrder->order_date->format('d M Y') }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Expected Delivery:</strong><br>
                                                    {{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('d M Y') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <p><strong>Created:</strong>
                                            {{ $purchaseOrder->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Financial Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <tbody>
                                                    <tr>
                                                        <td>Total Amount:</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax Amount:</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchaseOrder->tax_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount:</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchaseOrder->discount, 2) }}</td>
                                                    </tr>
                                                    <tr class="table-active fw-bold">
                                                        <td>Final Amount:</td>
                                                        <td class="text-end">
                                                            ${{ number_format($purchaseOrder->final_amount, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if ($purchaseOrder->notes)
                                <div class="col-md-12 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Notes</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $purchaseOrder->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- If you have items table, add here -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Order Items</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchaseOrder->items as $item)
                                                    <tr>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>${{ number_format($item->unit_price, 2) }}</td>
                                                        <td>${{ number_format($item->total, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
