@extends('admin.departments.layout')

@section('department-content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h1 class="h3 fw-bold mb-2">Create New Department</h1>
            <p class="text-muted mb-0">Add a new department to your organization</p>
        </div>
        <div>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.departments.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Basic Information -->
                            <div class="col-md-12">
                                <h6 class="mb-3 text-muted">Basic Information</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Department Code *</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    name="code" value="{{ old('code', $nextCode) }}" required>
                                <div class="form-text">Unique department identifier</div>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Department Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hierarchy & Management -->
                            <div class="col-md-12 mt-4">
                                <h6 class="mb-3 text-muted">Hierarchy & Management</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Parent Department</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" name="parent_id">
                                    <option value="">No Parent (Top Level)</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ old('parent_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }} ({{ $dept->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Leave empty for top-level department</div>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Department Manager</label>
                                <select class="form-select @error('manager_id') is-invalid @enderror" name="manager_id">
                                    <option value="">Select Manager</option>
                                    @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }} ({{ $manager->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Information -->
                            <div class="col-md-12 mt-4">
                                <h6 class="mb-3 text-muted">Contact Information</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    name="location" value="{{ old('location') }}" placeholder="e.g., Building A, Floor 3">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capacity & Budget -->
                            <div class="col-md-12 mt-4">
                                <h6 class="mb-3 text-muted">Capacity & Budget</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Staff Capacity</label>
                                <input type="number" class="form-control @error('staff_count') is-invalid @enderror"
                                    name="staff_count" value="{{ old('staff_count', 0) }}" min="0">
                                <div class="form-text">Maximum number of staff members</div>
                                @error('staff_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Annual Budget (৳)</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" step="0.01"
                                        class="form-control @error('budget') is-invalid @enderror" name="budget"
                                        value="{{ old('budget') }}" min="0">
                                </div>
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Settings -->
                            <div class="col-md-12 mt-4">
                                <h6 class="mb-3 text-muted">Settings</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <div class="form-text">Lower numbers appear first</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_active"
                                        id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Department
                                    </label>
                                    <div class="form-text">Inactive departments won't appear in selection lists</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-light me-3">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create Department
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
