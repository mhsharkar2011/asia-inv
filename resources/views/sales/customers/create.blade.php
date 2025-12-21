@extends('layouts.admin')

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
                                    <div class="form-text">Unique code for the customer</div>
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
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
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
                                            id="tin" name="tin" value="{{ old('tin') }}"
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
                                            name="bin_number" value="{{ old('bin_number') }}"
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
                                        id="tax_reg_number" name="tax_reg_number" value="{{ old('tax_reg_number') }}">
                                    @error('tax_reg_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <label for="payment_terms" class="form-label">Payment Terms</label>
                                        <select class="form-select @error('payment_terms') is-invalid @enderror"
                                            id="payment_terms" name="payment_terms">
                                            <option value="">-- Select Terms --</option>
                                            <option value="cod" {{ old('payment_terms') == 'cod' ? 'selected' : '' }}>
                                                Cash on Delivery
                                            </option>
                                            <option value="7_days"
                                                {{ old('payment_terms') == '7_days' ? 'selected' : '' }}>
                                                7 Days
                                            </option>
                                            <option value="15_days"
                                                {{ old('payment_terms') == '15_days' ? 'selected' : '' }}>
                                                15 Days
                                            </option>
                                            <option value="30_days"
                                                {{ old('payment_terms') == '30_days' ? 'selected' : '' }}>
                                                30 Days
                                            </option>
                                            <option value="60_days"
                                                {{ old('payment_terms') == '60_days' ? 'selected' : '' }}>
                                                60 Days
                                            </option>
                                        </select>
                                        @error('payment_terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="opening_balance" class="form-label">Opening Balance (BDT)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('opening_balance') is-invalid @enderror"
                                        id="opening_balance" name="opening_balance"
                                        value="{{ old('opening_balance', 0) }}">
                                    <div class="form-text">Initial balance when adding customer</div>
                                    @error('opening_balance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Bank Account Number</label>
                                    <input type="text"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        id="account_number" name="account_number" value="{{ old('account_number') }}">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="ifsc_code" class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                        id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}">
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="active"
                                            {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>
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
                                            id="website" name="website" value="{{ old('website') }}">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="industry" class="form-label">Industry</label>
                                        <input type="text"
                                            class="form-control @error('industry') is-invalid @enderror" id="industry"
                                            name="industry" value="{{ old('industry') }}">
                                        @error('industry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                    code = words[0].substring(0, 8).toUpperCase();
                } else {
                    code = words.map(word => word.charAt(0)).join('').toUpperCase();
                }

                // Limit to 8 characters
                if (code.length > 8) {
                    code = code.substring(0, 8);
                }

                // Ensure code is not empty
                if (code) {
                    codeInput.value = code;
                }
            }
        });

        // Format BIN number input (10 characters: 5 letters, 4 numbers, 1 letter)
        document.getElementById('bin_number').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');

            // Limit to 10 characters
            if (value.length > 10) {
                value = value.substring(0, 10);
            }

            e.target.value = value;

            // Add real-time validation
            const binPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            if (value.length === 10 && !binPattern.test(value)) {
                e.target.classList.add('is-invalid');
                e.target.classList.remove('is-valid');
            } else if (value.length === 10) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-invalid', 'is-valid');
            }
        });

        // Format TIN input (15 characters: 2 digits, 10 characters, 1 digit, 1 letter, 1 digit)
        document.getElementById('tin').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');

            // Limit to 15 characters
            if (value.length > 15) {
                value = value.substring(0, 15);
            }

            e.target.value = value;

            // Add real-time validation
            const tinPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            if (value.length === 15 && !tinPattern.test(value)) {
                e.target.classList.add('is-invalid');
                e.target.classList.remove('is-valid');
            } else if (value.length === 15) {
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

        // Opening balance validation
        document.getElementById('opening_balance').addEventListener('input', function(e) {
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

        // Email validation
        document.getElementById('email').addEventListener('blur', function(e) {
            const value = e.target.value.trim();

            if (value && !isValidEmail(value)) {
                e.target.classList.add('is-invalid');
                e.target.classList.remove('is-valid');
            } else if (value) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-invalid', 'is-valid');
            }
        });

        function isValidEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

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

        // Set default values
        document.addEventListener('DOMContentLoaded', function() {
            // Set default status to active
            document.getElementById('status').value = 'active';

            // Set default opening balance to 0 if empty
            const openingBalance = document.getElementById('opening_balance');
            if (!openingBalance.value.trim()) {
                openingBalance.value = '0';
            }
        });
    </script>
@endpush
