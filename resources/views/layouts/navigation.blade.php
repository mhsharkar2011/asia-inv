<nav x-data="{ open: false, dropdowns: {} }" class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-chart-network text-white text-lg"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                Asia Enterprise
                            </span>
                            <span class="block text-xs text-gray-500 font-medium">Tally Pro</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-1 ml-10">
                    @can('view dashboard')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="relative px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:bg-blue-50 hover:text-blue-600 group">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-tachometer-alt text-gray-400 group-hover:text-blue-500"></i>
                            <span>{{ __('Dashboard') }}</span>
                        </div>
                        @if(request()->routeIs('dashboard'))
                        <div class="absolute -bottom-2 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
                        @endif
                    </x-nav-link>
                    @endcan

                    <!-- Inventory Dropdown -->
                    @canany(['manage inventory', 'view products', 'view categories', 'view suppliers'])
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
                                :class="{ 'text-blue-600 bg-blue-50': open }">
                            <i class="fas fa-boxes text-gray-400 group-hover:text-blue-500"></i>
                            <span>Inventory</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @can('view products')
                            <a href="{{ route('inventory.products.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 group transition-colors {{ request()->routeIs('inventory.products.*') ? 'bg-blue-50 text-blue-600 border-r-3 border-blue-500' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200">
                                    <i class="fas fa-box text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Products</span>
                                    <p class="text-xs text-gray-500">Manage products</p>
                                </div>
                            </a>
                            @endcan

                            @can('view categories')
                            <a href="{{ route('inventory.categories.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-green-50 group transition-colors {{ request()->routeIs('inventory.categories.*') ? 'bg-green-50 text-green-600 border-r-3 border-green-500' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200">
                                    <i class="fas fa-tags text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Categories</span>
                                    <p class="text-xs text-gray-500">Product categories</p>
                                </div>
                            </a>
                            @endcan

                            @can('view suppliers')
                            <a href="{{ route('purchase.suppliers.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 group transition-colors {{ request()->routeIs('inventory.suppliers.*') ? 'bg-purple-50 text-purple-600 border-r-3 border-purple-500' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200">
                                    <i class="fas fa-truck text-purple-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Suppliers</span>
                                    <p class="text-xs text-gray-500">Manage suppliers</p>
                                </div>
                            </a>
                            @endcan

                            @can('view purchases')
                            <a href="{{ route('purchases.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-amber-50 group transition-colors {{ request()->routeIs('purchases.*') ? 'bg-amber-50 text-amber-600 border-r-3 border-amber-500' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200">
                                    <i class="fas fa-shopping-cart text-amber-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Purchases</span>
                                    <p class="text-xs text-gray-500">Purchase orders</p>
                                </div>
                            </a>
                            @endcan

                            @can('view sales')
                            <a href="{{ route('sales.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 group transition-colors {{ request()->routeIs('sales.*') ? 'bg-emerald-50 text-emerald-600 border-r-3 border-emerald-500' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200">
                                    <i class="fas fa-chart-line text-emerald-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Sales</span>
                                    <p class="text-xs text-gray-500">Sales orders</p>
                                </div>
                            </a>
                            @endcan

                            @can('manage inventory')
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="{{ route('inventory.dashboard') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 group transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-chart-pie text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-blue-600">Inventory Dashboard</span>
                                        <p class="text-xs text-blue-500">Analytics & insights</p>
                                    </div>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    <!-- Reports Dropdown -->
                    @canany(['view reports', 'generate reports', 'view financial reports'])
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200 group"
                                :class="{ 'text-emerald-600 bg-emerald-50': open }">
                            <i class="fas fa-chart-bar text-gray-400 group-hover:text-emerald-500"></i>
                            <span>Reports</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @can('view inventory reports')
                            <a href="{{ route('reports.inventory') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 group transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-cubes text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Inventory Report</span>
                                    <p class="text-xs text-gray-500">Stock analysis</p>
                                </div>
                            </a>
                            @endcan

                            @can('view sales reports')
                            <a href="{{ route('reports.sales') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 group transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-chart-line text-emerald-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Sales Report</span>
                                    <p class="text-xs text-gray-500">Sales performance</p>
                                </div>
                            </a>
                            @endcan

                            @can('view purchase reports')
                            <a href="{{ route('reports.purchases') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-amber-50 group transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-amber-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Purchase Report</span>
                                    <p class="text-xs text-gray-500">Procurement analysis</p>
                                </div>
                            </a>
                            @endcan

                            @can('view financial reports')
                            <a href="{{ route('reports.financial') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 group transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-coins text-purple-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Financial Report</span>
                                    <p class="text-xs text-gray-500">Financial insights</p>
                                </div>
                            </a>
                            @endcan

                            @can('generate reports')
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="{{ route('reports.generate') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-emerald-100 group transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                        <i class="fas fa-file-export text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-emerald-600">Generate Report</span>
                                        <p class="text-xs text-emerald-500">Custom reports</p>
                                    </div>
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    @endcanany

                    <!-- Admin Menu -->
                    @if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin'))
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200 group"
                                :class="Auth::user()->hasRole('super-admin')
                                    ? 'text-rose-600 hover:text-rose-700 hover:bg-rose-50'
                                    : 'text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50'"
                                :class="{ 'bg-rose-50': open && Auth::user()->hasRole('super-admin'),
                                         'bg-indigo-50': open && Auth::user()->hasRole('admin') }">
                            <i class="fas fa-crown text-rose-500" x-show="Auth::user()->hasRole('super-admin')"></i>
                            <i class="fas fa-shield-alt text-indigo-500" x-show="!Auth::user()->hasRole('super-admin')"></i>
                            <span x-text="Auth::user()->hasRole('super-admin') ? 'Super Admin' : 'Admin'"></span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute top-full left-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                             :class="Auth::user()->hasRole('super-admin') ? 'border-rose-100' : 'border-indigo-100'">

                            <!-- Admin Items -->
                            <div class="px-3 py-2">
                                <span class="text-xs font-semibold uppercase text-gray-500 tracking-wider">Administration</span>
                            </div>

                            @can('manage users')
                            <a href="{{ route('admin.users.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 group transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">User Management</span>
                                    <p class="text-xs text-gray-500">Manage system users</p>
                                </div>
                            </a>
                            @endcan

                            @can('manage companies')
                            <a href="{{ route('admin.companies.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-indigo-50 group transition-colors {{ request()->routeIs('admin.companies.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-building text-indigo-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Companies</span>
                                    <p class="text-xs text-gray-500">Manage companies</p>
                                </div>
                            </a>
                            @endcan

                            @can('manage roles')
                            <a href="{{ route('admin.roles.index') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 group transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700' }}">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-user-lock text-purple-600 text-sm"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Roles & Permissions</span>
                                    <p class="text-xs text-gray-500">Access control</p>
                                </div>
                            </a>
                            @endcan

                            <!-- Super Admin Only Section -->
                            @if(Auth::user()->hasRole('super-admin'))
                            <div class="border-t border-rose-100 mt-2 pt-2">
                                <div class="px-3 py-2">
                                    <span class="text-xs font-semibold uppercase text-rose-600 tracking-wider flex items-center">
                                        <i class="fas fa-crown mr-2"></i> Super Admin Only
                                    </span>
                                </div>

                                @can('view audit logs')
                                <a href="{{ route('admin.audit-logs.index') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-rose-50 group transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center">
                                        <i class="fas fa-history text-rose-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium">Audit Logs</span>
                                        <p class="text-xs text-gray-500">System activity</p>
                                    </div>
                                </a>
                                @endcan

                                @can('manage settings')
                                <a href="{{ route('admin.settings.index') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-amber-50 group transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                        <i class="fas fa-cog text-amber-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium">System Settings</span>
                                        <p class="text-xs text-gray-500">Configure system</p>
                                    </div>
                                </a>
                                @endcan

                                @can('backup database')
                                <a href="{{ route('admin.backup.index') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 group transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                        <i class="fas fa-database text-emerald-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium">Database Backup</span>
                                        <p class="text-xs text-gray-500">Data protection</p>
                                    </div>
                                </a>
                                @endcan

                                <a href="{{ route('admin.super.dashboard') }}"
                                   class="flex items-center space-x-3 px-4 py-3 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 group transition-colors mt-2">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center">
                                        <i class="fas fa-star text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium text-rose-600">Super Admin Panel</span>
                                        <p class="text-xs text-rose-500">Full system control</p>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-3">
                <!-- Search Button -->
                <button @click="$dispatch('open-search')"
                        class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors group">
                    <i class="fas fa-search text-gray-400 group-hover:text-gray-600"></i>
                    <span class="text-gray-500 text-sm">Search...</span>
                    <kbd class="text-xs bg-white border border-gray-200 rounded px-1.5 py-0.5 text-gray-500">Ctrl+K</kbd>
                </button>

                <!-- Notifications -->
                @can('view notifications')
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="relative p-2.5 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                        <i class="fas fa-bell text-gray-400 group-hover:text-gray-600"></i>
                        @if($unreadNotificationsCount = Auth::user()->unreadNotifications()->count())
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-rose-500 to-pink-600 text-white text-xs rounded-full flex items-center justify-center animate-pulse">
                            {{ $unreadNotificationsCount }}
                        </span>
                        @endif
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900">Notifications</h3>
                                @if($unreadNotificationsCount)
                                <span class="px-2 py-1 text-xs bg-gradient-to-r from-rose-50 to-pink-50 text-rose-600 rounded-full">
                                    {{ $unreadNotificationsCount }} new
                                </span>
                                @endif
                            </div>
                        </div>

                        @if($unreadNotificationsCount)
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Notification items -->
                        </div>
                        <div class="px-4 py-3 border-t border-gray-100">
                            <a href="{{ route('notifications.index') }}"
                               class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center justify-center">
                                View all notifications
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                        @else
                        <div class="px-4 py-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-bell text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">No new notifications</p>
                            <p class="text-sm text-gray-400 mt-1">You're all caught up!</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endcan

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-3 p-1.5 rounded-xl hover:bg-gray-50 transition-colors group">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br
                                @if(Auth::user()->hasRole('super-admin')) from-rose-500 to-pink-600
                                @elseif(Auth::user()->hasRole('admin')) from-blue-500 to-blue-600
                                @elseif(Auth::user()->hasRole('inventory-manager')) from-emerald-500 to-emerald-600
                                @elseif(Auth::user()->hasRole('sales-person')) from-purple-500 to-purple-600
                                @else from-gray-500 to-gray-600 @endif
                                flex items-center justify-center text-white font-bold shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            @if(Auth::user()->hasRole('super-admin'))
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full border-2 border-white flex items-center justify-center">
                                <i class="fas fa-crown text-white text-xs"></i>
                            </div>
                            @endif
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">

                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br
                                    @if(Auth::user()->hasRole('super-admin')) from-rose-500 to-pink-600
                                    @elseif(Auth::user()->hasRole('admin')) from-blue-500 to-blue-600
                                    @elseif(Auth::user()->hasRole('inventory-manager')) from-emerald-500 to-emerald-600
                                    @elseif(Auth::user()->hasRole('sales-person')) from-purple-500 to-purple-600
                                    @else from-gray-500 to-gray-600 @endif
                                    flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach(Auth::user()->roles as $role)
                                        <span class="text-xs px-2 py-0.5 rounded-full
                                            @if($role->name == 'super-admin') bg-gradient-to-r from-rose-50 to-pink-50 text-rose-700
                                            @elseif($role->name == 'admin') bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700
                                            @elseif($role->name == 'inventory-manager') bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700
                                            @elseif($role->name == 'sales-person') bg-gradient-to-r from-purple-50 to-violet-50 text-purple-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200">
                                    <i class="fas fa-user-cog text-gray-600"></i>
                                </div>
                                <span class="font-medium text-gray-700">Profile Settings</span>
                            </a>

                            @if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200">
                                    <i class="fas fa-shield-alt text-blue-600"></i>
                                </div>
                                <span class="font-medium text-gray-700">Admin Panel</span>
                            </a>
                            @endif

                            @if(Auth::user()->hasRole('super-admin'))
                            <a href="{{ route('admin.super.dashboard') }}"
                               class="flex items-center space-x-3 px-4 py-3 hover:bg-rose-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                    <i class="fas fa-crown text-rose-600"></i>
                                </div>
                                <span class="font-medium text-rose-600">Super Admin Panel</span>
                            </a>
                            @endif
                        </div>

                        <!-- Logout -->
                        <div class="border-t border-gray-100 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center space-x-3 w-full px-4 py-3 hover:bg-gray-50 transition-colors text-left group">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200">
                                        <i class="fas fa-sign-out-alt text-gray-600"></i>
                                    </div>
                                    <span class="font-medium text-gray-700">Log Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open"
                        class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-gray-600 text-lg" x-show="!open"></i>
                    <i class="fas fa-times text-gray-600 text-lg" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-3 space-y-1">
            <!-- Mobile Search -->
            <div class="mb-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Search...">
                </div>
            </div>

            @can('view dashboard')
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-tachometer-alt text-blue-600"></i>
                </div>
                <div>
                    <span class="font-medium">Dashboard</span>
                    <p class="text-sm text-gray-500">Overview & analytics</p>
                </div>
            </a>
            @endcan

            <!-- Mobile Inventory Section -->
            @canany(['manage inventory', 'view products', 'view categories', 'view suppliers'])
            <div class="border-t border-gray-100 pt-3">
                <h3 class="text-xs font-semibold uppercase text-gray-500 tracking-wider px-4 mb-2">Inventory</h3>
                <div class="space-y-1">
                    @can('view products')
                    <a href="{{ route('inventory.products.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors {{ request()->routeIs('inventory.products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Products</span>
                    </a>
                    @endcan

                    @can('view categories')
                    <a href="{{ route('inventory.categories.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-50 transition-colors {{ request()->routeIs('inventory.categories.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-700' }}">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-tags text-emerald-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Categories</span>
                    </a>
                    @endcan

                    @can('view suppliers')
                    <a href="{{ route('purchase.suppliers.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-purple-50 transition-colors {{ request()->routeIs('inventory.suppliers.*') ? 'bg-purple-50 text-purple-600' : 'text-gray-700' }}">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-truck text-purple-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Suppliers</span>
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Mobile Reports Section -->
            @canany(['view reports', 'generate reports'])
            <div class="border-t border-gray-100 pt-3">
                <h3 class="text-xs font-semibold uppercase text-gray-500 tracking-wider px-4 mb-2">Reports</h3>
                <div class="space-y-1">
                    @can('view inventory reports')
                    <a href="{{ route('reports.inventory') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-cubes text-blue-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Inventory Report</span>
                    </a>
                    @endcan

                    @can('view sales reports')
                    <a href="{{ route('reports.sales') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-chart-line text-emerald-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Sales Report</span>
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Mobile Admin Section -->
            @if(Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('admin'))
            <div class="border-t border-gray-100 pt-3">
                <h3 class="text-xs font-semibold uppercase tracking-wider px-4 mb-2
                    {{ Auth::user()->hasRole('super-admin') ? 'text-rose-600' : 'text-indigo-600' }}">
                    <i class="fas fa-crown mr-1" x-show="Auth::user()->hasRole('super-admin')"></i>
                    <i class="fas fa-shield-alt mr-1" x-show="!Auth::user()->hasRole('super-admin')"></i>
                    Administration
                </h3>
                <div class="space-y-1">
                    @can('manage users')
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Users</span>
                    </a>
                    @endcan

                    @can('manage companies')
                    <a href="{{ route('admin.companies.index') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-indigo-50 transition-colors {{ request()->routeIs('admin.companies.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-building text-indigo-600 text-sm"></i>
                        </div>
                        <span class="font-medium">Companies</span>
                    </a>
                    @endcan

                    @if(Auth::user()->hasRole('super-admin'))
                    <a href="{{ route('admin.super.dashboard') }}"
                       class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-rose-50 to-pink-50 border border-rose-100">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center">
                            <i class="fas fa-star text-white text-sm"></i>
                        </div>
                        <span class="font-medium text-rose-600">Super Admin</span>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</nav>
