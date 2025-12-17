@extends('layouts.app')

@section('title', 'Edit Supplier - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Supplier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('purchase.suppliers.show', $supplier->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-eye"></i> View
            </a>
            <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Suppliers
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Supplier Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('purchase.suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label for="supplier_code" class="form-label">Supplier Code *</label>
                                    <input type="text" class="form-control @error('supplier_code') is-invalid @enderror"
                                        id="supplier_code" name="supplier_code"
                                        value="{{ old('supplier_code', $supplier->supplier_code) }}" required>
                                    @error('supplier_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="supplier_name" class="form-label">Supplier Name *</label>
                                    <input type="text" class="form-control @error('supplier_name') is-invalid @enderror"
                                        id="supplier_name" name="supplier_name"
                                        value="{{ old('supplier_name', $supplier->supplier_name) }}" required>
                                    @error('supplier_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person"
                                        value="{{ old('contact_person', $supplier->contact_person) }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $supplier->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tax & Financial Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Tax & Financial Information</h6>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gstin" class="form-label">GSTIN</label>
                                        <input type="text" class="form-control @error('gstin') is-invalid @enderror"
                                            id="gstin" name="gstin" value="{{ old('gstin', $supplier->gstin) }}"
                                            pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}"
                                            title="Enter valid 15-digit GSTIN">
                                        @error('gstin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pan_number" class="form-label">PAN Number</label>
                                        <input type="text" class="form-control @error('pan_number') is-invalid @enderror"
                                            id="pan_number" name="pan_number"
                                            value="{{ old('pan_number', $supplier->pan_number) }}"
                                            pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" title="Enter valid PAN (e.g., ABCDE1234F)">
                                        @error('pan_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="credit_limit" class="form-label">Credit Limit (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('credit_limit') is-invalid @enderror"
                                            id="credit_limit" name="credit_limit"
                                            value="{{ old('credit_limit', $supplier->credit_limit) }}">
                                        @error('credit_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="outstanding_balance" class="form-label">Outstanding Balance
                                            (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('outstanding_balance') is-invalid @enderror"
                                            id="outstanding_balance" name="outstanding_balance"
                                            value="{{ old('outstanding_balance', $supplier->outstanding_balance) }}">
                                        @error('outstanding_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="payment_terms" class="form-label">Payment Terms</label>
                                    <select class="form-select @error('payment_terms') is-invalid @enderror"
                                        id="payment_terms" name="payment_terms">
                                        <option value="">-- Select Payment Terms --</option>
                                        <option value="Cash on Delivery"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Cash on Delivery' ? 'selected' : '' }}>
                                            Cash on Delivery</option>
                                        <option value="Net 7 Days"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Net 7 Days' ? 'selected' : '' }}>
                                            Net 7 Days</option>
                                        <option value="Net 15 Days"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Net 15 Days' ? 'selected' : '' }}>
                                            Net 15 Days</option>
                                        <option value="Net 30 Days"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Net 30 Days' ? 'selected' : '' }}>
                                            Net 30 Days</option>
                                        <option value="Net 45 Days"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Net 45 Days' ? 'selected' : '' }}>
                                            Net 45 Days</option>
                                        <option value="Net 60 Days"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Net 60 Days' ? 'selected' : '' }}>
                                            Net 60 Days</option>
                                        <option value="Advance Payment"
                                            {{ old('payment_terms', $supplier->payment_terms) == 'Advance Payment' ? 'selected' : '' }}>
                                            Advance Payment</option>
                                    </select>
                                    @error('payment_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $supplier->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Supplier</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('purchase.suppliers.show', $supplier->id) }}"
                                class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Information -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle me-1"></i> Current Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Total Purchase Orders:</strong> {{ $supplier->purchaseOrders->count() }}</p>
                            <p><strong>Total Purchases:</strong> BDT{{ number_format($supplier->total_purchases ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Credit Usage:</strong>
                                {{ number_format($supplier->credit_usage_percentage ?? 0, 1) }}%</p>
                            <p><strong>Created:</strong> {{ $supplier->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Format GSTIN input
        document.getElementById('gstin').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });

        // Format PAN input
        document.getElementById('pan_number').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });
    </script>
@endpush
