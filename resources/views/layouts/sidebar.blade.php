<nav class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo/Header -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-white text-sm"></i>
            </div>
            <span class="text-lg font-bold text-gray-900">Asia Enterprise</span>
        </div>
    </div>

    <!-- Navigation Items -->
    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-1">
            <!-- Dashboard -->
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

            <!-- Inventory Section -->
            <li>
                <div class="mt-6 mb-2 px-3">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Inventory</span>
                </div>
                <div>
                    <!-- Products -->
                    <a href="{{ route('inventory.products.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('inventory/products*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('inventory/products*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Products
                    </a>

                    <!-- Categories -->
                    <a href="{{ route('inventory.categories.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('inventory/categories*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('inventory/categories*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Categories
                    </a>

                    <!-- Stock View -->
                    <a href="{{ route('inventory.stock.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('inventory/stock*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('inventory/stock*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Stock View
                    </a>
                </div>
            </li>

            <!-- Purchase Section -->
            <li>
                <div class="mt-6 mb-2 px-3">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Purchase</span>
                </div>
                <div>
                    <!-- Suppliers -->
                    <a href="{{ route('purchase.organizations.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('purchase/organizations*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('purchase/organizations*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Suppliers
                    </a>

                    <!-- Purchase Orders -->
                    <a href="{{ route('purchase.purchase-orders.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('purchase/purchase-orders*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('purchase/purchase-orders*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Purchase Orders
                    </a>
                </div>
            </li>

            <!-- Sales Section -->
            <li>
                <div class="mt-6 mb-2 px-3">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sales</span>
                </div>
                <div>
                    <!-- Customers -->
                    <a href="{{ route('sales.organizations.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('sales/organizations*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('sales/organizations*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01" />
                        </svg>
                        Customers
                    </a>

                    <!-- Sales Orders -->
                    <a href="{{ route('sales.sales-orders.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('sales/sales-orders*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('sales/sales-orders*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Sales Orders
                    </a>

                    <!-- Sales Invoices -->
                    <a href="{{ route('sales.invoices.index') }}"
                       class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                              {{ request()->is('sales/invoices*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->is('sales/invoices*') ? 'text-blue-600' : 'text-gray-500' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Sales Invoices
                    </a>
                </div>
            </li>

            <!-- Administration Section (Admin Only) -->
            @if (Auth::user()->role === 'admin')
                <li>
                    <div class="mt-6 mb-2 px-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Administration</span>
                    </div>
                    <div>
                        <!-- Users -->
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                                  {{ request()->is('admin/users*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/users*') ? 'text-blue-600' : 'text-gray-500' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01" />
                            </svg>
                            Users
                        </a>

                        <!-- Companies -->
                        <a href="{{ route('admin.organizations.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                                  {{ request()->is('admin/organizations*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/organizations*') ? 'text-blue-600' : 'text-gray-500' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Companies
                        </a>

                        <!-- Branches -->
                        <a href="{{ route('admin.branches.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                                  {{ request()->is('admin/branches*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/branches*') ? 'text-blue-600' : 'text-gray-500' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Branches
                        </a>

                        <!-- Departments -->
                        <a href="{{ route('admin.departments.index') }}"
                           class="flex items-center px-3 py-2.5 text-sm rounded-lg ml-3 transition-colors
                                  {{ request()->is('admin/departments*') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->is('admin/departments*') ? 'text-blue-600' : 'text-gray-500' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Departments
                        </a>
                    </div>
                </li>
            @endif
        </ul>
    </div>

    <!-- Footer/User Info -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-xs font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // JavaScript for expandable submenus (optional - removed collapsible)
    // You can add back collapsible functionality if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight parent menu when child is active
        const activeLinks = document.querySelectorAll('a[class*="bg-blue-50"]');
        activeLinks.forEach(link => {
            // Optional: You can add logic to highlight parent sections
        });
    });
</script>
@endpush
