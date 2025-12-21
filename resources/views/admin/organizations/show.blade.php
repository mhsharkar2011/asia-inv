@extends('layouts.admin')

@section('title', $organization->name)

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-3 lg:px-8">
            <!-- Header -->
            <div class="mb-3">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                    <div class="mb-3 md:mb-0">
                        <div class="flex items-start space-x-4">
                            <div
                                class="p-4 rounded-2xl bg-gradient-to-br
                            @if ($organization->type == 'company') from-blue-500 to-blue-600
                            @elseif($organization->type == 'customer') from-green-500 to-green-600
                            @else from-amber-500 to-amber-600 @endif shadow-lg">
                                @if ($organization->type == 'company')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                @elseif($organization->type == 'customer')
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center flex-wrap gap-2 mb-2">
                                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $organization->name }}</h1>
                                    <span
                                        class="px-3 py-1 text-sm font-bold rounded-full
                                    @if ($organization->type == 'company') bg-blue-100 text-blue-800
                                    @elseif($organization->type == 'customer') bg-green-100 text-green-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                        {{ ucfirst($organization->type) }}
                                    </span>
                                    @if ($organization->is_active)
                                        <span
                                            class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-red-100 to-red-200 text-red-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4 text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                        <span class="font-medium">Code: {{ $organization->code }}</span>
                                    </div>
                                    @if ($organization->sub_type)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <span>{{ ucfirst($organization->sub_type) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.organizations.edit', $organization) }}"
                            class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-amber-600 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Organization
                        </a>
                        <a href="{{ route('admin.organizations.index', ['type' => $organization->type]) }}"
                            class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Contact & Address Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Contact Card -->
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 mr-3">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Contact Information</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Contact Person</p>
                                        <p class="font-semibold text-gray-900">{{ $organization->contact_person ?? 'N/A' }}
                                        </p>
                                    </div>

                                    @if ($organization->email)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-500">Email</p>
                                                <a href="mailto:{{ $organization->email }}"
                                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                                                    {{ $organization->email }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($organization->phone)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-500">Phone</p>
                                                <a href="tel:{{ $organization->phone }}"
                                                    class="text-gray-900 font-medium hover:text-blue-600 transition-colors duration-200">
                                                    {{ $organization->phone }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($organization->mobile)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-500">Mobile</p>
                                                <a href="tel:{{ $organization->mobile }}"
                                                    class="text-gray-900 font-medium hover:text-blue-600 transition-colors duration-200">
                                                    {{ $organization->mobile }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($organization->website)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-500">Website</p>
                                                <a href="{{ $organization->website }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                                                    {{ $organization->website }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Address Card -->
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-green-100 to-green-200 mr-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Address Information</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @if ($organization->address)
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 mb-1">Address</p>
                                            <p class="font-semibold text-gray-900">{{ $organization->address }}</p>
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-2 gap-4">
                                        @if ($organization->city)
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 mb-1">City</p>
                                                <p class="font-semibold text-gray-900">{{ $organization->city }}</p>
                                            </div>
                                        @endif

                                        @if ($organization->district)
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 mb-1">District</p>
                                                <p class="font-semibold text-gray-900">{{ $organization->district }}</p>
                                            </div>
                                        @endif

                                        @if ($organization->country)
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 mb-1">Country</p>
                                                <p class="font-semibold text-gray-900">{{ $organization->country }}</p>
                                            </div>
                                        @endif

                                        @if ($organization->postal_code)
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 mb-1">Postal Code</p>
                                                <p class="font-semibold text-gray-900">{{ $organization->postal_code }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($organization->latitude && $organization->longitude)
                                        <div class="pt-4">
                                            <a href="https://maps.google.com/?q={{ $organization->latitude }},{{ $organization->longitude }}"
                                                target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 font-medium rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                                </svg>
                                                View on Map
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-6">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg bg-gradient-to-br from-amber-100 to-amber-200 mr-3">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Financial Information</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <!-- Tax Information -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                    <p class="text-sm font-medium text-gray-500 mb-2">TIN Number</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $organization->tin ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                    <p class="text-sm font-medium text-gray-500 mb-2">BIN Number</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $organization->bin ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4">
                                    <p class="text-sm font-medium text-gray-500 mb-2">Trade License</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $organization->trade_license ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Type-specific Financial Info -->
                            @if ($organization->type == 'customer')
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-md font-bold text-gray-900 mb-4">Credit Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5">
                                            <p class="text-sm font-medium text-gray-500 mb-2">Credit Limit</p>
                                            <p class="text-2xl font-bold text-blue-600">
                                                ৳{{ number_format($organization->credit_limit, 2) }}
                                            </p>
                                        </div>
                                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5">
                                            <p class="text-sm font-medium text-gray-500 mb-2">Outstanding Balance</p>
                                            <p
                                                class="text-2xl font-bold {{ $organization->outstanding_balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                                ৳{{ number_format($organization->outstanding_balance, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($organization->type == 'supplier' && $organization->payment_terms)
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-md font-bold text-gray-900 mb-4">Payment Terms</h4>
                                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-5">
                                        <p class="text-lg font-bold text-amber-700">{{ $organization->payment_terms }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if ($organization->description || $organization->notes)
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                            <div class="px-6 py-5 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Additional Information</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                @if ($organization->description)
                                    <div class="mb-6">
                                        <p class="text-sm font-medium text-gray-500 mb-3">Description</p>
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <p class="text-gray-700 leading-relaxed">{{ $organization->description }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($organization->notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-3">Notes</p>
                                        <div class="bg-amber-50 rounded-xl p-4">
                                            <p class="text-amber-800 leading-relaxed">{{ $organization->notes }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif


                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Quick Stats</h3>
                        </div>
                        <div class="p-3">
                            <div class="grid grid-cols-4 gap-4">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-blue-600 mb-1">{{ $organization->transaction ?? '0' }}</p>
                                    <p class="text-sm font-medium text-gray-500">Transactions</p>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-green-600 mb-1">৳{{ $totalValue }}</p>
                                    <p class="text-sm font-medium text-gray-500">Total Value</p>
                                </div>
                                <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-amber-600 mb-1">{{ $order }}</p>
                                    <p class="text-sm font-medium text-gray-500">Orders</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                                    <p class="text-2xl font-bold text-purple-600 mb-1">0</p>
                                    <p class="text-sm font-medium text-gray-500">Invoices</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Info Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Status & Information</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Status</span>
                                    @if ($organization->is_active)
                                        <span
                                            class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-sm font-bold rounded-full bg-gradient-to-r from-red-100 to-red-200 text-red-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Created</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $organization->created_at->format('d M Y, h:i A') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Updated</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $organization->updated_at->format('d M Y, h:i A') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Currency</span>
                                    <span class="font-semibold text-gray-900">{{ $organization->currency }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Language</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $organization->language == 'en' ? 'English' : 'Bangla' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-500">Timezone</span>
                                    <span class="font-semibold text-gray-900">{{ $organization->timezone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @if ($organization->is_active)
                                    <form action="{{ route('admin.organizations.toggle-status', $organization) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="group w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 rounded-xl hover:from-amber-100 hover:to-amber-200 hover:shadow transition-all duration-200">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-3 group-hover:rotate-180 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-semibold">Deactivate</span>
                                            </div>
                                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.organizations.toggle-status', $organization) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="group w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-xl hover:from-green-100 hover:to-green-200 hover:shadow transition-all duration-200">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-3 group-hover:rotate-180 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-semibold">Activate</span>
                                            </div>
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                <a href="#"
                                    class="group flex items-center justify-between px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-xl hover:from-blue-100 hover:to-blue-200 hover:shadow transition-all duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="font-semibold">View Transactions</span>
                                    </div>
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                                <a href="#"
                                    class="group flex items-center justify-between px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 rounded-xl hover:from-gray-100 hover:to-gray-200 hover:shadow transition-all duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        <span class="font-semibold">Print Details</span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                                <button
                                    class="group w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-xl hover:from-purple-100 hover:to-purple-200 hover:shadow transition-all duration-200"
                                    data-bs-toggle="modal" data-bs-target="#sendEmailModal">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-semibold">Send Email</span>
                                    </div>
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <form action="{{ route('admin.organizations.destroy', $organization) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this organization? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="group w-full flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-50 to-red-100 text-red-700 rounded-xl hover:from-red-100 hover:to-red-200 hover:shadow transition-all duration-200">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="font-semibold">Delete Organization</span>
                                        </div>
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Email Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-xl p-6">
                    <h5 class="modal-title text-xl font-bold">Send Email to {{ $organization->name }}</h5>
                    <button type="button" class="btn-close text-white opacity-80 hover:opacity-100"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="emailForm">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                                <input type="text"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    placeholder="Email subject" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                                <textarea
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    rows="4" placeholder="Type your message here..." required></textarea>
                            </div>
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4">
                                <div class="flex">
                                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-bold text-blue-800">Email Recipient</p>
                                        <p class="text-sm text-blue-700 mt-1">
                                            @if ($organization->email)
                                                Email will be sent to: <span
                                                    class="font-bold">{{ $organization->email }}</span>
                                            @else
                                                <span class="text-red-600 font-bold">No email address available for this
                                                    organization.</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4 pt-4">
                                <button type="button"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5"
                                    @if (!$organization->email) disabled @endif>
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Send Email
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
            // Email form submission
            const emailForm = document.getElementById('emailForm');
            if (emailForm) {
                emailForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.innerHTML = `
                    <svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Sending...
                `;
                    submitBtn.disabled = true;

                    // Simulate API call
                    setTimeout(() => {
                        // Show success message
                        alert('Email sent successfully!');

                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;

                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'sendEmailModal'));
                        modal.hide();

                        // Reset form
                        emailForm.reset();
                    }, 1500);
                });
            }

            // Confirm delete with sweet alert
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm(
                            'Are you sure you want to delete this organization? This action cannot be undone.'
                            )) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom animations */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Smooth transitions */
        .transition-all {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card hover effects */
        .hover\\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush
