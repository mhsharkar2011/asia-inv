<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Department;
use App\Models\Admin\User;
use App\Http\Requests\Admin\DepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $parent = $request->input('parent_id');

        // Get hierarchical departments
        $departments = Department::with(['manager', 'parent', 'children'])
            ->withCount(['users', 'children'])
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->when($status, function ($query, $status) {
                if ($status === 'active') {
                    return $query->active();
                } elseif ($status === 'inactive') {
                    return $query->inactive();
                }
            })
            ->when($parent, function ($query, $parent) {
                if ($parent === 'null') {
                    return $query->topLevel();
                } else {
                    return $query->where('parent_id', $parent);
                }
            })
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        // Get all departments for parent select
        $allDepartments = Department::active()
            ->orderBy('name')
            ->get();

        // Get managers for select
        $managers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['manager', 'admin', 'super_admin']);
            })
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Statistics
        $totalDepartments = Department::count();
        $activeDepartments = Department::active()->count();
        $inactiveDepartments = Department::inactive()->count();
        $topLevelDepartments = Department::topLevel()->count();

        return view('admin.departments.index', compact(
            'departments',
            'allDepartments',
            'managers',
            'totalDepartments',
            'activeDepartments',
            'inactiveDepartments',
            'topLevelDepartments',
            'search',
            'status',
            'parent'
        ));
    }

    public function create()
    {
        $departments = Department::active()
            ->orderBy('name')
            ->get();

        $managers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['manager', 'admin', 'super_admin']);
            })
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Auto-generate next code
        $lastDepartment = Department::latest()->first();
        $nextCode = 'DEPT' . str_pad(($lastDepartment ? Department::count() + 1 : 1), 3, '0', STR_PAD_LEFT);

        return view('admin.departments.create', compact('departments', 'managers', 'nextCode'));
    }

    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();

            $department = Department::create($request->validated());

            // If this is a sub-department, update parent's staff count
            if ($department->parent_id) {
                $parent = Department::find($department->parent_id);
                if ($parent) {
                    // You might want to update parent's stats here
                }
            }

            DB::commit();

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error creating department: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Department $department)
    {
        $department->load(['manager', 'parent', 'children', 'users']);

        // Get department hierarchy
        $hierarchy = $this->getDepartmentHierarchy($department);

        // Get department statistics
        $stats = [
            'total_staff' => $department->users()->count(),
            'active_staff' => $department->users()->where('is_active', true)->count(),
            'sub_departments' => $department->children()->count(),
            'budget_utilization' => 0, // You can calculate this based on your business logic
        ];

        return view('admin.departments.show', compact('department', 'hierarchy', 'stats'));
    }

    public function edit(Department $department)
    {
        $departments = Department::active()
            ->where('id', '!=', $department->id)
            ->orderBy('name')
            ->get();

        $managers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['manager', 'admin', 'super_admin']);
            })
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.departments.edit', compact('department', 'departments', 'managers'));
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try {
            DB::beginTransaction();

            $oldParentId = $department->parent_id;

            $department->update($request->validated());

            // Handle parent change
            if ($oldParentId != $department->parent_id) {
                // Update old parent's stats if needed
                if ($oldParentId) {
                    $oldParent = Department::find($oldParentId);
                    // Update stats
                }

                // Update new parent's stats if needed
                if ($department->parent_id) {
                    $newParent = Department::find($department->parent_id);
                    // Update stats
                }
            }

            DB::commit();

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Error updating department: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Department $department)
    {
        // Check if department can be deleted
        if (!$department->canBeDeleted()) {
            return redirect()->back()
                ->with('error', 'Cannot delete department. It has staff members or sub-departments.');
        }

        try {
            $department->delete();

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Department $department)
    {
        try {
            $department->update(['is_active' => !$department->is_active]);

            return response()->json([
                'success' => true,
                'is_active' => $department->is_active,
                'message' => 'Department status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating department status.'
            ], 500);
        }
    }

    public function getHierarchy(Request $request)
    {
        $departments = Department::with(['children' => function ($query) {
                $query->withCount('users');
            }])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json($departments);
    }

    private function getDepartmentHierarchy(Department $department): array
    {
        $hierarchy = [];
        $current = $department;

        while ($current) {
            $hierarchy[] = $current;
            $current = $current->parent;
        }

        return array_reverse($hierarchy);
    }
}
