@extends('layouts.app')

@section('title', 'Suppliers - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Suppliers</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('purchase.suppliers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> New Supplier
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('purchase.suppliers.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by name, code, phone, email..." value="{{ $search }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Suppliers</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                            <option value="credit_exceeded" {{ $status == 'credit_exceeded' ? 'selected' : '' }}>Credit
                                Limit Exceeded</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('purchase.suppliers.index') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="card">
        <div class="card-body">
            @if ($suppliers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Supplier Name</th>
                                <th>Contact</th>
                                <th>GSTIN</th>
                                <th>Credit Limit</th>
                                <th>Outstanding</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <strong>{{ $supplier->supplier_code }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $supplier->supplier_name }}</div>
                                        @if ($supplier->contact_person)
                                            <small class="text-muted">{{ $supplier->contact_person }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supplier->phone)
                                            <div><i class="bi bi-telephone me-1"></i>{{ $supplier->phone }}</div>
                                        @endif
                                        @if ($supplier->email)
                                            <div><i class="bi bi-envelope me-1"></i>{{ $supplier->email }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supplier->gstin)
                                            <span class="badge bg-info">{{ $supplier->gstin }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supplier->credit_limit)
                                            ₹{{ number_format($supplier->credit_limit, 2) }}
                                        @else
                                            <span class="text-muted">No Limit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supplier->outstanding_balance > 0)
                                            <span
                                                class="badge bg-warning">₹{{ number_format($supplier->outstanding_balance, 2) }}</span>
                                        @else
                                            <span class="text-muted">₹0.00</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($supplier->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif

                                        @if ($supplier->is_credit_limit_exceeded)
                                            <span class="badge bg-danger mt-1">Limit Exceeded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('purchase.suppliers.show', $supplier->id) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('purchase.suppliers.edit', $supplier->id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('purchase.suppliers.destroy', $supplier->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this supplier?')"
                                                    title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $suppliers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people display-4 text-muted mb-3"></i>
                    <h4>No Suppliers Found</h4>
                    <p class="text-muted">Get started by adding your first supplier.</p>
                    <a href="{{ route('purchase.suppliers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Supplier
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
