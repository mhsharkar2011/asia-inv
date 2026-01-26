<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         $purchaseOrderId = $this->route('purchase_order')?->id;

         return [
            'po_number' => ['required', 'string', 'max:50', Rule::unique('purchase_orders')->ignore($purchaseOrderId)],
            'company_id' => 'required|exists:companies,id',
            'supplier_id' => 'required|exists:companies,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            // Financial fields should be nullable or auto-calculated
            'total_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'final_amount' => 'nullable|numeric|min:0',
        ];
    }
}
