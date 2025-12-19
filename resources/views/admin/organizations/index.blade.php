@extends('layouts.app')

@section('title', 'Organization Management')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm sidebar-nav">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-funnel me-2"></i>Filters
                        </h5>

                        <!-- Type Filter -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Organization Type</h6>
                            <div class="list-group">
                                <a href="{{ route('admin.organizations.index') }}"
                                    class="list-group-item list-group-item-action {{ !$type ? 'active' : '' }}">
                                    <i class="bi bi-grid me-2"></i>All Organizations
                                    <span
                                        class="badge bg-secondary float-end">{{ $stats['companies'] + $stats['customers'] + $stats['suppliers'] }}</span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'company']) }}"
                                    class="list-group-item list-group-item-action {{ $type == 'company' ? 'active' : '' }}">
                                    <i class="bi bi-building me-2 text-company"></i>Companies
                                    <span class="badge bg-company float-end">{{ $stats['companies'] }}</span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'customer']) }}"
                                    class="list-group-item list-group-item-action {{ $type == 'customer' ? 'active' : '' }}">
                                    <i class="bi bi-people me-2 text-customer"></i>Customers
                                    <span class="badge bg-customer float-end">{{ $stats['customers'] }}</span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'supplier']) }}"
                                    class="list-group-item list-group-item-action {{ $type == 'supplier' ? 'active' : '' }}">
                                    <i class="bi bi-truck me-2 text-supplier"></i>Suppliers
                                    <span class="badge bg-supplier float-end">{{ $stats['suppliers'] }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Status</h6>
                            <div class="list-group">
                                <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                                    class="list-group-item list-group-item-action {{ !$status ? 'active' : '' }}">
                                    All Status
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                                    class="list-group-item list-group-item-action {{ $status == 'active' ? 'active' : '' }}">
                                    <i class="bi bi-check-circle text-success me-2"></i>Active Only
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                                    class="list-group-item list-group-item-action {{ $status == 'inactive' ? 'active' : '' }}">
                                    <i class="bi bi-x-circle text-danger me-2"></i>Inactive Only
                                </a>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Quick Stats</h6>
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total Active:</span>
                                        <span class="fw-bold">{{ $stats['active'] }}</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 5px;">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ ($stats['active'] / max(array_sum($stats), 1)) * 100 }}%">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <small
                                            class="text-muted">{{ number_format(($stats['active'] / max(array_sum($stats), 1)) * 100, 1) }}%
                                            active rate</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h6 class="text-muted mb-2">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.organizations.create', ['type' => 'company']) }}"
                                    class="btn btn-outline-company btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Add Company
                                </a>
                                <a href="{{ route('admin.organizations.create', ['type' => 'customer']) }}"
                                    class="btn btn-outline-customer btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Add Customer
                                </a>
                                <a href="{{ route('admin.organizations.create', ['type' => 'supplier']) }}"
                                    class="btn btn-outline-supplier btn-sm">
                                    <i class="bi bi-plus-circle me-1"></i>Add Supplier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">
                            @if ($type)
                                {{ ucfirst($type) }} Management
                            @else
                                Organization Management
                            @endif
                        </h2>
                        <p class="text-muted mb-0">
                            Manage {{ $type ? $type . 's' : 'companies, customers, and suppliers' }} in one place
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-upload me-1"></i>Import
                        </button>
                        <a href="{{ route('admin.organizations.export', request()->query()) }}"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-download me-1"></i>Export
                        </a>
                    </div>
                </div>

                <!-- Search & Stats -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <form method="GET" class="row g-2">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control border-start-0"
                                                placeholder="Search by name, code, email, phone..."
                                                value="{{ $search }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-filter me-1"></i>Search
                                        </button>
                                    </div>
                                    @if ($type)
                                        <input type="hidden" name="type" value="{{ $type }}">
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-0">Showing</h6>
                                        <h4 class="fw-bold mb-0">{{ $organizations->count() }}</h4>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="text-muted mb-0">of {{ $organizations->total() }}</h6>
                                        <small class="text-muted">{{ $type ? ucfirst($type) : 'Organizations' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizations Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>Organization</th>
                                        <th>Type</th>
                                        <th>Contact Information</th>
                                        <th>Location</th>
                                        <th>Financial Info</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($organizations as $org)
                                        <tr class="organization-row" data-type="{{ $org->type }}">
                                            <td class="ps-4">
                                                <input type="checkbox" class="form-check-input organization-checkbox"
                                                    value="{{ $org->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="rounded-circle p-2 me-3 bg-{{ $org->type }}">
                                                            <i
                                                                class="bi
                                                        @if ($org->type == 'company') bi-building
                                                        @elseif($org->type == 'customer') bi-people
                                                        @else bi-truck @endif text-{{ $org->type }}">
                                                            </i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ $org->name }}</h6>
                                                        <small class="text-muted">Code: {{ $org->code }}</small>
                                                        @if ($org->sub_type)
                                                            <small class="d-block text-muted">
                                                                {{ ucfirst($org->sub_type) }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $org->type }}">
                                                    <i
                                                        class="bi
                                                @if ($org->type == 'company') bi-building
                                                @elseif($org->type == 'customer') bi-person-check
                                                @else bi-box @endif me-1">
                                                    </i>
                                                    {{ ucfirst($org->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    @if ($org->contact_person)
                                                        <span class="fw-semibold">{{ $org->contact_person }}</span>
                                                    @endif
                                                    @if ($org->email)
                                                        <small class="text-muted">
                                                            <i class="bi bi-envelope me-1"></i>{{ $org->email }}
                                                        </small>
                                                    @endif
                                                    @if ($org->phone)
                                                        <small class="text-muted">
                                                            <i class="bi bi-telephone me-1"></i>{{ $org->phone }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    @if ($org->city)
                                                        <span>{{ $org->city }}</span>
                                                    @endif
                                                    @if ($org->country)
                                                        <small class="text-muted">{{ $org->country }}</small>
                                                    @endif
                                                    @if ($org->website)
                                                        <small class="text-primary">
                                                            <i class="bi bi-globe me-1"></i>Website
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if ($org->type == 'customer')
                                                    <div class="d-flex flex-column">
                                                        <small>Credit: ৳{{ number_format($org->credit_limit, 2) }}</small>
                                                        <small
                                                            class="{{ $org->outstanding_balance > 0 ? 'text-danger' : 'text-success' }}">
                                                            Balance: ৳{{ number_format($org->outstanding_balance, 2) }}
                                                        </small>
                                                    </div>
                                                @elseif($org->type == 'supplier')
                                                    @if ($org->payment_terms)
                                                        <small class="text-muted">{{ $org->payment_terms }}</small>
                                                    @endif
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($org->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Inactive
                                                    </span>
                                                @endif
                                                @if ($org->tin)
                                                    <div class="mt-1">
                                                        <small class="badge bg-info">TIN: {{ $org->tin }}</small>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.organizations.show', $org) }}"
                                                        class="btn btn-outline-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.organizations.edit', $org) }}"
                                                        class="btn btn-outline-warning" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="bi bi-file-text me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="bi bi-card-checklist me-2"></i>Transactions
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        @if ($org->is_active)
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.organizations.toggle-status', $org) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="dropdown-item text-warning">
                                                                        <i class="bi bi-pause-circle me-2"></i>Deactivate
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.organizations.toggle-status', $org) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="dropdown-item text-success">
                                                                        <i class="bi bi-play-circle me-2"></i>Activate
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.organizations.destroy', $org) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Delete this organization?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash me-2"></i>Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="py-5">
                                                    <i class="bi bi-buildings display-1 text-muted opacity-50"></i>
                                                    <h5 class="mt-3">No organizations found</h5>
                                                    <p class="text-muted">
                                                        @if ($type)
                                                            No {{ $type }}s found. Create your first
                                                            {{ $type }}.
                                                        @else
                                                            No organizations found. Create your first organization.
                                                        @endif
                                                    </p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{ route('admin.organizations.create', ['type' => 'company']) }}"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-building me-2"></i>Add Company
                                                        </a>
                                                        <a href="{{ route('admin.organizations.create', ['type' => 'customer']) }}"
                                                            class="btn btn-success">
                                                            <i class="bi bi-people me-2"></i>Add Customer
                                                        </a>
                                                        <a href="{{ route('admin.organizations.create', ['type' => 'supplier']) }}"
                                                            class="btn btn-warning">
                                                            <i class="bi bi-truck me-2"></i>Add Supplier
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($organizations->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $organizations->firstItem() }} to {{ $organizations->lastItem() }}
                                    of {{ $organizations->total() }} entries
                                </div>
                                <div>
                                    {{ $organizations->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Bulk Actions -->
                <div class="row mt-3 d-none" id="bulkActions">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-3" id="selectedCount">0 selected</span>
                                    <div class="btn-group btn-group-sm me-3">
                                        <button type="button" class="btn btn-outline-secondary" id="bulkActivate">
                                            <i class="bi bi-check-circle me-1"></i>Activate
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="bulkDeactivate">
                                            <i class="bi bi-pause-circle me-1"></i>Deactivate
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-outline-danger btn-sm me-3" id="bulkDelete">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="clearSelection">
                                        Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Organizations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.organizations.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select File</label>
                            <input type="file" class="form-control" name="file" accept=".csv,.xlsx,.xls">
                            <div class="form-text">Supported formats: CSV, Excel (.xlsx, .xls)</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Organization Type</label>
                            <select class="form-select" name="type">
                                <option value="">Auto Detect</option>
                                <option value="company">Company</option>
                                <option value="customer">Customer</option>
                                <option value="supplier">Supplier</option>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Download <a href="{{ asset('templates/organization-template.csv') }}">template file</a> for
                            correct format.
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Bulk selection
            $('#selectAll').change(function() {
                $('.organization-checkbox').prop('checked', this.checked);
                updateBulkActions();
            });

            $('.organization-checkbox').change(updateBulkActions);

            function updateBulkActions() {
                const selected = $('.organization-checkbox:checked');
                const count = selected.length;

                if (count > 0) {
                    $('#bulkActions').removeClass('d-none');
                    $('#selectedCount').text(count + ' organization(s) selected');
                    $('#selectAll').prop('indeterminate', count > 0 && count < $('.organization-checkbox').length);
                } else {
                    $('#bulkActions').addClass('d-none');
                    $('#selectAll').prop('indeterminate', false).prop('checked', false);
                }
            }

            // Bulk actions
            $('#bulkActivate').click(function() {
                const ids = getSelectedIds();
                if (ids.length > 0) {
                    if (confirm('Activate ' + ids.length + ' selected organization(s)?')) {
                        bulkAction('/admin/organizations/bulk-activate', ids);
                    }
                }
            });

            $('#bulkDeactivate').click(function() {
                const ids = getSelectedIds();
                if (ids.length > 0) {
                    if (confirm('Deactivate ' + ids.length + ' selected organization(s)?')) {
                        bulkAction('/admin/organizations/bulk-deactivate', ids);
                    }
                }
            });

            $('#bulkDelete').click(function() {
                const ids = getSelectedIds();
                if (ids.length > 0) {
                    if (confirm('Delete ' + ids.length +
                            ' selected organization(s)? This action cannot be undone.')) {
                        bulkAction('/admin/organizations/bulk-delete', ids);
                    }
                }
            });

            $('#clearSelection').click(function() {
                $('.organization-checkbox').prop('checked', false);
                $('#selectAll').prop('checked', false);
                updateBulkActions();
            });

            function getSelectedIds() {
                return $('.organization-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
            }

            function bulkAction(url, ids) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Error performing bulk action');
                    }
                });
            }

            // Quick search
            $('#searchInput').on('keyup', function() {
                const search = $(this).val().toLowerCase();
                $('.organization-row').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(search));
                });
            });

            // Initialize Select2 for dropdowns
            $('.select2').select2({
                placeholder: "Select...",
                allowClear: true
            });
        });
    </script>
@endpush
