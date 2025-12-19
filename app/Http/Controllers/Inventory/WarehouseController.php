<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $warehouses = Warehouse::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $activeWarehouses = Warehouse::where('is_active', true)->count();
        $totalWarehouses = $warehouses->total();
        $activePercentage = $totalWarehouses > 0 ? round(($activeWarehouses / $totalWarehouses) * 100) : 0;

        $totalCapacity = Warehouse::sum('capacity');
        $currentOccupancy = Warehouse::sum('current_occupancy');
        $capacityUtilization = $totalCapacity > 0 ? round(($currentOccupancy / $totalCapacity) * 100) : 0;

        $totalStaff = Warehouse::sum('staff_count');
        $avgStaffPerWarehouse = $totalWarehouses > 0 ? round($totalStaff / $totalWarehouses) : 0;

        return view('inventory.warehouse.index', compact(
            'warehouses',
            'activeWarehouses',
            'activePercentage',
            'totalCapacity',
            'capacityUtilization',
            'totalStaff',
            'avgStaffPerWarehouse'
        ));
    }

    public function create()
    {
        return view('inventory.warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses',
            'address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'required|numeric|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Warehouse::create($validated);

        return redirect()->route('inventory.warehouses.index')
            ->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse)
    {
        return view('inventory.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('inventory.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'required|numeric|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $warehouse->update($validated);

        return redirect()->route('inventory.warehouses.index')
            ->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('inventory.warehouses.index')
            ->with('success', 'Warehouse deleted successfully.');
    }

    public function toggleStatus(Warehouse $warehouse)
    {
        $warehouse->update(['is_active' => !$warehouse->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $warehouse->is_active
        ]);
    }
}
