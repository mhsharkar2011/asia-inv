<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'inventories', 'productImages'])
            ->where('is_active', true)
            ->paginate(12);

        $activeProducts = Product::where('is_active', true)->count();
        $categoriesCount = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })->count();

        return view('home', compact('products', 'activeProducts', 'categoriesCount'));
    }


    public function view(Product $product)
    {
        // Check if product is active (optional, you can remove this if you want to show all)
        if (!$product->is_active) {
            abort(404, 'Product is not available');
        }

        // Eager load relationships for better performance
        $product->load(['category', 'productImages', 'inventories']);

        return view('product-show', compact('product'));
    }
}
