<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\InvoiceCOntroller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\SalesOrderController;

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
        Route::resource('categories', CategoryController::class);

        // Products routes
        Route::resource('products', ProductController::class);
        // Additional product routes
        Route::post('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        // AJAX route for product dropdown
        Route::get('products-ajax', [ProductController::class, 'getProducts'])->name('products.ajax');
        Route::post('inventory/products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');

        // Stock routes (placeholder)
        Route::get('stock', function () {
            return view('inventory.stock.index');
        })->name('stock.index');

        // AJAX routes for category dropdowns
        Route::get('categories-ajax', [CategoryController::class, 'getCategories'])
            ->name('categories.ajax');
        Route::get('categories/{parentId}/subcategories', [CategoryController::class, 'getSubcategories'])
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
        // Customers routes
        Route::resource('customers', CustomerController::class);

        // Additional customer routes
        Route::post('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])
            ->name('customers.toggle-status');

        // AJAX route for customer dropdown
        Route::get('customers-ajax', [CustomerController::class, 'getCustomers'])
            ->name('customers.ajax');

        // Sales Orders (placeholder)
        Route::resource('sales-orders', SalesOrderController::class);
        // Additional sales order routes
        Route::post('sales-orders/{salesOrder}/change-status', [SalesOrderController::class, 'changeStatus'])->name('sales-orders.change-status');
        Route::get('sales-orders/{salesOrder}/convert-to-invoice', [SalesOrderController::class, 'convertToInvoice'])->name('sales-orders.convert-to-invoice');
        Route::get('sales-orders/{salesOrder}/print', [SalesOrderController::class, 'print'])->name('sales-orders.print');
        Route::post('sales-orders/{sales_order}/confirm', [SalesOrderController::class, 'confirm'])->name('sales-orders.confirm');

        // Invoice Routes
        Route::resource('invoices', InvoiceCOntroller::class);
        // Additional invoice routes
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
        Route::post('invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])->name('invoices.payment');
        Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    });

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers');
        Route::get('/products', [ReportController::class, 'productReport'])->name('products');
        Route::get('/tax', [ReportController::class, 'taxReport'])->name('tax');
        Route::post('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');

        Route::get('/reports', function () {
            return redirect()->route('dashboard.index')->with('info', 'Reports module is under development');
        })->name('reports.index');

        Route::get('/reports', function () {
            return view('reports.placeholder');
        })->name('reports.index');
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
