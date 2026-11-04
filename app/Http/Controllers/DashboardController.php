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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    public function index(Request $request)
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
        // $lowStockProducts = Product::where('stock_quantity', '<=', \DB::raw('reorder_level'))
        //     ->where('stock_quantity', '>', 0)
        //     ->orderBy('stock_quantity', 'asc')
        //     ->take(5)
        //     ->get();

        $lowStockProducts = Product::where('stock_quantity', '<', 10)->orderBy('stock_quantity', 'asc')->get();


        // $monthlyRevenue = Invoice::whereYear('created_at', date('Y'))
        //     ->where('status', 'paid') // or 'completed' based on your status
        //     ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get()
        //     ->map(function ($item) {
        //         return [
        //             'month' => Carbon::create()->month($item->month)->format('M'),
        //             'revenue' => $item->revenue ?? 0
        //         ];
        //     })
        //     ->toArray();


        $year = $request->get('year', date('Y'));
        $status = $request->get('status', 'paid');

        $monthlyRevenue = $this->getDynamicRevenue($year, $status);
        $lowStockProducts = $this->getLowStockProducts();
        $growthRate = $this->getGrowthRate($monthlyRevenue);
        $growthColor = $growthRate >= 0 ? 'text-green-600' : 'text-red-600';
        $growthIcon = $growthRate >= 0 ? '↑' : '↓';
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $averageRevenue = collect($monthlyRevenue)->avg('revenue') ?? 0;
        $currentMonthRevenue = $this->getCurrentMonthRevenue($status);
        $projectedRevenue = $this->getProjectedRevenue($year, $status);

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
            'lowStockProducts',
            'monthlyRevenue',
            'averageRevenue',
            'currentMonthRevenue',
            'projectedRevenue',
            'growthRate',
            'growthColor',
            'growthIcon',
            'totalRevenue'

        ));
    }



    private function getGrowthRate($monthlyRevenue)
    {
        // Get last two months revenue
        $revenues = collect($monthlyRevenue)->pluck('revenue')->values();

        if ($revenues->count() < 2) {
            return 0;
        }

        $currentMonth = $revenues->last();
        $previousMonth = $revenues->slice(-2, 1)->first();

        if ($previousMonth == 0) {
            return $currentMonth > 0 ? 100 : 0;
        }

        $growthRate = (($currentMonth - $previousMonth) / $previousMonth) * 100;

        return round($growthRate, 1);
    }


    private function getDynamicRevenue($year, $status)
    {
        $revenueData = Invoice::whereYear('created_at', $year)
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->selectRaw('MONTH(created_at) as month_num,
                         SUM(total_amount) as revenue')
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get()
            ->keyBy('month_num');

        $monthlyRevenue = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyRevenue[] = [
                'month' => Carbon::create($year, $month, 1)->format('M'),
                'revenue' => $revenueData->get($month)->revenue ?? 0
            ];
        }

        return $monthlyRevenue;
    }
    private function getCurrentMonthRevenue($status)
    {
        return Invoice::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->sum('total_amount');
    }

    private function getProjectedRevenue($year, $status)
    {
        $lastTwoMonths = Invoice::whereYear('created_at', $year)
            ->where('status', $status)
            ->join(DB::raw('(SELECT MONTH(created_at) as month_num, MAX(created_at) as max_date
                        FROM invoices
                        WHERE YEAR(created_at) = ' . (int)$year . '
                        AND status = "' . $status . '"
                        GROUP BY MONTH(created_at)
                        ORDER BY month_num DESC
                        LIMIT 2) as latest'), function ($join) {
                $join->on('invoices.created_at', '=', 'latest.max_date');
            })
            ->avg('total_amount') ?? 0;

        return $lastTwoMonths * 12;
    }

    private function getLowStockProducts()
    {
        // Adjust the threshold (10) as needed
        return Product::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->limit(5) // Limit to 5 products for the dashboard
            ->get();
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
