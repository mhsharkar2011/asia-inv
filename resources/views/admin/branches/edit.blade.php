@extends('layouts.app')

@section('title', 'Edit Branch')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h3 fw-bold mb-2">Edit Branch: {{ $branch->branch_name }}</h1>
                <p class="text-muted mb-0">Update branch information</p>
            </div>
            <div>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('admin.branches.update', $branch) }}" method="POST" id="editBranchForm">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Company & Basic Information -->
                                <div class="col-md-12">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-building me-2"></i>Company & Basic Information
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Company *</label>
                                    <select class="form-select @error('company_id') is-invalid @enderror" name="company_id"
                                        id="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company_id', $branch->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Branch Code *</label>
                                    <input type="text" class="form-control @error('branch_code') is-invalid @enderror"
                                        name="branch_code" id="branch_code"
                                        value="{{ old('branch_code', $branch->branch_code) }}" required>
                                    <div class="form-text">Unique branch identifier</div>
                                    @error('branch_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Branch Name *</label>
                                    <input type="text" class="form-control @error('branch_name') is-invalid @enderror"
                                        name="branch_name" value="{{ old('branch_name', $branch->branch_name) }}" required>
                                    @error('branch_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Branch Type *</label>
                                    <select class="form-select @error('branch_type') is-invalid @enderror"
                                        name="branch_type" required>
                                        <option value="">Select Type</option>
                                        @foreach ($branchTypes as $typeKey => $typeName)
                                            <option value="{{ $typeKey }}"
                                                {{ old('branch_type', $branch->branch_type) == $typeKey ? 'selected' : '' }}>
                                                {{ $typeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                        name="contact_person" value="{{ old('contact_person', $branch->contact_person) }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $branch->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contact Information -->
                                <div class="col-md-12 mt-4">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-telephone me-2"></i>Contact Information
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', $branch->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone', $branch->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Alternate Phone</label>
                                    <input type="text"
                                        class="form-control @error('alternate_phone') is-invalid @enderror"
                                        name="alternate_phone"
                                        value="{{ old('alternate_phone', $branch->alternate_phone) }}">
                                    @error('alternate_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address Information -->
                                <div class="col-md-12 mt-4">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-geo-alt me-2"></i>Address Information
                                    </h6>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Address Line 1 *</label>
                                    <input type="text" class="form-control @error('address_line_1') is-invalid @enderror"
                                        name="address_line_1" value="{{ old('address_line_1', $branch->address_line_1) }}"
                                        required>
                                    @error('address_line_1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text"
                                        class="form-control @error('address_line_2') is-invalid @enderror"
                                        name="address_line_2"
                                        value="{{ old('address_line_2', $branch->address_line_2) }}">
                                    @error('address_line_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">City *</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city', $branch->city) }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">State/Province</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        name="state" value="{{ old('state', $branch->state) }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Country *</label>
                                    <select class="form-select @error('country') is-invalid @enderror" name="country"
                                        required>
                                        <option value="Bangladesh"
                                            {{ old('country', $branch->country) == 'Bangladesh' ? 'selected' : '' }}>
                                            Bangladesh</option>
                                        <option value="India"
                                            {{ old('country', $branch->country) == 'India' ? 'selected' : '' }}>India
                                        </option>
                                        <option value="USA"
                                            {{ old('country', $branch->country) == 'USA' ? 'selected' : '' }}>United States
                                        </option>
                                        <option value="UK"
                                            {{ old('country', $branch->country) == 'UK' ? 'selected' : '' }}>United Kingdom
                                        </option>
                                        <option value="Other"
                                            {{ old('country', $branch->country) == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                        name="postal_code" value="{{ old('postal_code', $branch->postal_code) }}">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Latitude</label>
                                    <input type="number" step="0.00000001"
                                        class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                                        value="{{ old('latitude', $branch->latitude) }}">
                                    <div class="form-text">For mapping (optional)</div>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Longitude</label>
                                    <input type="number" step="0.00000001"
                                        class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                                        value="{{ old('longitude', $branch->longitude) }}">
                                    <div class="form-text">For mapping (optional)</div>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Operating Hours -->
                                <div class="col-md-12 mt-4">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-clock me-2"></i>Operating Hours
                                    </h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Opening Time *</label>
                                    <input type="time"
                                        class="form-control @error('opening_time') is-invalid @enderror"
                                        name="opening_time"
                                        value="{{ old('opening_time', $branch->opening_time->format('H:i')) }}" required>
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Closing Time *</label>
                                    <input type="time"
                                        class="form-control @error('closing_time') is-invalid @enderror"
                                        name="closing_time"
                                        value="{{ old('closing_time', $branch->closing_time->format('H:i')) }}" required>
                                    @error('closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Working Days *</label>
                                    <input type="text"
                                        class="form-control @error('working_days') is-invalid @enderror"
                                        name="working_days" value="{{ old('working_days', $branch->working_days) }}"
                                        required>
                                    <div class="form-text">e.g., Monday-Friday, Sunday-Thursday</div>
                                    @error('working_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Capacity & Facilities -->
                                <div class="col-md-12 mt-4">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-diagram-3 me-2"></i>Capacity & Facilities
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Staff Capacity</label>
                                    <input type="number" class="form-control @error('staff_count') is-invalid @enderror"
                                        name="staff_count" value="{{ old('staff_count', $branch->staff_count) }}"
                                        min="0">
                                    <div class="form-text">Maximum number of staff members</div>
                                    @error('staff_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Area (Square Feet)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01"
                                            class="form-control @error('area_sqft') is-invalid @enderror"
                                            name="area_sqft" value="{{ old('area_sqft', $branch->area_sqft) }}"
                                            min="0">
                                        <span class="input-group-text">sqft</span>
                                    </div>
                                    @error('area_sqft')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Settings -->
                                <div class="col-md-12 mt-4">
                                    <h6 class="mb-3 text-muted border-bottom pb-2">
                                        <i class="bi bi-gear me-2"></i>Settings
                                    </h6>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="is_head_office" id="is_head_office" value="1"
                                                    {{ old('is_head_office', $branch->is_head_office) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_head_office">
                                                    Head Office
                                                </label>
                                                <div class="form-text">Primary company location</div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="is_active" id="is_active" value="1"
                                                    {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active Branch
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="has_warehouse" id="has_warehouse" value="1"
                                                    {{ old('has_warehouse', $branch->has_warehouse) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="has_warehouse">
                                                    Has Warehouse
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="has_showroom" id="has_showroom" value="1"
                                                    {{ old('has_showroom', $branch->has_showroom) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="has_showroom">
                                                    Has Showroom
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <a href="{{ route('admin.branches.index') }}" class="btn btn-light me-3">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Branch
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
        document.addEventListener('DOMContentLoaded', function() {
            // Time validation
            const openingTime = document.querySelector('input[name="opening_time"]');
            const closingTime = document.querySelector('input[name="closing_time"]');

            if (openingTime && closingTime) {
                openingTime.addEventListener('change', function() {
                    closingTime.min = this.value;
                });

                closingTime.addEventListener('change', function() {
                    if (this.value <= openingTime.value) {
                        alert('Closing time must be after opening time');
                        this.value = openingTime.value;
                    }
                });
            }

            // Head office warning
            const isHeadOfficeCheckbox = document.getElementById('is_head_office');
            if (isHeadOfficeCheckbox) {
                isHeadOfficeCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (!confirm(
                                'Setting this as head office will remove head office status from other branches of the same company. Continue?'
                                )) {
                            this.checked = false;
                        }
                    }
                });
            }
        });
    </script>
@endpush
