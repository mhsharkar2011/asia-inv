<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Asia Enterprise - Comprehensive Inventory and Business Management System">
    <meta name="author" content="Asia Enterprise">

    <title>@yield('title', 'Asia Enterprise - Tally Pro')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vendor JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    @stack('styles')

    <!-- Page-specific styles -->
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 64px;
        }

        body {
            height: 100vh;
            overflow-x: hidden;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .print-content {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased gradient-bg" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
    <!-- Loading Overlay -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-white/80 backdrop-blur-sm z-[9999] flex items-center justify-center hidden">
        <div class="text-center space-y-4">
            <div class="relative">
                <div class="w-20 h-20 rounded-full border-4 border-gray-200"></div>
                <div
                    class="w-20 h-20 rounded-full border-4 border-blue-500 border-t-transparent absolute top-0 left-0 animate-spin">
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full animate-pulse"></div>
                </div>
            </div>
            <div class="space-y-2">
                <p class="text-lg font-semibold text-gray-700">Loading</p>
                <div class="flex space-x-1 justify-center">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-50 glass border-b border-gray-200/50 h-[var(--header-height)]">
            @include('layouts.navigation')
        </header>

        <!-- Main Content Area -->
        <div class="flex flex-1">
            <!-- Sidebar Overlay (Mobile) -->
            <div class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity duration-300" x-show="sidebarOpen"
                @click="sidebarOpen = false" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-cloak>
            </div>

            <!-- Sidebar -->
            <aside
                class="fixed lg:sticky top-[var(--header-height)] left-0 h-[calc(100vh-var(--header-height))] bg-white border-r border-gray-200/50 z-40 transition-all duration-300 ease-in-out overflow-y-auto shadow-xl lg:shadow-none"
                :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
                style="width: var(--sidebar-width);">
                @include('layouts.sidebar')
            </aside>

            <!-- Main Content -->
            <main class="flex-1 transition-all duration-300 min-h-[calc(100vh-var(--header-height))] overflow-y-auto"
                :class="{ 'lg:ml-[0px]': sidebarOpen }">
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Breadcrumb -->
                    @if (View::hasSection('breadcrumb') || isset($breadcrumb))
                        <nav class="mb-6" aria-label="Breadcrumb">
                            <ol class="flex flex-wrap items-center gap-2">
                                <li>
                                    <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary transition-colors group">
                                        <i class="fas fa-home mr-2 text-gray-400 group-hover:text-primary"></i>
                                        Dashboard
                                    </a>
                                </li>
                                @yield('breadcrumb')
                                @if (isset($breadcrumb))
                                    @foreach ($breadcrumb as $item)
                                        <li class="flex items-center gap-2">
                                            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                                            @if (isset($item['url']))
                                                <a href="{{ $item['url'] }}"
                                                    class="text-sm font-medium text-gray-500 hover:text-primary transition-colors">
                                                    {{ $item['title'] }}
                                                </a>
                                            @else
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ $item['title'] }}
                                                </span>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </nav>
                    @endif

                    <!-- Page Header -->
                    @if (View::hasSection('page-header') || isset($pageTitle))
                        <div class="mb-8">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="space-y-2">
                                    @if (View::hasSection('page-header'))
                                        @yield('page-header')
                                    @else
                                        <div class="flex items-center gap-3">
                                            @if (isset($pageIcon))
                                                <div
                                                    class="p-2 bg-gradient-to-br from-primary/10 to-accent/10 rounded-xl">
                                                    <i class="{{ $pageIcon }} text-xl text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                                                    {{ $pageTitle ?? 'Page Title' }}</h1>
                                                @if (isset($pageDescription))
                                                    <p class="text-gray-600 mt-1">{{ $pageDescription }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    @yield('page-actions')
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Alerts -->
                    <div class="mb-8 space-y-4">
                        <!-- Session Messages -->
                        @foreach (['success', 'error', 'warning', 'info'] as $type)
                            @if (session($type))
                                <div
                                    class="flex items-center p-4 rounded-xl border-l-4 bg-gradient-to-r
                                    @if ($type == 'success') from-green-50 to-emerald-50 border-green-500
                                    @elseif($type == 'error') from-red-50 to-rose-50 border-red-500
                                    @elseif($type == 'warning') from-amber-50 to-orange-50 border-amber-500
                                    @else from-blue-50 to-cyan-50 border-blue-500 @endif">
                                    <div class="flex-1 flex items-center gap-3">
                                        <i
                                            class="fas
                                            @if ($type == 'success') fa-check-circle text-green-600
                                            @elseif($type == 'error') fa-exclamation-circle text-red-600
                                            @elseif($type == 'warning') fa-exclamation-triangle text-amber-600
                                            @else fa-info-circle text-blue-600 @endif
                                            text-xl"></i>
                                        <div>
                                            <p
                                                class="font-medium
                                                @if ($type == 'success') text-green-800
                                                @elseif($type == 'error') text-red-800
                                                @elseif($type == 'warning') text-amber-800
                                                @else text-blue-800 @endif">
                                                {{ ucfirst($type) }}!
                                            </p>
                                            <p
                                                class="text-sm
                                                @if ($type == 'success') text-green-600
                                                @elseif($type == 'error') text-red-600
                                                @elseif($type == 'warning') text-amber-600
                                                @else text-blue-600 @endif">
                                                {{ session($type) }}
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="ml-4 p-1.5 rounded-lg hover:bg-white/50 transition-colors"
                                        onclick="this.parentElement.remove()">
                                        <i class="fas fa-times text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div
                                class="p-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-circle text-red-600 text-xl mt-0.5"></i>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                                        <ul class="space-y-1.5">
                                            @foreach ($errors->all() as $error)
                                                <li class="text-sm text-red-700 flex items-center gap-2">
                                                    <i class="fas fa-circle text-[6px]"></i>
                                                    {{ $error }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Main Content -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                        <div class="p-4 sm:p-6 lg:p-8">
                            @yield('content')
                        </div>
                    </div>

                    <!-- Page Footer -->
                    @hasSection('page-footer')
                        <div class="mt-8">
                            @yield('page-footer')
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <footer class="mt-4 py-3 px-2 sm:px-3 lg:px-4 border-t border-gray-200/50">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="text-sm text-gray-600">
                            &copy; {{ date('Y') }} Asia Enterprise Tally Pro. All rights reserved.
                            <span class="mx-2 hidden sm:inline">•</span>
                            <span class="block sm:inline mt-1 sm:mt-0 text-xs bg-gray-100 px-2 py-1 rounded">
                                v{{ config('app.version', '1.0.0') }}
                            </span>
                        </div>
                        <div class="flex items-left gap-4">
                            <a href="#"
                                class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center gap-1.5">
                                <i class="fas fa-question-circle"></i>
                                <span class="hidden sm:inline">Help</span>
                            </a>
                            <a href="#"
                                class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center gap-1.5">
                                <i class="fas fa-file-alt"></i>
                                <span class="hidden sm:inline">Docs</span>
                            </a>
                            <a href="#"
                                class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center gap-1.5">
                                <i class="fas fa-cog"></i>
                                <span class="hidden sm:inline">Settings</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Back to Top -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-gradient-to-br from-primary to-accent text-blue-800     p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 transform translate-y-4 z-40"
        aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Search Modal -->
    <div id="searchModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[999] hidden">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-2xl">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Search Input -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="relative">
                            <input type="text" placeholder="Search for products, customers, orders, reports..."
                                class="w-full pl-12 pr-4 py-4 text-lg border-0 focus:ring-0 focus:outline-none placeholder-gray-400"
                                id="globalSearchInput" autofocus>
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                            <button type="button"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="closeSearchModal()">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Search Results -->
                    <div id="searchResults" class="max-h-96 overflow-y-auto"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Responsive sidebar
            function handleResponsiveSidebar() {
                if (window.innerWidth < 1024) {
                    Alpine.data('sidebarOpen', false);
                } else {
                    Alpine.data('sidebarOpen', true);
                }
            }

            // Initial check
            handleResponsiveSidebar();
            window.addEventListener('resize', handleResponsiveSidebar);

            // Back to Top
            const backToTopBtn = document.getElementById('backToTop');
            if (backToTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.pageYOffset > 300) {
                        backToTopBtn.classList.remove('opacity-0', 'translate-y-4');
                        backToTopBtn.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
                        backToTopBtn.classList.add('opacity-0', 'translate-y-4');
                    }
                });

                backToTopBtn.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Initialize Select2 with modern theme
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true,
                    dropdownParent: $('body')
                });
            }

            // Initialize Flatpickr
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.datepicker', {
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    theme: 'material_blue'
                });
            }

            // Global keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Ctrl+K or Cmd+K for search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    openSearchModal();
                }

                // Escape to close search
                if (e.key === 'Escape') {
                    closeSearchModal();
                }
            });

            // Toastr notifications
            @if (session('toastr'))
                toastr.{{ session('toastr.type', 'info') }}(
                    "{{ session('toastr.message') }}",
                    "{{ session('toastr.title', 'Notification') }}", {
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        timeOut: 5000,
                        closeButton: true,
                        newestOnTop: true,
                        preventDuplicates: true,
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut'
                    }
                );
            @endif
        });

        // Global functions
        window.showLoading = function() {
            document.getElementById('loadingOverlay')?.classList.remove('hidden');
        };

        window.hideLoading = function() {
            document.getElementById('loadingOverlay')?.classList.add('hidden');
        };

        window.openSearchModal = function() {
            const modal = document.getElementById('searchModal');
            modal.classList.remove('hidden');
            document.getElementById('globalSearchInput')?.focus();
        };

        window.closeSearchModal = function() {
            document.getElementById('searchModal')?.classList.add('hidden');
        };

        // Form submission loading
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                showLoading();
            }
        });

        // Page transition loading
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading();
        });
    </script>

    @stack('scripts')
</body>

</html>
