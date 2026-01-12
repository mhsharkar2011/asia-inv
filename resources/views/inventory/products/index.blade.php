@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="p-6 sm:px-8 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Products Management</h2>
                        <p class="text-gray-600 mt-1">Manage your inventory products</p>
                    </div>

                    <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                        <!-- Quick Stats -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-4 py-2 rounded-lg border border-blue-200">
                            <p class="text-xs text-blue-600 font-medium">Total Products</p>
                            <p class="text-lg font-bold text-blue-700">{{ $products->total() }}</p>
                        </div>

                        @can('export products')
                        <button onclick="exportProducts()"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                            <i class="fas fa-file-export mr-2"></i>
                            Export
                        </button>
                        @endcan

                        @can('create products')
                        <a href="{{ route('inventory.products.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Product
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('inventory.products.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search"
                                       value="{{ request('search') }}"
                                       placeholder="Search products..."
                                       class="pl-10 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category" id="category"
                                    class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                    class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <select name="sort" id="sort"
                                    class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock (Low to High)</option>
                                <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock (High to Low)</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                <option value="created_desc" {{ !request('sort') || request('sort') == 'created_desc' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('inventory.products.index') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Reset
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-filter mr-2"></i>
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Stats Summary -->
            <div class="border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mr-4">
                                <i class="fas fa-box text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Active Products</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $activeProductsCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center mr-4">
                                <i class="fas fa-cubes text-emerald-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Stock Value</p>
                                <p class="text-2xl font-bold text-gray-800">@bdt($totalStockValue)</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-triangle text-amber-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Low Stock Items</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $lowStockCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center mr-4">
                                <i class="fas fa-ban text-rose-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Out of Stock</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $outOfStockCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Last Updated
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($product->image)
                                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                SKU: {{ $product->sku ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $product->category ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $product->stock_quantity }}</div>
                                    <div class="text-xs text-gray-500">
                                        Min: {{ $product->min_stock ?? 0 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        @bdt($product->selling_price)
                                    </div>
                                    @if($product->cost_price)
                                    <div class="text-xs text-gray-500">
                                        Cost: @bdt($product->cost_price)
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-emerald-100 text-emerald-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'low_stock' => 'bg-amber-100 text-amber-800',
                                            'out_of_stock' => 'bg-rose-100 text-rose-800'
                                        ];
                                        $status = $product->status ?? 'active';
                                        if($product->stock_quantity <= 0) {
                                            $status = 'out_of_stock';
                                        } elseif($product->stock_quantity <= ($product->min_stock ?? 10)) {
                                            $status = 'low_stock';
                                        }
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$status] }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->updated_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-400">
                                        {{ $product->updated_at->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @can('view products')
                                        <a href="{{ route('inventory.products.show', $product->id) }}"
                                           class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endcan

                                        @can('edit products')
                                        <a href="{{ route('inventory.products.edit', $product->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 p-2 hover:bg-indigo-50 rounded-lg transition-colors"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('adjust stock')
                                        <button onclick="showStockAdjustment({{ $product->id }})"
                                                class="text-emerald-600 hover:text-emerald-900 p-2 hover:bg-emerald-50 rounded-lg transition-colors"
                                                title="Adjust Stock">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        @endcan

                                        @can('delete products')
                                        <form action="{{ route('inventory.products.destroy', $product->id) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-rose-600 hover:text-rose-900 p-2 hover:bg-rose-50 rounded-lg transition-colors"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 mb-3">
                                        <i class="fas fa-box-open text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No products found</p>
                                    <p class="text-gray-400 text-sm mt-1">
                                        @can('create products')
                                            <a href="{{ route('inventory.products.create') }}" class="text-blue-600 hover:text-blue-700">
                                                Add your first product
                                            </a>
                                        @else
                                            Contact administrator to add products
                                        @endcan
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Stock Adjustment Modal -->
@can('adjust stock')
<div id="stockAdjustmentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 transform transition-all" id="modalContent">
        <!-- Modal content will be loaded via AJAX -->
    </div>
</div>
@endcan

<!-- Bulk Actions (for future implementation) -->
<div class="fixed bottom-4 right-4" id="bulkActions" style="display: none;">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
        <div class="flex items-center space-x-4">
            <span id="selectedCount" class="text-sm font-medium text-gray-700">0 items selected</span>
            <div class="flex space-x-2">
                @can('export products')
                <button class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                    Export Selected
                </button>
                @endcan
                @can('delete products')
                <button class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-sm font-medium">
                    Delete Selected
                </button>
                @endcan
                <button onclick="clearSelection()" class="px-3 py-1.5 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Stock Adjustment Modal
function showStockAdjustment(productId) {
    fetch(`/inventory/products/${productId}/stock-adjustment-form`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('stockAdjustmentModal').classList.remove('hidden');
            document.getElementById('stockAdjustmentModal').classList.add('flex');
        });
}

function closeStockModal() {
    document.getElementById('stockAdjustmentModal').classList.add('hidden');
    document.getElementById('stockAdjustmentModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('stockAdjustmentModal').addEventListener('click', function(e) {
    if (e.target.id === 'stockAdjustmentModal') {
        closeStockModal();
    }
});

// Export functionality
function exportProducts() {
    // Get current filters
    const params = new URLSearchParams(window.location.search);

    // Add export parameter
    params.set('export', 'true');

    // Redirect to export URL
    window.location.href = '{{ route("inventory.products.index") }}?' + params.toString();
}

// Bulk selection (for future implementation)
let selectedProducts = new Set();

function toggleProductSelection(productId) {
    if (selectedProducts.has(productId)) {
        selectedProducts.delete(productId);
    } else {
        selectedProducts.add(productId);
    }

    updateBulkActions();
}

function updateBulkActions() {
    const count = selectedProducts.size;
    if (count > 0) {
        document.getElementById('selectedCount').textContent = count + ' item' + (count > 1 ? 's' : '') + ' selected';
        document.getElementById('bulkActions').style.display = 'block';
    } else {
        document.getElementById('bulkActions').style.display = 'none';
    }
}

function clearSelection() {
    selectedProducts.clear();
    updateBulkActions();
    // Uncheck all checkboxes
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+F for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('search').focus();
    }

    // Ctrl+N for new product
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        @can('create products')
        window.location.href = '{{ route("inventory.products.create") }}';
        @endcan
    }

    // Escape to close modal
    if (e.key === 'Escape') {
        closeStockModal();
    }
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // You can add tooltip initialization here if using a library
});
</script>
@endpush

@push('styles')
<style>
/* Custom styles for the table */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

/* Status badge animations */
@keyframes pulse-low-stock {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.bg-amber-100 {
    animation: pulse-low-stock 2s infinite;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>
@endpush
