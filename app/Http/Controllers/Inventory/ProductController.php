<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{
    public function __construct()
    {
        // Apply middleware for permissions
        $this->middleware('permission:view products')->only(['index', 'show']);
        $this->middleware('permission:create products')->only(['create', 'store', 'generateProductCodeAjax']);
        $this->middleware('permission:edit products')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete products')->only(['destroy']);
        $this->middleware('permission:adjust stock')->only(['updateStock']);
    }

    public function index(Request $request)
    {
        // Alternative permission check (if not using middleware)
        // if (!auth()->user()->can('view products')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $companyId = Auth::user()->company_id;
        $search = $request->get('search');
        $category = $request->get('category');
        $status = $request->get('status', 'all');
        $stockStatus = $request->get('stock_status', 'all');

        // Start building the query
        $query = Product::with('category')
            ->where('company_id', $companyId);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_code', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('hsn_sac_code', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        // Apply status filter
        if ($status !== 'all') {
            $query->where('status', $status === 'active');
        }

        // Apply stock status filter
        if ($stockStatus !== 'all') {
            if ($stockStatus === 'low_stock') {
                $query->whereColumn('stock_quantity', '<=', 'reorder_level')
                    ->where('stock_quantity', '>', 0);
            } elseif ($stockStatus === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($stockStatus === 'in_stock') {
                $query->where('stock_quantity', '>', 0)
                    ->whereColumn('stock_quantity', '>', 'reorder_level');
            }
        }

        // Order and paginate
        $products = $query->orderBy('product_name')->paginate(10);

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        // Get statistics (only for users who can view reports)
        $stats = [];
        if (auth()->user()->can('view inventory reports')) {
            $stats = [
                'total_products' => Product::where('company_id', $companyId)->count(),
                'active_products' => Product::where('company_id', $companyId)->where('is_active', true)->count(),
                'low_stock_count' => Product::where('company_id', $companyId)
                    ->whereColumn('stock_quantity', '<=', 'reorder_level')
                    ->where('stock_quantity', '>', 0)
                    ->count(),
                'out_of_stock_count' => Product::where('company_id', $companyId)
                    ->where('stock_quantity', '<=', 0)
                    ->count(),
                'total_stock_value' => Product::where('company_id', $companyId)
                    ->sum(\DB::raw('stock_quantity * purchase_price')),
            ];
        }

        // Check user permissions for UI elements
        $permissions = [
            'can_create' => auth()->user()->can('create products'),
            'can_edit' => auth()->user()->can('edit products'),
            'can_delete' => auth()->user()->can('delete products'),
            'can_adjust_stock' => auth()->user()->can('adjust stock'),
            'can_export' => auth()->user()->can('export products'),
            'can_view_reports' => auth()->user()->can('view inventory reports'),
        ];

        return view('inventory.products.index', compact(
            'products',
            'search',
            'category',
            'status',
            'stockStatus',
            'categories',
            'stats',
            'permissions'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Permission already handled by middleware, but double check
        // if (!auth()->user()->can('create products')) {
        //     abort(403, 'You do not have permission to create products.');
        // }

        $companyId = Auth::user()->company_id;

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        $productCode = Product::generateProductCode();

        return view('inventory.products.create', compact('categories', 'productCode'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Permission check
        if (!auth()->user()->can('create products')) {
            abort(403, 'Unauthorized action.');
        }

        $companyId = Auth::user()->company_id;

        // Debug: Check what's coming in
        Log::info('Store request data:', $request->all());

        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code|max:50',
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|max:1000',
            'unit_of_measure' => 'required|max:20',
            'reorder_level' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'hsn_sac_code' => 'nullable|max:10',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'track_batch' => 'nullable|in:0,1,true,false',
            'track_expiry' => 'nullable|in:0,1,true,false',
            'is_active' => 'nullable|in:0,1,true,false',
        ]);

        $validated['company_id'] = $companyId;
        $validated['created_by'] = Auth::id(); // Track who created the product
        $validated['track_batch'] = $request->has('track_batch');
        $validated['track_expiry'] = $request->has('track_expiry');
        $validated['is_active'] = $request->has('is_active');

        Log::info('Final data to create:', $validated);

        try {
            $product = Product::create($validated);

            if ($request->hasFile('image')) {
                $product->addMedia($request->file('image'))
                    ->toMediaCollection('products');
            }

            Log::info('Product created successfully:', $product->toArray());

            // Log activity if user has permission
            if (auth()->user()->can('log activities')) {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($product)
                    ->withProperties(['new_data' => $validated])
                    ->log('created product');
            }

            if ($request->has('save_and_new')) {
                return redirect()->route('inventory.products.create')
                    ->with('success', 'Product created successfully!');
            }

            return redirect()->route('inventory.products.index')
                ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            Log::error('Product creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        // Check if user can view products
        if (!auth()->user()->can('view products')) {
            abort(403, 'You do not have permission to view products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::with(['category', 'inventories.warehouse'])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        // Check if user can view audit trail
        $showAuditTrail = auth()->user()->can('view audit trail');

        return view('inventory.products.show', compact('product', 'showAuditTrail'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        // Check permission
        if (!auth()->user()->can('edit products')) {
            abort(403, 'You do not have permission to edit products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        // Check permission
        if (!auth()->user()->can('edit products')) {
            abort(403, 'You do not have permission to edit products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        // Store old data for logging
        $oldData = $product->toArray();

        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id . '|max:50',
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|max:1000',
            'unit_of_measure' => 'nullable|max:20',
            'reorder_level' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'hsn_sac_code' => 'nullable|max:10',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['track_batch'] = $request->has('track_batch');
        $validated['track_expiry'] = $request->has('track_expiry');
        $validated['updated_by'] = Auth::id(); // Track who updated

        $product->update($validated);

        // Log activity if user has permission
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties([
                    'old_data' => $oldData,
                    'new_data' => $validated
                ])
                ->log('updated product');
        }

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        // Check permission
        if (!auth()->user()->can('delete products')) {
            abort(403, 'You do not have permission to delete products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        // Check if product has inventory transactions
        if ($product->inventories()->count() > 0) {
            return redirect()->route('inventory.products.index')
                ->with('error', 'Cannot delete product with existing inventory.');
        }

        // Store product data for logging
        $productData = $product->toArray();

        $product->delete();

        // Log activity if user has permission
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['deleted_product' => $productData])
                ->log('deleted product');
        }

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus($id)
    {
        // Check permission
        if (!auth()->user()->can('edit products')) {
            abort(403, 'You do not have permission to edit products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        $oldStatus = $product->is_active;
        $newStatus = !$product->is_active;

        $product->update([
            'is_active' => $newStatus,
            'updated_by' => Auth::id()
        ]);

        $status = $newStatus ? 'activated' : 'deactivated';

        // Log activity if user has permission
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties([
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus
                ])
                ->log("{$status} product");
        }

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', "Product {$status} successfully!");
    }

    public function generateProductCodeAjax()
    {
        // Check permission
        if (!auth()->user()->can('create products')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        try {
            $productCode = Product::generateProductCode();

            return response()->json([
                'success' => true,
                'product_code' => $productCode,
                'message' => 'Product code generated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate product code'
            ], 500);
        }
    }

    /**
     * Get products for dropdown (AJAX).
     */
    public function getProducts(Request $request)
    {
        // Check if user can view products
        if (!auth()->user()->can('view products')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $products = Product::where('company_id', $companyId)
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                return $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            })
            ->orderBy('product_name')
            ->limit(20)
            ->get(['id', 'product_code', 'product_name', 'selling_price', 'tax_rate']);

        return response()->json($products);
    }

    /**
     * Update stock quantity.
     */
    public function updateStock(Request $request, Product $product)
    {
        // Check permission
        if (!auth()->user()->can('adjust stock')) {
            abort(403, 'You do not have permission to adjust stock.');
        }

        // Also check if user can edit this specific product
        if (!auth()->user()->can('edit products')) {
            abort(403, 'You do not have permission to edit products.');
        }

        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'reason' => 'required|string|max:255',
        ]);

        $oldQuantity = $product->stock_quantity;

        switch ($validated['adjustment_type']) {
            case 'add':
                $newQuantity = $oldQuantity + $validated['quantity'];
                break;
            case 'subtract':
                $newQuantity = max(0, $oldQuantity - $validated['quantity']);
                break;
            case 'set':
                $newQuantity = $validated['quantity'];
                break;
        }

        $product->update([
            'stock_quantity' => $newQuantity,
            'updated_by' => Auth::id()
        ]);

        // Log stock adjustment
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties([
                    'old_quantity' => $oldQuantity,
                    'new_quantity' => $newQuantity,
                    'adjustment_type' => $validated['adjustment_type'],
                    'adjustment_amount' => $validated['quantity'],
                    'reason' => $validated['reason'],
                    'notes' => $validated['notes'] ?? null
                ])
                ->log('adjusted stock');
        }

        return redirect()->back()
            ->with('success', 'Stock updated successfully. New quantity: ' . $newQuantity);
    }

    /**
     * Export products (if you want to add export functionality)
     */
    public function export(Request $request)
    {
        // Check permission
        if (!auth()->user()->can('export products')) {
            abort(403, 'You do not have permission to export products.');
        }

        $companyId = Auth::user()->company_id;

        $products = Product::where('company_id', $companyId)
            ->with('category')
            ->get();

        $filename = "products_export_" . date('Y_m_d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($file, [
                'Product Code',
                'Product Name',
                'Category',
                'Description',
                'Unit',
                'Stock Quantity',
                'Reorder Level',
                'Purchase Price',
                'Selling Price',
                'MRP',
                'HSN/SAC Code',
                'Tax Rate',
                'Status',
                'Batch Tracking',
                'Expiry Tracking'
            ]);

            // Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->product_code,
                    $product->product_name,
                    $product->category->category_name ?? 'N/A',
                    $product->description,
                    $product->unit_of_measure,
                    $product->stock_quantity,
                    $product->reorder_level,
                    $product->purchase_price,
                    $product->selling_price,
                    $product->mrp,
                    $product->hsn_sac_code,
                    $product->tax_rate,
                    $product->is_active ? 'Active' : 'Inactive',
                    $product->track_batch ? 'Yes' : 'No',
                    $product->track_expiry ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk actions (delete/activate/deactivate)
     */
    public function bulkAction(Request $request)
    {
        // Check permissions based on action
        $action = $request->input('action');

        switch ($action) {
            case 'delete':
                if (!auth()->user()->can('delete products')) {
                    abort(403, 'You do not have permission to delete products.');
                }
                break;
            case 'activate':
            case 'deactivate':
                if (!auth()->user()->can('edit products')) {
                    abort(403, 'You do not have permission to edit products.');
                }
                break;
            default:
                abort(400, 'Invalid action');
        }

        $companyId = Auth::user()->company_id;
        $productIds = $request->input('product_ids', []);

        if (empty($productIds)) {
            return redirect()->back()->with('error', 'No products selected.');
        }

        $products = Product::where('company_id', $companyId)
            ->whereIn('id', $productIds)
            ->get();

        $count = 0;
        foreach ($products as $product) {
            switch ($action) {
                case 'delete':
                    // Check if product has inventory
                    if ($product->inventories()->count() === 0) {
                        $product->delete();
                        $count++;
                    }
                    break;
                case 'activate':
                    $product->update(['is_active' => true, 'updated_by' => Auth::id()]);
                    $count++;
                    break;
                case 'deactivate':
                    $product->update(['is_active' => false, 'updated_by' => Auth::id()]);
                    $count++;
                    break;
            }
        }

        $message = "Successfully {$action}d {$count} product(s).";

        // Log bulk action
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'action' => $action,
                    'product_ids' => $productIds,
                    'affected_count' => $count
                ])
                ->log("performed bulk {$action} on products");
        }

        return redirect()->back()->with('success', $message);
    }
}
