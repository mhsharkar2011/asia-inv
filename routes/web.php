<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Inventory\WarehouseController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\InvoiceCOntroller;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\SalesOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Purchase\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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
        Route::post('users/{user}/login-as', [UserController::class, 'loginAs'])->name('users.login-as');
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        Route::resource('companies', CompanyController::class);
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
        Route::post('inventory/products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::resource('stock', StockController::class);
        Route::resource('warehouses', WarehouseController::class);
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
        Route::get('suppliers-ajax', [SupplierController::class, 'getSuppliers'])->name('suppliers.ajax');
        Route::resource('purchase-orders', PurchaseOrderController::class);
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::post('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::get('customers-ajax', [CustomerController::class, 'getCustomers'])->name('customers.ajax');

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

  // Route::get('/reports', function () {
        //     return redirect()->route('dashboard.index')->with('info', 'Reports module is under development');
        // })->name('dashboard.index');
