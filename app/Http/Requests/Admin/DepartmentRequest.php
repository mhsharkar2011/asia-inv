<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('admin.departments') ? $this->route('admin.departments')->id : null;
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('departments', 'code')->ignore($departmentId)
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'parent_id' => [
                'nullable',
                'exists:departments,id',
                function ($attribute, $value, $fail) use ($departmentId) {
                    if ($departmentId && $value == $departmentId) {
                        $fail('A department cannot be its own parent.');
                    }
                }
            ],
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'staff_count' => 'nullable|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This department code is already in use.',
            'parent_id.exists' => 'Selected parent department does not exist.',
            'manager_id.exists' => 'Selected manager does not exist.',
        ];
    }
}
