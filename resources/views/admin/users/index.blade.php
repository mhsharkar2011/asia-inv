@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center py-4">
            <div>
                <h1 class="h3 fw-bold mb-2">User Management</h1>
                <p class="text-muted mb-0">Manage system users, roles, and permissions</p>
            </div>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="bi bi-person-plus me-2"></i>Add New User
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
                                <h6 class="text-uppercase text-muted mb-2">Total Users</h6>
                                <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-arrow-up me-1"></i>{{ $activeUsersPercentage }}% active
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
                                <h6 class="text-uppercase text-muted mb-2">Active Users</h6>
                                <h2 class="fw-bold mb-0">{{ $activeUsers }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">{{ $todayLogins }} logged in today</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Admin Users</h6>
                                <h2 class="fw-bold mb-0">{{ $adminUsers }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-shield-fill-check text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">{{ $adminPercentage }}% of total</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Recent Activity</h6>
                                <h2 class="fw-bold mb-0">{{ $recentActivity }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-activity text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted">Last 24 hours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Users List -->
            <div class="col-xl-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold">User List</h5>
                            <div class="d-flex gap-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search users..."
                                        id="searchUsers">
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bi bi-filter me-1"></i>Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-filter="all">All Users</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="active">Active Only</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-filter="inactive">Inactive Only</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-filter="admin">Admin Users</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="staff">Staff Users</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="customer">Customer
                                                Users</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm" id="exportUsers">
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
                                        <th class="ps-4" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllUsers">
                                            </div>
                                        </th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Last Login</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr class="user-row" data-status="{{ $user->is_active ? 'active' : 'inactive' }}"
                                            data-role="{{ strtolower($user->role) }}">
                                            <td class="ps-4">
                                                <div class="form-check">
                                                    <input class="form-check-input user-checkbox" type="checkbox"
                                                        value="{{ $user->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if ($user->avatar)
                                                            <img src="{{ asset($user->avatar) }}"
                                                                alt="{{ $user->name }}" class="rounded-circle me-3"
                                                                width="40" height="40">
                                                        @else
                                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                                style="width: 40px; height: 40px;">
                                                                <span class="text-primary fw-bold">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <small class="text-muted">
                                                                <i class="bi bi-person me-1"></i>ID: {{ $user->id }}
                                                            </small>
                                                            <small class="text-muted ms-3">
                                                                <i
                                                                    class="bi bi-telephone me-1"></i>{{ $user->phone ?? 'N/A' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $roleColors = [
                                                        'admin' => 'danger',
                                                        'manager' => 'warning',
                                                        'staff' => 'info',
                                                        'customer' => 'success',
                                                        'super_admin' => 'purple',
                                                    ];
                                                    $roleColor = $roleColors[strtolower($user->role)] ?? 'secondary';
                                                    $roleIcons = [
                                                        'admin' => 'bi-shield-check',
                                                        'manager' => 'bi-person-badge',
                                                        'staff' => 'bi-person',
                                                        'customer' => 'bi-person-circle',
                                                        'super_admin' => 'bi-star-fill',
                                                    ];
                                                    $roleIcon = $roleIcons[strtolower($user->role)] ?? 'bi-person';
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} px-3 py-2">
                                                    <i class="bi {{ $roleIcon }} me-1"></i>
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                                @if ($user->permissions_count)
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            {{ $user->permissions_count }} permission(s)
                                                        </small>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->department)
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-circle p-2 me-2">
                                                            <i class="bi bi-building text-secondary"></i>
                                                        </div>
                                                        <div>
                                                            <span class="d-block">{{ $user->department->name }}</span>
                                                            @if ($user->position)
                                                                <small class="text-muted">{{ $user->position }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Not assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->last_login_at)
                                                    <div class="d-flex flex-column">
                                                        <span>{{ $user->last_login_at->format('d/m/Y H:i') }}</span>
                                                        <small class="text-muted">
                                                            {{ $user->last_login_at->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Never logged in</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->is_active)
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        <i class="bi bi-check-circle me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Inactive
                                                    </span>
                                                @endif
                                                @if ($user->email_verified_at)
                                                    <div class="mt-1">
                                                        <small class="badge bg-info bg-opacity-10 text-info">
                                                            <i class="bi bi-envelope-check me-1"></i>Verified
                                                        </small>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group" role="group">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-light text-dark dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item view-user" href="#"
                                                                data-id="{{ $user->id }}">
                                                                <i class="bi bi-eye me-2"></i>View Profile
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item edit-user" href="#"
                                                                data-id="{{ $user->id }}">
                                                                <i class="bi bi-pencil me-2"></i>Edit User
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.users.login-as', $user->id) }}">
                                                                <i class="bi bi-box-arrow-in-right me-2"></i>Login As User
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        @if ($user->is_active)
                                                            <li>
                                                                <a class="dropdown-item text-warning deactivate-user"
                                                                    href="#" data-id="{{ $user->id }}">
                                                                    <i class="bi bi-pause-circle me-2"></i>Deactivate
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a class="dropdown-item text-success activate-user"
                                                                    href="#" data-id="{{ $user->id }}">
                                                                    <i class="bi bi-play-circle me-2"></i>Activate
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if (!$user->email_verified_at)
                                                            <li>
                                                                <a class="dropdown-item text-info verify-email"
                                                                    href="#" data-id="{{ $user->id }}">
                                                                    <i class="bi bi-envelope-check me-2"></i>Verify Email
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-danger delete-user"
                                                                href="#" data-id="{{ $user->id }}">
                                                                <i class="bi bi-trash me-2"></i>Delete User
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
                                                    <i class="bi bi-people display-1 text-muted opacity-50"></i>
                                                    <h5 class="mt-3">No users found</h5>
                                                    <p class="text-muted">Create your first user to get started</p>
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#createUserModal">
                                                        <i class="bi bi-person-plus me-2"></i>Add User
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($users->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                                    of {{ $users->total() }} users
                                </div>
                                <div>
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Personal Information -->
                            <div class="col-md-12">
                                <h6 class="mb-3 text-muted">Personal Information</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth">
                            </div>

                            <!-- Account Information -->
                            <div class="col-md-12 mt-3">
                                <h6 class="mb-3 text-muted">Account Information</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role *</label>
                                <select class="form-select" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <select class="form-select" name="department_id">
                                    <option value="">Select Department</option>
                                    @foreach ($departments ?? [] as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar" id="passwordStrength"></div>
                                </div>
                                <small class="form-text text-muted">Minimum 8 characters with uppercase, lowercase &
                                    number</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password *</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-12 mt-3">
                                <h6 class="mb-3 text-muted">Additional Information</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Position/Title</label>
                                <input type="text" class="form-control" name="position">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="1"></textarea>
                            </div>

                            <!-- Permissions & Settings -->
                            <div class="col-md-12 mt-3">
                                <h6 class="mb-3 text-muted">Permissions & Settings</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                name="is_active" id="is_active" checked>
                                            <label class="form-check-label" for="is_active">
                                                Active Account
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                name="send_welcome_email" id="send_welcome_email" checked>
                                            <label class="form-check-label" for="send_welcome_email">
                                                Send Welcome Email
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                name="force_password_change" id="force_password_change">
                                            <label class="form-check-label" for="force_password_change">
                                                Force Password Change
                                            </label>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                name="two_factor_auth" id="two_factor_auth">
                                            <label class="form-check-label" for="two_factor_auth">
                                                Enable 2FA
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="userDetails">
                    <!-- Details will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editUserFormBody">
                        <!-- Form will be loaded here via AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
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
                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle me-2"></i>
                        User account and all associated data will be permanently removed.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Modal -->
    <div class="modal fade" id="quickActionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary text-start" type="button">
                            <i class="bi bi-envelope me-2"></i>Send Email to Selected Users
                        </button>
                        <button class="btn btn-outline-secondary text-start" type="button">
                            <i class="bi bi-lock me-2"></i>Reset Passwords
                        </button>
                        <button class="btn btn-outline-success text-start" type="button">
                            <i class="bi bi-check-circle me-2"></i>Activate Selected
                        </button>
                        <button class="btn btn-outline-warning text-start" type="button">
                            <i class="bi bi-pause-circle me-2"></i>Deactivate Selected
                        </button>
                        <button class="btn btn-outline-danger text-start" type="button">
                            <i class="bi bi-trash me-2"></i>Delete Selected
                        </button>
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
            const searchInput = document.getElementById('searchUsers');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.user-row');

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
                    const rows = document.querySelectorAll('.user-row');

                    rows.forEach(row => {
                        if (filterType === 'all') {
                            row.style.display = '';
                        } else if (filterType === 'active') {
                            row.style.display = row.getAttribute('data-status') ===
                                'active' ? '' : 'none';
                        } else if (filterType === 'inactive') {
                            row.style.display = row.getAttribute('data-status') ===
                                'inactive' ? '' : 'none';
                        } else {
                            row.style.display = row.getAttribute('data-role') ===
                                filterType ? '' : 'none';
                        }
                    });
                });
            });

            // Bulk selection
            const selectAll = document.getElementById('selectAllUsers');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }

            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('passwordStrength');

            if (passwordInput && passwordStrength) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;

                    // Check password strength
                    if (password.length >= 8) strength += 25;
                    if (/[a-z]/.test(password)) strength += 25;
                    if (/[A-Z]/.test(password)) strength += 25;
                    if (/[0-9]/.test(password)) strength += 25;

                    // Update progress bar
                    passwordStrength.style.width = strength + '%';

                    // Change color based on strength
                    if (strength < 50) {
                        passwordStrength.className = 'progress-bar bg-danger';
                    } else if (strength < 75) {
                        passwordStrength.className = 'progress-bar bg-warning';
                    } else {
                        passwordStrength.className = 'progress-bar bg-success';
                    }
                });
            }

            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const passwordField = document.getElementById('password');
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    this.querySelector('i').className = type === 'password' ? 'bi bi-eye' :
                        'bi bi-eye-slash';
                });
            }

            // Auto-generate username from email
            const emailInput = document.querySelector('input[name="email"]');
            const usernameInput = document.querySelector('input[name="username"]');

            if (emailInput && usernameInput) {
                emailInput.addEventListener('blur', function() {
                    if (!usernameInput.value.trim() && this.value.trim()) {
                        const username = this.value.split('@')[0].replace(/[^a-zA-Z0-9]/g, '');
                        usernameInput.value = username;
                    }
                });
            }

            // View user details
            document.querySelectorAll('.view-user').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');

                    // Show loading state
                    document.getElementById('userDetails').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading user details...</p>
                </div>
            `;

                    // Load user details via AJAX
                    fetch(`/users/${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('userDetails').innerHTML = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                     style="width: 100px; height: 100px;">
                                    <span class="text-primary fw-bold display-6">
                                        ${data.name.charAt(0).toUpperCase()}
                                    </span>
                                </div>
                                <h5>${data.name}</h5>
                                <p class="text-muted">${data.email}</p>
                                <span class="badge bg-${data.is_active ? 'success' : 'danger'}">
                                    ${data.is_active ? 'Active' : 'Inactive'}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Role</label>
                                        <p class="fw-semibold">${data.role}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Phone</label>
                                        <p class="fw-semibold">${data.phone || 'N/A'}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Last Login</label>
                                        <p class="fw-semibold">${data.last_login_at || 'Never'}</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label text-muted">Created At</label>
                                        <p class="fw-semibold">${data.created_at}</p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted">Address</label>
                                        <p class="fw-semibold">${data.address || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        })
                        .catch(error => {
                            document.getElementById('userDetails').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Failed to load user details. Please try again.
                        </div>
                    `;
                        });

                    const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
                    modal.show();
                });
            });

            // Edit user
            document.querySelectorAll('.edit-user').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');

                    // Load edit form via AJAX
                    fetch(`/users/${userId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editUserFormBody').innerHTML = html;
                            document.getElementById('editUserForm').action = `/users/${userId}`;

                            const modal = new bootstrap.Modal(document.getElementById(
                                'editUserModal'));
                            modal.show();
                        })
                        .catch(error => {
                            alert('Failed to load edit form');
                        });
                });
            });

            // Delete user confirmation
            document.querySelectorAll('.delete-user').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');
                    const form = document.getElementById('deleteUserForm');
                    form.action = `/users/${userId}`;

                    const modal = new bootstrap.Modal(document.getElementById(
                        'deleteConfirmationModal'));
                    modal.show();
                });
            });

            // Toggle user status
            document.querySelectorAll('.activate-user, .deactivate-user').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');
                    const isActivate = this.classList.contains('activate-user');

                    if (confirm(
                            `Are you sure you want to ${isActivate ? 'activate' : 'deactivate'} this user?`
                            )) {
                        fetch(`/users/${userId}/toggle-status`, {
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
                                }
                            })
                            .catch(error => {
                                alert('Failed to update user status');
                            });
                    }
                });
            });

            // Export users
            const exportBtn = document.getElementById('exportUsers');
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    window.location.href = '/users/export';
                });
            }

            // Form validation for create user
            const createForm = document.getElementById('createUserForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.querySelector('input[name="password_confirmation"]')
                        .value;

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        return;
                    }

                    if (password.length < 8) {
                        e.preventDefault();
                        alert('Password must be at least 8 characters long!');
                        return;
                    }
                });
            }
        });
    </script>

    @push('styles')
        <style>
            .avatar-initials {
                width: 40px;
                height: 40px;
                background-color: var(--bs-primary);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(var(--bs-primary-rgb), 0.05);
            }

            .progress-bar {
                transition: width 0.5s ease-in-out;
            }

            .badge {
                font-weight: 500;
            }

            .form-check-input:checked {
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
            }

            .modal-content {
                border: none;
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            }

            .dropdown-menu {
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                border: 1px solid rgba(0, 0, 0, 0.1);
            }

            .bg-purple {
                background-color: #6f42c1 !important;
            }

            .text-purple {
                color: #6f42c1 !important;
            }
        </style>
    @endpush
@endpush
