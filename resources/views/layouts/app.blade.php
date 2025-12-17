<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Asia Enterprise - Tally Pro')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-size: .875rem;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
        .navbar .navbar-toggler {
            top: .25rem;
            right: 1rem;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }
        .sidebar .nav-link.active {
            color: #007bff;
        }
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('dashboard') }}">
            <i class="bi bi-box-seam me-2"></i>Asia Enterprise
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav px-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}"
                               href="#inventorySubmenu" data-bs-toggle="collapse">
                                <i class="bi bi-boxes me-2"></i>Inventory
                            </a>
                            <ul class="nav flex-column collapse" id="inventorySubmenu">
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('inventory.products.index') }}">
                                        <i class="bi bi-box me-2"></i>Products
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('inventory.categories.index') }}">
                                        <i class="bi bi-tags me-2"></i>Categories
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('inventory.stock.index') }}">
                                        <i class="bi bi-clipboard-data me-2"></i>Stock View
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('purchase*') ? 'active' : '' }}"
                               href="#purchaseSubmenu" data-bs-toggle="collapse">
                                <i class="bi bi-cart-plus me-2"></i>Purchase
                            </a>
                            <ul class="nav flex-column collapse" id="purchaseSubmenu">
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('purchase.suppliers.index') }}">
                                        <i class="bi bi-people me-2"></i>Suppliers
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('purchase.purchase-orders.index') }}">
                                        <i class="bi bi-file-text me-2"></i>Purchase Orders
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('sales*') ? 'active' : '' }}"
                               href="#salesSubmenu" data-bs-toggle="collapse">
                                <i class="bi bi-cart-check me-2"></i>Sales
                            </a>
                            <ul class="nav flex-column collapse" id="salesSubmenu">
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('sales.customers.index') }}">
                                        <i class="bi bi-people me-2"></i>Customers
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('sales.sales-orders.index') }}">
                                        <i class="bi bi-receipt me-2"></i>Sales Orders
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}"
                               href="#adminSubmenu" data-bs-toggle="collapse">
                                <i class="bi bi-gear me-2"></i>Administration
                            </a>
                            <ul class="nav flex-column collapse" id="adminSubmenu">
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-person-badge me-2"></i>Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ms-4" href="{{ route('admin.companies.index') }}">
                                        <i class="bi bi-building me-2"></i>Companies
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Auto-close alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
