<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Sales\Invoice;
use App\Models\Sales\Customer;
use App\Models\Inventory\Product;
use App\Models\Sales\SalesOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Show the form for creating a sales report.
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])
            ->with('customer')
            ->get();

        $salesOrders = SalesOrder::whereBetween('created_at', [$startDate, $endDate])
            ->with('customer')
            ->get();

        $totalInvoiceAmount = $invoices->sum('total_amount');
        $totalOrdersAmount = $salesOrders->sum('total_amount');
        $totalSales = $totalInvoiceAmount + $totalOrdersAmount;

        return view('reports.sales', compact(
            'invoices',
            'salesOrders',
            'totalInvoiceAmount',
            'totalOrdersAmount',
            'totalSales',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show the form for creating a customer report.
     */
    public function customerReport(Request $request)
    {
        $customers = Customer::withCount(['invoices', 'salesOrders'])
            ->withSum('invoices as total_invoice_amount', 'total_amount')
            ->withSum('salesOrders as total_order_amount', 'total_amount')
            ->orderBy('total_invoice_amount', 'desc')
            ->get();

        return view('reports.customers', compact('customers'));
    }


    /**
     * Show the form for creating a customer report.
     */
    // public function customerReport(Request $request)
    // {
    //     $customers = Customer::withCount([
    //         'invoices as invoices_count' => function ($query) {
    //             $query->select(DB::raw('COUNT(*)'));
    //         },
    //         'salesOrders as sales_orders_count' => function ($query) {
    //             $query->select(DB::raw('COUNT(*)'));
    //         }
    //     ])
    //         ->withSum([
    //             'invoices as total_invoice_amount' => function ($query) {
    //                 $query->select(DB::raw('COALESCE(SUM(total_amount), 0)'));
    //             }
    //         ])
    //         ->withSum([
    //             'salesOrders as total_order_amount' => function ($query) {
    //                 $query->select(DB::raw('COALESCE(SUM(total_amount), 0)'));
    //             }
    //         ])
    //         ->orderBy('total_invoice_amount', 'desc')
    //         ->get();

    //     return view('reports.customers', compact('customers'));
    // }

    /**
     * Show the form for creating a product report.
     */
    public function productReport()
    {
        $products = Product::orderBy('stock_quantity')->get();

        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_level')
            ->where('is_active', '1')
            ->get();

        return view('reports.products', compact('products', 'lowStockProducts'));
    }

    /**
     * Show the form for creating a tax report (GST).
     */
    public function taxReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::whereBetween('invoice_date', [$startDate, $endDate])
            ->where('status', 'paid')
            ->with('customer')
            ->get();

        // Group by GST rate
        $gstSummary = $invoices->groupBy(function ($invoice) {
            return $invoice->tax_rate ?? 18; // Default 18%
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'taxable_amount' => $group->sum('taxable_amount'),
                'tax_amount' => $group->sum('tax_amount'),
                'total_amount' => $group->sum('total_amount')
            ];
        });

        return view('reports.tax', compact('invoices', 'gstSummary', 'startDate', 'endDate'));
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $reportType = $request->input('report_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Generate PDF based on report type
        // You'll need to install dompdf: composer require barryvdh/laravel-dompdf

        return response()->json(['message' => 'PDF export feature coming soon']);
    }

    /**
     * Export report to Excel.
     */
    public function exportExcel(Request $request)
    {
        $reportType = $request->input('report_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Generate Excel based on report type
        // You'll need to install maatwebsite/excel: composer require maatwebsite/excel

        return response()->json(['message' => 'Excel export feature coming soon']);
    }
}
