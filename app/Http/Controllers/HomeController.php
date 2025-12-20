<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with(['category', 'inventories'])
            ->where('is_active', true)
            ->paginate(12);

        $activeProducts = Product::where('is_active', true)->count();
        $categoriesCount = Category::whereHas('products', function ($query) {
            $query->where('is_active', true);
        })->count();

        return view('home', compact('products', 'activeProducts', 'categoriesCount'));
    }
}
