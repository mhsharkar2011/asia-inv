<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Department;
use App\Models\Admin\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request, Department $department)
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
                $q->where('name', 'manager');
            })
            ->get();

        return view('admin.departments.index', compact('departments','department', 'allDepartments', 'managers'));
    }

    public function edit(Department $department)
    {
        return response()->json($department);
    }

    // Other controller methods...
}
