<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
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
        $products = $query->orderBy('product_name')->paginate(20);

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        return view('inventory.products.index', compact('products', 'search', 'category', 'status', 'stockStatus', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        return view('inventory.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
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
        $validated['track_batch'] = $request->has('track_batch');
        $validated['track_expiry'] = $request->has('track_expiry');
        $validated['is_active'] = $request->has('is_active');

        Log::info('Final data to create:', $validated);

        try {
            $product = Product::create($validated);
            Log::info('Product created successfully:', $product->toArray());

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
        $companyId = Auth::user()->company_id;

        $product = Product::with(['category', 'inventories.warehouse'])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        return view('inventory.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
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
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

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

        $product->update($validated);

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        // Check if product has inventory transactions
        if ($product->inventories()->count() > 0) {
            return redirect()->route('inventory.products.index')
                ->with('error', 'Cannot delete product with existing inventory.');
        }

        $product->delete();

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus($id)
    {
        $companyId = Auth::user()->company_id;

        $product = Product::where('company_id', $companyId)
            ->findOrFail($id);

        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';

        return redirect()->route('inventory.products.show', $product->id)
            ->with('success', "Product {$status} successfully!");
    }

    /**
     * Get products for dropdown (AJAX).
     */
    public function getProducts(Request $request)
    {
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
        $validated = $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
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

        $product->update(['stock_quantity' => $newQuantity]);

        // You can log this stock adjustment in a separate table here

        return redirect()->back()
            ->with('success', 'Stock updated successfully. New quantity: ' . $newQuantity);
    }
}
