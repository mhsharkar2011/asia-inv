@extends('admin.departments.layout')

@section('department-content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h1 class="h3 fw-bold mb-2">Department Management</h1>
            <p class="text-muted mb-0">Organize your company departments hierarchically</p>
        </div>
        <div>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                <i class="bi bi-building-add me-2"></i>Add Department
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
                            <h6 class="text-uppercase text-muted mb-2">Total Departments</h6>
                            <h2 class="fw-bold mb-0">{{ $totalDepartments }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-building text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            {{ $topLevelDepartments }} main departments
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
                            <h6 class="text-uppercase text-muted mb-2">Active Departments</h6>
                            <h2 class="fw-bold mb-0">{{ $activeDepartments }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span
                            class="text-muted">{{ number_format(($activeDepartments / max($totalDepartments, 1)) * 100, 1) }}%
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
                        <span class="text-muted">Across all departments</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Hierarchy Levels</h6>
                            <h2 class="fw-bold mb-0">{{ Department::max('parent_id') ? 'Multi-level' : 'Single' }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-diagram-3-fill text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted">Organization structure</span>
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
                        <h5 class="mb-0 fw-semibold">Department List</h5>
                        <div class="d-flex gap-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0"
                                    placeholder="Search departments..." id="searchDepartments" value="{{ $search }}">
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-filter me-1"></i>Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => '']) }}">All Departments</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Active Only</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}">Inactive
                                            Only</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ request()->fullUrlWithQuery(['parent_id' => 'null']) }}">Main
                                            Departments</a></li>
                                    @foreach ($allDepartments->take(5) as $dept)
                                        <li><a class="dropdown-item"
                                                href="{{ request()->fullUrlWithQuery(['parent_id' => $dept->id]) }}">
                                                Sub-departments of {{ $dept->name }}
                                            </a></li>
                                    @endforeach
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
                                    <th class="ps-4">Department</th>
                                    <th>Code</th>
                                    <th>Manager</th>
                                    <th>Staff</th>
                                    <th>Sub-Depts</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $department)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                        <i class="bi bi-building text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 fw-semibold">{{ $department->name }}</h6>
                                                    <small
                                                        class="text-muted">{{ $department->description ? \Illuminate\Support\Str::limit($department->description, 50) : 'No description' }}</small>
                                                    @if ($department->parent)
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="bi bi-arrow-return-right me-1"></i>
                                                                Parent: {{ $department->parent->name }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-primary">{{ $department->code }}</code>
                                        </td>
                                        <td>
                                            @if ($department->manager)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xs me-2">
                                                        <div class="avatar-title rounded-circle bg-light text-dark">
                                                            {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <span>{{ $department->manager->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold">{{ $department->users_count }}</span>
                                                @if ($department->staff_count > 0)
                                                    <div class="progress ms-2" style="width: 60px; height: 6px;">
                                                        <div class="progress-bar bg-info"
                                                            style="width: {{ min(($department->users_count / $department->staff_count) * 100, 100) }}%">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($department->staff_count > 0)
                                                <small class="text-muted">Capacity: {{ $department->staff_count }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($department->children_count > 0)
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    {{ $department->children_count }} sub-departments
                                                </span>
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($department->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.departments.show', $department) }}"
                                                    class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.departments.edit', $department) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if ($department->canBeDeleted())
                                                    <form action="{{ route('admin.departments.destroy', $department) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this department?')">
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
                                        <td colspan="7" class="text-center py-5">
                                            <div class="py-5">
                                                <i class="bi bi-building display-1 text-muted opacity-50"></i>
                                                <h5 class="mt-3">No departments found</h5>
                                                <p class="text-muted">Create your first department to get started</p>
                                                <a href="{{ route('admin.departments.create') }}"
                                                    class="btn btn-primary">
                                                    <i class="bi bi-building-add me-2"></i>Add Department
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($departments->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }}
                                of {{ $departments->total() }} departments
                            </div>
                            <div>
                                {{ $departments->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Department Hierarchy Visualization -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold">Department Hierarchy</h5>
                </div>
                <div class="card-body">
                    <div id="departmentTree" style="min-height: 300px;">
                        <!-- Tree view will be loaded here via JavaScript -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading department hierarchy...</p>
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
            const searchInput = document.getElementById('searchDepartments');
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

            // Load department hierarchy
            function loadDepartmentTree() {
                fetch('{{ route('admin.departments.hierarchy') }}')
                    .then(response => response.json())
                    .then(data => {
                        const treeContainer = document.getElementById('departmentTree');
                        treeContainer.innerHTML = buildTreeHTML(data);
                    })
                    .catch(error => {
                        console.error('Error loading department hierarchy:', error);
                        document.getElementById('departmentTree').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load department hierarchy
                    </div>
                `;
                    });
            }

            function buildTreeHTML(departments, level = 0) {
                let html = '<ul class="department-tree list-unstyled">';

                departments.forEach(dept => {
                    const hasChildren = dept.children && dept.children.length > 0;
                    const padding = level * 20;

                    html += `
                <li class="mb-2" style="padding-left: ${padding}px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                            <i class="bi bi-building text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${dept.name}</h6>
                            <small class="text-muted">${dept.code} • ${dept.users_count} staff</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="/admin/departments/${dept.id}" class="btn btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/admin/departments/${dept.id}/edit" class="btn btn-outline-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
            `;

                    if (hasChildren) {
                        html += buildTreeHTML(dept.children, level + 1);
                    }

                    html += '</li>';
                });

                html += '</ul>';
                return html;
            }

            // Load tree on page load
            loadDepartmentTree();
        });
    </script>

    @push('styles')
        <style>
            .department-tree ul {
                margin-left: 20px;
                border-left: 2px dashed #dee2e6;
                padding-left: 10px;
            }

            .department-tree li {
                position: relative;
            }

            .department-tree li:before {
                content: '';
                position: absolute;
                left: -12px;
                top: 20px;
                width: 10px;
                height: 2px;
                background-color: #dee2e6;
            }
        </style>
    @endpush
@endpush
