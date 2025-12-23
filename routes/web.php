<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Inventory\WarehouseController;
use App\Http\Controllers\Sales\InvoiceController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\SalesOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration (can be disabled via config)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin routes
    Route::middleware(['can:view users'])->prefix('admin')->name('admin.')->group(function () {
        // Users
        Route::resource('users', UserController::class);

        // Additional user routes
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::post('users/{user}/verify-email', [UserController::class, 'verifyEmail'])
            ->name('users.verify-email');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
        Route::post('users/{user}/login-as', [UserController::class, 'loginAs'])
            ->name('users.login-as');
        Route::get('users/export', [UserController::class, 'export'])
            ->name('users.export');
        Route::post('users/bulk-action', [UserController::class, 'bulkAction'])
            ->name('users.bulk-action');
    });
});


// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth', 'role:admin|super_admin|user'])->group(function () {
    // Admin User Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::get('users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');

        Route::get('users-ajax', [UserController::class, 'getUsers'])->name('users.ajax');
        Route::post('users/{user}/login-as', [UserController::class, 'loginAs'])->name('users.login-as');
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        // User profile edit
        Route::get('profile', [UserController::class, 'editProfile'])->name('users.profile.edit');
        Route::put('profile', [UserController::class, 'updateProfile'])->name('users.profile.update');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::resource('companies', CompanyController::class)->except(['index', 'create']);
        Route::get('companies/{type?}', [CompanyController::class, 'index'])->name('companies.index');
        Route::get('companies/{type?}/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('companies/{Company}/show', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('companies/{Company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('companies/{Company}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('companies/{Company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::get('companies/export', [CompanyController::class, 'export'])->name('companies.export');
        Route::get('companies/{type?}/import', [CompanyController::class, 'import'])->name('companies.import');
        Route::post('companies/{Company}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');
    });

    // Dashboard

    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::get('categories-ajax', [CategoryController::class, 'getCategories'])->name('categories.ajax');
        Route::get('categories/{parentId}/subcategories', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories');

        Route::resource('products', ProductController::class);
        Route::post('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::get('products-ajax', [ProductController::class, 'getProducts'])->name('products.ajax');
        Route::get('/products/generate-code', [ProductController::class, 'generateProductCodeAjax'])->name('products.generate-code');

        Route::post('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::resource('stock', StockController::class);
        Route::resource('warehouses', WarehouseController::class);
        Route::get('warehouses/products', [WarehouseController::class, 'getProducts'])->name('warehouses.products');
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
        Route::get('suppliers-ajax', [SupplierController::class, 'getSuppliers'])->name('suppliers.ajax');
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::resource('companies', CompanyController::class);
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::post('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::get('customers-ajax', [CustomerController::class, 'getCustomers'])->name('customers.ajax');
        Route::resource('companies', CompanyController::class);

        Route::resource('sales-orders', SalesOrderController::class);
        Route::post('sales-orders/{salesOrder}/change-status', [SalesOrderController::class, 'changeStatus'])->name('sales-orders.change-status');
        Route::get('sales-orders/{salesOrder}/convert-to-invoice', [SalesOrderController::class, 'convertToInvoice'])->name('sales-orders.convert-to-invoice');
        Route::get('sales-orders/{salesOrder}/print', [SalesOrderController::class, 'print'])->name('sales-orders.print');
        Route::post('sales-orders/{sales_order}/confirm', [SalesOrderController::class, 'confirm'])->name('sales-orders.confirm');
        Route::get('sales-orders/export', [SalesOrderController::class, 'export'])->name('sales-orders.export');

        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
        Route::post('invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])->name('invoices.payment');
        Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/dashboard/reports-generate', [ReportController::class, 'reportsGenerate'])->name('dashboard.reports-generate');
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers');
        Route::get('/products', [ReportController::class, 'productReport'])->name('products');
        Route::get('/tax', [ReportController::class, 'taxReport'])->name('tax');
        Route::post('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/placeholder', [ReportController::class, 'placeholder'])->name('placeholder');
    });
});


// Auth routes (if using Laravel Breeze/Jetstream)
require __DIR__ . '/auth.php';
