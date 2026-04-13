<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with(['productImages', 'category'])
            ->take(8)
            ->get();

             $products = Product::with(['category', 'inventories', 'productImages'])
            ->where('is_active', true)
            ->paginate(12);
        $categories = Category::get();

        return view('home', compact('featuredProducts','products', 'categories'));
    }


    public function show(Product $product)
    {
        // Check if product is active (optional, you can remove this if you want to show all)
        if (!$product->is_active) {
            abort(404, 'Product is not available');
        }

        // Eager load relationships for better performance
        $product->load(['category', 'productImages', 'inventories']);

        return view('product-show', compact('product'));
    }

    /**
     * Show shop page
     */
    public function shop(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['productImages', 'category']);

        // Filter by category if specified
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('id', $request->category)
                  ->orWhere('description', $request->category);
            });
        }

        // Filter by search term
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                  ->orWhere('product_code', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('selling_price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('selling_price', '<=', $request->max_price);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'name':
                $query->orderBy('product_name', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::get();

        return view('shops.index', compact('products', 'categories', 'sort'));
    }

    /**
     * Show products by category
     */
    public function category($slug)
    {
        $category = Category::where('description', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->with(['productImages', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::get();

        return view('shops.categories', compact('category', 'products', 'categories'));
    }

    /**
     * Show single product
     */
    public function product($id)
    {
        $product = Product::where('id', $id)
            ->orWhere('description', $id)
            ->with(['productImages', 'category'])
            ->firstOrFail();

        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['productImages'])
            ->take(4)
            ->get();

        return view('inventory.products.show', compact('product', 'relatedProducts'));
    }
}
