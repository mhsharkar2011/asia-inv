<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory\Product;
use App\Models\Inventory\Category;
use App\Models\Purchase\Supplier;
use App\Models\Sales\Customer;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companyId = Auth::user()->company_id;

        try {
            // Get basic counts - handle cases where tables might not exist yet
            $productCount = 0;
            $categoryCount = 0;
            $supplierCount = 0;
            $customerCount = 0;

            // Check if table exists before counting
            if (\Schema::hasTable('products')) {
                $productCount = Product::where('company_id', $companyId)->count();
            }

            if (\Schema::hasTable('categories')) {
                $categoryCount = Category::where('company_id', $companyId)->count();
            }

            if (\Schema::hasTable('suppliers')) {
                $supplierCount = Supplier::where('company_id', $companyId)->count();
            }

            if (\Schema::hasTable('customers')) {
                $customerCount = Customer::where('company_id', $companyId)->count();
            }

            // For now, use placeholder data until we have real inventory data
            $totalStockValue = 0;
            $lowStockItems = 0;
            $pendingOrders = 0;
            $monthlyRevenue = 0;

            // Get recent products (simplified)
            $recentProducts = [];
            if (\Schema::hasTable('products')) {
                $recentProducts = Product::where('company_id', $companyId)
                    ->where('is_active', true)
                    ->with('category')
                    ->latest()
                    ->limit(5)
                    ->get();
            }

            // Sales data for chart (placeholder)
            $salesData = [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'values' => [50000, 75000, 60000, 90000, 85000, 95000]
            ];

            // Recent activities (placeholder)
            $recentActivities = collect([
                (object)[
                    'created_at' => now()->subHours(2),
                    'description' => 'System initialized successfully',
                    'user' => (object)['name' => 'System'],
                    'reference' => 'System'
                ]
            ]);

            return view('dashboard.index', compact(
                'totalStockValue',
                'lowStockItems',
                'pendingOrders',
                'monthlyRevenue',
                'recentProducts',
                'salesData',
                'recentActivities',
                'productCount',
                'categoryCount',
                'supplierCount',
                'customerCount'
            ));

        } catch (\Exception $e) {
            // If there's an error, show a simplified dashboard
            return view('dashboard.welcome');
        }
    }
}
