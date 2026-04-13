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
use Illuminate\Support\Facades\Storage;
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
        $companyId = Auth::user()->company_id;
        $product = Product::where('company_id', $companyId)->findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max per image
        ]);

        // Update product basic info
        $product->update($validated);

        // Handle image deletions
        if ($request->has('deleted_images')) {
            $deletedImageIds = json_decode($request->deleted_images, true) ?? [];

            if (!empty($deletedImageIds)) {
                $imagesToDelete = ProductImage::where('product_id', $product->id)
                    ->whereIn('id', $deletedImageIds)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    // Delete physical file from storage
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    // Delete database record
                    $image->delete();
                }

                // If primary image was deleted, set a new primary
                if ($deletedImageIds->contains($product->primary_image_id)) {
                    $newPrimary = ProductImage::where('product_id', $product->id)
                        ->orderBy('display_order')
                        ->first();

                    if ($newPrimary) {
                        $newPrimary->update(['is_primary' => true]);
                    }
                }
            }
        }

        // Handle image reordering
        if ($request->has('image_order')) {
            $imageOrder = json_decode($request->image_order, true) ?? [];

            foreach ($imageOrder as $order => $imageId) {
                ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update([
                        'display_order' => $order + 1,
                        'is_primary' => ($order === 0) // First image becomes primary
                    ]);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $existingImagesCount = ProductImage::where('product_id', $product->id)->count();
            $uploadOrder = $existingImagesCount + 1;

            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();

                // Store image
                $imageName = Str::slug($originalName) . '_' . time() . '_' . Str::random(5) . '.' . $extension;
                $folderPath = 'products/product_' . $product->id;
                $imagePath = $image->storeAs($folderPath, $imageName, 'public');

                // Create product image record
                ProductImage::create([
                    'product_id' => $product->id,
                    'company_id' => $companyId,
                    'image_path' => $imagePath,
                    'image_name' => $imageName,
                    'is_primary' => ($uploadOrder === 1 && $existingImagesCount === 0), // Primary if first image
                    'display_order' => $uploadOrder
                ]);

                $uploadOrder++;
            }
        }

        // Log activity
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties($validated)
                ->log('updated product');
        }

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', 'Product updated successfully.');
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



    /**
     * Delete a specific product image
     */
    public function deleteImage($id, $imageId)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)->findOrFail($id);

        $image = ProductImage::where('product_id', $product->id)
            ->where('id', $imageId)
            ->firstOrFail();

        // Store image info for response
        $imageInfo = [
            'id' => $image->id,
            'name' => $image->image_name,
            'url' => asset('storage/' . $image->image_path)
        ];

        // Delete physical file
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete database record
        $image->delete();

        // If this was the primary image, set a new one
        if ($image->is_primary) {
            $newPrimary = ProductImage::where('product_id', $product->id)
                ->orderBy('display_order')
                ->first();

            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }

        // Log activity
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties(['deleted_image' => $imageInfo])
                ->log('deleted product image');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'deleted_image' => $imageInfo
            ]);
        }

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Set an image as primary
     */
    public function setPrimaryImage($id, $imageId)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)->findOrFail($id);

        // First, unset all primary images for this product
        ProductImage::where('product_id', $product->id)
            ->update(['is_primary' => false]);

        // Set the new primary image
        $image = ProductImage::where('product_id', $product->id)
            ->where('id', $imageId)
            ->update(['is_primary' => true]);

        // Log activity
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties(['primary_image_id' => $imageId])
                ->log('set primary product image');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Primary image updated successfully',
                'primary_image_id' => $imageId
            ]);
        }

        return redirect()->back()->with('success', 'Primary image updated successfully.');
    }

    /**
     * Get product images for gallery (AJAX)
     */
    public function getImages($id)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)->findOrFail($id);

        $images = $product->productImages->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => asset('storage/' . $image->image_path),
                'thumb' => $this->getThumbnailUrl($image->image_path),
                'name' => $image->image_name,
                'is_primary' => $image->is_primary,
                'display_order' => $image->display_order,
                'size' => Storage::disk('public')->size($image->image_path),
                'created_at' => $image->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json([
            'success' => true,
            'images' => $images,
            'product_name' => $product->product_name
        ]);
    }

    /**
     * Generate thumbnail URL (helper method)
     */
    private function getThumbnailUrl($imagePath)
    {
        // You can implement image resizing/intervention image here
        // For now, return the original image URL
        return asset('storage/' . $imagePath);
    }

    /**
     * View image in large modal
     */
    public function viewImage($id, $imageId)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)->findOrFail($id);

        $image = ProductImage::where('product_id', $product->id)
            ->where('id', $imageId)
            ->firstOrFail();

        $imageData = [
            'id' => $image->id,
            'url' => asset('storage/' . $image->image_path),
            'name' => $image->image_name,
            'is_primary' => $image->is_primary,
            'size' => $this->formatBytes(Storage::disk('public')->size($image->image_path)),
            'uploaded' => $image->created_at->format('F j, Y, g:i a'),
            'dimensions' => $this->getImageDimensions($image->image_path)
        ];

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'image' => $imageData,
                'product_name' => $product->product_name
            ]);
        }

        // Return view for non-AJAX requests
        return view('inventory.products.image-view', [
            'product' => $product,
            'image' => $imageData,
            'otherImages' => $product->productImages()->where('id', '!=', $imageId)->get()
        ]);
    }

    /**
     * Helper: Format bytes to readable size
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Helper: Get image dimensions
     */
    private function getImageDimensions($imagePath)
    {
        try {
            $fullPath = storage_path('app/public/' . $imagePath);
            if (file_exists($fullPath)) {
                $size = getimagesize($fullPath);
                return $size ? $size[0] . '×' . $size[1] : 'Unknown';
            }
        } catch (\Exception $e) {
            Log::error('Failed to get image dimensions: ' . $e->getMessage());
        }

        return 'Unknown';
    }

    /**
     * Remove the specified product with images.
     */
    public function destroy($id)
    {
        // Check permission
        if (!auth()->user()->can('delete products')) {
            abort(403, 'You do not have permission to delete products.');
        }

        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->with('productImages')
            ->findOrFail($id);

        // Check if product has inventory transactions
        if ($product->inventories()->count() > 0) {
            return redirect()->route('inventory.products.index')
                ->with('error', 'Cannot delete product with existing inventory.');
        }

        // Store product data for logging
        $productData = $product->toArray();
        $imagesData = $product->productImages->toArray();

        // Delete all product images from storage
        foreach ($product->productImages as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // Delete the product (this will cascade delete product_images records)
        $product->delete();

        // Log activity if user has permission
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'deleted_product' => $productData,
                    'deleted_images' => $imagesData
                ])
                ->log('deleted product with images');
        }

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product and all associated images deleted successfully!');
    }

    /**
     * Bulk delete product images
     */
    public function bulkDeleteImages($id, Request $request)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)->findOrFail($id);

        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:product_images,id,product_id,' . $product->id
        ]);

        $deletedImages = [];
        $deletedCount = 0;

        foreach ($request->image_ids as $imageId) {
            $image = ProductImage::find($imageId);

            if ($image) {
                // Store info for logging
                $deletedImages[] = [
                    'id' => $image->id,
                    'name' => $image->image_name,
                    'path' => $image->image_path
                ];

                // Delete physical file
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                // Delete database record
                $image->delete();
                $deletedCount++;
            }
        }

        // Update primary image if needed
        if ($deletedCount > 0) {
            $remainingImages = ProductImage::where('product_id', $product->id)->count();

            if ($remainingImages > 0) {
                // Check if any primary image remains
                $hasPrimary = ProductImage::where('product_id', $product->id)
                    ->where('is_primary', true)
                    ->exists();

                if (!$hasPrimary) {
                    $newPrimary = ProductImage::where('product_id', $product->id)
                        ->orderBy('display_order')
                        ->first();

                    if ($newPrimary) {
                        $newPrimary->update(['is_primary' => true]);
                    }
                }
            }
        }

        // Log activity
        if (auth()->user()->can('log activities')) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties([
                    'deleted_images_count' => $deletedCount,
                    'deleted_images' => $deletedImages
                ])
                ->log('bulk deleted product images');
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} image(s).",
                'deleted_count' => $deletedCount
            ]);
        }

        return redirect()->back()
            ->with('success', "Successfully deleted {$deletedCount} image(s).");
    }
}
