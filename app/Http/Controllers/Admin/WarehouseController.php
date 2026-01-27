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
        $warehouses = Warehouse::with(['manager'])
            ->latest()
            ->paginate(20);

        // Calculate statistics
        $totalWarehouses = $warehouses->total();
        $activeWarehouses = $warehouses->where('status', true)->count();
        $activePercentage = $totalWarehouses > 0 ? round(($activeWarehouses / $totalWarehouses) * 100) : 0;
        $totalCapacity = $warehouses->sum('capacity');
        $totalStaff = $warehouses->sum('staff_count');
        $avgStaffPerWarehouse = $totalWarehouses > 0 ? round($totalStaff / $totalWarehouses, 1) : 0;

        // Calculate capacity utilization (if you have occupancy data)
        $totalOccupancy = $warehouses->sum('current_occupancy');
        $capacityUtilization = $totalCapacity > 0 ? round(($totalOccupancy / $totalCapacity) * 100) : 0;

        $managers = Warehouse::with('manager')->get()->pluck('manager')->unique();


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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'capacity' => 'nullable|numeric|min:0',
            'status' => 'required|integer|in:0,1',
            'is_default' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // If this is set as default, remove default from others
            if ($request->is_default) {
                Warehouse::where('is_default', true)->update(['is_default' => false]);
            }

            $warehouse = Warehouse::create([
                ...$validated,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // If no warehouse is default yet and this is active, make it default
            if (!Warehouse::where('is_default', true)->exists() && $warehouse->status === '1') {
                $warehouse->update(['is_default' => true]);
            }
        });

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Warehouse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        $warehouse->load(['creator', 'updater', 'zones', 'racks', 'bins']);

        return view('admin.warehouses.show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'capacity' => 'nullable|numeric|min:0',
            'status' => 'required|integer|in:0,1',
            'is_default' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($warehouse, $validated) {
            // If this is set as default, remove default from others
            if ($request->is_default) {
                Warehouse::where('is_default', true)
                    ->where('id', '!=', $warehouse->id)
                    ->update(['is_default' => false]);
            }

            $warehouse->update([
                ...$validated,
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

        // Check if it's the default warehouse
        if ($warehouse->is_default) {
            return redirect()->back()
                ->with('error', 'Cannot delete default warehouse. Set another warehouse as default first.');
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
        $newStatus = $warehouse->status === '1' ? '0' : '1';

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
     * Set as default warehouse
     */
    public function setDefault(Warehouse $warehouse)
    {
        $warehouse->markAsDefault();

        return response()->json([
            'success' => true,
            'message' => 'Warehouse set as default successfully',
        ]);
    }

    /**
     * Get warehouse statistics
     */
    public function statistics()
    {
        $stats = [
            'total_warehouses' => Warehouse::count(),
            'active_warehouses' => Warehouse::active()->count(),
            'total_capacity' => Warehouse::sum('capacity'),
            'used_capacity' => Warehouse::sum('used_capacity'),
            'default_warehouse' => Warehouse::default()->first(),
        ];

        return response()->json($stats);
    }
}
