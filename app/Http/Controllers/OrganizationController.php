<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $organizations = Organization::query()
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status, function ($query, $status) {
                return $status === 'active'
                    ? $query->active()
                    : $query->where('is_active', false);
            })
            ->orderBy('name')
            ->paginate(20);

        $stats = [
            'companies' => Organization::companies()->count(),
            'customers' => Organization::customers()->count(),
            'suppliers' => Organization::suppliers()->count(),
            'active' => Organization::active()->count(),
        ];

        return view('admin.organizations.index', compact(
            'organizations', 'stats', 'type', 'search', 'status'
        ));
    }

    public function create($type = 'company')
    {
        return view('admin.organizations.create', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,customer,supplier',
            'sub_type' => 'nullable|string',
            'email' => 'nullable|email|unique:organizations,email',
            'phone' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:50',
            'bin' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        Organization::create($validated);

        return redirect()->route('admin.organizations.index', ['type' => $request->type])
            ->with('success', ucfirst($request->type) . ' created successfully.');
    }
}
