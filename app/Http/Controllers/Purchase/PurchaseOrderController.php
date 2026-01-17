<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Admin\Warehouse;
use App\Http\Requests\PurchaseOrderRequest;
use App\Models\Admin\Company;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = $request->input('per_page', 10);

        // Get statistics from companies table where type = 'supplier'
        $totalSuppliers = Company::where('type', 'supplier')->count();
        $activeSuppliers = Company::where('type', 'supplier')->where('is_active', true)->count();
        $inactiveSuppliers = Company::where('type', 'supplier')->where('is_active', false)->count();

        // Calculate credit limit statistics
        $totalCreditLimit = Company::where('type', 'supplier')->sum('credit_limit');
        $totalOutstanding = Company::where('type', 'supplier')->sum('outstanding_balance');
        $exceededCount = Company::where('type', 'supplier')
            ->where('is_credit_limit_exceeded', true)
            ->count();

        // Calculate averages
        $avgCreditLimit = Company::where('type', 'supplier')
            ->where('credit_limit', '>', 0)
            ->avg('credit_limit') ?? 0;

        $activePercentage = $totalSuppliers > 0 ? round(($activeSuppliers / $totalSuppliers) * 100) : 0;

        // Query suppliers
        $query = Company::where('type', 'supplier')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('contact_person', 'like', "%{$search}%");
                });
            })
            ->when($status && $status !== 'all', function ($query, $status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'credit_exceeded') {
                    return $query->where('is_credit_limit_exceeded', true);
                }
                return $query;
            })
            ->orderBy('created_at', 'desc');

        $suppliers = $query->paginate($perPage);

        return view('purchase.suppliers.index', compact(
            'suppliers',
            'search',
            'status',
            'totalSuppliers',
            'activeSuppliers',
            'inactiveSuppliers',
            'activePercentage',
            'totalCreditLimit',
            'totalOutstanding',
            'exceededCount',
            'avgCreditLimit'
        ));
    }
    public function create()
    {
        $companies = Company::all();
        $suppliers = Company::where('type', 'supplier')->get();
        $warehouses = Warehouse::all();
        $statuses = ['draft', 'pending', 'partial', 'completed', 'cancelled'];

        // Generate PO number
        $lastPO = PurchaseOrder::latest()->first();
        $poNumber = 'PO-' . str_pad(($lastPO ? $lastPO->id + 1 : 1), 6, '0', STR_PAD_LEFT);

        return view('purchase.purchase-orders.create', compact('companies', 'suppliers', 'warehouses', 'statuses', 'poNumber'));
    }

    public function store(PurchaseOrderRequest $request)
    {
        try {
            PurchaseOrder::create($request->validated());

            return redirect()->route('purchase.purchase-orders.index')
                ->with('success', 'Purchase order created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating purchase order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['company', 'warehouse', 'items']);
        return view('purchase.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $companies = Company::all();
        $suppliers = Company::where('type', 'supplier')->get();
        $warehouses = Warehouse::all();
        $statuses = ['draft', 'pending', 'partial', 'completed', 'cancelled'];

        return view('purchase.purchase-orders.edit', compact('purchaseOrder', 'companies', 'suppliers', 'warehouses', 'statuses'));
    }

    public function update(PurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrder->update($request->validated());

            return redirect()->route('purchase.purchase-orders.index')
                ->with('success', 'Purchase order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating purchase order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrder->delete();

            return redirect()->route('purchase.purchase-orders.index')
                ->with('success', 'Purchase order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting purchase order: ' . $e->getMessage());
        }
    }
    public function export(Request $request)
    {
        // Option 1: Simple CSV export
        $purchaseOrders = PurchaseOrder::with(['warehouse', 'company'])
            ->filter($request->all())
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="purchase_orders_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($purchaseOrders) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'PO Number',
                'Supplier',
                'Warehouse',
                'Order Date',
                'Delivery Date',
                'Status',
                'Amount',
                'Tax Amount',
                'Discount',
                'Final Amount'
            ]);

            // Add data rows
            foreach ($purchaseOrders as $po) {
                fputcsv($file, [
                    $po->po_number,
                    $po->company->name ?? 'N/A',
                    $po->warehouse->name ?? 'N/A',
                    $po->order_date->format('Y-m-d'),
                    $po->expected_delivery_date ? $po->expected_delivery_date->format('Y-m-d') : 'N/A',
                    $po->status,
                    $po->amount,
                    $po->tax_amount,
                    $po->discount,
                    $po->final_amount,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        // Option 2: Using Laravel Excel (if installed)
        // return Excel::download(new PurchaseOrdersExport($request->all()), 'purchase_orders.xlsx');
    }

    public function import()
    {
        //
    }
}
