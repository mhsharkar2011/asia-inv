<?php

namespace App\Http\Controllers;

use App\Models\Admin\Company;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use App\Models\Inventory\Product;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\Supplier;
use App\Models\Sales\Customer;
use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index()
    {
        // Check if user has permission to view dashboard
        if (!Auth::user()->can('view dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        // Get counts for dashboard cards
        $productCount = Product::count();
        $customerCount = Company::where('type', 'customer')->count();
        $supplierCount = Company::where('type', 'supplier')->count();
        $purchaseOrderCount = PurchaseOrder::count();
        $salesOrderCount = SalesOrder::count();
        $invoiceCount = Invoice::count();

        // Get recent activities
        $recentProducts = Product::latest()->take(5)->get();
        $recentSalesOrders = SalesOrder::with('customer')->latest()->take(5)->get();
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();

        // Get low stock products (stock <= reorder_level)
        $lowStockProducts = Product::where('stock_quantity', '<=', \DB::raw('reorder_level'))
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();


        return view('dashboard.index', compact(
            'productCount',
            'customerCount',
            'supplierCount',
            'purchaseOrderCount',
            'salesOrderCount',
            'invoiceCount',
            'recentProducts',
            'recentSalesOrders',
            'recentInvoices',
            'lowStockProducts'
        ));
    }

    /**
     * Display the admin dashboard.
     */
    public function admin()
    {
        // Check if user has permission to access admin panel
        if (!Auth::user()->can('access admin panel')) {
            abort(403, 'Unauthorized action.');
        }

        // Admin-specific dashboard data
        $userCount = User::count();
        $roles = Role::withCount('users')->get();
        $recentUsers = User::with('roles')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'userCount',
            'roles',
            'recentUsers'
        ));
    }
}
