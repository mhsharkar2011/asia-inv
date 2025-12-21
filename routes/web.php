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
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Purchase\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware(['auth'])->group(function () {
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


        // Route::resource('organizations', OrganizationController::class)->except(['index', 'create']);
        Route::get('organizations/{type?}', [OrganizationController::class, 'index'])->name('organizations.index');
        Route::get('organizations/{type?}/create', [OrganizationController::class, 'create'])->name('organizations.create');
        Route::post('organizations', [OrganizationController::class, 'store'])->name('organizations.store');
        Route::get('organizations/{organization}/show', [OrganizationController::class, 'show'])->name('organizations.show');
        Route::get('organizations/{organization}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
        Route::put('organizations/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
        Route::delete('organizations/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');
        Route::get('organizations/export', [OrganizationController::class, 'export'])->name('organizations.export');
        Route::get('organizations/{type?}/import', [OrganizationController::class, 'import'])->name('organizations.import');
        Route::post('organizations/{organization}/toggle-status', [OrganizationController::class, 'toggleStatus'])->name('organizations.toggle-status');

        Route::resource('branches', BranchController::class);
        Route::prefix('branches')->name('branches.')->group(function () {
            Route::post('/{branch}/toggle-status', [BranchController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{branch}/set-head-office', [BranchController::class, 'setHeadOffice'])->name('set-head-office');
            Route::get('/company/{companyId}', [BranchController::class, 'getByCompany'])->name('by-company');
            Route::get('/export', [BranchController::class, 'export'])->name('export');
        });
        Route::resource('departments', DepartmentController::class);
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::resource('organizations', OrganizationController::class);
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::post('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::get('customers-ajax', [CustomerController::class, 'getCustomers'])->name('customers.ajax');
        Route::resource('organizations', OrganizationController::class);

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
