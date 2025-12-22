<?php

namespace App\Http\Controllers\Admin;

Use App\Http\Controllers\Controller;
use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use App\Http\Requests\Admin\BranchRequest;
use App\Models\Admin\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $type = $request->input('type');
        $company = $request->input('company_id');

        $branches = Branch::with('company')
            ->withCount(['users', 'warehouses'])
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status, function ($query, $status) {
                if ($status === 'active') {
                    return $query->active();
                } elseif ($status === 'inactive') {
                    return $query->inactive();
                } elseif ($status === 'head_office') {
                    return $query->headOffice();
                }
            })
            ->when($type, function ($query, $type) {
                return $query->byType($type);
            })
            ->when($company, function ($query, $company) {
                return $query->byCompany($company);
            })
            ->orderBy('is_head_office', 'desc')
            ->orderBy('is_active', 'desc')
            ->orderBy('branch_name')
            ->paginate(15);

        $companies = Organization::active()->orderBy('name')->get();

        $branchTypes = [
            'retail' => 'Retail Store',
            'warehouse' => 'Warehouse',
            'office' => 'Office',
            'factory' => 'Factory',
            'distribution' => 'Distribution Center',
            'service' => 'Service Center'
        ];

        // Statistics
        $totalStaff = User::count();
        $totalBranches = Branch::count();
        $activeBranches = Branch::active()->count();
        $headOffices = Branch::headOffice()->count();
        $branchesWithWarehouse = Branch::withWarehouse()->count();

        return view('admin.branches.index', compact(
            'totalStaff',
            'branches',
            'companies',
            'branchTypes',
            'totalBranches',
            'activeBranches',
            'headOffices',
            'branchesWithWarehouse',
            'search',
            'status',
            'type',
            'company'
        ));
    }

    public function create()
    {
        $companies = Company::active()->orderBy('name')->get();

        $branchTypes = [
            'retail' => 'Retail Store',
            'warehouse' => 'Warehouse',
            'office' => 'Office',
            'factory' => 'Factory',
            'distribution' => 'Distribution Center',
            'service' => 'Service Center'
        ];

        // Auto-generate next code
        $lastBranch = Branch::latest()->first();
        $nextCode = 'BRN' . str_pad(($lastBranch ? Branch::count() + 1 : 1), 3, '0', STR_PAD_LEFT);

        return view('admin.branches.create', compact('companies', 'branchTypes', 'nextCode'));
    }

    public function store(BranchRequest $request)
    {
        try {
            DB::beginTransaction();

            $branch = Branch::create($request->validated());

            // If this is set as head office, update other branches
            if ($branch->is_head_office) {
                Branch::where('company_id', $branch->company_id)
                    ->where('id', '!=', $branch->id)
                    ->update(['is_head_office' => false]);
            }

            DB::commit();

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error creating branch: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Branch $branch)
    {
        $branch->load(['company', 'users', 'warehouses']);

        // Get branch statistics
        $stats = [
            'total_staff' => $branch->users()->count(),
            'active_staff' => $branch->users()->where('is_active', true)->count(),
            'total_warehouses' => $branch->warehouses()->count(),
            'active_warehouses' => $branch->warehouses()->where('is_active', true)->count(),
            'inventory_value' => 0, // You can calculate this based on your business logic
        ];

        return view('admin.branches.show', compact('branch', 'stats'));
    }

    public function edit(Branch $branch)
    {
        $companies = Organization::active()->orderBy('name')->get();

        $branchTypes = [
            'retail' => 'Retail Store',
            'warehouse' => 'Warehouse',
            'office' => 'Office',
            'factory' => 'Factory',
            'distribution' => 'Distribution Center',
            'service' => 'Service Center'
        ];

        return view('admin.branches.edit', compact('branch', 'companies', 'branchTypes'));
    }

    public function update(BranchRequest $request, Branch $branch)
    {
        try {
            DB::beginTransaction();

            $oldHeadOfficeStatus = $branch->is_head_office;

            $branch->update($request->validated());

            // If this is set as head office, update other branches
            if ($branch->is_head_office && !$oldHeadOfficeStatus) {
                Branch::where('company_id', $branch->company_id)
                    ->where('id', '!=', $branch->id)
                    ->update(['is_head_office' => false]);
            }

            DB::commit();

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error updating branch: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Branch $branch)
    {
        // Check if branch can be deleted
        if (!$branch->canBeDeleted()) {
            return redirect()->back()
                ->with('error', 'Cannot delete branch. It has staff members or warehouses assigned.');
        }

        try {
            // If this is head office, assign new head office
            if ($branch->is_head_office) {
                $newHeadOffice = Branch::where('company_id', $branch->company_id)
                    ->where('id', '!=', $branch->id)
                    ->first();

                if ($newHeadOffice) {
                    $newHeadOffice->update(['is_head_office' => true]);
                }
            }

            $branch->delete();

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting branch: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Branch $branch)
    {
        try {
            // Cannot deactivate head office
            if ($branch->is_head_office && $branch->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot deactivate head office branch.'
                ], 400);
            }

            $branch->update(['is_active' => !$branch->is_active]);

            return response()->json([
                'success' => true,
                'is_active' => $branch->is_active,
                'message' => 'Branch status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating branch status.'
            ], 500);
        }
    }

    public function setHeadOffice(Branch $branch)
    {
        try {
            DB::beginTransaction();

            // Remove head office status from other branches of same company
            Branch::where('company_id', $branch->company_id)
                ->update(['is_head_office' => false]);

            // Set this branch as head office
            $branch->update(['is_head_office' => true, 'is_active' => true]);

            DB::commit();

            return redirect()->route('admin.branches.index')
                ->with('success', 'Branch set as head office successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error setting head office: ' . $e->getMessage());
        }
    }

    public function getByCompany($companyId)
    {
        $branches = Branch::where('company_id', $companyId)
            ->active()
            ->orderBy('branch_name')
            ->get(['id', 'branch_code', 'branch_name']);

        return response()->json($branches);
    }

    public function export(Request $request)
    {
        // Export branches to CSV/Excel
        return response()->streamDownload(function () {
            $branches = Branch::with('company')->get();
            $handle = fopen('php://output', 'w');

            // Add headers
            fputcsv($handle, ['Code', 'Name', 'Company', 'Type', 'City', 'Phone', 'Status', 'Staff Count', 'Created At']);

            // Add data
            foreach ($branches as $branch) {
                fputcsv($handle, [
                    $branch->branch_code,
                    $branch->branch_name,
                    $branch->company->name,
                    ucfirst($branch->branch_type),
                    $branch->city,
                    $branch->phone,
                    $branch->is_active ? 'Active' : 'Inactive',
                    $branch->staff_count,
                    $branch->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($handle);
        }, 'branches-' . date('Y-m-d') . '.csv');
    }
}
