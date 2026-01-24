<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with(['manager', 'parent', 'children'])
            ->withCount(['users as active_staff_count' => function ($q) {
                $q->where('is_active', true);
            }]);

        // Apply filters
        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('level') && $request->level === 'top') {
            $query->whereNull('parent_id');
        }

        // Get departments for tree view (top level only)
        $departments = (clone $query)->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        // Get all departments for grid view
        $allDepartments = $query->orderBy('sort_order')->paginate(20);

        // Get managers for dropdown
        $managers = User::where('is_active', true)
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['manager', 'admin']);
            })
            ->get();

        $companies = Company::where('is_active', true)->orderBy('name')->get();

        return view('admin.departments.index', compact('departments', 'allDepartments', 'managers', 'companies'));
    }

    public function create()
    {
        $departments = Department::all();
        $managers = User::where('is_active', true)
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['manager', 'admin']);
            })
            ->get();

        return view('admin.departments.create', compact('departments', 'managers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:departments,code',
            'parent_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'staff_count' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $department = Department::create([
                'company_id' => $request->company_id,
                'name' => $request->name,
                'code' => $request->code,
                'parent_id' => $request->parent_id,
                'manager_id' => $request->manager_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'staff_count' => $request->staff_count ?? 0,
                'budget' => $request->budget ?? 0,
                'location' => $request->location,
                'sort_order' => $request->sort_order ?? 0,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active'),
            ]);

            DB::commit();

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to create department: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Department $department)
    {
        $department->load(['manager', 'parent', 'children.manager', 'users' => function ($q) {
            $q->where('is_active', true);
        }]);

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        // Always return JSON for now to test
        return response()->json([
            'id' => $department->id,
            'company_id' => $department->company_id,
            'name' => $department->name,
            'code' => $department->code,
            'parent_id' => $department->parent_id,
            'manager_id' => $department->manager_id,
            'email' => $department->email,
            'phone' => $department->phone,
            'staff_count' => $department->staff_count,
            'budget' => $department->budget,
            'location' => $department->location,
            'sort_order' => $department->sort_order,
            'description' => $department->description,
            'is_active' => $department->is_active,
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:departments,code,' . $department->id,
            'parent_id' => 'nullable|exists:departments,id',
            'manager_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'staff_count' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Prevent circular reference - a department cannot be its own parent
            if ($request->parent_id == $department->id) {
                throw new \Exception('Department cannot be its own parent.');
            }

            // Check if parent is a descendant - simple version without descendants() method
            if ($request->parent_id) {
                $this->checkIfParentIsDescendant($department, $request->parent_id);
            }

            $department->update([
                'company_id' => $request->company_id,
                'name' => $request->name,
                'code' => $request->code,
                'parent_id' => $request->parent_id,
                'manager_id' => $request->manager_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'staff_count' => $request->staff_count ?? $department->staff_count,
                'budget' => $request->budget ?? $department->budget,
                'location' => $request->location,
                'sort_order' => $request->sort_order ?? $department->sort_order,
                'description' => $request->description,
                'is_active' => $request->boolean('is_active'),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department updated successfully.'
                ]);
            }

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to update department: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Add this helper method to the controller
    private function checkIfParentIsDescendant($department, $parentId)
    {
        $current = Department::find($parentId);

        while ($current) {
            if ($current->id == $department->id) {
                throw new \Exception('Cannot set a descendant as parent.');
            }

            // Move up to parent
            $current = $current->parent;

            // If we reach null (top level) and haven't found the department, it's not a descendant
            if ($current === null) {
                break;
            }
        }
    }

    
    public function destroy(Department $department)
    {
        try {
            DB::beginTransaction();

            if (!$department->canBeDeleted()) {
                throw new \Exception('Cannot delete department. It may have users or child departments.');
            }

            $department->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Department deleted successfully.']);
            }

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to delete department: ' . $e->getMessage());
        }
    }

    public function getDescendants(Department $department)
    {
        $descendants = $department->descendants()->pluck('id')->toArray();
        return response()->json($descendants);
    }

    // Additional helper methods for hierarchical data
    public function tree()
    {
        $departments = Department::with(['children.children'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json($departments);
    }
}
