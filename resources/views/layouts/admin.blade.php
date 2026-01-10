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
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Toastr Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Select2 for enhanced dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <!-- Flatpickr for date pickers -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Alpine.js for interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/product-code-generator.js'])

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
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50" x-data="{ sidebarOpen: true }">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white bg-opacity-80 z-50 flex items-center justify-center hidden">
        <div class="text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-lg font-semibold text-gray-700">Loading...</p>
        </div>
    </div>

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-40 h-16" :class="{ 'ml-0': !sidebarOpen, 'ml-[250px]': sidebarOpen }">
        @include('layouts.navigation')
    </header>

    <!-- Main Layout -->
    <div class="flex min-h-screen pt-16">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="fixed bottom-4 left-4 z-30 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all lg:hidden"
                x-show="!sidebarOpen">
            <i class="fas fa-bars text-lg"></i>
        </button>

        <!-- Sidebar Overlay (Mobile) -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
             x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-full bg-white shadow-xl z-40 transition-all duration-300 ease-in-out overflow-y-auto"
               :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
               style="width: 250px;">
            @include('layouts.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-grow transition-all duration-300 ease-in-out min-h-screen"
              :class="{ 'ml-0': !sidebarOpen, 'ml-[250px]': sidebarOpen }">
            <div class="p-4 md:p-6 lg:p-8">
                <!-- Breadcrumb -->
                @if(View::hasSection('breadcrumb') || isset($breadcrumb))
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <i class="fas fa-home mr-2 text-gray-500"></i>
                                    Dashboard
                                </a>
                            </li>
                            @yield('breadcrumb')
                            @if(isset($breadcrumb))
                                @foreach($breadcrumb as $item)
                                    <li>
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                            @if(isset($item['url']))
                                                <a href="{{ $item['url'] }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                                    {{ $item['title'] }}
                                                </a>
                                            @else
                                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                                    {{ $item['title'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                @endif

                <!-- Page Header -->
                @if(View::hasSection('page-header') || isset($pageTitle))
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                @if(View::hasSection('page-header'))
                                    @yield('page-header')
                                @else
                                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $pageTitle ?? 'Page Title' }}</h1>
                                    @if(isset($pageDescription))
                                        <p class="mt-2 text-gray-600">{{ $pageDescription }}</p>
                                    @endif
                                @endif
                            </div>
                            <div class="mt-4 md:mt-0">
                                @yield('page-actions')
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Flash Messages -->
                @if(session('success') || session('error') || session('warning') || session('info'))
                    <div class="mb-6 space-y-3">
                        @if(session('success'))
                            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                                <i class="fas fa-check-circle mr-3 text-green-600"></i>
                                <div class="flex-1">
                                    <span class="font-medium">Success!</span> {{ session('success') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-100">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                                <div class="flex-1">
                                    <span class="font-medium">Error!</span> {{ session('error') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-100">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                                <i class="fas fa-exclamation-triangle mr-3 text-yellow-600"></i>
                                <div class="flex-1">
                                    <span class="font-medium">Warning!</span> {{ session('warning') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-yellow-50 text-yellow-500 rounded-lg p-1.5 hover:bg-yellow-100">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if(session('info'))
                            <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                                <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                                <div class="flex-1">
                                    <span class="font-medium">Info:</span> {{ session('info') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg p-1.5 hover:bg-blue-100">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Please fix the following errors:
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6">
                    @yield('content')
                </div>

                <!-- Page Footer -->
                @hasSection('page-footer')
                    <div class="mt-6">
                        @yield('page-footer')
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8 py-4 px-6" :class="{ 'ml-0': !sidebarOpen, 'ml-[250px]': sidebarOpen }">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-600 mb-2 md:mb-0">
                    &copy; {{ date('Y') }} Asia Enterprise. All rights reserved.
                    <span class="mx-2">•</span>
                    <span class="text-xs">v{{ config('app.version', '1.0.0') }}</span>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-sm text-gray-600 hover:text-blue-600">
                        <i class="fas fa-question-circle mr-1"></i> Help
                    </a>
                    <a href="#" class="text-sm text-gray-600 hover:text-blue-600">
                        <i class="fas fa-file-alt mr-1"></i> Documentation
                    </a>
                    <a href="#" class="text-sm text-gray-600 hover:text-blue-600">
                        <i class="fas fa-cog mr-1"></i> Settings
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
            class="fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all opacity-0 transform translate-y-4">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Custom Scripts -->
    <script>
        // Initialize components when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-close alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Initialize Select2
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            }

            // Initialize Flatpickr
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.datepicker', {
                    dateFormat: 'Y-m-d',
                    allowInput: true
                });
            }

            // Back to top button
            const backToTopButton = document.getElementById('backToTop');
            if (backToTopButton) {
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTopButton.classList.remove('opacity-0', 'translate-y-4');
                        backToTopButton.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        backToTopButton.classList.remove('opacity-100', 'translate-y-0');
                        backToTopButton.classList.add('opacity-0', 'translate-y-4');
                    }
                });

                backToTopButton.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Toggle sidebar on mobile
            const sidebarOpenState = localStorage.getItem('sidebarOpen');
            if (sidebarOpenState !== null) {
                Alpine.data('sidebarOpen', JSON.parse(sidebarOpenState));
            }

            // Save sidebar state
            window.addEventListener('alpine:init', () => {
                Alpine.$persist('sidebarOpen').as('sidebarOpen');
            });

            // Show loading overlay on form submission
            document.addEventListener('submit', function(e) {
                if (e.target.tagName === 'FORM') {
                    const loadingOverlay = document.getElementById('loadingOverlay');
                    if (loadingOverlay) {
                        loadingOverlay.classList.remove('hidden');
                    }
                }
            });

            // Toastr notifications from session
            @if(session('toastr'))
                toastr.{{ session('toastr.type', 'info') }}("{{ session('toastr.message') }}", "{{ session('toastr.title', 'Notification') }}", {
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    timeOut: 5000,
                    closeButton: true
                });
            @endif

            // Close alert buttons
            document.querySelectorAll('[data-dismiss="alert"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('.alert').remove();
                });
            });

            // Initialize tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            }

            // Print functionality
            window.printPage = function() {
                window.print();
            };

            // Export functionality
            window.exportTable = function(tableId, format = 'excel') {
                const table = document.getElementById(tableId);
                if (!table) return;

                // Implement export logic here
                console.log(`Exporting ${tableId} as ${format}`);
                // You can add export functionality using libraries like SheetJS
            };

            // Responsive sidebar toggle for mobile
            function checkScreenSize() {
                if (window.innerWidth < 1024) {
                    Alpine.data('sidebarOpen', false);
                } else {
                    Alpine.data('sidebarOpen', true);
                }
            }

            // Check on load and resize
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
        });

        // Global functions
        window.confirmAction = function(message, callback) {
            if (confirm(message || 'Are you sure you want to proceed?')) {
                if (typeof callback === 'function') {
                    callback();
                }
                return true;
            }
            return false;
        };

        window.showLoading = function() {
            document.getElementById('loadingOverlay')?.classList.remove('hidden');
        };

        window.hideLoading = function() {
            document.getElementById('loadingOverlay')?.classList.add('hidden');
        };

        // Form validation helper
        window.validateForm = function(formId) {
            const form = document.getElementById(formId);
            if (!form) return true;

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return false;
            }
            return true;
        };
    </script>

    @stack('scripts')

    <!-- Google Analytics (Optional) -->
    @if(config('services.google.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google.analytics_id') }}');
        </script>
    @endif
</body>
</html>
