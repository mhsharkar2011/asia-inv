<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId = $this->route('admin.branches') ? $this->route('admin.branches')->id : null;
        $companyId = $this->input('company_id');

        return [
            'company_id' => 'required|exists:companies,id',
            'branch_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('branches', 'branch_code')->ignore($branchId)
            ],
            'branch_name' => 'required|string|max:255',
            'branch_type' => 'required|in:retail,warehouse,office,factory,distribution,service',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'working_days' => 'required|string|max:100',
            'staff_count' => 'nullable|integer|min:0',
            'area_sqft' => 'nullable|numeric|min:0',
            'is_head_office' => 'boolean',
            'is_active' => 'boolean',
            'has_warehouse' => 'boolean',
            'has_showroom' => 'boolean',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => 'Please select a company.',
            'branch_code.unique' => 'This branch code is already in use.',
            'branch_name.required' => 'Branch name is required.',
            'opening_time.required' => 'Opening time is required.',
            'closing_time.after' => 'Closing time must be after opening time.',
            'latitude.between' => 'Latitude must be between -90 and 90.',
            'longitude.between' => 'Longitude must be between -180 and 180.',
        ];
    }

    public function prepareForValidation()
    {
        // Ensure boolean fields are properly cast
        $this->merge([
            'is_head_office' => $this->boolean('is_head_office'),
            'is_active' => $this->boolean('is_active'),
            'has_warehouse' => $this->boolean('has_warehouse'),
            'has_showroom' => $this->boolean('has_showroom'),
        ]);
    }
}
