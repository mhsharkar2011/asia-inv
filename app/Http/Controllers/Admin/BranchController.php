<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $companies = Company::where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.branches.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['company_id'] = $validated['company_id'] ?? Company::first()->id;

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $companies = Company::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.branches.edit', compact('branch', 'companies'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->is_active = !$branch->is_active;
            $branch->save();
            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.branches.index')
                ->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
}
