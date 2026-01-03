<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @can('view dashboard')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @endcan

                    <!-- Inventory Management -->
                    @hasanyrole(['super-admin', 'admin', 'inventory-manager'])
                    @canany(['view products', 'view categories', 'view suppliers', 'manage inventory'])
                    <div class="relative group" x-data="{ inventoryOpen: false }">
                        <button @click="inventoryOpen = !inventoryOpen"
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            Inventory
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="inventoryOpen"
                             @click.away="inventoryOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                @can('view products')
                                <a href="{{ route('inventory.products.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('inventory.products.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Products
                                </a>
                                @endcan

                                @can('view categories')
                                <a href="{{ route('inventory.categories.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('inventory.categories.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Categories
                                </a>
                                @endcan

                                @can('view suppliers')
                                <a href="{{ route('inventory.suppliers.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('inventory.suppliers.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Suppliers
                                </a>
                                @endcan

                                @can('view purchases')
                                <a href="{{ route('purchases.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('purchases.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Purchases
                                </a>
                                @endcan

                                @can('view sales')
                                <a href="{{ route('sales.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('sales.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Sales
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endcanany
                    @endhasanyrole

                    <!-- Reports -->
                    @canany(['view reports', 'view financial reports'])
                    <div class="relative group" x-data="{ reportsOpen: false }">
                        <button @click="reportsOpen = !reportsOpen"
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            Reports
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="reportsOpen"
                             @click.away="reportsOpen = false"
                             class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                @can('view inventory reports')
                                <a href="{{ route('reports.inventory') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Inventory Report
                                </a>
                                @endcan

                                @can('view sales reports')
                                <a href="{{ route('reports.sales') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Sales Report
                                </a>
                                @endcan

                                @can('view purchase reports')
                                <a href="{{ route('reports.purchases') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Purchase Report
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endcanany

                    <!-- Admin Menu -->
                    @hasanyrole(['super-admin', 'admin'])
                    <div class="relative group" x-data="{ adminOpen: false }">
                        <button @click="adminOpen = !adminOpen"
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="adminOpen"
                             @click.away="adminOpen = false"
                             class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                @can('view users')
                                <a href="{{ route('admin.users.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('admin.users.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    User Management
                                </a>
                                @endcan

                                @can('view roles')
                                <a href="{{ route('admin.roles.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-50 text-gray-900' : '' }}">
                                    Roles & Permissions
                                </a>
                                @endcan

                                @can('view audit logs')
                                <a href="{{ route('admin.audit-logs.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    Audit Logs
                                </a>
                                @endcan

                                @can('view system settings')
                                <a href="{{ route('admin.settings.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    System Settings
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endhasanyrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notifications -->
                @hasanyrole(['super-admin', 'admin', 'inventory-manager'])
                @can('view notifications')
                <div class="relative mr-3" x-data="{ notificationsOpen: false }">
                    <button @click="notificationsOpen = !notificationsOpen"
                            class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-red-400"></span>
                    </button>

                    <div x-show="notificationsOpen"
                         @click.away="notificationsOpen = false"
                         class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <!-- Notification items would go here -->
                            <div class="px-4 py-3 text-sm text-gray-500">
                                No new notifications
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                @endhasanyrole

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold mr-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User Info -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()?->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ Auth::user()?->email }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs text-gray-500 capitalize">
                                    {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                                </span>
                                @hasanyrole('super-admin|admin')
                                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Admin</span>
                                @endhasanyrole
                                @hasrole('inventory-manager')
                                <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Inventory Manager</span>
                                @endhasrole
                                @hasrole('sales-person')
                                <span class="ml-2 px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">Sales</span>
                                @endhasrole
                            </div>
                        </div>

                        <!-- Profile -->
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Switch to Admin Panel -->
                        @hasanyrole(['super-admin', 'admin'])
                        <x-dropdown-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Admin Panel') }}
                        </x-dropdown-link>
                        @endhasanyrole

                        <!-- Divider -->
                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @can('view dashboard')
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endcan

            <!-- Inventory Menu (Mobile) -->
            @hasanyrole(['super-admin', 'admin', 'inventory-manager'])
            @canany(['view products', 'view categories', 'view suppliers', 'manage inventory'])
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Inventory</h3>
                <div class="space-y-1">
                    @can('view products')
                    <x-responsive-nav-link :href="route('inventory.products.index')" :active="request()->routeIs('inventory.products.*')">
                        {{ __('Products') }}
                    </x-responsive-nav-link>
                    @endcan

                    @can('view categories')
                    <x-responsive-nav-link :href="route('inventory.categories.index')" :active="request()->routeIs('inventory.categories.*')">
                        {{ __('Categories') }}
                    </x-responsive-nav-link>
                    @endcan

                    @can('view suppliers')
                    <x-responsive-nav-link :href="route('inventory.suppliers.index')" :active="request()->routeIs('inventory.suppliers.*')">
                        {{ __('Suppliers') }}
                    </x-responsive-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany
            @endhasanyrole

            <!-- Reports Menu (Mobile) -->
            @canany(['view reports', 'view financial reports'])
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Reports</h3>
                <div class="space-y-1">
                    @can('view inventory reports')
                    <x-responsive-nav-link :href="route('reports.inventory')">
                        {{ __('Inventory Report') }}
                    </x-responsive-nav-link>
                    @endcan

                    @can('view sales reports')
                    <x-responsive-nav-link :href="route('reports.sales')">
                        {{ __('Sales Report') }}
                    </x-responsive-nav-link>
                    @endcan
                </div>
            </div>
            @endcanany

            <!-- Admin Menu (Mobile) -->
            @hasanyrole(['super-admin', 'admin'])
            <div class="px-4 py-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Admin</h3>
                <div class="space-y-1">
                    @can('view users')
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                    @endcan

                    @can('view roles')
                    <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        {{ __('Roles & Permissions') }}
                    </x-responsive-nav-link>
                    @endcan

                    @can('view system settings')
                    <x-responsive-nav-link :href="route('admin.settings.index')">
                        {{ __('Settings') }}
                    </x-responsive-nav-link>
                    @endcan
                </div>
            </div>
            @endhasanyrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold mr-3">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        <div class="text-xs text-gray-600 mt-1">
                            Role: {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
                            @hasanyrole('super-admin|admin')
                            <span class="ml-2 px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full">Admin</span>
                            @endhasanyrole
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @hasanyrole(['super-admin', 'admin'])
                <x-responsive-nav-link :href="route('admin.dashboard')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
                @endhasanyrole

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
