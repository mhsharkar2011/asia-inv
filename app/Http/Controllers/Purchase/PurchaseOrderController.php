<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Inventory\Company;
use App\Models\Purchase\Supplier;
use App\Models\Inventory\Warehouse;
use App\Http\Requests\PurchaseOrderRequest;
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

        // Get statistics
        $pendingCount = PurchaseOrder::where('status', 'pending')->count();
        $completedCount = PurchaseOrder::where('status', 'completed')->count();
        $totalValue = PurchaseOrder::where('status', '!=', 'cancelled')->sum('final_amount');

        $query = PurchaseOrder::with(['company', 'supplier', 'warehouse'])
            ->when($search, function ($query, $search) {
                return $query->where('po_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('order_date', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc');

        $purchaseOrders = $query->paginate($perPage);

        return view('purchase.purchase-orders.index', compact(
            'purchaseOrders',
            'search',
            'status',
            'pendingCount',
            'completedCount',
            'totalValue'
        ));
    }

    public function create()
    {
        $companies = Company::all();
        $suppliers = Supplier::all();
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
        $purchaseOrder->load(['company', 'supplier', 'warehouse', 'items']);
        return view('purchase.purchase-orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $companies = Company::all();
        $suppliers = Supplier::all();
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
}
