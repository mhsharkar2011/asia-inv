{{-- resources/views/admin/roles/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.roles.index') }}"
                        class="mr-4 text-gray-400 hover:text-gray-600 transition-colors duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Role</h1>
                        <p class="mt-2 text-sm text-gray-600">Update role: {{ $role->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Role Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Role Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Role Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Role Name *
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $role->name) }}" required
                                        {{ in_array($role->name, ['admin', 'super-admin']) ? 'readonly' : '' }}
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('name') border-red-300 @enderror {{ in_array($role->name, ['admin', 'super-admin']) ? 'bg-gray-50' : '' }}"
                                        placeholder="e.g., moderator, editor">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if (in_array($role->name, ['admin', 'super-admin']))
                                        <p class="mt-2 text-sm text-yellow-600">System roles cannot be renamed</p>
                                    @endif
                                </div>

                                <!-- Guard Name -->
                                <div>
                                    <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Guard Name *
                                    </label>
                                    <select id="guard_name" name="guard_name" required
                                        {{ in_array($role->name, ['admin', 'super-admin']) ? 'disabled' : '' }}
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('guard_name') border-red-300 @enderror {{ in_array($role->name, ['admin', 'super-admin']) ? 'bg-gray-50' : '' }}">
                                        <option value="">Select Guard</option>
                                        <option value="web"
                                            {{ old('guard_name', $role->guard_name) === 'web' ? 'selected' : '' }}>Web
                                        </option>
                                        <option value="api"
                                            {{ old('guard_name', $role->guard_name) === 'api' ? 'selected' : '' }}>API
                                        </option>
                                        <option value="sanctum"
                                            {{ old('guard_name', $role->guard_name) === 'sanctum' ? 'selected' : '' }}>
                                            Sanctum</option>
                                    </select>
                                    @error('guard_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if (in_array($role->name, ['admin', 'super-admin']))
                                        <input type="hidden" name="guard_name" value="{{ $role->guard_name }}">
                                        <p class="mt-2 text-sm text-yellow-600">System role guard cannot be changed</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Assignment -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Assign Permissions</h3>
                                @if ($permissions && $permissions->count() > 0)
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="selectAllPermissions()"
                                            class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors duration-150">
                                            Select All
                                        </button>
                                        <span class="text-gray-300">|</span>
                                        <button type="button" onclick="deselectAllPermissions()"
                                            class="text-sm text-gray-600 hover:text-gray-500 transition-colors duration-150">
                                            Deselect All
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="bg-gray-50 rounded-xl p-4">
                                @if ($permissions && $permissions->count() > 0)
                                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                                        @foreach ($permissions as $permission)
                                            <div
                                                class="flex items-center p-3 border border-gray-200 rounded-lg bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                                                <div class="flex items-center h-5">
                                                    <input id="permission_{{ $permission->id }}" name="permissions[]"
                                                        type="checkbox" value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}
                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="permission_{{ $permission->id }}"
                                                        class="font-medium text-gray-700 cursor-pointer">
                                                        {{ $permission->name }}
                                                    </label>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ str($permission->name)->replace('.', ' • ')->title() }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none"
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
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                @if (!in_array($role->name, ['admin', 'super-admin']))
                                    <button type="button" onclick="confirmDelete()"
                                        class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 focus:outline-none">
                                        Delete Role
                                    </button>
                                @else
                                    <div></div>
                                @endif
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.roles.index') }}"
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
                                            Update Role
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Delete Role</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Are you sure you want to delete "{{ $role->name }}"?
                    This action cannot be undone.</p>
                <div class="flex justify-center space-x-4">
                    <button onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" action="{{ route('admin.roles.destroy', $role->id) }}"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Role
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function selectAllPermissions() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function deselectAllPermissions() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function confirmDelete() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Close modal on background click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endpush
