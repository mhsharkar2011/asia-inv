@extends('layouts.admin')

@section('title', 'Purchase Orders')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h5 class="mb-0 fw-bold"><i class="bi bi-cart-check me-2 text-primary"></i>Purchase Orders</h5>
                            <small class="text-muted">Manage and track your purchase orders</small>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => '']) }}">All Orders</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'draft']) }}">Draft</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">Pending</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'partial']) }}">Partial</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}">Completed</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}">Cancelled</a>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('purchase.purchase-orders.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Create PO
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Quick Stats -->
                        <div class="row mb-4 g-3">
                            <div class="col-md-3">
                                <div class="card border-start border-primary border-4">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Total Orders</h6>
                                                <h4 class="mb-0 fw-bold">{{ $purchaseOrders->total() }}</h4>
                                            </div>
                                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                                <i class="bi bi-cart text-primary fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-start border-warning border-4">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Pending</h6>
                                                <h4 class="mb-0 fw-bold">{{ $pendingCount ?? 0 }}</h4>
                                            </div>
                                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                                <i class="bi bi-clock text-warning fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-start border-success border-4">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Completed</h6>
                                                <h4 class="mb-0 fw-bold">{{ $completedCount ?? 0 }}</h4>
                                            </div>
                                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                                <i class="bi bi-check-circle text-success fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-start border-info border-4">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-muted mb-1">Total Value</h6>
                                                <h4 class="mb-0 fw-bold">${{ number_format($totalValue ?? 0, 2) }}</h4>
                                            </div>
                                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                                <i class="bi bi-cash-coin text-info fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search and Filter -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="GET" action="{{ route('purchase.purchase-orders.index') }}">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">PO Number</label>
                                                    <input type="text" name="search" class="form-control"
                                                        placeholder="Search PO number..." value="{{ request('search') }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="">All Status</option>
                                                        <option value="draft"
                                                            {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                                        </option>
                                                        <option value="pending"
                                                            {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="partial"
                                                            {{ request('status') == 'partial' ? 'selected' : '' }}>Partial
                                                        </option>
                                                        <option value="completed"
                                                            {{ request('status') == 'completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                        <option value="cancelled"
                                                            {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Date Range</label>
                                                    <input type="date" name="start_date" class="form-control"
                                                        value="{{ request('start_date') }}" placeholder="From Date">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">&nbsp;</label>
                                                    <input type="date" name="end_date" class="form-control"
                                                        value="{{ request('end_date') }}" placeholder="To Date">
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-search me-1"></i> Search
                                                        </button>
                                                        <a href="{{ route('purchase.purchase-orders.index') }}"
                                                            class="btn btn-outline-secondary">
                                                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                                        </a>
                                                        <div class="ms-auto">
                                                            <select class="form-select form-select-sm"
                                                                style="width: auto;" id="perPageSelect">
                                                                <option value="10"
                                                                    {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                                                                    10 per page</option>
                                                                <option value="25"
                                                                    {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                                                    per page</option>
                                                                <option value="50"
                                                                    {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                                                    per page</option>
                                                                <option value="100"
                                                                    {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                                                    per page</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Table -->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </th>
                                                <th>PO Number</th>
                                                <th>Supplier</th>
                                                <th>Warehouse</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Status</th>
                                                <th class="text-end">Amount</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($purchaseOrders as $po)
                                                <tr>
                                                    <td class="ps-4">
                                                        <input type="checkbox" class="form-check-input select-row"
                                                            value="{{ $po->id }}">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                                                <i class="bi bi-file-text text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <strong class="d-block">{{ $po->po_number }}</strong>
                                                                <small
                                                                    class="text-muted">{{ $po->company->name ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                <div class="bg-light rounded-circle p-2">
                                                                    <i class="bi bi-building text-secondary"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <strong
                                                                    class="d-block">{{ $po->supplier->name ?? 'N/A' }}</strong>
                                                                <small
                                                                    class="text-muted">{{ $po->supplier->supplier_code ?? '' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            <i class="bi bi-house-door me-1"></i>
                                                            {{ $po->warehouse->name ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $po->order_date->format('d/m/Y') }}</span>
                                                            <small
                                                                class="text-muted">{{ $po->order_date->diffForHumans() }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($po->expected_delivery_date)
                                                            @php
                                                                $isOverdue =
                                                                    $po->expected_delivery_date < now() &&
                                                                    !in_array($po->status, ['completed', 'cancelled']);
                                                            @endphp
                                                            <div class="d-flex flex-column">
                                                                <span class="{{ $isOverdue ? 'text-danger' : '' }}">
                                                                    {{ $po->expected_delivery_date->format('d/m/Y') }}
                                                                </span>
                                                                @if ($isOverdue)
                                                                    <small class="text-danger">
                                                                        <i class="bi bi-exclamation-triangle"></i> Overdue
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'draft' => 'secondary',
                                                                'pending' => 'warning',
                                                                'partial' => 'info',
                                                                'completed' => 'success',
                                                                'cancelled' => 'danger',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $statusColors[$po->status] ?? 'secondary' }} px-3 py-2">
                                                            <i
                                                                class="bi
                                                                @if ($po->status == 'draft') bi-file-earmark
                                                                @elseif($po->status == 'pending') bi-clock
                                                                @elseif($po->status == 'partial') bi-hourglass-split
                                                                @elseif($po->status == 'completed') bi-check-circle
                                                                @else bi-x-circle @endif me-1"></i>
                                                            {{ ucfirst($po->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column align-items-end">
                                                            <strong
                                                                class="text-dark">${{ number_format($po->final_amount, 2) }}</strong>
                                                            <small class="text-muted">
                                                                <span class="me-2">Tax:
                                                                    ${{ number_format($po->tax_amount, 2) }}</span>
                                                                <span>Disc: ${{ number_format($po->discount, 2) }}</span>
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-light text-dark dropdown-toggle"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('purchase.purchase-orders.show', $po) }}">
                                                                        <i class="bi bi-eye me-2"></i> View Details
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('purchase.purchase-orders.edit', $po) }}">
                                                                        <i class="bi bi-pencil me-2"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="bi bi-printer me-2"></i> Print PO
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="bi bi-envelope me-2"></i> Send to
                                                                        Supplier
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                @if ($po->status == 'draft')
                                                                    <li>
                                                                        <a class="dropdown-item text-success"
                                                                            href="#">
                                                                            <i class="bi bi-check-circle me-2"></i> Mark as
                                                                            Pending
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if ($po->status == 'pending' || $po->status == 'partial')
                                                                    <li>
                                                                        <a class="dropdown-item text-success"
                                                                            href="#">
                                                                            <i class="bi bi-check-circle me-2"></i> Mark as
                                                                            Completed
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if ($po->status != 'cancelled')
                                                                    <li>
                                                                        <a class="dropdown-item text-danger"
                                                                            href="#">
                                                                            <i class="bi bi-x-circle me-2"></i> Cancel
                                                                            Order
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('purchase.purchase-orders.destroy', $po) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="return confirm('Are you sure you want to delete this purchase order?')">
                                                                            <i class="bi bi-trash me-2"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-5">
                                                        <div class="py-5">
                                                            <i class="bi bi-cart-x display-1 text-muted"></i>
                                                            <h5 class="mt-3">No purchase orders found</h5>
                                                            <p class="text-muted">Get started by creating your first
                                                                purchase order</p>
                                                            <a href="{{ route('purchase.purchase-orders.create') }}"
                                                                class="btn btn-primary mt-2">
                                                                <i class="bi bi-plus-circle me-1"></i> Create Purchase
                                                                Order
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="row mt-3 d-none" id="bulkActions">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center">
                                            <span class="me-3" id="selectedCount">0 orders selected</span>
                                            <div class="btn-group btn-group-sm me-3">
                                                <button type="button" class="btn btn-outline-secondary" disabled>
                                                    <i class="bi bi-check-circle me-1"></i> Mark as
                                                </button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Cancelled</a></li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger btn-sm me-3"
                                                id="deleteSelected">
                                                <i class="bi bi-trash me-1"></i> Delete Selected
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                id="clearSelection">
                                                Clear Selection
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($purchaseOrders->hasPages())
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $purchaseOrders->firstItem() }} to
                                            {{ $purchaseOrders->lastItem() }}
                                            of {{ $purchaseOrders->total() }} entries
                                        </div>
                                        <div>
                                            {{ $purchaseOrders->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Bulk selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const rowCheckboxes = document.querySelectorAll('.select-row');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const clearSelectionBtn = document.getElementById('clearSelection');
            const deleteSelectedBtn = document.getElementById('deleteSelected');

            // Select all rows
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateBulkActions();
            });

            // Update bulk actions when individual checkboxes change
            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActions);
            });

            // Update bulk actions panel
            function updateBulkActions() {
                const selected = document.querySelectorAll('.select-row:checked');
                const count = selected.length;

                if (count > 0) {
                    bulkActions.classList.remove('d-none');
                    selectedCount.textContent = count + ' order' + (count > 1 ? 's' : '') + ' selected';
                    selectAll.indeterminate = count > 0 && count < rowCheckboxes.length;
                } else {
                    bulkActions.classList.add('d-none');
                    selectAll.indeterminate = false;
                    selectAll.checked = false;
                }
            }

            // Clear selection
            clearSelectionBtn.addEventListener('click', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAll.checked = false;
                updateBulkActions();
            });

            // Delete selected
            deleteSelectedBtn.addEventListener('click', function() {
                const selected = document.querySelectorAll('.select-row:checked');
                if (selected.length === 0) return;

                if (confirm('Are you sure you want to delete ' + selected.length +
                        ' selected purchase order(s)?')) {
                    // Implement bulk delete here
                    const selectedIds = Array.from(selected).map(cb => cb.value);
                    console.log('Deleting:', selectedIds);
                    // You would typically make an AJAX call here
                }
            });

            // Per page select change
            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', this.value);
                    window.location.href = url.toString();
                });
            }

            // Status quick filter
            const statusBadges = document.querySelectorAll('.status-filter');
            statusBadges.forEach(badge => {
                badge.addEventListener('click', function(e) {
                    e.preventDefault();
                    const status = this.getAttribute('data-status');
                    const url = new URL(window.location.href);
                    url.searchParams.set('status', status);
                    window.location.href = url.toString();
                });
            });
        });

        // Auto-refresh every 30 seconds if there are pending orders
        @if ($pendingCount > 0)
            setTimeout(() => {
                window.location.reload();
            }, 30000);
        @endif
    </script>

    @push('styles')
        <style>
            .table-hover tbody tr:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.05);
            }

            .status-badge {
                padding: 0.35em 0.65em;
                font-size: 0.875em;
                border-radius: 50rem;
            }

            .dropdown-menu {
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .card {
                border: 1px solid rgba(0, 0, 0, 0.075);
            }

            .table th {
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                color: #6c757d;
                border-bottom-width: 2px;
            }
        </style>
    @endpush
@endpush
