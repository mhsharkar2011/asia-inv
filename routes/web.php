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
use Illuminate\Validation\Rules\Can;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//public Routes

// Auth routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    //Register Can be disable by config
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    });

    // Dashboard

    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::get('categories-ajax', [CategoryController::class, 'getCategories'])->name('categories.ajax');
        Route::get('categories/{parentId}/subcategories', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories');

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
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', OrganizationController::class);
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::get('purchase-orders/clone', [PurchaseOrderController::class,'PDF'])->name('purchase-orders.clone');
        Route::get('purchase-orders/email', [PurchaseOrderController::class,'email'])->name('purchase-orders.email');
        Route::get('purchase-orders/po-upload', [PurchaseOrderController::class,'poUpload'])->name('purchase-orders.upload');
        Route::get('purchase-orders/po-cancel', [PurchaseOrderController::class,'poCancel'])->name('purchase-orders.cancel');
        Route::get('purchase-orders/po-receive', [PurchaseOrderController::class,'poReceive'])->name('purchase-orders.receive');
        Route::get('purchase-orders/pdf', [PurchaseOrderController::class,'OrderPDF'])->name('purchase-orders.pdf');
        Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
        Route::get('suppliers-ajax', [SupplierController::class, 'getSuppliers'])->name('suppliers.ajax');
        Route::resource('organizations', OrganizationController::class);
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
        Route::get('inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('purchases', [ReportController::class, 'purchases'])->name('purchases');
    });
});


Route::get('/', [HomeController::class, 'index'])->name('home');
