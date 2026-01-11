@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Role Management</h1>
                        <p class="text-gray-600 mt-1">Manage user roles and permissions</p>
                    </div>
                    <div>
                        @can('create roles')
                            <a href="{{ route('admin.roles.create') }}"
                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600
                                      text-white font-medium rounded-lg hover:from-purple-700 hover:to-indigo-700
                                      transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create New Role
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Users
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Permissions
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($roles as $role)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-lg bg-purple-100
                                                        flex items-center justify-center text-purple-600">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $role->name }}
                                                    @if ($role->name === 'super_admin')
                                                        <span
                                                            class="ml-2 px-2 py-1 text-xs font-medium
                                                               bg-gradient-to-r from-yellow-100 to-amber-100 text-amber-800 rounded-full">
                                                            Super Admin
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                                    font-medium bg-blue-100 text-blue-800">
                                            {{ $role->users_count }} users
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                                    font-medium bg-green-100 text-green-800">
                                            {{ $role->permissions_count }} permissions
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $role->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            @can('view roles')
                                                <a href="{{ route('admin.roles.show', $role) }}"
                                                    class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600
                                                          hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                    title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('edit roles')
                                                @if ($role->name !== 'super_admin')
                                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                                        class="inline-flex items-center p-2 text-gray-400 hover:text-amber-600
                                                              hover:bg-amber-50 rounded-lg transition-colors duration-200"
                                                        title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            @endcan
                                            @can('delete roles')
                                                @if ($role->name !== 'super_admin' && $role->users_count === 0)
                                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center p-2 text-gray-400 hover:text-red-600
                                                                       hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                            title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="max-w-sm mx-auto">
                                            <div
                                                class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No roles found</h3>
                                            <p class="text-gray-500 mb-6">Create your first role to get started</p>
                                            @can('create roles')
                                                <a href="{{ route('admin.roles.create') }}"
                                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600
                                                          text-white font-medium rounded-lg hover:from-purple-700 hover:to-indigo-700
                                                          transition-all duration-200 shadow-sm hover:shadow-md">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Create Role
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($roles->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">{{ $roles->firstItem() }}</span> to
                                <span class="font-medium">{{ $roles->lastItem() }}</span> of
                                <span class="font-medium">{{ $roles->total() }}</span> roles
                            </div>
                            <div>
                                {{ $roles->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
