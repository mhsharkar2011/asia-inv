<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companyId = Auth::user()->company_id;

        $products = Product::where('company_id', $companyId)
            ->with('category')
            ->paginate(20);

        return view('inventory.products.index', compact('products'));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;
        $categories = Category::where('company_id', $companyId)->get();

        return view('inventory.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code',
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'unit_of_measure' => 'required',
            'hsn_sac_code' => 'nullable|max:50',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'reorder_level' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
        ]);

        $validated['company_id'] = Auth::user()->company_id;
        $validated['created_by'] = Auth::id();

        $product = Product::create($validated);

        if ($request->has('save_and_new')) {
            return redirect()->route('inventory.products.create')
                ->with('success', 'Product created successfully!');
        }

        return redirect()->route('inventory.products.show', $product->product_id)
            ->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'inventories.warehouse'])
            ->findOrFail($id);

        // Check if user has access to this company's data
        if ($product->company_id != Auth::user()->company_id) {
            abort(403, 'Unauthorized access.');
        }

        return view('inventory.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companyId = Auth::user()->company_id;

        // Check if user has access to this company's data
        if ($product->company_id != $companyId) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Category::where('company_id', $companyId)->get();

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Check if user has access to this company's data
        if ($product->company_id != Auth::user()->company_id) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id . ',product_id',
            'product_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'unit_of_measure' => 'required',
            'hsn_sac_code' => 'nullable|max:50',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'reorder_level' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('inventory.products.show', $product->product_id)
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Check if user has access to this company's data
        if ($product->company_id != Auth::user()->company_id) {
            abort(403, 'Unauthorized access.');
        }

        // Check if product has transactions
        if ($product->stockTransactions()->exists()) {
            return redirect()->route('inventory.products.index')
                ->with('error', 'Cannot delete product with existing transactions.');
        }

        $product->delete();

        return redirect()->route('inventory.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function search(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $products = Product::where('company_id', $companyId)
            ->where(function($query) use ($search) {
                $query->where('product_code', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%")
                    ->orWhere('hsn_sac_code', 'like', "%{$search}%");
            })
            ->where('is_active', true)
            ->limit(10)
            ->get();

        return response()->json($products);
    }
}
