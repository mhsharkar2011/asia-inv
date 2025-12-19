@extends('layouts.app')

@section('title', 'Create ' . ucfirst($type))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Create New {{ ucfirst($type) }}</h2>
                        <p class="text-muted mb-0">Add a new {{ $type }} to the system</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.organizations.index', ['type' => $type]) }}"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                <!-- Progress Steps -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <h6 class="mb-0">Basic Info</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="rounded-circle bg-light text-secondary d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="rounded-circle bg-light text-secondary d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <h6 class="mb-0">Financial</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="rounded-circle bg-light text-secondary d-inline-flex align-items-center justify-content-center mb-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <h6 class="mb-0">Complete</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('admin.organizations.store') }}" method="POST" id="createForm">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="row">
                                <!-- Left Column: Basic Information -->
                                <div class="col-lg-6">
                                    <h5 class="mb-3 text-primary">
                                        <i class="bi bi-info-circle me-2"></i>Basic Information
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Organization Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Organization Code *</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                name="code" id="code" value="{{ old('code') }}" required>
                                            <div class="form-text">Unique identifier</div>
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Sub Type</label>
                                            <select class="form-select @error('sub_type') is-invalid @enderror"
                                                name="sub_type">
                                                <option value="">Select Sub Type</option>
                                                @foreach ($subTypes as $subType)
                                                    <option value="{{ $subType }}"
                                                        {{ old('sub_type') == $subType ? 'selected' : '' }}>
                                                        {{ ucfirst($subType) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sub_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Contact Person *</label>
                                        <input type="text"
                                            class="form-control @error('contact_person') is-invalid @enderror"
                                            name="contact_person" value="{{ old('contact_person') }}" required>
                                        @error('contact_person')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number *</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                            name="mobile" value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                                            name="website" value="{{ old('website') }}" placeholder="https://">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column: Tax & Address -->
                                <div class="col-lg-6">
                                    <h5 class="mb-3 text-primary">
                                        <i class="bi bi-file-text me-2"></i>Tax & Registration
                                    </h5>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">TIN Number</label>
                                            <input type="text" class="form-control @error('tin') is-invalid @enderror"
                                                name="tin" value="{{ old('tin') }}">
                                            <div class="form-text">Tax Identification Number</div>
                                            @error('tin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">BIN Number</label>
                                            <input type="text" class="form-control @error('bin') is-invalid @enderror"
                                                name="bin" value="{{ old('bin') }}">
                                            <div class="form-text">Business Identification Number</div>
                                            @error('bin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <h5 class="mb-3 text-primary mt-4">
                                        <i class="bi bi-geo-alt me-2"></i>Address Information
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <input type="text"
                                                class="form-control @error('city') is-invalid @enderror" name="city"
                                                value="{{ old('city') }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">District</label>
                                            <input type="text"
                                                class="form-control @error('district') is-invalid @enderror"
                                                name="district" value="{{ old('district') }}">
                                            @error('district')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Country</label>
                                            <select class="form-select @error('country') is-invalid @enderror"
                                                name="country">
                                                <option value="Bangladesh"
                                                    {{ old('country', 'Bangladesh') == 'Bangladesh' ? 'selected' : '' }}>
                                                    Bangladesh</option>
                                                <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>
                                                    India</option>
                                                <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>
                                                    United States</option>
                                                <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>
                                                    United Kingdom</option>
                                                <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Postal Code</label>
                                            <input type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                name="postal_code" value="{{ old('postal_code') }}">
                                            @error('postal_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($type == 'customer')
                                        <h5 class="mb-3 text-primary mt-4">
                                            <i class="bi bi-credit-card me-2"></i>Credit Information
                                        </h5>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Credit Limit (৳)</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    name="credit_limit" value="{{ old('credit_limit', 0) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Outstanding Balance (৳)</label>
                                                <input type="number" step="0.01" class="form-control"
                                                    name="outstanding_balance"
                                                    value="{{ old('outstanding_balance', 0) }}">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($type == 'supplier')
                                        <h5 class="mb-3 text-primary mt-4">
                                            <i class="bi bi-cash-coin me-2"></i>Payment Terms
                                        </h5>
                                        <div class="mb-3">
                                            <label class="form-label">Payment Terms</label>
                                            <select class="form-select" name="payment_terms">
                                                <option value="">Select Terms</option>
                                                <option value="Cash on Delivery"
                                                    {{ old('payment_terms') == 'Cash on Delivery' ? 'selected' : '' }}>Cash
                                                    on Delivery</option>
                                                <option value="Net 7 Days"
                                                    {{ old('payment_terms') == 'Net 7 Days' ? 'selected' : '' }}>Net 7 Days
                                                </option>
                                                <option value="Net 15 Days"
                                                    {{ old('payment_terms') == 'Net 15 Days' ? 'selected' : '' }}>Net 15
                                                    Days</option>
                                                <option value="Net 30 Days"
                                                    {{ old('payment_terms') == 'Net 30 Days' ? 'selected' : '' }}>Net 30
                                                    Days</option>
                                                <option value="Advance Payment"
                                                    {{ old('payment_terms') == 'Advance Payment' ? 'selected' : '' }}>
                                                    Advance Payment</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5 class="mb-3 text-primary">
                                        <i class="bi bi-card-text me-2"></i>Additional Information
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Currency</label>
                                            <select class="form-select" name="currency">
                                                <option value="BDT"
                                                    {{ old('currency', 'BDT') == 'BDT' ? 'selected' : '' }}>Bangladeshi
                                                    Taka (BDT)</option>
                                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>US
                                                    Dollar (USD)</option>
                                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>
                                                    Euro (EUR)</option>
                                                <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>
                                                    Indian Rupee (INR)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Language</label>
                                            <select class="form-select" name="language">
                                                <option value="en"
                                                    {{ old('language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="bn" {{ old('language') == 'bn' ? 'selected' : '' }}>
                                                    Bangla</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="is_active"
                                            id="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">
                                            Active {{ ucfirst($type) }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <a href="{{ route('admin.organizations.index', ['type' => $type]) }}"
                                    class="btn btn-light me-3">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Create {{ ucfirst($type) }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Auto-generate code from name
            $('input[name="name"]').on('blur', function() {
                const name = $(this).val().trim();
                const codeInput = $('#code');

                if (name && !codeInput.val()) {
                    let prefix = '{{ strtoupper(substr($type, 0, 4)) }}';
                    if (prefix.length < 4) prefix += 'X'.repeat(4 - prefix.length);

                    const randomNum = Math.floor(Math.random() * 9000) + 1000;
                    const code = prefix + randomNum;
                    codeInput.val(code);
                }
            });

            // Form validation
            $('#createForm').submit(function(e) {
                const phone = $('input[name="phone"]').val();
                const email = $('input[name="email"]').val();

                // Phone validation
                if (phone && !/^[0-9+\-\s]+$/.test(phone)) {
                    e.preventDefault();
                    alert('Please enter a valid phone number');
                    return false;
                }

                // Email validation
                if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address');
                    return false;
                }

                return true;
            });

            // Auto-capitalize organization name
            $('input[name="name"]').on('keyup', function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
@endpush
