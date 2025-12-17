<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $categories = Category::with('parent', 'products')
            ->where('company_id', $companyId)
            ->when($search, function($query) use ($search) {
                return $query->where('category_code', 'like', "%{$search}%")
                    ->orWhere('category_name', 'like', "%{$search}%");
            })
            ->orderBy('parent_category_id')
            ->orderBy('category_name')
            ->paginate(20);

        return view('inventory.categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;

        // Get parent categories for dropdown
        $parentCategories = Category::where('company_id', $companyId)
            ->whereNull('parent_category_id')
            ->orderBy('category_name')
            ->get();

        return view('inventory.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'category_code' => 'required|unique:categories,category_code|max:50',
            'category_name' => 'required|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|max:1000',
            'tax_rate_applicable' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['company_id'] = $companyId;

        Category::create($validated);

        return redirect()->route('inventory.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $companyId = Auth::user()->company_id;

        $category = Category::with(['parent', 'children', 'products'])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        return view('inventory.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $companyId = Auth::user()->company_id;

        $category = Category::where('company_id', $companyId)
            ->findOrFail($id);

        // Get parent categories (excluding current category and its children)
        $parentCategories = Category::where('company_id', $companyId)
            ->whereNull('parent_category_id')
            ->where('id', '!=', $id)
            ->orderBy('category_name')
            ->get();

        return view('inventory.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $companyId = Auth::user()->company_id;

        $category = Category::where('company_id', $companyId)
            ->findOrFail($id);

        $validated = $request->validate([
            'category_code' => 'required|unique:categories,category_code,' . $id . '|max:50',
            'category_name' => 'required|max:255',
            'parent_category_id' => 'nullable|exists:categories,id|not_in:' . $id,
            'description' => 'nullable|max:1000',
            'tax_rate_applicable' => 'nullable|numeric|min:0|max:100',
        ]);

        // Prevent making a category its own parent
        if ($validated['parent_category_id'] == $id) {
            return back()->withErrors(['parent_category_id' => 'A category cannot be its own parent.']);
        }

        // Check for circular reference
        if ($this->isCircularReference($id, $validated['parent_category_id'])) {
            return back()->withErrors(['parent_category_id' => 'This would create a circular reference.']);
        }

        $category->update($validated);

        return redirect()->route('inventory.categories.show', $category->id)
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $companyId = Auth::user()->company_id;

        $category = Category::where('company_id', $companyId)
            ->findOrFail($id);

        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('inventory.categories.index')
                ->with('error', 'Cannot delete category with associated products.');
        }

        // Check if category has subcategories
        if ($category->children()->count() > 0) {
            return redirect()->route('inventory.categories.index')
                ->with('error', 'Cannot delete category with subcategories.');
        }

        $category->delete();

        return redirect()->route('inventory.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Check for circular reference in category hierarchy.
     */
    private function isCircularReference($categoryId, $parentId)
    {
        if (!$parentId) {
            return false;
        }

        $currentParentId = $parentId;

        while ($currentParentId) {
            if ($currentParentId == $categoryId) {
                return true;
            }

            $parentCategory = Category::find($currentParentId);
            $currentParentId = $parentCategory ? $parentCategory->parent_category_id : null;
        }

        return false;
    }

    /**
     * Get categories for dropdown (AJAX).
     */
    public function getCategories(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $search = $request->get('search');

        $categories = Category::where('company_id', $companyId)
            ->when($search, function($query) use ($search) {
                return $query->where('category_name', 'like', "%{$search}%")
                    ->orWhere('category_code', 'like', "%{$search}%");
            })
            ->orderBy('category_name')
            ->limit(20)
            ->get();

        return response()->json($categories);
    }

    /**
     * Get subcategories for a parent category (AJAX).
     */
    public function getSubcategories($parentId)
    {
        $companyId = Auth::user()->company_id;

        $subcategories = Category::where('company_id', $companyId)
            ->where('parent_category_id', $parentId)
            ->orderBy('category_name')
            ->get();

        return response()->json($subcategories);
    }
}
