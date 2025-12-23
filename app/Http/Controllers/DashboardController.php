<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\Admin\Company;
use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get low stock products (stock less than or equal to 10)
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->limit(10)
            ->get();

        // Get recent invoices
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->limit(10)
            ->get();

        // Get recent sales orders
        $recentSalesOrders = SalesOrder::with('customer')
            ->latest()
            ->limit(10)
            ->get();

        // Get recent customers
        $recentCustomers = Company::latest()
            ->limit(10)
            ->get();

        // Calculate dashboard statistics
        $totalCustomers = Company::count();
        $totalProducts = Product::count();

        $totalInvoices = Invoice::count();
        $totalInvoiceAmount = Invoice::sum('total_amount');
        $pendingInvoices = Invoice::where('status', '!=', 'paid')->count();

        $totalSalesOrders = SalesOrder::count();
        $totalSalesAmount = SalesOrder::sum('total_amount');
        $pendingOrders = SalesOrder::where('status', 'draft')->orWhere('status', 'confirmed')->count();

        // Get monthly revenue data for chart
        $monthlyRevenue = $this->getMonthlyRevenue();

        return view('dashboard.index', compact(
            'lowStockProducts',
            'recentInvoices',
            'recentSalesOrders',
            'recentCustomers',
            'totalCustomers',
            'totalProducts',
            'totalInvoices',
            'totalInvoiceAmount',
            'pendingInvoices',
            'totalSalesOrders',
            'totalSalesAmount',
            'pendingOrders',
            'monthlyRevenue'
        ));
    }

    private function getMonthlyRevenue()
    {
        $revenueData = [];

        // Get last 6 months revenue
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthlyInvoices = Invoice::whereBetween('invoice_date', [$monthStart, $monthEnd])
                ->where('status', 'paid')
                ->sum('total_amount');

            $revenueData[] = [
                'month' => $month->format('M Y'),
                'revenue' => $monthlyInvoices ?? 0
            ];
        }

        return $revenueData;
    }
}
