@extends('layouts.admin')

@section('title', 'Branch Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <div class="p-3 rounded-2xl bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg mr-4">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                                Branch Management
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                Manage all your branches across locations
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Import
                    </button>
                    <a href="{{ route('admin.branches.export', request()->query()) }}"
                       class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                    </a>
                    <a href="{{ route('admin.branches.create') }}"
                       class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Branch
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Branches</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $branches->total() }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        <span>{{ $stats['active'] ?? $branches->where('is_active', true)->count() }} active</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Branches</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active'] ?? $branches->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-50 to-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Inactive Branches</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['inactive'] ?? $branches->where('is_active', false)->count() }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-red-50 to-red-100">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Search Bar -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <form action="{{ route('admin.branches.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-grow">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search"
                                   class="pl-12 w-full px-5 py-3 border-0 bg-gray-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200"
                                   placeholder="Search branches by name, code, address, or phone..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <!-- Status Filter -->
                        <select name="status" class="px-4 py-3 border-0 bg-gray-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            Search
                        </button>
                        @if (request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.branches.index') }}"
                               class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Branches List -->
            <div class="divide-y divide-gray-100">
                @forelse($branches as $branch)
                    <div class="group p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                        <div class="flex items-start space-x-4">
                            <!-- Checkbox -->
                            <div class="pt-1">
                                <input type="checkbox"
                                       class="branch-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                       value="{{ $branch->id }}">
                            </div>

                            <!-- Branch Avatar -->
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg bg-gradient-to-br from-indigo-500 to-indigo-600">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    @if($branch->is_active)
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                                    @endif
                                </div>
                            </div>

                            <!-- Branch Info -->
                            <div class="flex-grow">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <div class="flex items-center space-x-3">
                                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                {{ $branch->name }}
                                            </h4>
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-indigo-100 text-indigo-800">
                                                {{ $branch->code }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">
                                            @if($branch->manager_name)
                                                <span class="font-medium">Manager:</span> {{ $branch->manager_name }}
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-2 md:mt-0">
                                        @if($branch->is_active)
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-red-100 to-red-200 text-red-800">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <!-- Contact Info -->
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Contact</h5>
                                        <div class="space-y-1">
                                            @if($branch->phone)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span>{{ $branch->phone }}</span>
                                            </div>
                                            @endif
                                            @if($branch->email)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="truncate">{{ $branch->email }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Location Info -->
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location</h5>
                                        <div class="space-y-1">
                                            @if($branch->address)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="truncate">{{ Str::limit($branch->address, 40) }}</span>
                                            </div>
                                            @endif
                                            @if($branch->city || $branch->country)
                                            <div class="text-sm text-gray-600">
                                                <span>{{ $branch->city }}{{ $branch->city && $branch->country ? ', ' : '' }}{{ $branch->country }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Additional Info -->
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Details</h5>
                                        <div class="space-y-1">
                                            <div class="text-sm text-gray-600">
                                                Created: {{ $branch->created_at->format('M d, Y') }}
                                            </div>
                                            @if($branch->description)
                                            <div class="text-sm text-gray-500 truncate">
                                                {{ Str::limit($branch->description, 30) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex-shrink-0">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.branches.show', $branch) }}"
                                       class="p-2 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 hover:shadow transition-all duration-200"
                                       title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.branches.edit', $branch) }}"
                                       class="p-2 rounded-lg bg-gradient-to-r from-amber-50 to-amber-100 text-amber-600 hover:from-amber-100 hover:to-amber-200 hover:shadow transition-all duration-200"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <div class="relative">
                                        <button type="button"
                                                class="p-2 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 hover:from-gray-100 hover:to-gray-200 hover:shadow transition-all duration-200"
                                                id="menu-button-{{ $branch->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                             id="menu-{{ $branch->id }}">
                                            <div class="py-2">
                                                <a href="{{ route('admin.branches.show', $branch) }}"
                                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    View Details
                                                </a>
                                                <a href="{{ route('admin.branches.edit', $branch) }}"
                                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit Branch
                                                </a>
                                                <div class="border-t border-gray-100 my-1"></div>
                                                @if($branch->is_active)
                                                    <form action="{{ route('admin.branches.toggle-status', $branch) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="w-full flex items-center px-4 py-3 text-sm text-amber-700 hover:bg-amber-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Deactivate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.branches.toggle-status', $branch) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="w-full flex items-center px-4 py-3 text-sm text-green-700 hover:bg-green-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Activate
                                                        </button>
                                                    </form>
                                                @endif
                                                <div class="border-t border-gray-100 my-1"></div>
                                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST"
                                                      onsubmit="return confirm('Delete this branch? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete Branch
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="inline-block p-6 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 mb-6">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No branches found</h3>
                        <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                            Start by creating your first branch to manage different locations of your business.
                        </p>
                        <a href="{{ route('admin.branches.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Your First Branch
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($branches->hasPages())
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                            Showing <span class="font-bold">{{ $branches->firstItem() }}</span> to
                            <span class="font-bold">{{ $branches->lastItem() }}</span> of
                            <span class="font-bold">{{ $branches->total() }}</span> results
                        </div>
                        <div class="flex space-x-2">
                            {{ $branches->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Bulk Actions -->
        <div id="bulkActions" class="hidden mt-6">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl shadow-xl border border-blue-200">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <span class="font-bold text-blue-800" id="selectedCount">0 selected</span>
                            <p class="text-sm text-blue-600 mt-1">Perform actions on selected branches</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" id="bulkActivate"
                                    class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Activate Selected
                            </button>
                            <button type="button" id="bulkDeactivate"
                                    class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Deactivate Selected
                            </button>
                            <button type="button" id="bulkDelete"
                                    class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:shadow-lg hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Selected
                            </button>
                            <button type="button" id="clearSelection"
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                Clear Selection
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-xl p-6">
                <h5 class="modal-title text-xl font-bold">Import Branches</h5>
                <button type="button" class="btn-close text-white opacity-80 hover:opacity-100" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-6">
                <form action="{{ route('admin.branches.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <div class="space-y-6">
                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Upload File</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-blue-500 transition-colors duration-200">
                                <div class="space-y-3 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file" type="file" class="sr-only" accept=".csv,.xlsx,.xls">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">CSV, XLSX up to 10MB</p>
                                    <div id="file-name" class="text-sm font-medium text-gray-900 hidden"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Import Options -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Default Status</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            name="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Import Mode</label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            name="import_mode">
                                        <option value="create">Create New Only</option>
                                        <option value="update">Update Existing</option>
                                        <option value="both">Create & Update</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Template Info -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-5">
                                <div class="flex">
                                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-bold text-blue-800">Need help with formatting?</p>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Download our
                                            <a href="{{ asset('templates/branch-template.csv') }}"
                                               class="font-bold underline hover:text-blue-900 transition-colors duration-200">
                                                template file
                                            </a>
                                            to ensure your data is formatted correctly.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="button"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                                        data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import Branches
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File upload preview
        const fileInput = document.getElementById('file-upload');
        const fileName = document.getElementById('file-name');

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    fileName.classList.remove('hidden');
                } else {
                    fileName.classList.add('hidden');
                }
            });
        }

        // Drag and drop file upload
        const dropArea = fileInput?.closest('.border-dashed');
        if (dropArea) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight(e) {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                if (files.length > 0) {
                    fileName.textContent = files[0].name;
                    fileName.classList.remove('hidden');
                }
            }
        }

        // Search functionality
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }

        // Dropdown menus
        document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
            const menuId = button.id.replace('menu-button-', 'menu-');
            const menu = document.getElementById(menuId);

            button.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('[id^="menu-"]').forEach(m => {
                    if (m.id !== menuId) m.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        });

        // Bulk selection
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.branch-checkbox');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAll && checkboxes.length > 0) {
            // Create select all checkbox if it doesn't exist
            if (!selectAll) {
                const header = document.querySelector('.bg-gradient-to-r.from-gray-50');
                const selectAllHtml = `
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="selectAll"
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200">
                        <h3 class="text-lg font-bold text-gray-900">
                            Branches ({{ $branches->total() }})
                        </h3>
                    </div>
                `;
                header.querySelector('div').innerHTML = selectAllHtml + header.querySelector('div').innerHTML;
            }

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    checkbox.closest('.group')?.classList.toggle('bg-blue-50', this.checked);
                });
                updateBulkActions();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    this.closest('.group')?.classList.toggle('bg-blue-50', this.checked);
                    updateBulkActions();
                });
            });

            function updateBulkActions() {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                const count = selected.length;

                if (count > 0) {
                    bulkActions.classList.remove('hidden');
                    selectedCount.textContent = `${count} branch${count > 1 ? 'es' : ''} selected`;
                    selectAll.indeterminate = count > 0 && count < checkboxes.length;
                    selectAll.checked = count === checkboxes.length;
                } else {
                    bulkActions.classList.add('hidden');
                    selectAll.indeterminate = false;
                    selectAll.checked = false;
                }
            }

            // Bulk actions
            const bulkActivateBtn = document.getElementById('bulkActivate');
            const bulkDeactivateBtn = document.getElementById('bulkDeactivate');
            const bulkDeleteBtn = document.getElementById('bulkDelete');
            const clearSelectionBtn = document.getElementById('clearSelection');

            if (bulkActivateBtn) {
                bulkActivateBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Activate ${ids.length} selected branch${ids.length > 1 ? 'es' : ''}?`)) {
                        bulkAction('/admin/branches/bulk-activate', ids);
                    }
                });
            }

            if (bulkDeactivateBtn) {
                bulkDeactivateBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Deactivate ${ids.length} selected branch${ids.length > 1 ? 'es' : ''}?`)) {
                        bulkAction('/admin/branches/bulk-deactivate', ids);
                    }
                });
            }

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Delete ${ids.length} selected branch${ids.length > 1 ? 'es' : ''}? This action cannot be undone.`)) {
                        bulkAction('/admin/branches/bulk-delete', ids);
                    }
                });
            }

            if (clearSelectionBtn) {
                clearSelectionBtn.addEventListener('click', () => {
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                        cb.closest('.group')?.classList.remove('bg-blue-50');
                    });
                    updateBulkActions();
                });
            }

            function getSelectedIds() {
                return Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
            }

            function bulkAction(url, ids) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error performing bulk action');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error performing bulk action');
                });
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    .group:hover .group-hover\:bg-blue-50 {
        background-color: rgba(239, 246, 255, 1);
    }

    input[type="checkbox"]:indeterminate {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 16'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 8h8'/%3e%3c/svg%3e");
        background-color: #2563eb;
        border-color: #2563eb;
    }

    /* Smooth transitions */
    .transition-all {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush
