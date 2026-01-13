<nav x-data="{ open: false, dropdowns: {} }" class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-chart-network text-white text-lg"></i>
                        </div>
                        <div>
                            <span
                                class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                                Asia Enterprise
                            </span>
                            <span class="block text-xs text-gray-500 font-medium">Tally Pro</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation - ONLY FOR AUTHENTICATED USERS -->
                @auth
                    <div class="hidden md:flex items-center space-x-1 ml-10">
                        @if (auth()->user()->can('view dashboard') || auth()->user()->hasRole(['admin', 'super-admin']))
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="relative px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:bg-blue-50 hover:text-blue-600 group">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-tachometer-alt text-gray-400 group-hover:text-blue-500"></i>
                                    <span>{{ __('Dashboard') }}</span>
                                </div>
                                @if (request()->routeIs('dashboard'))
                                    <div
                                        class="absolute -bottom-2 left-0 right-0 h-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full">
                                    </div>
                                @endif
                            </x-nav-link>
                        @endif

                        <!-- Inventory Dropdown -->
                        @if (auth()->user()->canAny([
                                'manage inventory',
                                'view products',
                                'view categories',
                                'view suppliers',
                                'view purchases',
                                'view sales',
                            ]) || auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager', 'sales-person']))
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group"
                                    :class="{ 'text-blue-600 bg-blue-50': open }">
                                    <i class="fas fa-boxes text-gray-400 group-hover:text-blue-500"></i>
                                    <span>Inventory</span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                    @if (auth()->user()->can('view products') ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager', 'sales-person']))
                                        <a href="{{ route('inventory.products.index') }}"
                                            class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-50 group transition-colors {{ request()->routeIs('inventory.products.*') ? 'bg-blue-50 text-blue-600 border-r-3 border-blue-500' : 'text-gray-700' }}">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200">
                                                <i class="fas fa-box text-blue-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-medium">Products</span>
                                                <p class="text-xs text-gray-500">Manage products</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->can('view categories') || auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager']))
                                        <a href="{{ route('inventory.categories.index') }}"
                                            class="flex items-center space-x-3 px-4 py-3 hover:bg-green-50 group transition-colors {{ request()->routeIs('inventory.categories.*') ? 'bg-green-50 text-green-600 border-r-3 border-green-500' : 'text-gray-700' }}">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200">
                                                <i class="fas fa-tags text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-medium">Categories</span>
                                                <p class="text-xs text-gray-500">Product categories</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->can('view suppliers') || auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager']))
                                        <a href="{{ route('purchase.suppliers.index') }}"
                                            class="flex items-center space-x-3 px-4 py-3 hover:bg-purple-50 group transition-colors {{ request()->routeIs('purchase.suppliers.*') ? 'bg-purple-50 text-purple-600 border-r-3 border-purple-500' : 'text-gray-700' }}">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200">
                                                <i class="fas fa-truck text-purple-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-medium">Suppliers</span>
                                                <p class="text-xs text-gray-500">Manage suppliers</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->can('view purchases') || auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager']))
                                        <a href="{{ route('purchase.purchase-orders.index') }}"
                                            class="flex items-center space-x-3 px-4 py-3 hover:bg-amber-50 group transition-colors {{ request()->routeIs('purchases.*') ? 'bg-amber-50 text-amber-600 border-r-3 border-amber-500' : 'text-gray-700' }}">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200">
                                                <i class="fas fa-shopping-cart text-amber-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-medium">Purchases</span>
                                                <p class="text-xs text-gray-500">Purchase orders</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->can('view sales') ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin', 'sales-person', 'inventory-manager']))
                                        <a href="{{ route('sales.sales-orders.index') }}"
                                            class="flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 group transition-colors {{ request()->routeIs('sales.*') ? 'bg-emerald-50 text-emerald-600 border-r-3 border-emerald-500' : 'text-gray-700' }}">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200">
                                                <i class="fas fa-chart-line text-emerald-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="font-medium">Sales</span>
                                                <p class="text-xs text-gray-500">Sales orders</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->can('manage inventory') || auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager']))
                                        <div class="border-t border-gray-100 mt-2 pt-2">
                                            <a href="{{ route('dashboard') }}"
                                                class="flex items-center space-x-3 px-4 py-3 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 group transition-colors">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-chart-pie text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-blue-600">Inventory Dashboard</span>
                                                    <p class="text-xs text-blue-500">Analytics & insights</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Reports Dropdown -->
                        @if (auth()->user()->canAny([
                                'view reports',
                                'generate reports',
                                'view financial reports',
                                'view inventory reports',
                                'view sales reports',
                                'view purchase reports',
                            ]) || auth()->user()->hasAnyRole(['admin', 'super-admin']))
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200 group"
                                    :class="{ 'text-emerald-600 bg-emerald-50': open }">
                                    <i class="fas fa-chart-bar text-gray-400 group-hover:text-emerald-500"></i>
                                    <span>Reports</span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                    <!-- Reports dropdown items (same as before but using auth()->user()) -->
                                </div>
                            </div>
                        @endif

                        <!-- Admin Menu -->
                        @if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin'))
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200 group"
                                    :class="auth()->user()->hasRole('super-admin')
                                                                        ? 'text-rose-600 hover:text-rose-700 hover:bg-rose-50'
                                                                        : 'text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50'"
                                    :class="{ 'bg-rose-50': open && auth()->user()->hasRole('super-admin'),
                                                                             'bg-indigo-50': open && auth()->user()->hasRole('admin') }">
                                    @if (auth()->user()->hasRole('super-admin'))
                                        <i class="fas fa-crown text-rose-500"></i>
                                    @else
                                        <i class="fas fa-shield-alt text-indigo-500"></i>
                                    @endif
                                    <span>{{ auth()->user()->hasRole('super-admin') ? 'Super Admin' : 'Admin' }}</span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    class="absolute top-full left-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50"
                                    :class="auth()->user()->hasRole('super-admin') ? 'border-rose-100' : 'border-indigo-100'">
                                    <!-- Admin dropdown items (same as before but using auth()->user()) -->
                                </div>
                            </div>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Right Section - ONLY FOR AUTHENTICATED USERS -->
            @auth
                <div class="flex items-center space-x-3">
                    <!-- Search Button -->
                    <button @click="$dispatch('open-search')"
                        class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors group">
                        <i class="fas fa-search text-gray-400 group-hover:text-gray-600"></i>
                        <span class="text-gray-500 text-sm">Search...</span>
                        <kbd
                            class="text-xs bg-white border border-gray-200 rounded px-1.5 py-0.5 text-gray-500">Ctrl+K</kbd>
                    </button>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-3 p-1.5 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br
                                    @if (auth()->user()->hasRole('super-admin')) from-rose-500 to-pink-600
                                    @elseif(auth()->user()->hasRole('admin')) from-blue-500 to-blue-600
                                    @elseif(auth()->user()->hasRole('inventory-manager')) from-emerald-500 to-emerald-600
                                    @elseif(auth()->user()->hasRole('sales-person')) from-purple-500 to-purple-600
                                    @else from-gray-500 to-gray-600 @endif
                                    flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                @if (auth()->user()->hasRole('super-admin'))
                                    <div
                                        class="absolute -bottom-1 -right-1 w-5 h-5 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-crown text-white text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-200"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <!-- User dropdown menu (same as before but using auth()->user()) -->
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bars text-gray-600 text-lg" x-show="!open"></i>
                        <i class="fas fa-times text-gray-600 text-lg" x-show="open"></i>
                    </button>
                </div>
            @else
                <!-- Guest User Links (when not authenticated) -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                       class="text-gray-700 hover:text-blue-600 font-medium px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                        {{ __('Login') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-sm">
                            {{ __('Register') }}
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Navigation Menu - ONLY FOR AUTHENTICATED USERS -->
    @auth
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
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

                @if (auth()->user()->can('view dashboard') || auth()->user()->hasAnyRole(['admin', 'super-admin']))
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
                @endif

                <!-- Mobile Inventory Section -->
                @if (auth()->user()->canAny(['manage inventory', 'view products', 'view categories', 'view suppliers']) ||
                        auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager', 'sales-person']))
                    <div class="border-t border-gray-100 pt-3">
                        <h3 class="text-xs font-semibold uppercase text-gray-500 tracking-wider px-4 mb-2">Inventory</h3>
                        <div class="space-y-1">
                            @if (auth()->user()->can('view products') ||
                                    auth()->user()->hasAnyRole(['admin', 'super-admin', 'inventory-manager', 'sales-person']))
                                <a href="{{ route('inventory.products.index') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-colors {{ request()->routeIs('inventory.products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-box text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium">Products</span>
                                </a>
                            @endif

                            <!-- Other mobile inventory links -->
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endauth
</nav>
