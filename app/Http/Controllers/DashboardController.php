<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\Inventory;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companyId = Auth::user()->company_id;

        // Calculate total stock value
        $totalStockValue = Inventory::whereHas('product', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get()->sum(function($inventory) {
            return $inventory->quantity_available * $inventory->average_purchase_price;
        });

        // Get low stock items
        $lowStockItems = Product::where('company_id', $companyId)
            ->whereHas('inventories', function($query) {
                $query->whereRaw('quantity_available <= reorder_level')
                      ->where('quantity_available', '>', 0);
            })
            ->count();

        // Get pending orders
        $pendingOrders = PurchaseOrder::where('company_id', $companyId)
            ->where('status', 'pending')
            ->count();

        // Get monthly revenue
        $monthlyRevenue = SalesOrder::where('company_id', $companyId)
            ->where('status', 'delivered')
            ->whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->sum('final_amount');

        // Get stock alerts
        $stockAlerts = Product::where('company_id', $companyId)
            ->with(['inventories' => function($query) {
                $query->whereRaw('quantity_available <= reorder_level')
                      ->where('quantity_available', '>', 0);
            }])
            ->whereHas('inventories', function($query) {
                $query->whereRaw('quantity_available <= reorder_level')
                      ->where('quantity_available', '>', 0);
            })
            ->limit(5)
            ->get();

        // Sales data for chart
        $salesData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'values' => [50000, 75000, 60000, 90000, 85000, 95000]
        ];

        // Recent activities (simplified for now)
        $recentActivities = collect([
            (object)[
                'created_at' => now()->subHours(2),
                'description' => 'Created new purchase order #PO-001',
                'user' => (object)['full_name' => Auth::user()->full_name],
                'reference' => 'PO-001'
            ],
            (object)[
                'created_at' => now()->subDays(1),
                'description' => 'Added new product "Product A"',
                'user' => (object)['full_name' => Auth::user()->full_name],
                'reference' => 'P-001'
            ]
        ]);

        return view('dashboard.index', compact(
            'totalStockValue',
            'lowStockItems',
            'pendingOrders',
            'monthlyRevenue',
            'stockAlerts',
            'salesData',
            'recentActivities'
        ));
    }
}
