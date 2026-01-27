<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users who are managers for the dropdown
        $managers = Warehouse::with('manager')->get()->pluck('manager')->unique();

        $warehouses = Warehouse::with(['manager'])
            ->latest()
            ->paginate(20);

        // Calculate statistics
        $totalWarehouses = Warehouse::count();
        $activeWarehouses = Warehouse::where('status', true)->count();
        $activePercentage = $totalWarehouses > 0 ? round(($activeWarehouses / $totalWarehouses) * 100) : 0;
        $totalCapacity = Warehouse::sum('capacity');
        $totalStaff = Warehouse::sum('staff_count');
        $avgStaffPerWarehouse = $totalWarehouses > 0 ? round($totalStaff / $totalWarehouses, 1) : 0;

        // Calculate capacity utilization
        $totalOccupancy = Warehouse::sum('current_occupancy');
        $capacityUtilization = $totalCapacity > 0 ? round(($totalOccupancy / $totalCapacity) * 100) : 0;

        return view('admin.warehouses.index', compact(
            'warehouses',
            'managers',
            'totalWarehouses',
            'activeWarehouses',
            'activePercentage',
            'totalCapacity',
            'totalStaff',
            'avgStaffPerWarehouse',
            'capacityUtilization'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'address' => 'nullable|string',
            'capacity' => 'nullable|numeric|min:0',
            'current_occupancy' => 'nullable|numeric|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|integer|in:0,1',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Convert string values to appropriate types
            $data = [
                'name' => $validated['name'],
                'code' => $validated['code'],
                'address' => $validated['address'] ?? null,
                'capacity' => $validated['capacity'] ?? null,
                'current_occupancy' => $validated['current_occupancy'] ?? null,
                'staff_count' => $validated['staff_count'] ?? null,
                'manager_id' => $validated['manager_id'] ?? null,
                'status' => (bool) $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ];

            $warehouse = Warehouse::create($data);
        });

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        $warehouse->load(['manager', 'creator', 'updater']);

        return view('admin.warehouses.show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        $managers = User::whereHas('roles', function ($query) {
            $query->where('name', 'manager');
        })->orWhere('role', 'manager')->get();

        return view('admin.warehouses.edit', compact('warehouse', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'address' => 'nullable|string',
            'capacity' => 'nullable|numeric|min:0',
            'current_occupancy' => 'nullable|numeric|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|integer|in:0,1',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($warehouse, $validated) {
            $warehouse->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'address' => $validated['address'] ?? null,
                'capacity' => $validated['capacity'] ?? null,
                'current_occupancy' => $validated['current_occupancy'] ?? null,
                'staff_count' => $validated['staff_count'] ?? null,
                'manager_id' => $validated['manager_id'] ?? null,
                'status' => (bool) $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'updated_by' => Auth::id(),
            ]);
        });

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // Check if warehouse has inventory
        if ($warehouse->inventory()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete warehouse that has inventory. Please transfer inventory first.');
        }

        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse deleted successfully.');
    }

    /**
     * Toggle warehouse status
     */
    public function toggleStatus(Request $request, Warehouse $warehouse)
    {
        $newStatus = !$warehouse->status; // Toggle boolean

        $warehouse->update([
            'status' => $newStatus,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $newStatus,
        ]);
    }

    /**
     * Get warehouse statistics
     */
    public function statistics()
    {
        $stats = [
            'total_warehouses' => Warehouse::count(),
            'active_warehouses' => Warehouse::where('status', true)->count(),
            'total_capacity' => Warehouse::sum('capacity'),
            'used_capacity' => Warehouse::sum('current_occupancy'),
        ];

        return response()->json($stats);
    }

}
