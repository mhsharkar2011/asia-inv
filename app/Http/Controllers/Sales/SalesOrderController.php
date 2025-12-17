<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\SalesOrder;
use App\Models\Sales\Customer;
use App\Models\Sales\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalesOrder::with('customer')->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('is_active') && $request->status != 'all') {
            $query->where('is_active', $request->status);
        }

        $salesOrders = $query->paginate(20);

        return view('sales.sales-orders.index', compact('salesOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customers = Customer::where('is_active', '1')->orderBy('customer_name')->get();
        $order_number = SalesOrder::generateOrderNumber();
        $selected_customer_id = $request->customer_id;

        return view('sales.sales-orders.create', compact('customers', 'order_number', 'selected_customer_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Debug the incoming request
    \Log::info('Store request data:', $request->all());

    // Enhanced validation
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'order_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0|max:100',
    ]);

    DB::beginTransaction();

    try {
        // Generate order number
        $orderNumber = $request->order_number ?? SalesOrder::generateOrderNumber();

        // Create sales order
        $salesOrder = SalesOrder::create([
            'order_number' => $orderNumber,
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'status' => 'draft',
            'created_by' => auth()->id(),
            // Add other fields as needed
        ]);

        if (!$salesOrder) {
            throw new \Exception('Failed to create sales order');
        }

        // Process items - ensure all required fields exist
        foreach ($request->items as $itemData) {
            // Skip if product_id is empty
            if (empty($itemData['product_id'])) {
                continue;
            }

            $item = new SalesOrderItem([
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'discount_percentage' => $itemData['discount'] ?? 0,
            ]);

            $item->calculateTotals();
            $salesOrder->items()->save($item);
        }

        // Check if any items were added
        if ($salesOrder->items()->count() === 0) {
            throw new \Exception('No valid items were added to the order');
        }

        // Calculate and save order totals
        $salesOrder->calculateTotals();
        $salesOrder->save();

        DB::commit();

        return redirect()
            ->route('sales-orders.show', $salesOrder)
            ->with('success', 'Sales order created successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Sales order creation failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        return back()
            ->withInput()
            ->with('error', 'Failed to create sales order: ' . $e->getMessage());
    }
}
    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load(['customer', 'items']);
        return view('sales.sales-orders.show', compact('salesOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft') {
            return redirect()->route('sales.sales-orders.show', $salesOrder->id)
                ->with('error', 'Only draft sales orders can be edited.');
        }

        $salesOrder->load('items');
        $customers = Customer::where('status', 'active')->orderBy('name')->get();

        return view('sales.sales-orders.edit', compact('salesOrder', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft') {
            return redirect()->route('sales.sales-orders.show', $salesOrder->id)
                ->with('error', 'Only draft sales orders can be edited.');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'sales_person' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'shipping_method' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'shipping_charges' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:sales_order_items,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            // Update sales order details
            $salesOrder->update([
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'delivery_date' => $validated['delivery_date'],
                'sales_person' => $validated['sales_person'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'shipping_address' => $validated['shipping_address'] ?? null,
                'billing_address' => $validated['billing_address'] ?? null,
                'shipping_method' => $validated['shipping_method'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
                'shipping_charges' => $validated['shipping_charges'] ?? 0,
                'notes' => $validated['notes'] ?? null,
                'terms_conditions' => $validated['terms_conditions'] ?? null,
                'status' => $request->input('action') == 'save_draft' ? 'draft' : 'confirmed',
            ]);

            // Update or create items
            $existingItemIds = $salesOrder->items->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($validated['items'] as $itemData) {
                if (isset($itemData['id'])) {
                    // Update existing item
                    $item = \App\Models\Sales\SalesOrderItem::find($itemData['id']);
                    $item->fill([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'discount_percentage' => $itemData['discount_percentage'] ?? 0,
                    ]);
                    $item->calculateTotals();
                    $item->save();
                    $updatedItemIds[] = $itemData['id'];
                } else {
                    // Create new item
                    $item = new \App\Models\Sales\SalesOrderItem([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'discount_percentage' => $itemData['discount_percentage'] ?? 0,
                    ]);
                    $item->calculateTotals();
                    $salesOrder->items()->save($item);
                }
            }

            // Delete removed items
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                \App\Models\Sales\SalesOrderItem::whereIn('id', $itemsToDelete)->delete();
            }

            // Recalculate totals
            $salesOrder->calculateTotals();

            DB::commit();

            return redirect()->route('sales.sales-orders.show', $salesOrder->id)
                ->with('success', 'Sales order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating sales order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'draft') {
            return redirect()->route('sales.sales-orders.show', $salesOrder->id)
                ->with('error', 'Only draft sales orders can be deleted.');
        }

        $salesOrder->delete();

        return redirect()->route('sales.sales-orders.index')
            ->with('success', 'Sales order deleted successfully.');
    }

    /**
     * Change status of sales order.
     */
    public function changeStatus(Request $request, SalesOrder $salesOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $salesOrder->update([
            'status' => $validated['status'],
        ]);

        // Add status change note if provided
        if ($validated['notes']) {
            // You might want to log this in an activity log
        }

        return redirect()->back()
            ->with('success', 'Sales order status updated successfully.');
    }

    /**
     * Convert sales order to invoice.
     */
    public function convertToInvoice(SalesOrder $salesOrder)
    {
        return redirect()->route('invoices.create', ['sales_order_id' => $salesOrder->id])
            ->with('info', 'Creating invoice from sales order...');
    }
}
