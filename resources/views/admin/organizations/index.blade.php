@extends('layouts.admin')

@section('title', 'Organization Management')

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
                                @if ($type)
                                    {{ ucfirst($type) }} Management
                                @else
                                    Organization Hub
                                @endif
                            </h1>
                            <p class="mt-2 text-lg text-gray-600">
                                {{ $type ? 'Manage all your ' . $type . 's' : 'Centralized management for companies, customers, and suppliers' }}
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
                    <a href="{{ route('admin.organizations.export', request()->query()) }}"
                       class="group relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Organizations</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['companies'] + $stats['customers'] + $stats['suppliers'] }}</p>
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
                        <span>{{ $stats['active'] }} active</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Companies</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['companies'] }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Customers</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['customers'] }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-50 to-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-11.75A8.25 8.25 0 0112 2.25a8.25 8.25 0 106.5 15" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Suppliers</p>
                        <p class="text-3xl font-bold text-amber-600 mt-2">{{ $stats['suppliers'] }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Quick Create -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Create</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.organizations.create', ['type' => 'company']) }}"
                               class="group flex items-center justify-between p-4 rounded-xl border border-blue-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 transition-all duration-200 hover:scale-[1.02]">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 mr-3 group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-700">New Company</span>
                                </div>
                                <svg class="w-5 h-5 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.organizations.create', ['type' => 'customer']) }}"
                               class="group flex items-center justify-between p-4 rounded-xl border border-green-200 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 transition-all duration-200 hover:scale-[1.02]">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-green-500 to-green-600 mr-3 group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-700">New Customer</span>
                                </div>
                                <svg class="w-5 h-5 text-green-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.organizations.create', ['type' => 'supplier']) }}"
                               class="group flex items-center justify-between p-4 rounded-xl border border-amber-200 hover:bg-gradient-to-r hover:from-amber-50 hover:to-amber-100 transition-all duration-200 hover:scale-[1.02]">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-amber-500 to-amber-600 mr-3 group-hover:rotate-12 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-gray-700">New Supplier</span>
                                </div>
                                <svg class="w-5 h-5 text-amber-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Filters</h3>

                        <!-- Type Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-3">Type</h4>
                            <div class="space-y-2">
                                <a href="{{ route('admin.organizations.index') }}"
                                   class="flex items-center justify-between px-4 py-3 rounded-xl {{ !$type ? 'bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 text-blue-700' : 'bg-gray-50 hover:bg-gray-100 text-gray-700' }} transition-all duration-200 hover:scale-[1.02]">
                                    <span>All Types</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500 text-white">
                                        {{ $stats['companies'] + $stats['customers'] + $stats['suppliers'] }}
                                    </span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'company']) }}"
                                   class="flex items-center justify-between px-4 py-3 rounded-xl {{ $type == 'company' ? 'bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 text-blue-700' : 'bg-gray-50 hover:bg-gray-100 text-gray-700' }} transition-all duration-200 hover:scale-[1.02]">
                                    <span>Companies</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500 text-white">
                                        {{ $stats['companies'] }}
                                    </span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'customer']) }}"
                                   class="flex items-center justify-between px-4 py-3 rounded-xl {{ $type == 'customer' ? 'bg-gradient-to-r from-green-50 to-green-100 border border-green-200 text-green-700' : 'bg-gray-50 hover:bg-gray-100 text-gray-700' }} transition-all duration-200 hover:scale-[1.02]">
                                    <span>Customers</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-500 text-white">
                                        {{ $stats['customers'] }}
                                    </span>
                                </a>
                                <a href="{{ route('admin.organizations.index', ['type' => 'supplier']) }}"
                                   class="flex items-center justify-between px-4 py-3 rounded-xl {{ $type == 'supplier' ? 'bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 text-amber-700' : 'bg-gray-50 hover:bg-gray-100 text-gray-700' }} transition-all duration-200 hover:scale-[1.02]">
                                    <span>Suppliers</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500 text-white">
                                        {{ $stats['suppliers'] }}
                                    </span>
                                </a>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-3">Status</h4>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                                   class="px-4 py-2 rounded-lg {{ !$status ? 'bg-gradient-to-r from-gray-800 to-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-all duration-200">
                                    All
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}"
                                   class="px-4 py-2 rounded-lg {{ $status == 'active' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition-all duration-200">
                                    Active
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}"
                                   class="px-4 py-2 rounded-lg {{ $status == 'inactive' ? 'bg-gradient-to-r from-red-500 to-red-600 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' }} transition-all duration-200">
                                    Inactive
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Search Bar -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex-grow">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="searchInput"
                                       class="pl-12 w-full px-5 py-3 border-0 bg-gray-50 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200"
                                       placeholder="Search organizations by name, code, email, or phone..."
                                       value="{{ $search }}">
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Search
                            </button>
                            @if ($search)
                                <a href="{{ route('admin.organizations.index', ['type' => $type]) }}"
                                   class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                    @if ($type)
                        <input type="hidden" name="type" value="{{ $type }}">
                    @endif
                </div>

                <!-- Organizations Grid -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" id="selectAll"
                                       class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200">
                                <h3 class="text-lg font-bold text-gray-900">
                                    @if ($type)
                                        {{ ucfirst($type) }}s ({{ $organizations->total() }})
                                    @else
                                        All Organizations ({{ $organizations->total() }})
                                    @endif
                                </h3>
                            </div>
                            <div class="text-sm text-gray-500">
                                Showing {{ $organizations->firstItem() ?? 0 }}-{{ $organizations->lastItem() ?? 0 }} of {{ $organizations->total() }}
                            </div>
                        </div>
                    </div>

                    <!-- Organizations List -->
                    <div class="divide-y divide-gray-100">
                        @forelse($organizations as $org)
                            <div class="group p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                                <div class="flex items-start space-x-4">
                                    <!-- Checkbox -->
                                    <div class="pt-1">
                                        <input type="checkbox"
                                               class="organization-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200"
                                               value="{{ $org->id }}">
                                    </div>

                                    <!-- Organization Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg
                                                @if($org->type == 'company') bg-gradient-to-br from-blue-500 to-blue-600
                                                @elseif($org->type == 'customer') bg-gradient-to-br from-green-500 to-green-600
                                                @else bg-gradient-to-br from-amber-500 to-amber-600 @endif">
                                                @if($org->type == 'company')
                                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                @elseif($org->type == 'customer')
                                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                    </svg>
                                                @endif
                                            </div>
                                            @if($org->is_active)
                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Organization Info -->
                                    <div class="flex-grow">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <div class="flex items-center space-x-3">
                                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                        {{ $org->name }}
                                                    </h4>
                                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                                        @if($org->type == 'company') bg-blue-100 text-blue-800
                                                        @elseif($org->type == 'customer') bg-green-100 text-green-800
                                                        @else bg-amber-100 text-amber-800 @endif">
                                                        {{ ucfirst($org->type) }}
                                                    </span>
                                                    @if($org->sub_type)
                                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded">
                                                            {{ ucfirst($org->sub_type) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <span class="font-medium">Code:</span> {{ $org->code }}
                                                    @if($org->tin)
                                                        <span class="mx-2">•</span>
                                                        <span class="font-medium">TIN:</span> {{ $org->tin }}
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mt-2 md:mt-0">
                                                @if($org->is_active)
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
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                                        </svg>
                                                        <span class="font-medium">{{ $org->contact_person }}</span>
                                                    </div>
                                                    @if($org->email)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="truncate">{{ $org->email }}</span>
                                                    </div>
                                                    @endif
                                                    @if($org->phone)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <span>{{ $org->phone }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Location Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Location</h5>
                                                <div class="space-y-1">
                                                    @if($org->city || $org->country)
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span>{{ $org->city }}{{ $org->city && $org->country ? ', ' : '' }}{{ $org->country }}</span>
                                                    </div>
                                                    @endif
                                                    @if($org->website)
                                                    <div class="flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                        </svg>
                                                        <a href="{{ $org->website }}" target="_blank" class="truncate">Website</a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Financial Info -->
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                                    @if($org->type == 'customer') Credit Info
                                                    @elseif($org->type == 'supplier') Payment Terms
                                                    @else Information
                                                    @endif
                                                </h5>
                                                <div class="space-y-1">
                                                    @if($org->type == 'customer')
                                                        <div class="text-sm">
                                                            <div class="text-gray-600">Limit: <span class="font-bold text-gray-900">৳{{ number_format($org->credit_limit, 2) }}</span></div>
                                                            <div class="text-sm {{ $org->outstanding_balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                                Balance: <span class="font-bold">৳{{ number_format($org->outstanding_balance, 2) }}</span>
                                                            </div>
                                                        </div>
                                                    @elseif($org->type == 'supplier' && $org->payment_terms)
                                                        <div class="flex items-center text-sm text-gray-600">
                                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>{{ $org->payment_terms }}</span>
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-gray-500">-</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex-shrink-0">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.organizations.show', $org) }}"
                                               class="p-2 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 hover:from-blue-100 hover:to-blue-200 hover:shadow transition-all duration-200"
                                               title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.organizations.edit', $org) }}"
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
                                                        id="menu-button-{{ $org->id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>
                                                <div class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                                     id="menu-{{ $org->id }}">
                                                    <div class="py-2">
                                                        <a href="{{ route('admin.organizations.show', $org) }}"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            View Details
                                                        </a>
                                                        <a href="#"
                                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                            </svg>
                                                            View Transactions
                                                        </a>
                                                        <div class="border-t border-gray-100 my-1"></div>
                                                        @if($org->is_active)
                                                            <form action="{{ route('admin.organizations.toggle-status', $org) }}" method="POST">
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
                                                            <form action="{{ route('admin.organizations.toggle-status', $org) }}" method="POST">
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
                                                        <form action="{{ route('admin.organizations.destroy', $org) }}" method="POST"
                                                              onsubmit="return confirm('Delete this organization? This action cannot be undone.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="w-full flex items-center px-4 py-3 text-sm text-red-700 hover:bg-red-50 transition-colors duration-200">
                                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Delete Organization
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
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">No organizations found</h3>
                                <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
                                    @if ($type)
                                        Get started by creating your first {{ $type }}.
                                    @else
                                        Start by creating your first organization - companies, customers, or suppliers.
                                    @endif
                                </p>
                                <div class="flex flex-wrap justify-center gap-4">
                                    <a href="{{ route('admin.organizations.create', ['type' => 'company']) }}"
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Create Company
                                    </a>
                                    <a href="{{ route('admin.organizations.create', ['type' => 'customer']) }}"
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Create Customer
                                    </a>
                                    <a href="{{ route('admin.organizations.create', ['type' => 'supplier']) }}"
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-amber-700 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        Create Supplier
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($organizations->hasPages())
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                                    Showing <span class="font-bold">{{ $organizations->firstItem() }}</span> to
                                    <span class="font-bold">{{ $organizations->lastItem() }}</span> of
                                    <span class="font-bold">{{ $organizations->total() }}</span> results
                                </div>
                                <div class="flex space-x-2">
                                    {{ $organizations->links('pagination::tailwind') }}
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
                                    <p class="text-sm text-blue-600 mt-1">Perform actions on selected organizations</p>
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
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-xl p-6">
                <h5 class="modal-title text-xl font-bold">Import Organizations</h5>
                <button type="button" class="btn-close text-white opacity-80 hover:opacity-100" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-6">
                <form action="{{ route('admin.organizations.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
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
                                <label class="block text-sm font-bold text-gray-700 mb-2">Organization Type</label>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        name="type">
                                    <option value="">Auto Detect</option>
                                    <option value="company">Company</option>
                                    <option value="customer">Customer</option>
                                    <option value="supplier">Supplier</option>
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
                                        <a href="{{ asset('templates/organization-template.csv') }}"
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
                                Import Organizations
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
        const searchInput = document.getElementById('searchInput');
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
        const checkboxes = document.querySelectorAll('.organization-checkbox');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (selectAll && checkboxes.length > 0) {
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
                    selectedCount.textContent = `${count} organization${count > 1 ? 's' : ''} selected`;
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
                    if (ids.length > 0 && confirm(`Activate ${ids.length} selected organization${ids.length > 1 ? 's' : ''}?`)) {
                        bulkAction('/admin/organizations/bulk-activate', ids);
                    }
                });
            }

            if (bulkDeactivateBtn) {
                bulkDeactivateBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Deactivate ${ids.length} selected organization${ids.length > 1 ? 's' : ''}?`)) {
                        bulkAction('/admin/organizations/bulk-deactivate', ids);
                    }
                });
            }

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = getSelectedIds();
                    if (ids.length > 0 && confirm(`Delete ${ids.length} selected organization${ids.length > 1 ? 's' : ''}? This action cannot be undone.`)) {
                        bulkAction('/admin/organizations/bulk-delete', ids);
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
