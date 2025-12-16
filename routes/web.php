<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Registration Routes (disabled)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Inventory\CategoryController::class);

        // Products routes (placeholder for now)
        // Products routes
        Route::resource('products', \App\Http\Controllers\Inventory\ProductController::class);

        // Additional product routes
        Route::post('products/{id}/toggle-status', [\App\Http\Controllers\Inventory\ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');

        // AJAX route for product dropdown
        Route::get('products-ajax', [\App\Http\Controllers\Inventory\ProductController::class, 'getProducts'])
            ->name('products.ajax');

        // Stock routes (placeholder)
        Route::get('stock', function () {
            return view('inventory.stock.index');
        })->name('stock.index');

        // AJAX routes for category dropdowns
        Route::get('categories-ajax', [\App\Http\Controllers\Inventory\CategoryController::class, 'getCategories'])
            ->name('categories.ajax');
        Route::get('categories/{parentId}/subcategories', [\App\Http\Controllers\Inventory\CategoryController::class, 'getSubcategories'])
            ->name('categories.subcategories');
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', \App\Http\Controllers\Purchase\SupplierController::class);

        // Additional supplier routes
        Route::post('suppliers/{id}/toggle-status', [\App\Http\Controllers\Purchase\SupplierController::class, 'toggleStatus'])
            ->name('suppliers.toggle-status');

        // AJAX route for supplier dropdown
        Route::get('suppliers-ajax', [\App\Http\Controllers\Purchase\SupplierController::class, 'getSuppliers'])
            ->name('suppliers.ajax');

        // Purchase Orders (placeholder)
        Route::get('purchase-orders', function () {
            return view('purchase.purchase-orders.index');
        })->name('purchase-orders.index');

        Route::get('purchase-orders/create', function () {
            return view('purchase.purchase-orders.create');
        })->name('purchase-orders.create');
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        // Customers (placeholder)
        Route::get('customers', function () {
            return view('sales.customers.index');
        })->name('customers.index');

        Route::get('customers/create', function () {
            return view('sales.customers.create');
        })->name('customers.create');

        // Sales Orders (placeholder)
        Route::get('sales-orders', function () {
            return view('sales.sales-orders.index');
        })->name('sales-orders.index');

        Route::get('sales-orders/create', function () {
            return view('sales.sales-orders.create');
        })->name('sales-orders.create');
    });

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', function () {
            return view('admin.users.index');
        })->name('users.index');

        Route::get('companies', function () {
            return view('admin.companies.index');
        })->name('companies.index');
    });
});
