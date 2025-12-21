@extends('layouts.admin')

@section('title', 'Branch Management')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h3 fw-bold mb-2">Branch Management</h1>
                <p class="text-muted mb-0">Manage company branches and locations</p>
            </div>
            <div>
                <a href="{{ route('admin.branches.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add Branch
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Branches</h6>
                                <h2 class="fw-bold mb-0">{{ $totalBranches }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-shop text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                {{ $activeBranches }} active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Head Offices</h6>
                                <h2 class="fw-bold mb-0">{{ $headOffices }}</h2>
                            </div>
                            <div class="bg-purple bg-opacity-10 p-3 rounded">
                                <i class="bi bi-building text-purple fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">Primary locations</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">With Warehouse</h6>
                                <h2 class="fw-bold mb-0">{{ $branchesWithWarehouse }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-box-seam text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span
                                class="text-muted">{{ number_format(($branchesWithWarehouse / max($totalBranches, 1)) * 100, 1) }}%
                                of total</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Staff</h6>
                                <h2 class="fw-bold mb-0">{{ App\Models\User::count() }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people-fill text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">Across all branches</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Branch List</h5>
                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0"
                                        placeholder="Search branches..." id="searchBranches" value="{{ $search }}">
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-filter me-1"></i>Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['status' => '']) }}">All Branches</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Active
                                                Only</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}">Inactive
                                                Only</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['status' => 'head_office']) }}">Head
                                                Offices</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach ($branchTypes as $typeKey => $typeName)
                                            <li><a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['type' => $typeKey]) }}">
                                                    {{ $typeName }}
                                                </a></li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['company_id' => '']) }}">All
                                                Companies</a></li>
                                        @foreach ($companies->take(5) as $company)
                                            <li><a class="dropdown-item"
                                                    href="{{ request()->fullUrlWithQuery(['company_id' => $company->id]) }}">
                                                    {{ $company->name }}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm" id="exportBranches">
                                    <i class="bi bi-download me-1"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Branch</th>
                                        <th>Company</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Contact</th>
                                        <th>Staff</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($branches as $branch)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if ($branch->is_head_office)
                                                            <div class="bg-purple bg-opacity-10 rounded p-2 me-3">
                                                                <i class="bi bi-building text-purple"></i>
                                                            </div>
                                                        @else
                                                            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                                <i class="bi bi-shop text-primary"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 fw-semibold">{{ $branch->branch_name }}</h6>
                                                        <small class="text-muted">Code: {{ $branch->branch_code }}</small>
                                                        @if ($branch->description)
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    {{ \Illuminate\Support\Str::limit($branch->description, 50) }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded-circle p-2 me-2">
                                                        <i class="bi bi-building text-secondary"></i>
                                                    </div>
                                                    <span>{{ $branch->company->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold">{{ $branch->city }}</span>
                                                    <small class="text-muted">
                                                        {{ $branch->state ? $branch->state . ', ' : '' }}{{ $branch->country }}
                                                    </small>
                                                    @if ($branch->area_sqft)
                                                        <small class="text-muted mt-1">
                                                            <i
                                                                class="bi bi-rulers me-1"></i>{{ number_format($branch->area_sqft) }}
                                                            sqft
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                {!! $branch->type_badge !!}
                                                @if ($branch->has_warehouse)
                                                    <div class="mt-1">
                                                        <small class="badge bg-warning bg-opacity-10 text-warning">
                                                            <i class="bi bi-box-seam me-1"></i>Warehouse
                                                        </small>
                                                    </div>
                                                @endif
                                                @if ($branch->has_showroom)
                                                    <div class="mt-1">
                                                        <small class="badge bg-info bg-opacity-10 text-info">
                                                            <i class="bi bi-display me-1"></i>Showroom
                                                        </small>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    @if ($branch->contact_person)
                                                        <span>{{ $branch->contact_person }}</span>
                                                    @endif
                                                    @if ($branch->phone)
                                                        <small class="text-muted">
                                                            <i class="bi bi-telephone me-1"></i>{{ $branch->phone }}
                                                        </small>
                                                    @endif
                                                    @if ($branch->email)
                                                        <small class="text-muted">
                                                            <i class="bi bi-envelope me-1"></i>{{ $branch->email }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-group me-2">
                                                        @php
                                                            $users = $branch->users()->take(3)->get();
                                                        @endphp
                                                        @foreach ($users as $user)
                                                            <div class="avatar avatar-xs">
                                                                <div
                                                                    class="avatar-title rounded-circle bg-light text-dark">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @if ($branch->users_count > 3)
                                                            <div class="avatar avatar-xs">
                                                                <div class="avatar-title rounded-circle bg-secondary">
                                                                    +{{ $branch->users_count - 3 }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <span>{{ $branch->users_count }} staff</span>
                                                </div>
                                                @if ($branch->warehouses_count > 0)
                                                    <small class="text-muted">
                                                        {{ $branch->warehouses_count }} warehouse(s)
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $branch->status_badge !!}
                                                <div class="mt-1">
                                                    <small class="text-muted">{{ $branch->operating_hours }}</small>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.branches.show', $branch) }}"
                                                        class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.branches.edit', $branch) }}"
                                                        class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if (!$branch->is_head_office)
                                                        <form
                                                            action="{{ route('admin.branches.set-head-office', $branch) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Set this branch as head office?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-purple"
                                                                title="Set as Head Office">
                                                                <i class="bi bi-building"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if ($branch->canBeDeleted())
                                                        <form action="{{ route('admin.branches.destroy', $branch) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this branch?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="py-5">
                                                    <i class="bi bi-shop display-1 text-muted opacity-50"></i>
                                                    <h5 class="mt-3">No branches found</h5>
                                                    <p class="text-muted">Create your first branch to get started</p>
                                                    <a href="{{ route('admin.branches.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="bi bi-plus-circle me-2"></i>Add Branch
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($branches->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }}
                                    of {{ $branches->total() }} branches
                                </div>
                                <div>
                                    {{ $branches->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Branches Map -->
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Branches Map</h5>
                    </div>
                    <div class="card-body">
                        <div id="branchesMap"
                            style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="d-flex justify-content-center align-items-center h-100 text-white">
                                <div class="text-center">
                                    <i class="bi bi-map display-4 mb-3"></i>
                                    <p class="mb-0">Branches Location Map</p>
                                    <small>Would show all branches on a map</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchBranches');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value;
                        const url = new URL(window.location.href);
                        url.searchParams.set('search', searchTerm);
                        window.location.href = url.toString();
                    }
                });
            }

            // Export functionality
            const exportBtn = document.getElementById('exportBranches');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    window.location.href = '{{ route('admin.branches.export') }}';
                });
            }

            // Toggle branch status
            document.querySelectorAll('.toggle-status').forEach(button => {
                button.addEventListener('click', function() {
                    const branchId = this.getAttribute('data-id');
                    fetch(`/admin/branches/${branchId}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            alert('Error updating branch status');
                        });
                });
            });
        });
    </script>

    @push('styles')
        <style>
            .bg-purple {
                background-color: #6f42c1 !important;
            }

            .text-purple {
                color: #6f42c1 !important;
            }

            .avatar-group .avatar {
                border: 2px solid #fff;
                margin-left: -8px;
            }

            .avatar-group .avatar:first-child {
                margin-left: 0;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.05);
            }

            .badge {
                font-weight: 500;
            }
        </style>
    @endpush
@endpush
