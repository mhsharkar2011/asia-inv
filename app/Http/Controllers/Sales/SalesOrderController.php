<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Product;
use App\Models\Admin\Organization;
use App\Models\Sales\SalesOrder;
use App\Models\Sales\SalesOrderItem;
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
        $query = SalesOrder::with(['customer', 'items'])->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('customer_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $salesOrders = $query->paginate(20);
        $customers = Organization::where('type', 'customer')->orderBy('name')->get();
        $statuses = ['draft', 'pending', 'confirmed', 'processing', 'completed', 'cancelled'];

        return view('sales.sales-orders.index', compact('salesOrders', 'customers', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $order_number = 'SO-' . date('YmdHis');
            $customers = Organization::where('type', 'customer')->orderBy('name')->get();
            $products = Product::where('is_active', true)->orderBy('product_name')->get();

            return view('sales.sales-orders.create', compact('order_number', 'customers', 'products'));
        } catch (\Exception $e) {
            Log::error('Error loading create sales order form: ' . $e->getMessage());
            return redirect()->route('sales.sales-orders.index')
                ->with('error', 'Error loading form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store request data:', $request->all());

        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:organizations,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_charges' => 'nullable|numeric|min:0',
            'adjustment' => 'nullable|numeric',
            'shipping_method' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string|max:50',
            'payment_status' => 'nullable|string|in:pending,partial,paid,overdue',
            'status' => 'nullable|string|in:draft,pending,confirmed,processing,completed,cancelled',
            'currency' => 'nullable|string|in:BDT,USD,EUR',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Calculate totals from items
            $subtotal = 0;
            $totalDiscount = 0;
            $itemsData = [];

            foreach ($request->items as $itemData) {
                // Skip if product_id is empty
                if (empty($itemData['product_id'])) {
                    continue;
                }

                // Get product
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
                    'discount_amount' => $itemDiscountAmount,
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

            // Determine status based on action
            $status = $request->status ?? 'draft';
            if ($request->action === 'confirm') {
                $status = 'confirmed';
            } elseif ($request->action === 'save_confirm') {
                $status = 'confirmed';
            }

            // Create sales order
            $salesOrder = SalesOrder::create([
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
                'status' => $status,
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

            if (!$salesOrder) {
                throw new \Exception('Failed to create sales order record');
            }

            Log::info('Sales order created with ID:', ['id' => $salesOrder->id]);

            // Create order items
            $createdItems = 0;
            foreach ($itemsData as $itemInfo) {
                $product = $itemInfo['product'];
                $itemData = $itemInfo['data'];

                $item = SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $itemData['product_id'],
                    'description' => $product->product_name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_percentage' => $itemData['discount'] ?? 0,
                    'discount_amount' => $itemInfo['discount_amount'],
                    'total_amount' => $itemInfo['total_amount'],
                    'item_total' => $itemInfo['item_total'],
                ]);

                if (!$item) {
                    throw new \Exception("Failed to create order item for product: {$product->product_name}");
                }
                $createdItems++;
            }

            // If confirmed, set confirmed_at
            if ($status === 'confirmed') {
                $salesOrder->update([
                    'confirmed_at' => now(),
                    'confirmed_by' => Auth::id(),
                ]);
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
        $salesOrder->load(['customer', 'items.product', 'createdBy']);
        return view('sales.sales-orders.show', compact('salesOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        // Allow editing of non-draft orders but restrict item modifications
        if ($salesOrder->status !== 'draft') {
            // Still allow viewing but with restrictions
            session()->flash('info', 'This order is ' . $salesOrder->status . '. Only non-item fields can be edited.');
        }

        $salesOrder->load(['customer', 'items.product']);
        $products = Product::where('is_active', true)->orderBy('product_name')->get();
        $customers = Organization::where('type', 'customer')->orderBy('name')->get();

        return view('sales.sales-orders.edit', compact('salesOrder', 'products', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        // For non-draft orders, only allow updates to certain fields
        if ($salesOrder->status !== 'draft') {
            $validator = Validator::make($request->all(), [
                'payment_status' => 'required|string|in:pending,partial,paid,overdue',
                'status' => 'required|string|in:draft,pending,confirmed,processing,completed,cancelled',
                'notes' => 'nullable|string',
                'terms_conditions' => 'nullable|string',
                'shipping_method' => 'nullable|string|max:50',
                'payment_terms' => 'nullable|string|max:50',
                'shipping_charges' => 'nullable|numeric|min:0',
                'adjustment' => 'nullable|numeric',
                'tax_rate' => 'nullable|numeric|min:0|max:100',
                'due_date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            try {
                // Recalculate totals with updated tax, shipping, and adjustment
                $taxableAmount = $salesOrder->taxable_amount;
                $taxAmount = $taxableAmount * ($request->tax_rate ?? $salesOrder->tax_rate) / 100;
                $totalAmount = $taxableAmount + $taxAmount + ($request->shipping_charges ?? $salesOrder->shipping_charges) + ($request->adjustment ?? $salesOrder->adjustment);

                $salesOrder->update([
                    'payment_status' => $request->payment_status,
                    'status' => $request->status,
                    'notes' => $request->notes,
                    'terms_conditions' => $request->terms_conditions,
                    'shipping_method' => $request->shipping_method,
                    'payment_terms' => $request->payment_terms,
                    'shipping_charges' => $request->shipping_charges ?? $salesOrder->shipping_charges,
                    'adjustment' => $request->adjustment ?? $salesOrder->adjustment,
                    'tax_rate' => $request->tax_rate ?? $salesOrder->tax_rate,
                    'due_date' => $request->due_date,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                ]);

                DB::commit();
                return redirect()->route('sales.sales-orders.show', $salesOrder)
                    ->with('success', 'Sales order updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Error updating sales order: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // For draft orders, allow full editing
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'sales_person' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'shipping_method' => 'nullable|string|max:50',
            'payment_terms' => 'nullable|string|max:50',
            'payment_status' => 'nullable|string|in:pending,partial,paid,overdue',
            'due_date' => 'nullable|date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_charges' => 'nullable|numeric|min:0',
            'adjustment' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'currency' => 'nullable|string|in:BDT,USD,EUR',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Update sales order details
            $salesOrder->update([
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
                'tax_rate' => $request->tax_rate ?? 15,
                'shipping_charges' => $request->shipping_charges ?? 0,
                'adjustment' => $request->adjustment ?? 0,
                'notes' => $request->notes,
                'terms_conditions' => $request->terms_conditions,
                'currency' => $request->currency ?? 'BDT',
                'status' => $request->action === 'confirm' ? 'confirmed' : 'draft',
            ]);

            // Delete existing items
            $salesOrder->items()->delete();

            // Create new items
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                if (!$product) continue;

                $itemTotal = $itemData['quantity'] * $itemData['unit_price'];
                $itemDiscountAmount = $itemTotal * ($itemData['discount'] ?? 0) / 100;
                $itemAmount = $itemTotal - $itemDiscountAmount;

                SalesOrderItem::create([
                    'sales_order_id' => $salesOrder->id,
                    'product_id' => $itemData['product_id'],
                    'description' => $product->product_name,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'discount_percentage' => $itemData['discount'] ?? 0,
                    'discount_amount' => $itemDiscountAmount,
                    'total_amount' => $itemAmount,
                    'item_total' => $itemTotal,
                ]);

                $subtotal += $itemTotal;
                $totalDiscount += $itemDiscountAmount;
            }

            // Recalculate totals
            $taxableAmount = $subtotal - $totalDiscount;
            $taxAmount = $taxableAmount * ($request->tax_rate ?? 15) / 100;
            $totalAmount = $taxableAmount + $taxAmount + ($request->shipping_charges ?? 0) + ($request->adjustment ?? 0);

            $salesOrder->update([
                'subtotal' => $subtotal,
                'total_discount' => $totalDiscount,
                'taxable_amount' => $taxableAmount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);

            // If confirmed, set confirmed_at
            if ($request->action === 'confirm') {
                $salesOrder->update([
                    'confirmed_at' => now(),
                    'confirmed_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sales.sales-orders.show', $salesOrder)
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
            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('error', 'Only draft sales orders can be deleted.');
        }

        try {
            $salesOrder->delete();
            return redirect()->route('sales.sales-orders.index')
                ->with('success', 'Sales order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('error', 'Error deleting sales order: ' . $e->getMessage());
        }
    }

    /**
     * Change status of sales order.
     */
    public function changeStatus(Request $request, SalesOrder $salesOrder)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:confirmed,processing,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $oldStatus = $salesOrder->status;
            $salesOrder->update([
                'status' => $request->status,
            ]);

            // If confirming, set confirmed_at
            if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
                $salesOrder->update([
                    'confirmed_at' => now(),
                    'confirmed_by' => Auth::id(),
                ]);
            }

            DB::commit();
            return redirect()->back()
                ->with('success', 'Sales order status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    /**
     * Convert sales order to invoice.
     */
    public function convertToInvoice(SalesOrder $salesOrder)
    {
        if ($salesOrder->status !== 'confirmed') {
            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('error', 'Only confirmed sales orders can be converted to invoices.');
        }

        return redirect()->route('sales.invoices.create', ['order_id' => $salesOrder->id])
            ->with('info', 'Creating invoice from sales order...');
    }

    /**
     * Confirm a draft sales order.
     */
    public function confirm(SalesOrder $salesOrder)
    {
        if ($salesOrder->status != 'draft') {
            return redirect()->route('sales.sales-orders.show', $salesOrder)
                ->with('error', 'Only draft orders can be confirmed.');
        }

        DB::beginTransaction();
        try {
            $salesOrder->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => Auth::id(),
            ]);

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

    /**
     * Print sales order.
     */
    public function print(SalesOrder $salesOrder)
    {
        $salesOrder->load(['customer', 'items.product', 'createdBy']);
        $company = Organization::where('type', 'company')->first(); // Adjust based on your company model

        return view('sales.sales-orders.print', compact('salesOrder', 'company'));
    }

    /**
     * Export sales orders to PDF/Excel.
     */
    public function export(Request $request)
    {
        $query = SalesOrder::with(['customer', 'items']);

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('order_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $salesOrders = $query->get();

        // You can implement PDF or Excel export here
        // For now, just return view
        return view('sales.sales-orders.export', compact('salesOrders'));
    }

    /**
     * Get sales order statistics.
     */
    public function statistics(Request $request)
    {
        $totalOrders = SalesOrder::count();
        $totalAmount = SalesOrder::sum('total_amount');
        $confirmedOrders = SalesOrder::where('status', 'confirmed')->count();
        $pendingOrders = SalesOrder::where('status', 'pending')->orWhere('status', 'draft')->count();

        // Monthly statistics
        $monthlyStats = SalesOrder::select(
            DB::raw('MONTH(order_date) as month'),
            DB::raw('YEAR(order_date) as year'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(total_amount) as total_amount')
        )
            ->whereYear('order_date', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json([
            'total_orders' => $totalOrders,
            'total_amount' => $totalAmount,
            'confirmed_orders' => $confirmedOrders,
            'pending_orders' => $pendingOrders,
            'monthly_stats' => $monthlyStats,
        ]);
    }
}
