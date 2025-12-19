<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Admin\Organization;
use App\Models\Sales\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');
        $type = $request->get('type', 'all');
        $status = $request->get('status', 'all');

        $customers = Organization::where('type', 'customer')
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('contact_person', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('tin', 'like', "%{$search}%");
                });
            })
            ->when($type !== 'all', function ($query) use ($type) {
                return $query->where('customer_type', $type);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'credit_exceeded') {
                    return $query->whereRaw('outstanding_balance > credit_limit');
                }
            })
            ->orderBy('customer_name')
            ->paginate(20);

        return view('sales.customers.index', compact('customers', 'search', 'type', 'status'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('sales.customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'customer_code' => 'required|unique:customers,customer_code|max:50',
            'customer_name' => 'required|max:255',
            'customer_type' => 'required|in:retail,wholesale,corporate',
            'contact_person' => 'nullable|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:1000',
            'tin' => 'nullable|max:15',
            'bin_number' => 'nullable|max:10',
            'bank_account' => 'nullable|max:15',
            'bank_name' => 'nullable',
            'credit_limit' => 'nullable|numeric|min:0',
            'outstanding_balance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|max:1000',
            'web_address' => 'nullable|max:1000',
            'industry' => 'nullable|max:200'
        ]);

        $validated['company_id'] = $companyId;
        $validated['is_active'] = $request->has('is_active');

        Customer::create($validated);

        return redirect()->route('sales.customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
    {
        $companyId = Auth::user()->company_id;

        $customer = Customer::where('company_id', $companyId)
            ->findOrFail($id);

        return view('sales.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit($id)
    {
        $companyId = Auth::user()->company_id;

        $customer = Customer::where('company_id', $companyId)
            ->findOrFail($id);

        return view('sales.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, $id)
    {
        $companyId = Auth::user()->company_id;

        $customer = Customer::where('company_id', $companyId)
            ->findOrFail($id);

        $validated = $request->validate([
           'customer_code' => 'required|unique:customers,customer_code|max:50',
            'customer_name' => 'required|max:255',
            'customer_type' => 'required|in:retail,wholesale,corporate',
            'contact_person' => 'nullable|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|max:1000',
            'tin' => 'nullable|max:15',
            'bin_number' => 'nullable|max:10',
            'bank_account' => 'nullable|max:15',
            'bank_name' => 'nullable',
            'credit_limit' => 'nullable|numeric|min:0',
            'outstanding_balance' => 'nullable|numeric|min:0',
            'notes' => 'nullable|max:1000',
            'web_address' => 'nullable|max:1000',
            'industry' => 'nullable|max:200'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $customer->update($validated);

        return redirect()->route('sales.customers.show', $customer->id)
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified customer.
     */
    public function destroy($id)
    {
        $companyId = Auth::user()->company_id;

        $customer = Customer::where('company_id', $companyId)
            ->findOrFail($id);

        // Check if customer has sales orders
        if ($customer->salesOrders()->count() > 0) {
            return redirect()->route('sales.customers.index')
                ->with('error', 'Cannot delete customer with associated sales orders.');
        }

        $customer->delete();

        return redirect()->route('sales.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    /**
     * Get customers for dropdown (AJAX).
     */
    public function getCustomers(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $customers = Customer::where('company_id', $companyId)
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_code', 'like', "%{$search}%");
            })
            ->orderBy('customer_name')
            ->limit(20)
            ->get(['id', 'customer_code', 'customer_name', 'tin', 'customer_type']);

        return response()->json($customers);
    }

    /**
     * Toggle customer active status.
     */
    public function toggleStatus($id)
    {
        $companyId = Auth::user()->company_id;

        $customer = Customer::where('company_id', $companyId)
            ->findOrFail($id);

        $customer->update(['is_active' => !$customer->is_active]);

        $status = $customer->is_active ? 'activated' : 'deactivated';

        return redirect()->route('sales.customers.show', $customer->id)
            ->with('success', "Customer {$status} successfully!");
    }
}
