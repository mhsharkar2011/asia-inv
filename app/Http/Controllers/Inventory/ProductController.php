<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');
        $category = $request->get('category');
        $status = $request->get('status', 'all');
        $stockStatus = $request->get('stock_status', 'all');
        $sort = $request->get('sort', 'created_desc');

        // Start building the query
        $query = Product::with('category', 'productImages')->where('company_id', $companyId);

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

        // Apply status filter - Updated to match blade view status values
        if ($status !== '') {
            if ($status === 'active') {
                $query->where('status', 1);
            } elseif ($status === 'inactive') {
                $query->where('status', 0);
            }
        }

        // Apply stock status filter - Removed as we'll handle it differently to match blade
        // The blade view calculates status based on stock quantity

        // Apply sorting
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product_name', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock_quantity', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock_quantity', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'created_desc':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get paginated results
        $products = $query->paginate(10);

        // Get categories
        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        // Calculate statistics for the current filtered results
        $active_products = clone $query;
        $lowStockCount = clone $query;
        $outOfStockCount = clone $query;
        $totalStockValue = clone $query;

        // Active products count (status = active/1)
        $active_products = $active_products->where('is_active', 1)->count();

        // Low stock count (stock <= min_stock/reorder_level and > 0)
        $lowStockCount = $lowStockCount->whereColumn('stock_quantity', '<=', 'reorder_level')
            ->where('stock_quantity', '>', 0)
            ->count();

        // Out of stock count
        $outOfStockCount = $outOfStockCount->where('stock_quantity', '<=', 0)->count();

        // Total stock value (sum of stock * selling_price)
        $totalStockValue = Product::where('company_id', $companyId)
            ->where(function ($q) use ($search, $category, $status) {
                // Apply the same filters
                if ($search) {
                    $q->where(function ($q2) use ($search) {
                        $q2->where('product_code', 'like', "%{$search}%")
                            ->orWhere('product_name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('hsn_sac_code', 'like', "%{$search}%");
                    });
                }

                if ($category) {
                    $q->where('category_id', $category);
                }

                if ($status !== '') {
                    if ($status === 'active') {
                        $q->where('status', 1);
                    } elseif ($status === 'inactive') {
                        $q->where('status', 0);
                    }
                }
            })
            ->sum(DB::raw('stock_quantity * selling_price'));

        // Pass data to view - Updated variable names to match blade
        return view('inventory.products.index', [
            'products' => $products,
            'categories' => $categories,
            'active_products' => $active_products,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'totalStockValue' => $totalStockValue,
            'search' => $search,
            'category' => $category,
            'is_active' => $status,
            'sort' => $sort
        ]);
    }
    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Permission already handled by middleware, but double check
        if (!auth()->user()->can('create products')) {
            abort(403, 'You do not have permission to create products.');
        }

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
    // In your ProductController
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'hs_code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'unit_of_measure' => 'required|string|max:10',
            'tax_rate' => 'required|numeric',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'track_batch' => 'boolean',
            'track_expiry' => 'boolean',
            'track_serial' => 'boolean',
            'manage_stock' => 'boolean',
            'allow_backorder' => 'boolean',
            'allow_negative' => 'boolean',
            'is_active' => 'boolean',
            // Don't validate images here since they go to separate table
        ]);

        // Validate images separately
        $request->validate([
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Create product WITHOUT images
        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imageOrder = 1;
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                // Store image
                $imageName = Str::slug($originalName) . '_' . time() . '_' . Str::random(5) . '.' . $extension;
                // Store in product-specific folder: products/product_{id}/
                $folderPath = 'products/product_' . $product->id;
                $imagePath = $image->storeAs($folderPath, $imageName, 'public');

                // Create product image record in product_images table
                ProductImage::create([
                    'product_id' => $product->id,
                    'company_id' => $product->company_id,
                    'image_path' => $imagePath,
                    'image_name' => $imageName,
                    'is_primary' => ($imageOrder === 1), // First image is primary
                    'display_order' => $imageOrder
                ]);

                $imageOrder++;
            }
        }

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product created successfully with ' . ($imageOrder - 1) . ' images.');
    }
    protected function generateProductCode()
    {
        $prefix = 'PROD-';
        $year = date('y');
        $month = date('m');
        $random = strtoupper(Str::random(3));
        $sequence = Product::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count() + 1;

        return sprintf('%s%s%s%s%03d', $prefix, $year, $month, $random, $sequence);
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

        $product = Product::with(['category', 'productImages', 'inventories.warehouse'])
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
    // In ProductController@update method
    // In ProductController@update method
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'product_name' => 'required',
            'category_id' => 'required|exists:categories,id',
            // ... other validation rules
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Update product data
        $product->update($validated);

        // Handle image deletions - FIXED VERSION
        if ($request->has('deleted_images') && !empty($request->deleted_images)) {
            try {
                $deletedImages = json_decode($request->deleted_images, true);

                // Check if json_decode was successful and we have an array
                if (is_array($deletedImages) && !empty($deletedImages)) {
                    ProductImage::whereIn('id', $deletedImages)->delete();
                }
            } catch (\Exception $e) {
                // Log error or handle gracefully
                \Log::error('Error deleting images: ' . $e->getMessage());
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'image_name' => $image->getClientOriginalName(),
                    // Add other image fields if needed
                ]);
            }
        }

        // Handle existing images (preserve the ones not deleted)
        // The existing images are already associated via hidden inputs

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', 'Product updated successfully.');
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
        // // Only require stock adjustment permission, not edit permission
        // if (!auth()->user()->can('adjust stock')) {
        //     abort(403, 'You do not have permission to adjust stock.');
        // }

        // // Optional: Check company ownership
        // if ($product->company_id !== Auth::user()->company_id) {
        //     abort(403, 'You do not have permission to adjust stock for this product.');
        // }

        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            // 'reason' => 'required|string|max:255',
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
                $newQuantity = max(0, $validated['quantity']);
                break;
            default:
                $newQuantity = $oldQuantity;
                break;
        }

        // Update product stock
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
                    // 'reason' => $validated['reason'],
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

        $callback = function () use ($products) {
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
