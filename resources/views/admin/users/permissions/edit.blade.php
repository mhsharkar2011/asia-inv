{{-- resources/views/admin/users/permissions/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit User Permissions')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('admin.users.index') }}"
                            class="mr-4 text-gray-400 hover:text-gray-600 transition-colors duration-150">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit User Permissions</h1>
                            <p class="mt-2 text-sm text-gray-600">Manage permissions for {{ $user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- User Info Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col items-center text-center">
                                <div class="h-20 w-20 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>

                                <div class="mt-4 space-y-2 w-full">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">User ID:</span>
                                        <span class="text-sm font-medium">{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                        {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Roles:</span>
                                        <span class="text-sm font-medium">{{ $user->roles->count() }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Permissions:</span>
                                        <span class="text-sm font-medium">{{ $user->permissions->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <button type="button" onclick="selectAllPermissions()"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Select All Permissions
                                </button>
                                <button type="button" onclick="deselectAllPermissions()"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Deselect All Permissions
                                </button>
                                <button type="button" onclick="resetToRolePermissions()"
                                    class="w-full flex items-center justify-center px-4 py-2 border border-purple-200 text-sm font-medium rounded-lg text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Reset to Role Permissions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Form -->
                <div class="lg:col-span-3">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Direct Permissions</h3>
                                    <p class="text-sm text-gray-500">Assign permissions directly to this user (in addition
                                        to permissions from roles).</p>
                                </div>
                                <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                                    <span class="text-sm text-gray-600" id="selectedCount">
                                        {{ $user->permissions->count() }} of {{ $permissions->count() }} selected
                                    </span>
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="selectAllPermissions()"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            All
                                        </button>
                                        <button type="button" onclick="deselectAllPermissions()"
                                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            None
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.users.permissions.update', $user->id) }}"
                            class="p-6">
                            @csrf
                            @method('PUT')

                            <!-- Permission Groups -->
                            @php
                                // Group permissions by their prefix (e.g., 'users.', 'posts.')
                                $groupedPermissions = $permissions->groupBy(function ($permission) {
                                    $parts = explode('.', $permission->name);
                                    return $parts[0] ?? 'other';
                                });

                                // Get user's role permissions
$userRolePermissions = $user->getPermissionsViaRoles()->pluck('id')->toArray();
                            @endphp

                            <div class="space-y-6">
                                @foreach ($groupedPermissions as $group => $groupPermissions)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="font-medium text-gray-900 capitalize">
                                                    {{ $group }} Permissions
                                                    <span class="text-xs text-gray-500">
                                                        ({{ $groupPermissions->count() }})
                                                    </span>
                                                </h4>
                                                <div class="flex space-x-1">
                                                    <button type="button"
                                                        onclick="toggleGroup('{{ $group }}', true)"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-green-700 bg-green-50 hover:bg-green-100">
                                                        Select All
                                                    </button>
                                                    <button type="button"
                                                        onclick="toggleGroup('{{ $group }}', false)"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100">
                                                        Deselect
                                                    </button>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500" id="groupCount-{{ $group }}">
                                                {{ $groupPermissions->whereIn('id', old('permissions', $user->permissions->pluck('id')->toArray()))->count() }}
                                                selected
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach ($groupPermissions as $permission)
                                                @php
                                                    $isRolePermission = in_array($permission->id, $userRolePermissions);
                                                    $isDirectPermission = in_array(
                                                        $permission->id,
                                                        old('permissions', $user->permissions->pluck('id')->toArray()),
                                                    );
                                                @endphp
                                                <div class="relative">
                                                    <div
                                                        class="relative flex items-start p-2 hover:bg-gray-50 rounded-lg transition duration-150 ease-in-out">
                                                        <div class="flex items-center h-5">
                                                            <input id="permission_{{ $permission->id }}"
                                                                name="permissions[]" type="checkbox"
                                                                value="{{ $permission->id }}"
                                                                {{ $isDirectPermission ? 'checked' : '' }}
                                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded permission-checkbox"
                                                                data-group="{{ $group }}"
                                                                onchange="updateCount()">
                                                        </div>
                                                        <div class="ml-3 flex-1 min-w-0">
                                                            <div class="flex items-center justify-between">
                                                                <label for="permission_{{ $permission->id }}"
                                                                    class="text-sm font-medium text-gray-700 cursor-pointer truncate">
                                                                    {{ $permission->name }}
                                                                </label>
                                                                @if ($isRolePermission)
                                                                    <span
                                                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"
                                                                        title="Permission inherited from role">
                                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                        Role
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="text-xs text-gray-500 mt-1 truncate">
                                                                {{ str($permission->name)->replace('.', ' • ')->title() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                @if ($permissions->isEmpty())
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500">No permissions available. <a
                                                href="{{ route('admin.permissions.create') }}"
                                                class="text-indigo-600 hover:text-indigo-500">Create permissions first</a>.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Summary Card -->
                            <div class="mt-8 bg-gray-50 rounded-xl p-6">
                                <h4 class="font-medium text-gray-900 mb-3">Permission Summary</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-indigo-100 rounded-lg">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Direct Permissions</p>
                                                <p class="text-xl font-bold text-gray-900" id="directCount">
                                                    {{ $user->permissions->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-100 rounded-lg">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">From Roles</p>
                                                <p class="text-xl font-bold text-gray-900">
                                                    {{ $user->getPermissionsViaRoles()->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-green-100 rounded-lg">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Total Effective</p>
                                                <p class="text-xl font-bold text-gray-900">
                                                    {{ $user->getAllPermissions()->count() }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        Changes will be saved immediately upon submission
                                    </div>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Save Permissions
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select all permissions
        function selectAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateCount();
        }

        // Deselect all permissions
        function deselectAllPermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateCount();
        }

        // Reset to role permissions only
        function resetToRolePermissions() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                // This would require additional logic to know which permissions come from roles
                // For now, just uncheck all
                checkbox.checked = false;
            });
            updateCount();
            alert('Note: This would normally reset to only role permissions. Currently clears all selections.');
        }

        // Toggle entire group
        function toggleGroup(group, select) {
            const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            checkboxes.forEach(checkbox => {
                checkbox.checked = select;
            });
            updateGroupCount(group);
            updateCount();
        }

        // Update group count display
        function updateGroupCount(group) {
            const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
            const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const totalCount = checkboxes.length;

            const groupCountElement = document.getElementById(`groupCount-${group}`);
            if (groupCountElement) {
                groupCountElement.textContent = `${selectedCount} selected`;
            }
        }

        // Update overall count display
        function updateCount() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const totalCount = checkboxes.length;

            // Update selected count
            const selectedCountElement = document.getElementById('selectedCount');
            if (selectedCountElement) {
                selectedCountElement.textContent = `${selectedCount} of ${totalCount} selected`;
            }

            // Update direct count
            const directCountElement = document.getElementById('directCount');
            if (directCountElement) {
                directCountElement.textContent = selectedCount;
            }

            // Update all group counts
            const groups = new Set(Array.from(checkboxes).map(cb => cb.dataset.group));
            groups.forEach(group => {
                updateGroupCount(group);
            });
        }

        // Initialize counts on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCount();

            // Update all group counts
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const groups = new Set(Array.from(checkboxes).map(cb => cb.dataset.group));
            groups.forEach(group => {
                updateGroupCount(group);
            });
        });

        // Add event listeners to all checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCount);
            });
        });
    </script>
@endpush
