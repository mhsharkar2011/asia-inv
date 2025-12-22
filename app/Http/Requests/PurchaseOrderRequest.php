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
        $purchaseOrderId = $this->route('purchase_order') ?: 'NULL';

        return [
            'company_id' => [
                'required',
                Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('type', 'company'); // If you have organization types
                }),
            ],
            'po_number' => [
                'required',
                'max:50',
                Rule::unique('purchase_orders', 'po_number')->ignore($purchaseOrderId),
            ],
            'supplier_id' => [
                'required',
                Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('type', 'supplier'); // If you have organization types
                }),
            ],
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date|before_or_equal:today',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|in:draft,pending,partial,completed,cancelled',
            'total_amount' => 'required|numeric|min:0.01',
            'tax_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|lte:total_amount',
            'final_amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
