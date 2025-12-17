<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Product;
use App\Models\Sales\SalesOrder;
use App\Models\Sales\Customer;
use App\Models\Sales\SalesOrderItem;
use App\Models\Sales\SalesOrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    // In SalesOrderController.php

    public function create()
    {
        try {
            $order_number = 'SO-' . date('YmdHis');
            $customers = Customer::where('is_active', true)->orderBy('customer_name')->get();
            $products = Product::where('is_active', true)->orderBy('product_name')->get();

            return view('sales.sales-orders.create', compact('order_number', 'customers', 'products'));
        } catch (\Exception $e) {
            Log::error('Error loading create sales order form: ' . $e->getMessage());
            return redirect()->route('sales.sales-orders.index')
                ->with('error', 'Error loading form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        Log::info('Store request data:', $request->all());

        // Validate the request
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:1000000',
            'items.*.amount' => 'nullable|numeric|min:0|max:10000000',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_charges' => 'nullable|numeric|min:0',
            'adjustment' => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Calculate totals from items
            $subtotal = 0;
            $totalDiscount = 0;
            $itemsData = []; // Store processed items

            foreach ($request->items as $itemData) {
                // Skip if product_id is empty
                if (empty($itemData['product_id'])) {
                    continue;
                }

                // Get product to get description
                $product = Product::find($itemData['product_id']);
                if (!$product) {
                    throw new \Exception("Product with ID {$itemData['product_id']} not found");
                }

                $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
                $itemDiscountAmount = $itemTotal * ($itemData['discount'] ?? 0) / 100;

                $subtotal += $itemTotal;
                $totalDiscount += $itemDiscountAmount;

                // Store processed item data
                $itemsData[] = [
                    'product' => $product,
                    'data' => $itemData,
                    'item_total' => $itemTotal,
                    'total_discount' => $itemDiscountAmount,
                    'total_amount' => $itemTotal - $itemDiscountAmount,
                ];
            }

            // Check if any valid items were found
            if (empty($itemsData)) {
                throw new \Exception('No valid items were added to the order');
            }

            $taxableAmount = $subtotal - $totalDiscount;
            $taxAmount = $taxableAmount * ($request->tax_rate ?? 15) / 100;
            $totalAmount = $taxableAmount + $taxAmount + ($request->shipping_charges ?? 0) + ($request->adjustment ?? 0);

            // Create sales order
            $salesOrder = new SalesOrder([
                'order_number' => $request->order_number ?? 'SO-' . date('YmdHis'),
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'delivery_date' => $request->delivery_date,
                'sales_person' => $request->sales_person,
                'reference_number' => $request->reference_number,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'shipping_method' => $request->shipping_method,
                'payment_terms' => $request->payment_terms,
                'payment_status' => $request->payment_status ?? 'pending',
                'due_date' => $request->due_date,
                'status' => $request->action === 'confirm' ? 'confirmed' : 'draft',
                'tax_rate' => $request->tax_rate ?? 15,
                'shipping_charges' => $request->shipping_charges ?? 0,
                'adjustment' => $request->adjustment ?? 0,
                'notes' => $request->notes,
                'terms_conditions' => $request->terms_conditions,
                'currency' => $request->currency ?? 'BDT',
                'created_by' => Auth::id(),
                'subtotal' => $subtotal,
                'total_discount' => $totalDiscount,
                'taxable_amount' => $taxableAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);

            // Save the sales order
            if (!$salesOrder->save()) {
                throw new \Exception('Failed to create sales order record');
            }

            Log::info('Sales order created with ID:', ['id' => $salesOrder->id]);

            // Create order items
            $createdItems = 0;
            foreach ($itemsData as $itemInfo) {
                $product = $itemInfo['product'];
                $itemData = $itemInfo['data'];

                $item = new SalesOrderItem([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $itemData['product_id'],
                    'description' => $product->product_name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_percentage' => $itemData['total_discount'] ?? 0,
                    'discount' => $itemInfo['total_discount'],
                    'amount' => $itemInfo['total_amount'],
                    'item_total' => $itemInfo['item_total'],
                ]);

                if ($item->save()) {
                    $createdItems++;
                    Log::info('Order item created:', ['product_id' => $itemData['product_id']]);
                } else {
                    throw new \Exception("Failed to create order item for product: {$product->product_name}");
                }
            }

            // Check if any items were created
            if ($createdItems === 0) {
                throw new \Exception('Failed to create any order items');
            }

            DB::commit();

            Log::info('Sales order created successfully:', [
                'order_id' => $salesOrder->id,
                'order_number' => $salesOrder->order_number,
                'item_count' => $createdItems,
                'total_amount' => $salesOrder->total_amount,
            ]);

            return redirect()
                ->route('sales.sales-orders.show', $salesOrder)
                ->with('success', 'Sales order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Sales order creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
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
        $products = Product::where('is_active', '1')->orderBy('product_name')->get();
        $customers = Customer::where('is_active', '1')->orderBy('customer_name')->get();

        return view('sales.sales-orders.edit', compact('salesOrder','products', 'customers'));
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
            'items.*.description' => 'nullable|string',
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
                        // 'description' => $itemData['description'],
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
                        // 'description' => $itemData['description'],
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
        return redirect()->route('sales.invoices.create', ['sales_order_id' => $salesOrder->id])
            ->with('info', 'Creating invoice from sales order...');
    }


    public function confirm(SalesOrder $salesOrder)
    {
        DB::beginTransaction();

        try {
            // Validate that order can be confirmed
            if ($salesOrder->status != 'draft') {
                return redirect()->route('sales.sales-orders.show', $salesOrder)
                    ->with('error', 'Only draft orders can be confirmed.');
            }

            // Update the status
            $salesOrder->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::id(),
            ]);

            // Optional: Create status history record
            if (class_exists('App\Models\SalesOrderStatusHistory')) {
                SalesOrderStatusHistory::create([
                    'sales_order_id' => $salesOrder->id,
                    'status' => 'confirmed',
                    'notes' => 'Order confirmed',
                    'changed_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('success', 'Order confirmed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error confirming order: ' . $e->getMessage());

            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('error', 'Failed to confirm order: ' . $e->getMessage());
        }
    }
}
