<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of suppliers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = $request->input('per_page', 10);

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

        // Get suppliers with pagination
        $suppliers = $query->paginate($perPage);

        // Add supplierData to each supplier
        foreach ($suppliers as $supplier) {
            $supplier->supplierData = $this->getSupplierData($supplier->id);
        }

        $totalSuppliers = Company::where('type', 'supplier')->count();
        $activeSuppliers = Company::where('type', 'supplier')->where('is_active', true)->count();
        $inactiveSuppliers = Company::where('type', 'supplier')->where('is_active', false)->count();
        $totalCreditLimit = Company::where('type', 'supplier')->sum('credit_limit');
        $totalOutstanding = Company::where('type', 'supplier')->sum('outstanding_balance');
        $exceededCount = Company::where('type', 'supplier')
            ->where('is_credit_limit_exceeded', true)
            ->count();
        $avgCreditLimit = Company::where('type', 'supplier')
            ->where('credit_limit', '>', 0)
            ->avg('credit_limit') ?? 0;
        $activePercentage = $totalSuppliers > 0 ? round(($activeSuppliers / $totalSuppliers) * 100) : 0;
        $performanceRatings = ['Excellent', 'Good', 'Average', 'Poor'];

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

    /**
     * Get supplier data including last order, order count, total spent, and performance
     */
    private function getSupplierData($supplierId)
    {
        // Get last order
        $lastOrder = PurchaseOrder::where('supplier_id', $supplierId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Get order count
        $orderCount = PurchaseOrder::where('supplier_id', $supplierId)->count();

        // Get total spent
        $totalSpent = PurchaseOrder::where('supplier_id', $supplierId)
            ->whereIn('status', ['confirmed', 'processing', 'shipped', 'delivered']) // Only completed/shipped orders
            ->sum('final_amount');

        // Calculate performance based on delivery time and order fulfillment
        $performance = $this->calculateSupplierPerformance($supplierId);

        return (object) [
            'lastOrder' => $lastOrder,
            'orderCount' => $orderCount,
            'totalSpent' => $totalSpent,
            'performance' => $performance,
        ];
    }

    /**
     * Calculate supplier performance
     */
    private function calculateSupplierPerformance($supplierId)
    {
        // Get delivered orders
        $deliveredOrders = PurchaseOrder::where('supplier_id', $supplierId)
            ->where('status', 'delivered')
            ->get();

        if ($deliveredOrders->isEmpty()) {
            return 'No Data';
        }

        // Calculate average delivery time difference
        $totalDaysDiff = 0;
        $onTimeDeliveries = 0;

        foreach ($deliveredOrders as $order) {
            if ($order->expected_delivery_date && $order->updated_at) {
                $expectedDate = Carbon::parse($order->expected_delivery_date);
                $actualDate = Carbon::parse($order->updated_at);
                $daysDiff = $expectedDate->diffInDays($actualDate, false); // Negative means early

                $totalDaysDiff += $daysDiff;

                // Count as on-time if delivered within 2 days of expected date
                if (abs($daysDiff) <= 2) {
                    $onTimeDeliveries++;
                }
            }
        }

        $onTimePercentage = ($onTimeDeliveries / $deliveredOrders->count()) * 100;

        // Determine performance rating
        if ($onTimePercentage >= 90) {
            return 'Excellent';
        } elseif ($onTimePercentage >= 75) {
            return 'Good';
        } elseif ($onTimePercentage >= 60) {
            return 'Average';
        } else {
            return 'Poor';
        }
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('purchase.suppliers.create');
    }

    /**
     * Store a newly created supplier.
     */
    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'supplier_code' => 'required|unique:suppliers,supplier_code|max:50',
            'supplier_name' => 'required|max:255',
            'contact_person' => 'nullable|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:1000',
            'gstin' => 'nullable|max:15',
            'pan_number' => 'nullable|max:10',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|max:255',
            'outstanding_balance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|max:1000',
        ]);

        $validated['company_id'] = $companyId;
        $validated['is_active'] = $request->has('is_active');

        Supplier::create($validated);

        return redirect()->route('purchase.suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified supplier.
     */
    public function show($id)
    {
        $companyId = Auth::user()->company_id;

        $supplier = Supplier::with(['purchaseOrders' => function ($query) {
            $query->orderBy('order_date', 'desc')->limit(10);
        }])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        return view('purchase.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit($id)
    {
        $companyId = Auth::user()->company_id;

        $supplier = Supplier::where('company_id', $companyId)
            ->findOrFail($id);

        return view('purchase.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier.
     */
    public function update(Request $request, $id)
    {
        $companyId = Auth::user()->company_id;

        $supplier = Supplier::where('company_id', $companyId)
            ->findOrFail($id);

        $validated = $request->validate([
            'supplier_code' => 'required|unique:suppliers,supplier_code,' . $id . '|max:50',
            'supplier_name' => 'required|max:255',
            'contact_person' => 'nullable|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:1000',
            'gstin' => 'nullable|max:15',
            'pan_number' => 'nullable|max:10',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms' => 'nullable|max:255',
            'outstanding_balance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|max:1000',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $supplier->update($validated);

        return redirect()->route('purchase.suppliers.show', $supplier->id)
            ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified supplier.
     */
    public function destroy($id)
    {
        $companyId = Auth::user()->company_id;

        $supplier = Supplier::where('company_id', $companyId)
            ->findOrFail($id);

        // Check if supplier has purchase orders
        if ($supplier->purchaseOrders()->count() > 0) {
            return redirect()->route('purchase.suppliers.index')
                ->with('error', 'Cannot delete supplier with associated purchase orders.');
        }

        $supplier->delete();

        return redirect()->route('purchase.suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }

    /**
     * Get suppliers for dropdown (AJAX).
     */
    public function getSuppliers(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $suppliers = Supplier::where('company_id', $companyId)
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('supplier_name', 'like', "%{$search}%")
                    ->orWhere('supplier_code', 'like', "%{$search}%");
            })
            ->orderBy('supplier_name')
            ->limit(20)
            ->get(['id', 'supplier_code', 'supplier_name', 'gstin']);

        return response()->json($suppliers);
    }

    /**
     * Toggle supplier active status.
     */
    public function toggleStatus($id)
    {
        $companyId = Auth::user()->company_id;

        $supplier = Supplier::where('company_id', $companyId)
            ->findOrFail($id);

        $supplier->update(['is_active' => !$supplier->is_active]);

        $status = $supplier->is_active ? 'activated' : 'deactivated';

        return redirect()->route('purchase.suppliers.show', $supplier->id)
            ->with('success', "Supplier {$status} successfully!");
    }
}
