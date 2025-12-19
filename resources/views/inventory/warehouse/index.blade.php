@extends('layouts.app')

@section('title', 'Warehouse Management')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h3 fw-bold mb-2">Warehouse Management</h1>
                <p class="text-muted mb-0">Manage your inventory storage locations efficiently</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createWarehouseModal">
                    <i class="bi bi-plus-circle me-2"></i>Add New Warehouse
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Warehouses</h6>
                                <h2 class="fw-bold mb-0">{{ $warehouses->total() }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-house-door-fill text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrow-up me-1"></i>5 from last month
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
                                <h6 class="text-uppercase text-muted mb-2">Active Warehouses</h6>
                                <h2 class="fw-bold mb-0">{{ $activeWarehouses ?? 0 }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">{{ $activePercentage ?? 0 }}% of total</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Capacity</h6>
                                <h2 class="fw-bold mb-0">{{ number_format($totalCapacity ?? 0) }} sqft</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-box-seam-fill text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: {{ $capacityUtilization ?? 0 }}%"></div>
                            </div>
                            <small class="text-muted">{{ $capacityUtilization ?? 0 }}% utilized</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Staff Count</h6>
                                <h2 class="fw-bold mb-0">{{ $totalStaff ?? 0 }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people-fill text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">Average: {{ $avgStaffPerWarehouse ?? 0 }} per warehouse</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Warehouse List -->
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">Warehouse List</h5>
                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0"
                                        placeholder="Search warehouses..." id="searchWarehouses">
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-filter me-1"></i>Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-filter="all">All Warehouses</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-filter="active">Active Only</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-filter="inactive">Inactive Only</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-filter="high-capacity">High
                                                Capacity</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="low-capacity">Low
                                                Capacity</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllWarehouses">
                                            </div>
                                        </th>
                                        <th>Warehouse</th>
                                        <th>Location</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>Staff</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($warehouses as $warehouse)
                                        <tr class="warehouse-row"
                                            data-status="{{ $warehouse->is_active ? 'active' : 'inactive' }}"
                                            data-capacity="{{ $warehouse->capacity > 5000 ? 'high-capacity' : 'low-capacity' }}">
                                            <td class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input warehouse-checkbox" type="checkbox"
                                                        value="{{ $warehouse->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                            <i class="bi bi-building text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 fw-semibold">{{ $warehouse->name }}</h6>
                                                        <small class="text-muted">Code: {{ $warehouse->code }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-geo-alt text-muted me-2"></i>
                                                    <span class="text-truncate" style="max-width: 150px;">
                                                        {{ $warehouse->city }}, {{ $warehouse->state }}
                                                    </span>
                                                </div>
                                                <small class="text-muted">{{ $warehouse->country }}</small>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="fw-semibold">{{ number_format($warehouse->capacity) }}
                                                        sqft</span>
                                                    <div class="progress mt-1" style="height: 5px; width: 100px;">
                                                        <div class="progress-bar bg-info"
                                                            style="width: {{ min(($warehouse->current_occupancy / $warehouse->capacity) * 100, 100) }}%">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ number_format($warehouse->current_occupancy ?? 0) }} sqft used
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($warehouse->is_active)
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        <i class="bi bi-check-circle me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-group me-2">
                                                        @for ($i = 0; $i < min(3, $warehouse->staff_count); $i++)
                                                            <div class="avatar avatar-xs">
                                                                <div
                                                                    class="avatar-title rounded-circle bg-light text-dark">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                        @if ($warehouse->staff_count > 3)
                                                            <div class="avatar avatar-xs">
                                                                <div class="avatar-title rounded-circle bg-secondary">
                                                                    +{{ $warehouse->staff_count - 3 }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <span>{{ $warehouse->staff_count }} staff</span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown">
                                                    <button class="btn btn-link text-dark dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item view-warehouse" href="#"
                                                                data-id="{{ $warehouse->id }}">
                                                                <i class="bi bi-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item edit-warehouse" href="#"
                                                                data-id="{{ $warehouse->id }}">
                                                                <i class="bi bi-pencil me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('inventory.warehouse.products', $warehouse->id) }}">
                                                                <i class="bi bi-box-seam me-2"></i>View Inventory
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            @if ($warehouse->is_active)
                                                                <a class="dropdown-item text-warning deactivate-warehouse"
                                                                    href="#" data-id="{{ $warehouse->id }}">
                                                                    <i class="bi bi-pause-circle me-2"></i>Deactivate
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item text-success activate-warehouse"
                                                                    href="#" data-id="{{ $warehouse->id }}">
                                                                    <i class="bi bi-play-circle me-2"></i>Activate
                                                                </a>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger delete-warehouse"
                                                                href="#" data-id="{{ $warehouse->id }}">
                                                                <i class="bi bi-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="py-5">
                                                    <i class="bi bi-building display-1 text-muted opacity-50"></i>
                                                    <h5 class="mt-3">No warehouses found</h5>
                                                    <p class="text-muted">Create your first warehouse to get started</p>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#createWarehouseModal">
                                                        <i class="bi bi-plus-circle me-2"></i>Add Warehouse
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($warehouses->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $warehouses->firstItem() }} to {{ $warehouses->lastItem() }}
                                    of {{ $warehouses->total() }} warehouses
                                </div>
                                <div>
                                    {{ $warehouses->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar - Map & Quick Stats -->
            <div class="col-xl-4">
                <!-- Warehouse Map -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Warehouse Locations</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="warehouseMap"
                            style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <!-- This would be replaced with an actual map component -->
                            <div class="d-flex justify-content-center align-items-center h-100 text-white">
                                <div class="text-center">
                                    <i class="bi bi-map display-4 mb-3"></i>
                                    <p class="mb-0">Interactive Map View</p>
                                    <small>Would show warehouse locations</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border-top">
                            <div class="row g-2">
                                @foreach ($warehouses->take(3) as $warehouse)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                <i class="bi bi-geo-alt text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $warehouse->name }}</h6>
                                                <small class="text-muted">{{ $warehouse->city }}</small>
                                            </div>
                                            <span class="badge bg-light text-dark">{{ $warehouse->distance ?? '--' }}
                                                km</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Capacity Overview -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Capacity Overview</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($warehouses->take(5) as $warehouse)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">{{ $warehouse->name }}</span>
                                    <span class="text-muted">{{ number_format($warehouse->capacity) }} sqft</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $utilization = min(
                                            ($warehouse->current_occupancy / $warehouse->capacity) * 100,
                                            100,
                                        );
                                        $color =
                                            $utilization > 80 ? 'danger' : ($utilization > 60 ? 'warning' : 'success');
                                    @endphp
                                    <div class="progress-bar bg-{{ $color }}"
                                        style="width: {{ $utilization }}%"></div>
                                </div>
                                <small class="text-muted">{{ number_format($utilization, 1) }}% utilized</small>
                            </div>
                        @endforeach
                        @if ($warehouses->count() > 5)
                            <div class="text-center">
                                <a href="#" class="text-primary text-decoration-none">
                                    View all {{ $warehouses->count() }} warehouses
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Warehouse Modal -->
    <div class="modal fade" id="createWarehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createWarehouseForm" action="{{ route('inventory.warehouses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Warehouse Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warehouse Code *</label>
                                <input type="text" class="form-control" name="code" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City *</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State *</label>
                                <input type="text" class="form-control" name="state" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Country *</label>
                                <select class="form-select" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="India">India</option>
                                    <option value="USA">United States</option>
                                    <option value="UK">United Kingdom</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" name="zip_code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Phone</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Capacity (sqft) *</label>
                                <input type="number" class="form-control" name="capacity" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Staff Count</label>
                                <input type="number" class="form-control" name="staff_count" value="1">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        checked>
                                    <label class="form-check-label" for="is_active">Active Warehouse</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create Warehouse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Warehouse Modal -->
    <div class="modal fade" id="viewWarehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warehouse Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="warehouseDetails">
                    <!-- Details will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWarehouseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editWarehouseFormBody">
                        <!-- Form will be loaded here via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this warehouse? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-2"></i>
                        All inventory and associated data will be permanently removed.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteWarehouseForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Warehouse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchWarehouses');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.warehouse-row');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Filter functionality
            document.querySelectorAll('[data-filter]').forEach(filter => {
                filter.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    const rows = document.querySelectorAll('.warehouse-row');

                    rows.forEach(row => {
                        if (filterType === 'all') {
                            row.style.display = '';
                        } else if (filterType === 'active') {
                            row.style.display = row.getAttribute('data-status') ===
                                'active' ? '' : 'none';
                        } else if (filterType === 'inactive') {
                            row.style.display = row.getAttribute('data-status') ===
                                'inactive' ? '' : 'none';
                        } else if (filterType === 'high-capacity') {
                            row.style.display = row.getAttribute('data-capacity') ===
                                'high-capacity' ? '' : 'none';
                        } else if (filterType === 'low-capacity') {
                            row.style.display = row.getAttribute('data-capacity') ===
                                'low-capacity' ? '' : 'none';
                        }
                    });
                });
            });

            // Bulk selection
            const selectAll = document.getElementById('selectAllWarehouses');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.warehouse-checkbox').forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }

            // View warehouse details
            document.querySelectorAll('.view-warehouse').forEach(button => {
                button.addEventListener('click', function() {
                    const warehouseId = this.getAttribute('data-id');
                    // In a real application, you would make an AJAX call here
                    const modal = new bootstrap.Modal(document.getElementById(
                    'viewWarehouseModal'));
                    modal.show();
                });
            });

            // Edit warehouse
            document.querySelectorAll('.edit-warehouse').forEach(button => {
                button.addEventListener('click', function() {
                    const warehouseId = this.getAttribute('data-id');
                    // In a real application, you would make an AJAX call here
                    const modal = new bootstrap.Modal(document.getElementById(
                    'editWarehouseModal'));
                    modal.show();
                });
            });

            // Delete warehouse confirmation
            document.querySelectorAll('.delete-warehouse').forEach(button => {
                button.addEventListener('click', function() {
                    const warehouseId = this.getAttribute('data-id');
                    const form = document.getElementById('deleteWarehouseForm');
                    form.action = `/warehouses/${warehouseId}`;

                    const modal = new bootstrap.Modal(document.getElementById(
                        'deleteConfirmationModal'));
                    modal.show();
                });
            });

            // Toggle warehouse status
            document.querySelectorAll('.activate-warehouse, .deactivate-warehouse').forEach(button => {
                button.addEventListener('click', function() {
                    const warehouseId = this.getAttribute('data-id');
                    const isActivate = this.classList.contains('activate-warehouse');

                    if (confirm(
                            `Are you sure you want to ${isActivate ? 'activate' : 'deactivate'} this warehouse?`
                            )) {
                        // In a real application, you would make an AJAX call here
                        console.log(
                            `${isActivate ? 'Activating' : 'Deactivating'} warehouse ${warehouseId}`
                            );
                        location.reload(); // Reload to show updated status
                    }
                });
            });

            // Form validation for create warehouse
            const createForm = document.getElementById('createWarehouseForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simple validation
                    const name = this.querySelector('input[name="name"]').value;
                    const code = this.querySelector('input[name="code"]').value;

                    if (!name.trim() || !code.trim()) {
                        alert('Please fill in all required fields');
                        return;
                    }

                    // Submit form
                    this.submit();
                });
            }

            // Auto-generate warehouse code from name
            const nameInput = document.querySelector('input[name="name"]');
            const codeInput = document.querySelector('input[name="code"]');

            if (nameInput && codeInput) {
                nameInput.addEventListener('blur', function() {
                    if (!codeInput.value.trim()) {
                        const name = this.value.trim();
                        if (name.length >= 3) {
                            const code = 'WH-' + name.substring(0, 3).toUpperCase() +
                                Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                            codeInput.value = code;
                        }
                    }
                });
            }

            // Animate progress bars on page load
            setTimeout(() => {
                document.querySelectorAll('.progress-bar').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
            }, 500);
        });
    </script>

    @push('styles')
        <style>
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

            .progress-bar {
                transition: width 1s ease-in-out;
            }

            .card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }

            .dropdown-menu {
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            }

            .modal-content {
                border: none;
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            }

            .badge {
                padding: 0.5em 0.75em;
                font-weight: 500;
            }
        </style>
    @endpush
@endpush
