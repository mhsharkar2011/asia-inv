@extends('layouts.app')

@section('title', 'Create Customer - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create Customer</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('sales.customers.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Customers
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.customers.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label for="customer_code" class="form-label">Customer Code *</label>
                                    <input type="text" class="form-control @error('customer_code') is-invalid @enderror"
                                        id="customer_code" name="customer_code" value="{{ old('customer_code') }}" required>
                                    <div class="form-text">Unique code for the customer (e.g., CUST001)</div>
                                    @error('customer_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer_type" class="form-label">Customer Type *</label>
                                    <select class="form-select @error('customer_type') is-invalid @enderror"
                                        id="customer_type" name="customer_type" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="retail" {{ old('customer_type') == 'retail' ? 'selected' : '' }}>
                                            Retail</option>
                                        <option value="wholesale"
                                            {{ old('customer_type') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                        <option value="corporate"
                                            {{ old('customer_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    </select>
                                    @error('customer_type')
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
                                        <label for="tin" class="form-label">TIN</label>
                                        <input type="text" class="form-control @error('tin') is-invalid @enderror"
                                            id="tin" name="tin" value="{{ old('tin') }}"
                                            title="Enter valid 15-digit tin">
                                        <div class="form-text">15-digit tin</div>
                                        @error('tin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bin_number" class="form-label">BIN Number</label>
                                        <input type="text"
                                            class="form-control @error('bin_number') is-invalid @enderror" id="bin_number"
                                            name="bin_number" value="{{ old('bin_number') }}"
                                            title="Enter valid BIN (e.g., ABCDE1234F)">
                                        @error('bin_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="credit_limit" class="form-label">Credit Limit (₹)</label>
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
                                            (₹)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('outstanding_balance') is-invalid @enderror"
                                            id="outstanding_balance" name="outstanding_balance"
                                            value="{{ old('outstanding_balance', 0) }}">
                                        @error('outstanding_balance')
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

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                        value="1" checked>
                                    <label class="form-check-label" for="is_active">Active Customer</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('sales.customers.index') }}" class="btn btn-secondary me-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Create Customer
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
        // Auto-generate customer code from name
        document.getElementById('customer_name').addEventListener('blur', function() {
            const nameInput = this;
            const codeInput = document.getElementById('customer_code');

            // Only generate code if code field is empty
            if (codeInput.value.trim() === '' && nameInput.value.trim() !== '') {
                const customerName = nameInput.value.trim();
                const words = customerName.split(' ');
                let code = '';

                if (words.length === 1) {
                    code = 'CUST' + words[0].substring(0, 3).toUpperCase();
                } else {
                    code = 'CUST' + words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Add sequential number if needed
                if (code.length > 8) {
                    code = code.substring(0, 8);
                }

                codeInput.value = code;
            }
        });

        // // Format tin input
        // document.getElementById('tin').addEventListener('input', function(e) {
        //     let value = e.target.value.toUpperCase();
        //     value = value.replace(/[^A-Z0-9]/g, '');
        //     e.target.value = value;
        // });

        // Format PAN input
        document.getElementById('bin_number').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });
    </script>
@endpush
