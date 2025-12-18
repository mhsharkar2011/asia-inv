<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'po_number' => 'required|unique:purchase_orders,po_number,' . $this->route('purchase_order'),
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|in:draft,pending,partial,completed,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'final_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
