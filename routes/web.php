<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes that require specific roles (using Spatie Permission)
Route::middleware(['auth', 'role:admin|super_admin'])->group(function () {
    // Admin Management
    Route::prefix('admin')->name('admin.')->group(function () {
        // Users Management
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
        Route::get('users/{user}/impersonate', [UserController::class, 'impersonate'])
            ->name('users.impersonate');
        Route::get('users-ajax', [UserController::class, 'getUsers'])
            ->name('users.ajax');

        // User profile routes
        Route::get('profile', [UserController::class, 'editProfile'])->name('users.profile.edit');
        Route::put('profile', [UserController::class, 'updateProfile'])->name('users.profile.update');

        // Company Management
        Route::get('companies/{type?}', [CompanyController::class, 'index'])->name('companies.index');
        Route::get('companies/{type?}/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('companies/{company}/show', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::get('companies/export', [CompanyController::class, 'export'])->name('companies.export');
        Route::get('companies/{type?}/import', [CompanyController::class, 'import'])->name('companies.import');
        Route::post('companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus'])
            ->name('companies.toggle-status');
    });
});

// Routes for users with inventory permissions (using permissions instead of roles)
Route::middleware(['auth','role:admin|super_admin'])->group(function () {
    // Inventory Management - Check permissions
    Route::prefix('inventory')->name('inventory.')->middleware('permission:view inventory')->group(function () {
        Route::resource('categories', CategoryController::class)->middleware('permission:manage categories');
        Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status')->middleware('permission:manage categories');
        Route::get('categories-ajax', [CategoryController::class, 'getCategories'])
            ->name('categories.ajax')->middleware('permission:view categories');
        Route::get('categories/{parentId}/subcategories', [CategoryController::class, 'getSubcategories'])
            ->name('categories.subcategories')->middleware('permission:view categories');

        Route::resource('products', ProductController::class)->middleware('permission:manage products');
        Route::post('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status')->middleware('permission:manage products');
        Route::get('products-ajax', [ProductController::class, 'getProducts'])
            ->name('products.ajax')->middleware('permission:view products');
        Route::get('/products/generate-code', [ProductController::class, 'generateProductCodeAjax'])
            ->name('products.generate-code')->middleware('permission:manage products');
        Route::post('products/{product}/update-stock', [ProductController::class, 'updateStock'])
            ->name('products.update-stock')->middleware('permission:manage stock');

        Route::resource('stock', StockController::class)->middleware('permission:manage stock');
        Route::resource('warehouses', WarehouseController::class)->middleware('permission:manage warehouses');
        Route::get('warehouses/products', [WarehouseController::class, 'getProducts'])
            ->name('warehouses.products')->middleware('permission:view warehouses');
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->middleware('permission:view purchases')->group(function () {
        Route::resource('suppliers', SupplierController::class)->middleware('permission:manage suppliers');
        Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])
            ->name('suppliers.toggle-status')->middleware('permission:manage suppliers');
        Route::get('suppliers-ajax', [SupplierController::class, 'getSuppliers'])
            ->name('suppliers.ajax')->middleware('permission:view suppliers');

        Route::resource('purchase-orders', PurchaseOrderController::class)->middleware('permission:manage purchase orders');
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->middleware('permission:view sales')->group(function () {
        Route::resource('customers', CustomerController::class)->middleware('permission:manage customers');
        Route::post('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])
            ->name('customers.toggle-status')->middleware('permission:manage customers');
        Route::get('customers-ajax', [CustomerController::class, 'getCustomers'])
            ->name('customers.ajax')->middleware('permission:view customers');

        Route::resource('sales-orders', SalesOrderController::class)->middleware('permission:manage sales orders');
        Route::post('sales-orders/{salesOrder}/change-status', [SalesOrderController::class, 'changeStatus'])
            ->name('sales-orders.change-status')->middleware('permission:manage sales orders');
        Route::get('sales-orders/{salesOrder}/convert-to-invoice', [SalesOrderController::class, 'convertToInvoice'])
            ->name('sales-orders.convert-to-invoice')->middleware('permission:manage sales orders');
        Route::get('sales-orders/{salesOrder}/print', [SalesOrderController::class, 'print'])
            ->name('sales-orders.print')->middleware('permission:view sales orders');
        Route::post('sales-orders/{sales_order}/confirm', [SalesOrderController::class, 'confirm'])
            ->name('sales-orders.confirm')->middleware('permission:manage sales orders');
        Route::get('sales-orders/export', [SalesOrderController::class, 'export'])
            ->name('sales-orders.export')->middleware('permission:export sales');

        Route::resource('invoices', InvoiceController::class)->middleware('permission:manage invoices');
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])
            ->name('invoices.download')->middleware('permission:view invoices');
        Route::get('invoices/{invoice}/send', [InvoiceController::class, 'send'])
            ->name('invoices.send')->middleware('permission:manage invoices');
        Route::post('invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])
            ->name('invoices.payment')->middleware('permission:manage invoices');
        Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])
            ->name('invoices.print')->middleware('permission:view invoices');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->middleware('permission:view reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/dashboard/reports-generate', [ReportController::class, 'reportsGenerate'])->name('dashboard.reports-generate');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales')->middleware('permission:view sales reports');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers')->middleware('permission:view customer reports');
        Route::get('/products', [ReportController::class, 'productReport'])->name('products')->middleware('permission:view product reports');
        Route::get('/tax', [ReportController::class, 'taxReport'])->name('tax')->middleware('permission:view tax reports');
        Route::post('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf')->middleware('permission:export reports');
        Route::post('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel')->middleware('permission:export reports');
        Route::get('/placeholder', [ReportController::class, 'placeholder'])->name('placeholder');
    });
});

// Alternative approach: Using role-based access if you prefer roles over permissions
// Route::middleware(['auth', 'role:admin|super_admin|manager|staff'])->group(function () {
//     // Your routes here...
// });

// Auth routes (if using Laravel Breeze/Jetstream)
require __DIR__ . '/auth.php';
