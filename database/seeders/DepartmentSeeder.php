<?php

namespace Database\Seeders;

use App\Models\Admin\Department;
use App\Models\Admin\Company;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $departments = [
                [
                    'company_id' => $company->id,
                    'code' => 'DEPT001',
                    'name' => 'Management',
                    'description' => 'Executive management and leadership',
                    'is_active' => true,
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'code' => 'DEPT002',
                    'name' => 'Sales & Marketing',
                    'description' => 'Sales, marketing, and customer relations',
                    'is_active' => true,
                    'sort_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'code' => 'DEPT003',
                    'name' => 'Information Technology',
                    'description' => 'IT infrastructure, development, and support',
                    'is_active' => true,
                    'sort_order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'code' => 'DEPT004',
                    'name' => 'Human Resources',
                    'description' => 'Recruitment, training, and employee management',
                    'is_active' => true,
                    'sort_order' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'code' => 'DEPT005',
                    'name' => 'Finance & Accounting',
                    'description' => 'Financial management, accounting, and budgeting',
                    'is_active' => true,
                    'sort_order' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($departments as $dept) {
                Department::create($dept);
            }

            // Add some sub-departments for Sales & Marketing
            $sales = Department::where('company_id', $company->id)
                ->where('code', 'DEPT002')
                ->first();

            if ($sales) {
                Department::create([
                    'company_id' => $company->id,
                    'parent_id' => $sales->id,
                    'code' => 'DEPT006',
                    'name' => 'Sales Team',
                    'description' => 'Direct sales and customer acquisition',
                    'is_active' => true,
                    'sort_order' => 6,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Department::create([
                    'company_id' => $company->id,
                    'parent_id' => $sales->id,
                    'code' => 'DEPT007',
                    'name' => 'Marketing Team',
                    'description' => 'Digital marketing and promotions',
                    'is_active' => true,
                    'sort_order' => 7,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Departments seeded successfully!');
    }
}
