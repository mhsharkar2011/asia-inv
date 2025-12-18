@extends('layouts.app')

@section('title', 'Create Supplier - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create Supplier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Suppliers
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('purchase.suppliers.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label for="supplier_code" class="form-label">Supplier Code *</label>
                                    <input type="text" class="form-control @error('supplier_code') is-invalid @enderror"
                                        id="supplier_code" name="supplier_code" value="{{ old('supplier_code') }}" required>
                                    <div class="form-text">Unique code for the supplier (e.g., SUP001)</div>
                                    @error('supplier_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="supplier_name" class="form-label">Supplier Name *</label>
                                    <input type="text" class="form-control @error('supplier_name') is-invalid @enderror"
                                        id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}" required>
                                    @error('supplier_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
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
                                        <label for="tin" class="form-label">TIN (Tax Identification Number)</label>
                                        <input type="text" class="form-control @error('tin') is-invalid @enderror"
                                            id="tin" name="tin" value="{{ old('tin') }}"
                                            title="Enter valid TIN (9 or 12 digits)">
                                        <div class="form-text">9 or 12 digit TIN (e.g., 123456789)</div>
                                        @error('tin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bin" class="form-label">BIN (Business Identification
                                            Number)</label>
                                        <input type="text" class="form-control @error('bin') is-invalid @enderror"
                                            id="bin" name="bin" value="{{ old('bin') }}"
                                            title="Enter valid BIN (13 or 15 digits)">
                                        <div class="form-text">13 or 15 digit BIN</div>
                                        @error('bin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="credit_limit" class="form-label">Credit Limit (BDT)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('credit_limit') is-invalid @enderror"
                                            id="credit_limit" name="credit_limit" value="{{ old('credit_limit') }}">
                                        <div class="form-text">Maximum credit allowed</div>
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
                                            value="{{ old('outstanding_balance', 0) }}">
                                        @error('outstanding_balance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="trade_license" class="form-label">Trade License Number</label>
                                        <input type="text"
                                            class="form-control @error('trade_license') is-invalid @enderror"
                                            id="trade_license" name="trade_license" value="{{ old('trade_license') }}">
                                        @error('trade_license')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="business_type" class="form-label">Business Type</label>
                                        <select class="form-select @error('business_type') is-invalid @enderror"
                                            id="business_type" name="business_type">
                                            <option value="">-- Select Business Type --</option>
                                            <option value="Sole Proprietorship"
                                                {{ old('business_type') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole
                                                Proprietorship</option>
                                            <option value="Partnership"
                                                {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>Partnership
                                            </option>
                                            <option value="Private Limited"
                                                {{ old('business_type') == 'Private Limited' ? 'selected' : '' }}>Private
                                                Limited</option>
                                            <option value="Public Limited"
                                                {{ old('business_type') == 'Public Limited' ? 'selected' : '' }}>Public
                                                Limited</option>
                                            <option value="LLC" {{ old('business_type') == 'LLC' ? 'selected' : '' }}>
                                                LLC</option>
                                            <option value="Other"
                                                {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('business_type')
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
                                            {{ old('payment_terms') == 'Cash on Delivery' ? 'selected' : '' }}>Cash on
                                            Delivery</option>
                                        <option value="Net 7 Days"
                                            {{ old('payment_terms') == 'Net 7 Days' ? 'selected' : '' }}>Net 7 Days
                                        </option>
                                        <option value="Net 15 Days"
                                            {{ old('payment_terms') == 'Net 15 Days' ? 'selected' : '' }}>Net 15 Days
                                        </option>
                                        <option value="Net 30 Days"
                                            {{ old('payment_terms') == 'Net 30 Days' ? 'selected' : '' }}>Net 30 Days
                                        </option>
                                        <option value="Net 45 Days"
                                            {{ old('payment_terms') == 'Net 45 Days' ? 'selected' : '' }}>Net 45 Days
                                        </option>
                                        <option value="Net 60 Days"
                                            {{ old('payment_terms') == 'Net 60 Days' ? 'selected' : '' }}>Net 60 Days
                                        </option>
                                        <option value="Advance Payment"
                                            {{ old('payment_terms') == 'Advance Payment' ? 'selected' : '' }}>Advance
                                            Payment</option>
                                    </select>
                                    @error('payment_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Supplier</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Create Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate supplier code from name
        document.getElementById('supplier_name').addEventListener('blur', function() {
            const nameInput = this;
            const codeInput = document.getElementById('supplier_code');

            // Only generate code if code field is empty
            if (codeInput.value.trim() === '' && nameInput.value.trim() !== '') {
                const supplierName = nameInput.value.trim();
                const words = supplierName.split(' ');
                let code = '';

                if (words.length === 1) {
                    code = 'SUP' + words[0].substring(0, 3).toUpperCase();
                } else {
                    code = 'SUP' + words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Add sequential number if needed
                if (code.length > 6) {
                    code = code.substring(0, 6);
                }

                codeInput.value = code;
            }
        });
    </script>
@endpush
