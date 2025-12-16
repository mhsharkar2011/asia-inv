<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\Purchase\SupplierController;
use App\Http\Controllers\Sales\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Auth::routes(['register' => false]);

// Main Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Company & Admin Routes (Admin only)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('companies', \App\Http\Controllers\Admin\CompanyController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
        Route::resource('warehouses', \App\Http\Controllers\Admin\WarehouseController::class);
        Route::resource('taxes', \App\Http\Controllers\Admin\TaxController::class);
    });

    // Inventory Management Routes
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        // Stock Management
        Route::get('stock', [\App\Http\Controllers\Inventory\StockController::class, 'index'])->name('stock.index');
        Route::get('stock/alert', [\App\Http\Controllers\Inventory\StockController::class, 'alerts'])->name('stock.alerts');
        Route::post('stock/adjust', [\App\Http\Controllers\Inventory\StockController::class, 'adjust'])->name('stock.adjust');

        // Stock Transfers
        Route::resource('transfers', \App\Http\Controllers\Inventory\TransferController::class);
    });

    // Purchase Management Routes
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchase-orders', \App\Http\Controllers\Purchase\PurchaseOrderController::class);
        Route::post('purchase-orders/{id}/receive',
            [\App\Http\Controllers\Purchase\PurchaseOrderController::class, 'receive'])->name('purchase-orders.receive');

        // Goods Receipt
        Route::resource('goods-receipt', \App\Http\Controllers\Purchase\GoodsReceiptController::class);
    });

    // Sales Management Routes
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('sales-orders', \App\Http\Controllers\Sales\SalesOrderController::class);
        Route::post('sales-orders/{id}/deliver',
            [\App\Http\Controllers\Sales\SalesOrderController::class, 'deliver'])->name('sales-orders.deliver');

        // Invoices
        Route::resource('invoices', \App\Http\Controllers\Sales\InvoiceController::class);
        Route::get('invoices/{id}/print',
            [\App\Http\Controllers\Sales\InvoiceController::class, 'print'])->name('invoices.print');
        Route::post('invoices/{id}/email',
            [\App\Http\Controllers\Sales\InvoiceController::class, 'email'])->name('invoices.email');
    });

    // Accounting Routes
    Route::prefix('accounting')->name('accounting.')->group(function () {
        Route::resource('ledgers', \App\Http\Controllers\Accounting\LedgerController::class);
        Route::resource('transactions', \App\Http\Controllers\Accounting\TransactionController::class);

        // Reports
        Route::get('reports/trial-balance',
            [\App\Http\Controllers\Accounting\ReportController::class, 'trialBalance'])->name('reports.trial-balance');
        Route::get('reports/profit-loss',
            [\App\Http\Controllers\Accounting\ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('reports/balance-sheet',
            [\App\Http\Controllers\Accounting\ReportController::class, 'balanceSheet'])->name('reports.balance-sheet');
    });

    // Tax & Compliance
    Route::prefix('tax')->name('tax.')->group(function () {
        Route::get('gstr1', [\App\Http\Controllers\Tax\GSTController::class, 'gstr1'])->name('gstr1');
        Route::get('gstr3b', [\App\Http\Controllers\Tax\GSTController::class, 'gstr3b'])->name('gstr3b');
        Route::get('e-way-bills', [\App\Http\Controllers\Tax\GSTController::class, 'eWayBills'])->name('e-way-bills');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('inventory/summary',
            [\App\Http\Controllers\Reports\InventoryReportController::class, 'summary'])->name('inventory.summary');
        Route::get('inventory/movement',
            [\App\Http\Controllers\Reports\InventoryReportController::class, 'movement'])->name('inventory.movement');
        Route::get('financial/sales',
            [\App\Http\Controllers\Reports\FinancialReportController::class, 'sales'])->name('financial.sales');
        Route::get('financial/purchase',
            [\App\Http\Controllers\Reports\FinancialReportController::class, 'purchase'])->name('financial.purchase');
    });

    // Profile & Settings
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/change-language',
        [\App\Http\Controllers\ProfileController::class, 'changeLanguage'])->name('profile.change-language');
});
