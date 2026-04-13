<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\Purchase\PurchaseOrder;
use App\Models\Purchase\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;
        $totalItems = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemTotal = $item['quantity'] * $item['price'];
                $cartItems[] = [
                    'id' => $product->id,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $itemTotal,
                    'image' => $product->productImages->first() ? asset('storage/' . $product->productImages->first()->image_path) : null
                ];
                $total += $itemTotal;
                $totalItems += $item['quantity'];
            }
        }

        return view('carts.index', compact('cartItems', 'total', 'totalItems'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
            ], 400);
        }

        $cart = session()->get('cart', []);

        // If product already in cart, update quantity
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = [
                'name' => $product->product_name,
                'quantity' => $request->quantity,
                'price' => $product->selling_price,
                'image' => $product->productImages->first() ? $product->productImages->first()->image_path : null
            ];
        }

        session()->put('cart', $cart);

        // Calculate cart totals
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['quantity'] * $item['price'];
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal, 2),
                'product' => [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'price' => $product->selling_price,
                    'quantity' => $cart[$request->product_id]['quantity']
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);

            // Check stock availability
            if ($product && $product->stock_quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock_quantity
                ], 400);
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            // Calculate item total
            $itemTotal = $cart[$id]['quantity'] * $cart[$id]['price'];

            // Calculate cart totals
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['quantity'] * $item['price'];
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_count' => $cartCount,
                    'cart_total' => number_format($cartTotal, 2),
                    'item_total' => number_format($itemTotal, 2)
                ]);
            }

            return redirect()->route('carts.index')->with('success', 'Cart updated successfully!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Calculate cart totals
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartTotal = 0;
            foreach ($cart as $item) {
                $cartTotal += $item['quantity'] * $item['price'];
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart',
                    'cart_count' => $cartCount,
                    'cart_total' => number_format($cartTotal, 2)
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product removed from cart');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_total' => '0.00'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }

    /**
     * Get cart summary (AJAX).
     */
    public function getSummary()
    {
        $cart = session()->get('cart', []);

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $cartTotal = 0;

        foreach ($cart as $item) {
            $cartTotal += $item['quantity'] * $item['price'];
        }

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Verify stock availability for all items
        $cartItems = [];
        $subtotal = 0;
        $tax = 0;
        $stockIssues = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product) {
                $stockIssues[] = "Product '{$item['name']}' no longer exists.";
                continue;
            }

            if ($product->stock_quantity < $item['quantity']) {
                $stockIssues[] = "Insufficient stock for '{$item['name']}'. Available: {$product->stock_quantity}";
                continue;
            }

            if (!$product->is_active) {
                $stockIssues[] = "Product '{$item['name']}' is currently unavailable.";
                continue;
            }

            $itemPrice = $item['price'] ?? $product->selling_price;
            $itemTotal = $item['quantity'] * $itemPrice;
            $itemTax = $itemTotal * ($product->tax_rate / 100);

            $subtotal += $itemTotal;
            $tax += $itemTax;

            $cartItems[] = [
                'product' => $product,
                'cart_item' => $item,
                'item_total' => $itemTotal,
                'item_tax' => $itemTax
            ];
        }

        // If there are stock issues, redirect back to cart
        if (!empty($stockIssues)) {
            return redirect()->route('cart.index')
                ->with('error', implode(' ', $stockIssues));
        }

        $total = $subtotal + $tax;

        return view('carts.checkout', compact('cart', 'cartItems', 'subtotal', 'tax', 'total'));
    }

    /**
     * Process checkout and create order.
     */
    public function processCheckout(Request $request)
    {
        // Validate the request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash,card,online,bkash,nagad',
            'order_notes' => 'nullable|string|max:500'
        ]);

        $cart = session()->get('cart', []);

        // Check if cart is empty
        if (empty($cart)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // Verify stock availability for all items
            $cartItems = [];
            $subtotal = 0;
            $tax = 0;
            $total = 0;

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (!$product) {
                    throw new \Exception("Product not found: {$item['name']}");
                }

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$item['name']}. Available: {$product->stock_quantity}, Requested: {$item['quantity']}");
                }

                // Calculate item totals
                $itemTotal = $item['quantity'] * $item['price'];
                $itemTax = $itemTotal * ($product->tax_rate / 100);

                $subtotal += $itemTotal;
                $tax += $itemTax;

                $cartItems[] = [
                    'product' => $product,
                    'item' => $item,
                    'total' => $itemTotal,
                    'tax' => $itemTax
                ];
            }

            $total = $subtotal + $tax;

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Check if Order model exists, if not create it first
            if (!class_exists('PurchaseOrder')) {
                // Create Order model migration first
                // Run: php artisan make:model Order -m
                // Then add the Order model code below
                throw new \Exception('Order model not found. Please run: php artisan make:model Order -m');
            }

            // Create the order
            $order = PurchaseOrder::create([
                'order_number' => $orderNumber,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'order_notes' => $request->order_notes,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'status' => 'pending',
                'user_id' => Auth::id(),
                'company_id' => Auth::user()->company_id ?? null,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                $product = $cartItem['product'];
                $item = $cartItem['item'];

                // Create order item
                PurchaseOrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $item['name'],
                    'product_code' => $product->product_code,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'tax_rate' => $product->tax_rate,
                    'tax_amount' => $cartItem['tax'],
                    'total_price' => $cartItem['total'],
                ]);

                // Update product stock
                $product->stock_quantity -= $item['quantity'];
                $product->save();

                // Create inventory transaction
                InventoryTransaction::create([
                    'product_id' => $product->id,
                    'warehouse_id' => 1, // Default warehouse, adjust as needed
                    'transaction_type' => 'sale',
                    'quantity' => -$item['quantity'], // Negative for sale
                    'unit_cost' => $product->purchase_price ?? $item['price'],
                    'total_cost' => $product->purchase_price ? $product->purchase_price * $item['quantity'] : null,
                    'reference_type' => 'order',
                    'reference_id' => $order->id,
                    'notes' => 'Sold via checkout',
                    'created_by' => Auth::id(),
                    'company_id' => Auth::user()->company_id ?? null,
                ]);
            }

            // Clear the cart
            session()->forget('cart');

            // Commit transaction
            DB::commit();

            // Log activity
            if (auth()->user()->can('log activities')) {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($order)
                    ->withProperties([
                        'order_number' => $orderNumber,
                        'total' => $total,
                        'items_count' => count($cartItems)
                    ])
                    ->log('created order via checkout');
            }

            // Prepare response data
            $responseData = [
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $orderNumber,
                    'total' => number_format($total, 2),
                    'date' => $order->created_at->format('F j, Y')
                ],
                'redirect' => route('orders.show', $order->id)
            ];

            // Send email notification (optional)
            // $this->sendOrderConfirmationEmail($order, $request->customer_email);

            if ($request->ajax()) {
                return response()->json($responseData);
            }

            return redirect()->route('purchase.purchase-orders.show', $order->id)
                ->with('success', 'Order placed successfully! Order #' . $orderNumber);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            Log::error('Checkout failed: ' . $e->getMessage(), [
                'customer' => $request->customer_name,
                'email' => $request->customer_email,
                'cart' => $cart
            ]);

            $errorMessage = $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }

            return redirect()->back()
                ->with('error', 'Checkout failed: ' . $errorMessage)
                ->withInput();
        }
    }

    /**
     * Show order confirmation page
     */
    public function orderConfirmation($orderId)
    {
        $order = PurchaseOrder::with('orderItems')->findOrFail($orderId);

        // Check if user has permission to view this order
        if (Auth::id() !== $order->user_id && !auth()->user()->can('view all orders')) {
            abort(403, 'Unauthorized to view this order');
        }

        return view('cart.confirmation', compact('order'));
    }

    /**
     * Quick add to cart (for AJAX requests from product cards).
     */
    public function quickAdd(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Add 1 quantity by default for quick add
        $quantity = 1;

        // Check stock availability
        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cart = session()->get('cart', []);

        // If product already in cart, increment quantity
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $quantity;
        } else {
            $cart[$request->product_id] = [
                'name' => $product->product_name,
                'quantity' => $quantity,
                'price' => $product->selling_price,
                'image' => $product->productImages->first() ? $product->productImages->first()->image_path : null
            ];
        }

        session()->put('cart', $cart);

        // Calculate cart totals
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['quantity'] * $item['price'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Added to cart!',
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'product_name' => $product->product_name
        ]);
    }
}
