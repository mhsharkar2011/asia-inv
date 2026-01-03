<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrder;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Company::query();

        if ($type) {
            $query->where('type', $type);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $companies = $query->orderBy('name')->paginate(20);

        $stats = [
            'companies' => Company::where('type', 'company')->count(),
            'customers' => Company::where('type', 'customer')->count(),
            'suppliers' => Company::where('type', 'supplier')->count(),
            'active' => Company::where('is_active', true)->count(),
        ];

        return view('admin.companies.index', compact(
            'companies',
            'stats',
            'type',
            'search',
            'status'
        ));
    }

    public function create($type = 'company')
    {
        // Define sub-types based on Company type
        $subTypes = $this->getSubTypes($type);

        return view('admin.companies.create', compact('type', 'subTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,customer,supplier',
            'sub_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:companies,email',
            'phone' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:50',
            'bin' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'trade_license' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Generate code if not provided
        if (!isset($validated['code'])) {
            $validated['code'] = $this->generateCode($validated['type']);
        }

        // Set default is_active if not provided
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        Company::create($validated);

        return redirect()->route('admin.companies.index', ['type' => $request->type])
            ->with('success', ucfirst($request->type) . ' created successfully.');
    }

    public function show(Company $Company)
    {
        $totalInvoice = Invoice::where('customer_id', $Company->id)->count();
        $totalValue = SalesOrder::where('customer_id', $Company->id)->sum('total_amount');
        $order = SalesOrder::count();
        return view('admin.companies.show', compact('Company', 'totalInvoice', 'totalValue', 'order'));
    }

    public function edit(Company $Company)
    {
        $types = Company::select('type')->distinct()->pluck('type')->toArray();

        return view('admin.companies.edit', compact('types', 'Company'));
    }

    public function update(Request $request, Company $Company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,customer,supplier',
            'sub_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:companies,email,' . $Company->id,
            'phone' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:50',
            'bin' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'trade_license' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $Company->update($validated);

        return redirect()->route('admin.companies.index', ['type' => $Company->type])
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $Company)
    {
        $type = $Company->type;
        $Company->delete();

        return redirect()->route('admin.companies.index', ['type' => $type])
            ->with('success', 'Company deleted successfully.');
    }

    /**
     * Get sub-types based on Company type
     */
    private function getSubTypes($type)
    {
        if ($type == 'company') {
            return ['private', 'public']; // removed 'llc' as it's commented in your template
        } elseif ($type == 'customer') {
            return ['retail', 'wholesale', 'corporate'];
        } elseif ($type == 'supplier') {
            return ['local', 'international'];
        }

        return [];
    }

    /**
     * Generate unique Company code
     */
    private function generateCode($type)
    {
        $prefix = strtoupper(substr($type, 0, 4));

        // Find the latest code with this prefix
        $latest = Company::where('code', 'like', $prefix . '%')
            ->orderBy('code', 'desc')
            ->first();

        if ($latest && preg_match('/' . $prefix . '(\d+)/', $latest->code, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Toggle Company status
     */
    public function toggleStatus(Company $Company)
    {
        $Company->update([
            'is_active' => !$Company->is_active
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
