<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\cartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Sales\InvoiceController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\SalesOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\SupplierController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/view/{product}', [HomeController::class, 'show'])->name('products.show');
Route::get('/products/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/products/notify', [HomeController::class, 'notify'])->name('product.notify');
Route::get('/products/shop/{category}', [HomeController::class, 'category'])->name('shop.category');
Route::get('/products/cart/add', [HomeController::class, 'cardAdd'])->name('cart.add');
Route::get('product/cart/checkout', [HomeController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/add', [cartController::class, 'add'])->name('cart.add');
Route::get('/product/quickview', [ProductController::class, 'quickView'])->name('product.quickview');
route::get('contact', function () {
    return view('contact');
})->name('contact');


// Public Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // User profile routes
    Route::get('/profile/{user}/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'setting'])->name('profile.settings');
});
require __DIR__ . '/auth.php';

// Routes that require specific roles (using Spatie Permission)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Admin Management
    Route::prefix('admin')->name('admin.')->group(function () {
        // Users Management
        Route::resource('users', UserController::class);
        // Additional user routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('super.dashboard');
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('users/{user}/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('users/{user}/login-as', [UserController::class, 'loginAs'])->name('users.login-as');
        // Roles and Permission Routes
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::get('/users/{user}/roles/edit', [UserController::class, 'editRoles'])->name('users.roles.edit');
        Route::post('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.roles.update');
        Route::get('/users/{user}/permissions/edit', [UserController::class, 'editPermissions'])->name('users.permissions.edit');
        Route::post('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
        // End Roles and Permission Routes
        Route::post('/users/{user}/send-password-reset', [UserController::class, 'sendPasswordReset'])->name('users.send-password-reset');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::get('users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
        Route::get('users-ajax', [UserController::class, 'getUsers'])->name('users.ajax');
        Route::get('users/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::get('users/bulk-delete', [UserController::class, 'bulk-delete'])->name('users.bulk-delete');
        Route::get('users/bulk-activate', [UserController::class, 'bulk-activate'])->name('users.bulk-activate');
        Route::get('users/bulk-deactivate', [UserController::class, 'bulk-deactivate'])->name('users.bulk-deactivate');
        Route::get('branches/by-company', [BranchController::class, 'getByCompany'])->name('branches.by-company');
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
        Route::post('companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');
        Route::resource('departments', DepartmentController::class);
        Route::resource('branches', BranchController::class);
        Route::get('branches/export', [BranchController::class, 'export'])->name('branches.export');
        Route::post('branches/toggle-status/{id}', [BranchController::class, 'toggleStatus'])->name('branches.toggle-status');
        Route::get('branches/import', [BranchController::class, 'import'])->name('branches.import');
        Route::resource('warehouses', WarehouseController::class);
        Route::get('warehouses/products', [WarehouseController::class, 'getProducts'])->name('warehouses.products');
        Route::post('warehouses/{warehouse}/toggle-status', [WarehouseController::class, 'toggleStatus'])->name('warehouses.toggle-status');
        Route::get('warehouses/export', [WarehouseController::class, 'export'])->name('warehouses.export');
        // API routes for warehouse modals
        Route::get('/api/warehouses/{warehouse}', [WarehouseController::class, 'apiShow'])->name('api.warehouses.show');
        Route::get('/api/warehouses/{warehouse}/edit', [WarehouseController::class, 'apiEdit'])->name('api.warehouses.edit');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/{id}', [AuditLogController::class, 'show'])->name('audit-logs.show');

        Route::resource('permissions', PermissionController::class)->except(['show']);
        Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::put('/users/{user}/permissions', [PermissionController::class, 'update'])->name('users.permissions.update');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
    });
});

// Routes for users with inventory permissions (using permissions instead of roles)
Route::middleware(['auth'])->group(function () {
    // Inventory Management - Check permissions
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
        Route::get('warehouses/products', [WarehouseController::class, 'getProducts'])->name('warehouses.products');
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::post('suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');
        Route::get('suppliers-ajax', [SupplierController::class, 'getSuppliers'])->name('suppliers.ajax');

        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::post('purchase-orders/{purchaseOrder}/change-status', [PurchaseOrderController::class, 'changeStatus'])->name('purchase-orders.change-status');
        Route::get('purchase-orders/{purchaseOrder}/print', [PurchaseOrderController::class, 'print'])->name('purchase-orders.print');
        Route::post('purchase-orders/{purchase_order}/confirm', [PurchaseOrderController::class, 'confirm'])->name('purchase-orders.confirm');
        Route::get('purchase-orders/export', [PurchaseOrderController::class, 'export'])->name('purchase-orders.export');
        Route::get('purchase-orders/import', [PurchaseOrderController::class, 'import'])->name('purchase-orders.import');
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('companies', CompanyController::class);
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

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/dashboard/reports-generate', [ReportController::class, 'reportsGenerate'])->name('dashboard.reports-generate');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers');
        Route::get('/products', [ReportController::class, 'productReport'])->name('products');
        Route::get('/tax', [ReportController::class, 'taxReport'])->name('tax');
        Route::post('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::post('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/placeholder', [ReportController::class, 'placeholder'])->name('placeholder');
        Route::get('inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('purchases', [ReportController::class, 'purchases'])->name('purchases');
    });
});
