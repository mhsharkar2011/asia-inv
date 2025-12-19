@extends('layouts.app')

@section('title', 'Branch Details: ' . $branch->branch_name)

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h3 fw-bold mb-2">Branch Details</h1>
                <p class="text-muted mb-0">{{ $branch->branch_name }} ({{ $branch->branch_code }})</p>
            </div>
            <div>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
                <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>Edit
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Branch Information -->
            <div class="col-xl-8">
                <!-- Branch Overview Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Branch Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Branch Code</label>
                                    <p class="fw-semibold">{{ $branch->branch_code }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Branch Name</label>
                                    <p class="fw-semibold">{{ $branch->branch_name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Branch Type</label>
                                    <p>{!! $branch->type_badge !!}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Company</label>
                                    <p class="fw-semibold">{{ $branch->company->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <p>{!! $branch->status_badge !!}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Operating Hours</label>
                                    <p class="fw-semibold">{{ $branch->operating_hours }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Working Days</label>
                                    <p class="fw-semibold">{{ $branch->working_days }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created Date</label>
                                    <p class="fw-semibold">{{ $branch->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($branch->description)
                            <div class="mt-3">
                                <label class="form-label text-muted">Description</label>
                                <p class="fw-semibold">{{ $branch->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Contact Person</label>
                                    <p class="fw-semibold">{{ $branch->contact_person ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Email Address</label>
                                    <p class="fw-semibold">{{ $branch->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Phone Number</label>
                                    <p class="fw-semibold">{{ $branch->phone ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Alternate Phone</label>
                                    <p class="fw-semibold">{{ $branch->alternate_phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Address Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">Full Address</label>
                            <p class="fw-semibold">{{ $branch->full_address }}</p>
                        </div>

                        @if ($branch->latitude && $branch->longitude)
                            <div class="mt-3">
                                <a href="{{ $branch->map_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-map me-1"></i>View on Map
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Statistics & Actions -->
            <div class="col-xl-4">
                <!-- Statistics Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Branch Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                    <h3 class="fw-bold text-primary mb-1">{{ $stats['total_staff'] }}</h3>
                                    <small class="text-muted">Total Staff</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                    <h3 class="fw-bold text-success mb-1">{{ $stats['active_staff'] }}</h3>
                                    <small class="text-muted">Active Staff</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                    <h3 class="fw-bold text-warning mb-1">{{ $stats['total_warehouses'] }}</h3>
                                    <small class="text-muted">Warehouses</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                    <h3 class="fw-bold text-info mb-1">{{ $stats['active_warehouses'] }}</h3>
                                    <small class="text-muted">Active Warehouses</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label text-muted">Staff Capacity</label>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-3" style="height: 10px;">
                                    <div class="progress-bar bg-{{ $branch->staff_count > 0 ? 'success' : 'secondary' }}"
                                        style="width: {{ min(($stats['total_staff'] / max($branch->staff_count, 1)) * 100, 100) }}%">
                                    </div>
                                </div>
                                <span class="fw-semibold">{{ $stats['total_staff'] }}/{{ $branch->staff_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Facilities</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">Branch Area</label>
                            <p class="fw-semibold">
                                {{ $branch->area_sqft ? number_format($branch->area_sqft) . ' sqft' : 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Available Facilities</label>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($branch->is_head_office)
                                    <span class="badge bg-purple">Head Office</span>
                                @endif
                                @if ($branch->has_warehouse)
                                    <span class="badge bg-warning">Warehouse</span>
                                @endif
                                @if ($branch->has_showroom)
                                    <span class="badge bg-info">Showroom</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if (!$branch->is_head_office)
                                <form action="{{ route('admin.branches.set-head-office', $branch) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-purple w-100 text-start"
                                        onclick="return confirm('Set this branch as head office?')">
                                        <i class="bi bi-building me-2"></i>Set as Head Office
                                    </button>
                                </form>
                            @endif

                            @if ($branch->canBeDeleted())
                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 text-start"
                                        onclick="return confirm('Are you sure you want to delete this branch?')">
                                        <i class="bi bi-trash me-2"></i>Delete Branch
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.users.index', ['branch_id' => $branch->id]) }}"
                                class="btn btn-outline-primary w-100 text-start">
                                <i class="bi bi-people me-2"></i>View Staff Members
                            </a>

                            <a href="{{ route('admin.warehouses.index', ['branch_id' => $branch->id]) }}"
                                class="btn btn-outline-warning w-100 text-start">
                                <i class="bi bi-box-seam me-2"></i>View Warehouses
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Staff Members -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Recent Staff Members</h5>
                            <a href="{{ route('admin.users.index', ['branch_id' => $branch->id]) }}"
                                class="btn btn-outline-primary btn-sm">
                                View All Staff
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($branch->users->count() > 0)
                            <div class="row">
                                @foreach ($branch->users->take(6) as $user)
                                    <div class="col-md-4 col-lg-2 mb-3">
                                        <div class="card border">
                                            <div class="card-body text-center">
                                                <div class="avatar avatar-lg mb-2">
                                                    <div class="avatar-title rounded-circle bg-primary text-white">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <h6 class="mb-1">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->role }}</small>
                                                <div class="mt-2">
                                                    @if ($user->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-people display-4 text-muted opacity-50"></i>
                                <p class="mt-3">No staff members assigned to this branch</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="bi bi-person-plus me-2"></i>Add Staff Member
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
