<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Adjust Stock</h3>
        <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
        <p class="text-sm text-gray-600">Product: <span class="font-medium text-gray-800">{{ $product->product_name }}</span></p>
        <p class="text-sm text-gray-600">Current Stock: <span class="font-medium text-gray-800">{{ $product->stock_quantity }}</span></p>
        <p class="text-sm text-gray-600">SKU: <span class="font-medium text-gray-800">{{ $product->product_code }}</span></p>
    </div>

    <form id="stockAdjustmentForm" action="{{ route('inventory.products.update-stock', $product->id) }}" method="POST">
        @csrf

        <div class="space-y-4">
            <!-- Adjustment Type -->
            <div>
                <label for="adjustment_type" class="block text-sm font-medium text-gray-700 mb-1">Adjustment Type *</label>
                <select name="adjustment_type" id="adjustment_type"
                        class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select Type</option>
                    <option value="add">Add Stock</option>
                    <option value="subtract">Remove Stock</option>
                    <option value="set">Set Stock</option>
                </select>
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input type="number" name="quantity" id="quantity"
                       class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       min="1" required>
            </div>

            <!-- Reason -->
            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason *</label>
                <input type="text" name="reason" id="reason"
                       class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter reason for adjustment" required>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Additional notes..."></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeStockModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button type="submit"
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all">
                Update Stock
            </button>
        </div>
    </form>
</div>
