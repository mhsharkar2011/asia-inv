<nav class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo/Header -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br
                @if(Auth::user()->hasRole('super-admin')) from-red-600 to-pink-700
                @elseif(Auth::user()->hasRole('admin')) from-blue-600 to-blue-700
                @elseif(Auth::user()->hasRole('inventory-manager')) from-green-600 to-green-700
                @elseif(Auth::user()->hasRole('sales-person')) from-purple-600 to-purple-700
                @else from-gray-600 to-gray-700 @endif
                rounded-lg flex items-center justify-center">
                @if(Auth::user()->hasRole('super-admin'))
                    <i class="fas fa-crown text-white text-sm"></i>
                @elseif(Auth::user()->hasRole('admin'))
                    <i class="fas fa-shield-alt text-white text-sm"></i>
                @else
                    <i class="fas fa-box text-white text-sm"></i>
                @endif
            </div>
            <span class="text-lg font-bold text-gray-900">Asia Enterprise</span>
        </div>
    </div>

    <!-- Navigation Items -->
    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-1">
            <!-- Dashboard -->
            @can('view dashboard')
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-colors
                          {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </li>
            @endcan

            <!-- Collapsible Sections -->
            @php
                $sections = [
                    'inventory' => [
                        'title' => 'Inventory',
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'permission' => 'view inventory',
                        'items' => [
                            ['route' => 'inventory.products.index', 'name' => 'Products', 'permission' => 'view products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['route' => 'inventory.categories.index', 'name' => 'Categories', 'permission' => 'view categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                            ['route' => 'inventory.stock.index', 'name' => 'Stock View', 'permission' => 'view stock', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['route' => 'inventory.dashboard', 'name' => 'Inventory Dashboard', 'permission' => 'manage inventory', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ]
                    ],
                    'purchase' => [
                        'title' => 'Purchase',
                        'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'permission' => 'view purchases',
                        'items' => [
                            ['route' => 'admin.companies.index', 'name' => 'Suppliers', 'permission' => 'view suppliers', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'purchases.index', 'name' => 'Purchase Orders', 'permission' => 'view purchase orders', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['route' => 'purchases.create', 'name' => 'New Purchase', 'permission' => 'create purchases', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                        ]
                    ],
                    'sales' => [
                        'title' => 'Sales',
                        'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                        'permission' => 'view sales',
                        'items' => [
                            ['route' => 'admin.companies.index', 'name' => 'Customers', 'permission' => 'view customers', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01'],
                            ['route' => 'sales.index', 'name' => 'Sales Orders', 'permission' => 'view sales orders', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'sales.create', 'name' => 'New Sale', 'permission' => 'create sales', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                            ['route' => 'invoices.index', 'name' => 'Invoices', 'permission' => 'view invoices', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ]
                    ],
                ];
            @endphp

            @foreach($sections as $key => $section)
                @canany([$section['permission'], 'manage ' . $key])
                <li x-data="{ open: {{ request()->is($key . '*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg text-gray-700 hover:bg-gray-100 transition-colors mt-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}" />
                            </svg>
                            <span class="font-medium">{{ $section['title'] }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-90': open }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        @foreach($section['items'] as $item)
                            @can($item['permission'])
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                      {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'text-blue-600' : 'text-gray-500' }}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </a>
                            @endcan
                        @endforeach
                    </div>
                </li>
                @endcanany
            @endforeach

            <!-- Reports Section -->
            @canany(['view reports', 'generate reports', 'view financial reports'])
            <li x-data="{ open: {{ request()->is('reports*') ? 'true' : 'false' }} }" class="mt-4">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-medium">Reports</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-90': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    @can('view inventory reports')
                    <a href="{{ route('reports.inventory') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                              {{ request()->is('reports/inventory*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-3 {{ request()->is('reports/inventory*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Inventory Reports
                    </a>
                    @endcan

                    @can('view sales reports')
                    <a href="{{ route('reports.sales') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                              {{ request()->is('reports/sales*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-3 {{ request()->is('reports/sales*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Sales Reports
                    </a>
                    @endcan

                    @can('view purchase reports')
                    <a href="{{ route('reports.purchases') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                              {{ request()->is('reports/purchases*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-3 {{ request()->is('reports/purchases*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Purchase Reports
                    </a>
                    @endcan

                    @can('view financial reports')
                    <a href="{{ route('reports.financial') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                              {{ request()->is('reports/financial*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-4 h-4 mr-3 {{ request()->is('reports/financial*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Financial Reports
                    </a>
                    @endcan

                    @can('generate reports')
                    <div class="pt-1 mt-1 border-t border-gray-100">
                        <a href="{{ route('reports.generate') }}"
                           class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors text-green-600 hover:bg-green-50">
                            <svg class="w-4 h-4 mr-3 text-green-600"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Generate Report
                        </a>
                    </div>
                    @endcan
                </div>
            </li>
            @endcanany

            <!-- Administration Section - For Super Admin and Admin -->
            @if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin'))
                @php
                    $adminItems = [
                        ['route' => 'admin.users.index', 'name' => 'User Management', 'permission' => 'manage users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01'],
                        ['route' => 'admin.companies.index', 'name' => 'Companies', 'permission' => 'manage companies', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['route' => 'admin.roles.index', 'name' => 'Roles & Permissions', 'permission' => 'manage roles', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ];

                    // Super Admin Only Items
                    $superAdminItems = [
                        ['route' => 'admin.audit-logs.index', 'name' => 'Audit Logs', 'permission' => 'view audit logs', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                        ['route' => 'admin.settings.index', 'name' => 'System Settings', 'permission' => 'manage settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['route' => 'admin.backup.index', 'name' => 'Database Backup', 'permission' => 'backup database', 'icon' => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10'],
                    ];
                @endphp

                <li x-data="{ open: {{ request()->is('admin*') ? 'true' : 'false' }} }" class="mt-4">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg transition-colors
                                   @if(Auth::user()->hasRole('super-admin')) text-red-700 hover:bg-red-50
                                   @else text-gray-700 hover:bg-gray-100 @endif">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 @if(Auth::user()->hasRole('super-admin')) text-red-600 @else text-gray-500 @endif"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium">
                                @if(Auth::user()->hasRole('super-admin'))
                                    Super Admin
                                @else
                                    Administration
                                @endif
                            </span>
                        </div>
                        <svg class="w-4 h-4 transition-transform @if(Auth::user()->hasRole('super-admin')) text-red-500 @else text-gray-500 @endif"
                             :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <!-- Admin Items (Both Admin & Super Admin) -->
                        @foreach($adminItems as $item)
                            @can($item['permission'])
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                      {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'text-blue-600' : 'text-gray-500' }}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </a>
                            @endcan
                        @endforeach

                        <!-- Super Admin Only Items -->
                        @if(Auth::user()->hasRole('super-admin'))
                            <div class="pt-1 mt-1 border-t border-red-100">
                                <div class="px-3 py-1">
                                    <span class="text-xs font-semibold text-red-600">SUPER ADMIN ONLY</span>
                                </div>
                                @foreach($superAdminItems as $item)
                                    @can($item['permission'])
                                    <a href="{{ route($item['route']) }}"
                                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-3 text-red-600"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                        </svg>
                                        {{ $item['name'] }}
                                    </a>
                                    @endcan
                                @endforeach

                                <!-- Super Admin Panel -->
                                <a href="{{ route('admin.super.dashboard') }}"
                                   class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors bg-red-50 text-red-700 hover:bg-red-100">
                                    <svg class="w-4 h-4 mr-3 text-red-600"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    Super Admin Panel
                                </a>
                            </div>
                        @endif
                    </div>
                </li>
            @endif

            <!-- Quick Actions for Managers -->
            @canany(['manage inventory', 'manage purchases', 'manage sales'])
            <div class="mt-4 px-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Quick Actions</h3>
                <div class="space-y-1">
                    @can('create purchases')
                    <a href="{{ route('purchases.create') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg bg-green-50 text-green-700 hover:bg-green-100">
                        <svg class="w-4 h-4 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        New Purchase Order
                    </a>
                    @endcan

                    @can('create sales')
                    <a href="{{ route('sales.create') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100">
                        <svg class="w-4 h-4 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        New Sales Order
                    </a>
                    @endcan

                    @can('add products')
                    <a href="{{ route('inventory.products.create') }}"
                       class="flex items-center px-3 py-2 text-sm rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100">
                        <svg class="w-4 h-4 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Product
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany
        </ul>
    </div>

    <!-- Footer/User Info -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-gradient-to-br
                    @if(Auth::user()->hasRole('super-admin')) from-red-500 to-pink-600
                    @elseif(Auth::user()->hasRole('admin')) from-blue-500 to-blue-600
                    @elseif(Auth::user()->hasRole('inventory-manager')) from-green-500 to-green-600
                    @elseif(Auth::user()->hasRole('sales-person')) from-purple-500 to-purple-600
                    @elseif(Auth::user()->hasRole('purchase-manager')) from-yellow-500 to-yellow-600
                    @else from-gray-500 to-gray-600 @endif
                    rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                <div class="flex flex-wrap gap-1 mt-1">
                    @foreach(Auth::user()->roles as $role)
                    <span class="text-xs px-2 py-0.5 rounded-full
                        @if($role->name == 'super-admin') bg-red-100 text-red-800
                        @elseif($role->name == 'admin') bg-blue-100 text-blue-800
                        @elseif($role->name == 'inventory-manager') bg-green-100 text-green-800
                        @elseif($role->name == 'sales-person') bg-purple-100 text-purple-800
                        @elseif($role->name == 'purchase-manager') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($role->name) }}
                    </span>
                    @endforeach
                    @if(Auth::user()->hasRole('super-admin'))
                    <span class="text-xs px-2 py-0.5 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-full animate-pulse">
                        ⚡ SUPER ADMIN
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('profile.edit') }}"
               class="block w-full text-center px-3 py-2 text-sm rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                <i class="fas fa-user-cog mr-2"></i>
                Profile Settings
            </a>
        </div>
    </div>
</nav>
