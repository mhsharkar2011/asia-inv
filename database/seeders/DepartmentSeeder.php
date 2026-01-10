<?php

namespace Database\Seeders;

use App\Models\Admin\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'code' => 'DEPT001',
                'name' => 'Management',
                'description' => 'Executive management and leadership',
                'staff_count' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'code' => 'DEPT002',
                'name' => 'Sales & Marketing',
                'description' => 'Sales, marketing, and customer relations',
                'staff_count' => 15,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'code' => 'DEPT003',
                'name' => 'Information Technology',
                'description' => 'IT infrastructure, development, and support',
                'staff_count' => 10,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'code' => 'DEPT004',
                'name' => 'Human Resources',
                'description' => 'Recruitment, training, and employee management',
                'staff_count' => 8,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'code' => 'DEPT005',
                'name' => 'Finance & Accounting',
                'description' => 'Financial management, accounting, and budgeting',
                'staff_count' => 12,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'code' => 'DEPT006',
                'name' => 'Operations',
                'description' => 'Daily operations and logistics',
                'staff_count' => 20,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'code' => 'DEPT007',
                'name' => 'Research & Development',
                'description' => 'Product research and development',
                'staff_count' => 8,
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }

        // Add some sub-departments
        $sales = Department::where('code', 'DEPT002')->first();
        if ($sales) {
            Department::create([
                'code' => 'DEPT008',
                'name' => 'Sales Team',
                'parent_id' => $sales->id,
                'description' => 'Direct sales and customer acquisition',
                'staff_count' => 8,
                'is_active' => true,
                'sort_order' => 1,
            ]);

            Department::create([
                'code' => 'DEPT009',
                'name' => 'Marketing Team',
                'parent_id' => $sales->id,
                'description' => 'Digital marketing and promotions',
                'staff_count' => 7,
                'is_active' => true,
                'sort_order' => 2,
            ]);
        }
    }
}
