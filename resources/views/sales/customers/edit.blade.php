@extends('layouts.app')

@section('title', 'Edit Customer - ' . $customer->customer_name . ' - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Customer</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('sales.customers.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Customers
            </a>
            <a href="{{ route('sales.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i> View Customer
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Customer Information</h5>
                    <p class="text-muted mb-0">Customer Code: {{ $customer->customer_code }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label for="customer_code" class="form-label">Customer Code *</label>
                                    <input type="text" class="form-control @error('customer_code') is-invalid @enderror"
                                        id="customer_code" name="customer_code"
                                        value="{{ old('customer_code', $customer->customer_code) }}" required>
                                    <div class="form-text">Unique code for the customer</div>
                                    @error('customer_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name"
                                        value="{{ old('customer_name', $customer->customer_name) }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer_type" class="form-label">Customer Type *</label>
                                    <select class="form-select @error('customer_type') is-invalid @enderror"
                                        id="customer_type" name="customer_type" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="retail"
                                            {{ old('customer_type', $customer->customer_type) == 'retail' ? 'selected' : '' }}>
                                            Retail</option>
                                        <option value="wholesale"
                                            {{ old('customer_type', $customer->customer_type) == 'wholesale' ? 'selected' : '' }}>
                                            Wholesale</option>
                                        <option value="corporate"
                                            {{ old('customer_type', $customer->customer_type) == 'corporate' ? 'selected' : '' }}>
                                            Corporate</option>
                                    </select>
                                    @error('customer_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person"
                                        value="{{ old('contact_person', $customer->contact_person) }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $customer->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $customer->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes', $customer->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <!-- Tax & Financial Information -->
                            <div class="col-md-6">
                                <h6 class="mb-3">Tax & Financial Information</h6>

                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <label for="tin" class="form-label">TIN Number</label>
                                        <input type="text" class="form-control @error('tin') is-invalid @enderror"
                                            id="tin" name="tin" value="{{ old('tin', $customer->tin) }}"
                                            title="Enter valid 15-digit tin">
                                            <div class="form-text">15-character TIN</div>
                                        @error('tin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="bin_number" class="form-label">BIN Number</label>
                                        <input type="text"
                                            class="form-control @error('bin_number') is-invalid @enderror" id="bin_number"
                                            name="bin_number" value="{{ old('bin_number', $customer->bin_number) }}"
                                            title="Enter valid BIN (e.g., ABCDE1234F)">
                                        <div class="form-text">10-character BIN</div>
                                        @error('bin_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tax_reg_number" class="form-label">Tax Registration Number</label>
                                    <input type="text"
                                        class="form-control @error('tax_reg_number') is-invalid @enderror"
                                        id="tax_reg_number" name="tax_reg_number"
                                        value="{{ old('tax_reg_number', $customer->tax_reg_number) }}">
                                    @error('tax_reg_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="credit_limit" class="form-label">Credit Limit (₹)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('credit_limit') is-invalid @enderror"
                                            id="credit_limit" name="credit_limit"
                                            value="{{ old('credit_limit', $customer->credit_limit) }}">
                                        <div class="form-text">Maximum credit allowed</div>
                                        @error('credit_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payment_terms" class="form-label">Payment Terms</label>
                                        <select class="form-select @error('payment_terms') is-invalid @enderror"
                                            id="payment_terms" name="payment_terms">
                                            <option value="">-- Select Terms --</option>
                                            <option value="cod"
                                                {{ old('payment_terms', $customer->payment_terms) == 'cod' ? 'selected' : '' }}>
                                                Cash on Delivery
                                            </option>
                                            <option value="7_days"
                                                {{ old('payment_terms', $customer->payment_terms) == '7_days' ? 'selected' : '' }}>
                                                7 Days
                                            </option>
                                            <option value="15_days"
                                                {{ old('payment_terms', $customer->payment_terms) == '15_days' ? 'selected' : '' }}>
                                                15 Days
                                            </option>
                                            <option value="30_days"
                                                {{ old('payment_terms', $customer->payment_terms) == '30_days' ? 'selected' : '' }}>
                                                30 Days
                                            </option>
                                            <option value="60_days"
                                                {{ old('payment_terms', $customer->payment_terms) == '60_days' ? 'selected' : '' }}>
                                                60 Days
                                            </option>
                                        </select>
                                        @error('payment_terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="opening_balance" class="form-label">Opening Balance (₹)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('opening_balance') is-invalid @enderror"
                                        id="opening_balance" name="opening_balance"
                                        value="{{ old('opening_balance', $customer->opening_balance) }}">
                                    <div class="form-text">Initial balance when adding customer</div>
                                    @error('opening_balance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Bank Account Number</label>
                                    <input type="text"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        id="account_number" name="account_number"
                                        value="{{ old('account_number', $customer->account_number) }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        id="bank_name" name="bank_name"
                                        value="{{ old('bank_name', $customer->bank_name) }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                        id="ifsc_code" name="ifsc_code"
                                        value="{{ old('ifsc_code', $customer->ifsc_code) }}">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="active"
                                            {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="blocked"
                                            {{ old('status', $customer->status) == 'blocked' ? 'selected' : '' }}>
                                            Blocked
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">Additional Information</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                                            id="website" name="website"
                                            value="{{ old('website', $customer->website) }}">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="industry" class="form-label">Industry</label>
                                        <input type="text"
                                            class="form-control @error('industry') is-invalid @enderror" id="industry"
                                            name="industry" value="{{ old('industry', $customer->industry) }}">
                                        @error('industry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i> Delete Customer
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('sales.customers.show', $customer->id) }}"
                                    class="btn btn-secondary me-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Update Customer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete customer <strong>{{ $customer->customer_name }}</strong>?</p>
                    <p class="text-danger">
                        <i class="bi bi-exclamation-triangle"></i> This action cannot be undone.
                        All associated invoices and sales orders will be affected.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('sales.customers.destroy', $customer->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        h6 {
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 8px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-text {
            font-size: 0.85rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // // Format BIN number input (10 characters: 5 letters, 4 numbers, 1 letter)
        // document.getElementById('bin_number').addEventListener('input', function(e) {
        //     let value = e.target.value.toUpperCase();
        //     value = value.replace(/[^A-Z0-9]/g, '');

        //     // Limit to 10 characters
        //     if (value.length > 10) {
        //         value = value.substring(0, 10);
        //     }

        //     e.target.value = value;

        //     // Add real-time validation
        //     const binPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
        //     if (value.length === 10 && !binPattern.test(value)) {
        //         e.target.classList.add('is-invalid');
        //         e.target.classList.remove('is-valid');
        //     } else if (value.length === 10) {
        //         e.target.classList.remove('is-invalid');
        //         e.target.classList.add('is-valid');
        //     } else {
        //         e.target.classList.remove('is-invalid', 'is-valid');
        //     }
        // });

        // // Format tin input (15 characters: 2 digits, 10 characters, 1 digit, 1 letter, 1 digit)
        // document.getElementById('tin').addEventListener('input', function(e) {
        //     let value = e.target.value.toUpperCase();
        //     value = value.replace(/[^A-Z0-9]/g, '');

        //     // Limit to 15 characters
        //     if (value.length > 15) {
        //         value = value.substring(0, 15);
        //     }

        //     e.target.value = value;

        //     // Add real-time validation
        //     const tinPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
        //     if (value.length === 15 && !tinPattern.test(value)) {
        //         e.target.classList.add('is-invalid');
        //         e.target.classList.remove('is-valid');
        //     } else if (value.length === 15) {
        //         e.target.classList.remove('is-invalid');
        //         e.target.classList.add('is-valid');
        //     } else {
        //         e.target.classList.remove('is-invalid', 'is-valid');
        //     }
        // });

        // Format IFSC Code input (11 characters: 4 letters, 0, 6 alphanumeric)
        document.getElementById('ifsc_code').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');

            // Limit to 11 characters
            if (value.length > 11) {
                value = value.substring(0, 11);
            }

            e.target.value = value;

            // Add real-time validation
            const ifscPattern = /^[A-Z]{4}0[A-Z0-9]{6}$/;
            if (value.length === 11 && !ifscPattern.test(value)) {
                e.target.classList.add('is-invalid');
                e.target.classList.remove('is-valid');
            } else if (value.length === 11) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-invalid', 'is-valid');
            }
        });

        // Format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9+]/g, '');

            // Add country code if starting with 0
            if (value.startsWith('0')) {
                value = '+91' + value.substring(1);
            }

            // Limit to 15 characters (including +)
            if (value.length > 15) {
                value = value.substring(0, 15);
            }

            e.target.value = value;

            // Validate Indian phone number
            const phonePattern = /^(\+91[-\s]?)?[6-9]\d{9}$/;
            const cleanPhone = value.replace(/[+\s-]/g, '');

            if (cleanPhone.length >= 10 && !phonePattern.test(value)) {
                e.target.classList.add('is-invalid');
                e.target.classList.remove('is-valid');
            } else if (cleanPhone.length >= 10) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-invalid', 'is-valid');
            }
        });

        // Auto-generate customer code from name (only if empty)
        document.getElementById('customer_name').addEventListener('blur', function() {
            const nameInput = this;
            const codeInput = document.getElementById('customer_code');
            const originalCode = '{{ $customer->customer_code }}';

            // Only generate code if user hasn't manually changed it from original
            if (codeInput.value === originalCode && nameInput.value.trim() !== '') {
                const customerName = nameInput.value.trim();
                const words = customerName.split(' ');
                let code = '';

                if (words.length === 1) {
                    code = words[0].substring(0, 8).toUpperCase();
                } else {
                    code = words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Add sequential number if needed
                if (code.length > 8) {
                    code = code.substring(0, 8);
                }

                // Ensure code is not empty
                if (code) {
                    codeInput.value = code;
                }
            }
        });

        // Credit limit validation
        document.getElementById('credit_limit').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value) || 0;

            if (value < 0) {
                e.target.value = 0;
                e.target.classList.add('is-invalid');
            } else if (value > 10000000) { // 1 Crore max
                e.target.value = 10000000;
                e.target.classList.add('is-invalid');
                setTimeout(() => {
                    e.target.classList.remove('is-invalid');
                }, 2000);
            } else {
                e.target.classList.remove('is-invalid');
            }
        });

        // Show confirmation before leaving page if form has changes
        let formChanged = false;
        const form = document.querySelector('form');

        form.addEventListener('change', function() {
            formChanged = true;
        });

        form.addEventListener('submit', function() {
            formChanged = false;
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            }
        });
    </script>
@endpush
