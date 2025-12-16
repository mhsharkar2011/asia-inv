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

Route::get('/login', function () {
    return redirect('/login');
})->name('login');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        // Stock Management (placeholder routes)
        Route::get('stock', function () {
            return view('inventory.stock.index');
        })->name('stock.index');
    });

    // Purchase Management
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::resource('suppliers', SupplierController::class);

        // Purchase Orders (placeholder routes)
        Route::get('purchase-orders', function () {
            return view('purchase.purchase-orders.index');
        })->name('purchase-orders.index');

        Route::get('purchase-orders/create', function () {
            return view('purchase.purchase-orders.create');
        })->name('purchase-orders.create');
    });

    // Sales Management
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('customers', CustomerController::class);

        // Sales Orders (placeholder routes)
        Route::get('sales-orders', function () {
            return view('sales.sales-orders.index');
        })->name('sales-orders.index');

        Route::get('sales-orders/create', function () {
            return view('sales.sales-orders.create');
        })->name('sales-orders.create');
    });

    // Reports (placeholder)
    Route::get('reports/inventory/summary', function () {
        return view('reports.inventory.summary');
    })->name('reports.inventory.summary');

    // Admin Routes (for admin users only)
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', function () {
            return view('admin.users.index');
        })->name('users.index');

        Route::get('companies', function () {
            return view('admin.companies.index');
        })->name('companies.index');
    });
});

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
