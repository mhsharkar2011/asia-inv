@extends('layouts.admin')

@section('title', 'Create Purchase Order')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-plus-circle text-primary"></i> Create New Purchase Order
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('purchase.purchase-orders.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Basic Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="po_number" class="form-label">PO Number *</label>
                                                <input type="text"
                                                    class="form-control @error('po_number') is-invalid @enderror"
                                                    id="po_number" name="po_number"
                                                    value="{{ old('po_number', $poNumber) }}" required>
                                                @error('po_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="company_id" class="form-label">Company *</label>
                                                <select class="form-select @error('company_id') is-invalid @enderror"
                                                    id="company_id" name="company_id" required>
                                                    <option value="">Select Company</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}"
                                                            {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                            {{ $company->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('company_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="order_date" class="form-label">Order Date *</label>
                                                    <input type="date"
                                                        class="form-control @error('order_date') is-invalid @enderror"
                                                        id="order_date" name="order_date"
                                                        value="{{ old('order_date', date('Y-m-d')) }}" required>
                                                    @error('order_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="expected_delivery_date" class="form-label">Expected Delivery
                                                        Date</label>
                                                    <input type="date"
                                                        class="form-control @error('expected_delivery_date') is-invalid @enderror"
                                                        id="expected_delivery_date" name="expected_delivery_date"
                                                        value="{{ old('expected_delivery_date') }}">
                                                    @error('expected_delivery_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Supplier & Warehouse -->
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Supplier & Warehouse</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="supplier_id" class="form-label">Supplier *</label>
                                                <select class="form-select @error('supplier_id') is-invalid @enderror"
                                                    id="supplier_id" name="supplier_id" required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}"
                                                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                            {{ $supplier->supplier_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('supplier_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="warehouse_id" class="form-label">Warehouse *</label>
                                                <select class="form-select @error('warehouse_id') is-invalid @enderror"
                                                    id="warehouse_id" name="warehouse_id" required>
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}"
                                                            {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                            {{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('warehouse_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status *</label>
                                                <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status }}"
                                                            {{ old('status', 'draft') == $status ? 'selected' : '' }}>
                                                            {{ ucfirst($status) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Financial Information -->
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Financial Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="total_amount" class="form-label">Total Amount *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01"
                                                            class="form-control @error('total_amount') is-invalid @enderror"
                                                            id="total_amount" name="total_amount"
                                                            value="{{ old('total_amount', 0) }}" required>
                                                    </div>
                                                    @error('total_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="tax_amount" class="form-label">Tax Amount *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01"
                                                            class="form-control @error('tax_amount') is-invalid @enderror"
                                                            id="tax_amount" name="tax_amount"
                                                            value="{{ old('tax_amount', 0) }}" required>
                                                    </div>
                                                    @error('tax_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="discount" class="form-label">Discount *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01"
                                                            class="form-control @error('discount') is-invalid @enderror"
                                                            id="discount" name="discount"
                                                            value="{{ old('discount', 0) }}" required>
                                                    </div>
                                                    @error('discount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="final_amount" class="form-label">Final Amount *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" step="0.01"
                                                            class="form-control @error('final_amount') is-invalid @enderror"
                                                            id="final_amount" name="final_amount"
                                                            value="{{ old('final_amount', 0) }}" required>
                                                    </div>
                                                    @error('final_amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notes</label>
                                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('purchase.purchase-orders.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Create Purchase Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-calculate final amount
            $(document).ready(function() {
                function calculateFinalAmount() {
                    let total = parseFloat($('#total_amount').val()) || 0;
                    let tax = parseFloat($('#tax_amount').val()) || 0;
                    let discount = parseFloat($('#discount').val()) || 0;
                    let final = total + tax - discount;
                    $('#final_amount').val(final.toFixed(2));
                }

                $('#total_amount, #tax_amount, #discount').on('input', calculateFinalAmount);

                // Set minimum dates
                const today = new Date().toISOString().split('T')[0];
                $('#order_date').attr('min', today);
                $('#expected_delivery_date').attr('min', today);
            });
        </script>
    @endpush
@endsection
