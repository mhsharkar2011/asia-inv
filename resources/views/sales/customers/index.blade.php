@extends('layouts.admin')

@section('title', 'Customers - Asia Enterprise')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customers</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('sales.customers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> New Customer
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('sales.customers.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                placeholder="Search by name, code, phone, email..." value="{{ $search }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="type" onchange="this.form.submit()">
                            <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Types</option>
                            <option value="retail" {{ $type == 'retail' ? 'selected' : '' }}>Retail</option>
                            <option value="wholesale" {{ $type == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                            <option value="corporate" {{ $type == 'corporate' ? 'selected' : '' }}>Corporate</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Customers</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                            <option value="credit_exceeded" {{ $status == 'credit_exceeded' ? 'selected' : '' }}>Credit
                                Limit Exceeded</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('sales.customers.index') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-body">
            @if ($customers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Customer Name</th>
                                <th>Type</th>
                                <th>Contact</th>
                                <th>GSTIN</th>
                                <th>Credit Limit</th>
                                <th>Outstanding</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>
                                        <strong>{{ $customer->customer_code }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $customer->customer_name }}</div>
                                        @if ($customer->contact_person)
                                            <small class="text-muted">{{ $customer->contact_person }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $typeColors = [
                                                'retail' => 'primary',
                                                'wholesale' => 'success',
                                                'corporate' => 'info',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $typeColors[$customer->customer_type] ?? 'secondary' }}">
                                            {{ ucfirst($customer->customer_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($customer->phone)
                                            <div><i class="bi bi-telephone me-1"></i>{{ $customer->phone }}</div>
                                        @endif
                                        @if ($customer->email)
                                            <div><i class="bi bi-envelope me-1"></i>{{ $customer->email }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($customer->gstin)
                                            <span class="badge bg-info">{{ $customer->gstin }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($customer->credit_limit)
                                            BDT{{ number_format($customer->credit_limit, 2) }}
                                        @else
                                            <span class="text-muted">No Limit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($customer->outstanding_balance > 0)
                                            <span
                                                class="badge bg-warning">BDT{{ number_format($customer->outstanding_balance, 2) }}</span>
                                        @else
                                            <span class="text-muted">BDT0.00</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($customer->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif

                                        @if ($customer->is_credit_limit_exceeded)
                                            <span class="badge bg-danger mt-1">Limit Exceeded</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('sales.customers.show', $customer->id) }}"
                                                class="btn btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('sales.customers.edit', $customer->id) }}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('sales.customers.destroy', $customer->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this customer?')"
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
                    {{ $customers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people display-4 text-muted mb-3"></i>
                    <h4>No Customers Found</h4>
                    <p class="text-muted">Get started by adding your first customer.</p>
                    <a href="{{ route('sales.customers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Customer
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
