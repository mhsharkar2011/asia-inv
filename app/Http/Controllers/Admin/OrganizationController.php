<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Organization;
use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrder;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Organization::query();

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

        $organizations = $query->orderBy('name')->paginate(20);

        $stats = [
            'companies' => Organization::where('type', 'company')->count(),
            'customers' => Organization::where('type', 'customer')->count(),
            'suppliers' => Organization::where('type', 'supplier')->count(),
            'active' => Organization::where('is_active', true)->count(),
        ];

        return view('admin.organizations.index', compact(
            'organizations',
            'stats',
            'type',
            'search',
            'status'
        ));
    }

    public function create($type = 'company')
    {
        // Define sub-types based on organization type
        $subTypes = $this->getSubTypes($type);

        return view('admin.organizations.create', compact('type', 'subTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,customer,supplier',
            'sub_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:organizations,email',
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

        Organization::create($validated);

        return redirect()->route('admin.organizations.index', ['type' => $request->type])
            ->with('success', ucfirst($request->type) . ' created successfully.');
    }

    public function show(Organization $organization)
    {
        $totalInvoice = Invoice::where('customer_id', $organization->id)->count();
        $totalValue = SalesOrder::where('customer_id', $organization->id)->sum('total_amount');
        $order = SalesOrder::count();
        return view('admin.organizations.show', compact('organization', 'totalInvoice', 'totalValue', 'order'));
    }

    public function edit(Organization $organization)
    {
        $types = Organization::select('type')->distinct()->pluck('type')->toArray();

        return view('admin.organizations.edit', compact('types', 'organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,customer,supplier',
            'sub_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|unique:organizations,email,' . $organization->id,
            'phone' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:50',
            'bin' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'trade_license' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $organization->update($validated);

        return redirect()->route('admin.organizations.index', ['type' => $organization->type])
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $type = $organization->type;
        $organization->delete();

        return redirect()->route('admin.organizations.index', ['type' => $type])
            ->with('success', 'Organization deleted successfully.');
    }

    /**
     * Get sub-types based on organization type
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
     * Generate unique organization code
     */
    private function generateCode($type)
    {
        $prefix = strtoupper(substr($type, 0, 4));

        // Find the latest code with this prefix
        $latest = Organization::where('code', 'like', $prefix . '%')
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
     * Toggle organization status
     */
    public function toggleStatus(Organization $organization)
    {
        $organization->update([
            'is_active' => !$organization->is_active
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
