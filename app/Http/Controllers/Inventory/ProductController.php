<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $products = Product::with('category')
            ->where('company_id', $companyId)
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('product_code', 'like', "%{$search}%")
                      ->orWhere('product_name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('hsn_sac_code', 'like', "%{$search}%");
                });
            })
            ->when($category, function($query) use ($category) {
                return $query->where('category_id', $category);
            })
            ->when($status !== 'all', function($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('is_active', true);
                } elseif ($status === 'inactive') {
                    return $query->where('is_active', false);
                } elseif ($status === 'low_stock') {
                    return $query->lowStock();
                } elseif ($status === 'out_of_stock') {
                    return $query->outOfStock();
                }
            })
            ->orderBy('product_name')
            ->paginate(20);

        $categories = Category::where('company_id', $companyId)
            ->orderBy('category_name')
            ->get();

        return view('inventory.products.index', compact('products', 'search', 'category', 'status', 'categories'));
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
            'track_batch' => 'boolean',
            'track_expiry' => 'boolean',
        ]);

        $validated['company_id'] = $companyId;
        $validated['is_active'] = $request->has('is_active');
        $validated['track_batch'] = $request->has('track_batch');
        $validated['track_expiry'] = $request->has('track_expiry');

        Product::create($validated);

        if ($request->has('save_and_new')) {
            return redirect()->route('inventory.products.create')
                ->with('success', 'Product created successfully!');
        }

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product created successfully!');
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
            'unit_of_measure' => 'required|max:20',
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
            ->when($search, function($query) use ($search) {
                return $query->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%");
            })
            ->orderBy('product_name')
            ->limit(20)
            ->get(['id', 'product_code', 'product_name', 'selling_price', 'tax_rate']);

        return response()->json($products);
    }
}
