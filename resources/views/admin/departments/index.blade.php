{{-- resources/views/admin/departments/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Department Management')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Department Management
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Manage organizational departments, their hierarchy and settings
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <button type="button" onclick="toggleFilters()"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                </button>
                <button type="button" onclick="openCreateModal()"
                    class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Department
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div id="filterSection" class="hidden mb-6 bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Search departments...">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="level" class="block text-sm font-medium text-gray-700">Hierarchy Level</label>
                    <select id="level" name="level"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">All Levels</option>
                        <option value="top">Top Level</option>
                        <option value="child">Child Departments</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="applyFilters()"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
                <button type="button" onclick="resetFilters()"
                    class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Reset
                </button>
            </div>
        </div>

        <!-- Departments Tree View -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md mb-8">
            <ul class="divide-y divide-gray-200">
                @foreach($departments as $department)
                    @include('admin.departments.partials.department-item', [
                        'department' => $department,
                        'level' => 0  {{-- FIX: Pass level parameter --}}
                    ])
                @endforeach
            </ul>
        </div>

        <!-- Departments Table (Grid View) -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">All Departments</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete list of departments in grid format</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Department
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Manager
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Staff
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Budget
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($allDepartments as $dept)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $dept->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $dept->code }}</div>
                                            @if($dept->parent)
                                                <div class="text-xs text-gray-400">Part of: {{ $dept->parent->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($dept->manager)
                                        <div class="text-sm text-gray-900">{{ $dept->manager->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $dept->manager->email }}</div>
                                    @else
                                        <span class="text-sm text-gray-400">Not assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $dept->active_staff_count }} / {{ $dept->staff_count }}</div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        @php
                                            $percentage = $dept->staff_count > 0 ? ($dept->active_staff_count / $dept->staff_count) * 100 : 0;
                                        @endphp
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($dept->budget, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $dept->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="editDepartment({{ $dept->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button onclick="viewDepartment({{ $dept->id }})"
                                            class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        @if($dept->canBeDeleted())
                                            <button onclick="confirmDelete({{ $dept->id }})"
                                                class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($allDepartments->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $allDepartments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="departmentModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                    Add New Department
                </h3>
                <form id="departmentForm" method="POST">
                    @csrf
                    <div id="formMethod"></div>
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Department Name *
                            </label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" required
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">
                                Department Code
                            </label>
                            <div class="mt-1">
                                <input type="text" name="code" id="code"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate</p>
                            </div>
                        </div>

                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700">
                                Parent Department
                            </label>
                            <div class="mt-1">
                                <select id="parent_id" name="parent_id"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Parent Department</option>
                                    @foreach($allDepartments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->full_path }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="manager_id" class="block text-sm font-medium text-gray-700">
                                Manager
                            </label>
                            <div class="mt-1">
                                <select id="manager_id" name="manager_id"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Select Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }} ({{ $manager->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Department Email
                            </label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Phone Number
                            </label>
                            <div class="mt-1">
                                <input type="text" name="phone" id="phone"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="staff_count" class="block text-sm font-medium text-gray-700">
                                Staff Count
                            </label>
                            <div class="mt-1">
                                <input type="number" name="staff_count" id="staff_count" min="0"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700">
                                Budget ($)
                            </label>
                            <div class="mt-1">
                                <input type="number" name="budget" id="budget" min="0" step="0.01"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">
                                Location
                            </label>
                            <div class="mt-1">
                                <input type="text" name="location" id="location"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700">
                                Sort Order
                            </label>
                            <div class="mt-1">
                                <input type="number" name="sort_order" id="sort_order" min="0"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <div class="mt-1">
                                <textarea id="description" name="description" rows="3"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <div class="flex items-center">
                                <input id="is_active" name="is_active" type="checkbox"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Department is active
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" onclick="submitForm()"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                    Save Department
                </button>
                <button type="button" onclick="closeModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Delete Department
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to delete this department? This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .department-item {
        transition: all 0.2s ease;
    }

    .department-item:hover {
        background-color: #f9fafb;
    }

    .expand-btn {
        transition: transform 0.2s ease;
    }

    .expand-btn.expanded {
        transform: rotate(90deg);
    }
</style>
@endpush

@push('scripts')
<script>
    let currentDepartmentId = null;

    function toggleFilters() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('hidden');
    }

    function applyFilters() {
        const search = document.getElementById('search').value;
        const status = document.getElementById('status').value;
        const level = document.getElementById('level').value;

        let url = '{{ route("admin.departments.index") }}?';
        if (search) url += `search=${search}&`;
        if (status) url += `status=${status}&`;
        if (level) url += `level=${level}`;

        window.location.href = url;
    }

    function resetFilters() {
        document.getElementById('search').value = '';
        document.getElementById('status').value = '';
        document.getElementById('level').value = '';
        window.location.href = '{{ route("admin.departments.index") }}';
    }

    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add New Department';
        document.getElementById('departmentForm').action = '{{ route("admin.departments.store") }}';
        document.getElementById('formMethod').innerHTML = '';
        document.getElementById('departmentForm').reset();
        document.getElementById('departmentModal').classList.remove('hidden');
    }

    function editDepartment(id) {
        fetch(`/admin/departments/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').textContent = 'Edit Department';
                document.getElementById('departmentForm').action = `/admin/departments/${id}`;
                document.getElementById('formMethod').innerHTML = '@method("PUT")';

                // Fill form with data
                document.getElementById('name').value = data.name || '';
                document.getElementById('code').value = data.code || '';
                document.getElementById('parent_id').value = data.parent_id || '';
                document.getElementById('manager_id').value = data.manager_id || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('staff_count').value = data.staff_count || '';
                document.getElementById('budget').value = data.budget || '';
                document.getElementById('location').value = data.location || '';
                document.getElementById('sort_order').value = data.sort_order || '';
                document.getElementById('description').value = data.description || '';
                document.getElementById('is_active').checked = data.is_active || false;

                document.getElementById('departmentModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading department data');
            });
    }

    function viewDepartment(id) {
        window.location.href = `/admin/departments/${id}`;
    }

    function confirmDelete(id) {
        currentDepartmentId = id;
        document.getElementById('deleteForm').action = `/admin/departments/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('departmentModal').classList.add('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDepartmentId = null;
    }

    function submitForm() {
        document.getElementById('departmentForm').submit();
    }

    function toggleChildren(departmentId) {
        const childrenRow = document.getElementById(`children-${departmentId}`);
        const expandBtn = document.getElementById(`expand-${departmentId}`);

        if (childrenRow.classList.contains('hidden')) {
            childrenRow.classList.remove('hidden');
            expandBtn.classList.add('expanded');
        } else {
            childrenRow.classList.add('hidden');
            expandBtn.classList.remove('expanded');
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            document.getElementById('search').focus();
        }
    });
</script>
@endpush
