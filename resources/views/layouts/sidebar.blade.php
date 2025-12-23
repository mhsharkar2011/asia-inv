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

            <!-- Collapsible Sections -->
            @php
                $sections = [
                    'inventory' => [
                        'title' => 'Inventory',
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'items' => [
                            ['route' => 'inventory.products.index', 'name' => 'Products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['route' => 'inventory.categories.index', 'name' => 'Categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                            ['route' => 'inventory.stock.index', 'name' => 'Stock View', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ]
                    ],
                    'purchase' => [
                        'title' => 'Purchase',
                        'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                        'items' => [
                            ['route' => 'purchase.companies.index', 'name' => 'Suppliers', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'purchase.purchase-orders.index', 'name' => 'Purchase Orders', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ]
                    ],
                    'sales' => [
                        'title' => 'Sales',
                        'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                        'items' => [
                            ['route' => 'sales.companies.index', 'name' => 'Customers', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01'],
                            ['route' => 'sales.sales-orders.index', 'name' => 'Sales Orders', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                            ['route' => 'sales.invoices.index', 'name' => 'Sales Invoices', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ]
                    ],
                ];
            @endphp

            @foreach($sections as $key => $section)
                <li x-data="{ open: {{ request()->is($key . '*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg text-gray-700 hover:bg-gray-100 transition-colors mt-6">
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
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                      {{ request()->is(str_replace('.', '/', $item['route'])) ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg class="w-4 h-4 mr-3 {{ request()->is(str_replace('.', '/', $item['route'])) ? 'text-blue-600' : 'text-gray-500' }}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
            @endforeach

            <!-- Administration Section (Admin Only) -->
            @if (Auth::user()->role === 'admin')
                @php
                    $adminSection = [
                        'title' => 'Administration',
                        'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                        'items' => [
                            ['route' => 'admin.users.index', 'name' => 'Users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.281.046-.562.086-.844.119A10.04 10.04 0 0115 19.5a10.01 10.01 0 01-5.656-1.724m10.656-8.776A10.023 10.023 0 0115 3.5c.67 0 1.32.087 1.944.249m10.656 8.776A10.023 10.023 0 0021 12.5c0 .527-.043 1.047-.124 1.558M3.5 10.5h.01m13.49 5h.01M3.5 15.5h.01'],
                            ['route' => 'admin.companies.index', 'name' => 'Companies', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            // Removed branches and departments since they're not needed
                        ]
                    ];
                @endphp

                <li x-data="{ open: {{ request()->is('admin*') ? 'true' : 'false' }} }" class="mt-6">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2.5 text-sm rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $adminSection['icon'] }}" />
                            </svg>
                            <span class="font-medium">{{ $adminSection['title'] }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-90': open }"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        @foreach($adminSection['items'] as $item)
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                      {{ request()->is(str_replace('.', '/', $item['route'])) ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg class="w-4 h-4 mr-3 {{ request()->is(str_replace('.', '/', $item['route'])) ? 'text-blue-600' : 'text-gray-500' }}"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                </svg>
                                {{ $item['name'] }}
                            </a>
                        @endforeach
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
