<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        $suppliers = Supplier::where('company_id', $companyId)
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('supplier_code', 'like', "%{$search}%")
                      ->orWhere('supplier_name', 'like', "%{$search}%")
                      ->orWhere('contact_person', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('gstin', 'like', "%{$search}%");
                });
            })
            ->when($status !== 'all', function($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'credit_exceeded') {
                    return $query->whereRaw('outstanding_balance > credit_limit');
                }
            })
            ->orderBy('supplier_name')
            ->paginate(20);

        return view('purchase.suppliers.index', compact('suppliers', 'search', 'status'));
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

        $supplier = Supplier::with(['purchaseOrders' => function($query) {
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
            ->when($search, function($query) use ($search) {
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
