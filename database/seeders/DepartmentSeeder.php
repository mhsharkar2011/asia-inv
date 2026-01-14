<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Company;
use App\Models\Admin\Department;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all companies
        $companies = Company::all();

        if ($companies->isEmpty()) {
            // Create a default company if none exists
            $company = Company::create([
                'name' => 'Asia Enterprise',
                'code' => 'ASIA001',
                'email' => 'info@asia-enterprise.com',
                'phone' => '+8801234567890',
                'address' => 'Dhaka, Bangladesh',
                'website' => 'https://asia-enterprise.com',
                'is_active' => true,
            ]);
            $companies = collect([$company]);
        }

        foreach ($companies as $company) {
            // Create main departments
            $departments = [
                [
                    'code' => $this->generateDepartmentCode('EXEC', $company),
                    'name' => 'Executive Management',
                    'description' => 'Top-level management responsible for overall company strategy and direction.',
                    'staff_count' => 5,
                    'budget' => 5000000,
                    'is_active' => true,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('HR', $company),
                    'name' => 'Human Resources',
                    'description' => 'Responsible for recruitment, employee relations, training, and benefits administration.',
                    'staff_count' => 8,
                    'budget' => 1500000,
                    'is_active' => true,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('FIN', $company),
                    'name' => 'Finance & Accounting',
                    'description' => 'Manages financial operations, accounting, budgeting, and financial reporting.',
                    'staff_count' => 12,
                    'budget' => 3000000,
                    'is_active' => true,
                    'sort_order' => 3,
                ],
                [
                    'code' => $this->generateDepartmentCode('SALES', $company),
                    'name' => 'Sales & Marketing',
                    'description' => 'Responsible for sales operations, marketing campaigns, and customer acquisition.',
                    'staff_count' => 25,
                    'budget' => 4500000,
                    'is_active' => true,
                    'sort_order' => 4,
                ],
                [
                    'code' => $this->generateDepartmentCode('OPS', $company),
                    'name' => 'Operations',
                    'description' => 'Manages day-to-day business operations and process optimization.',
                    'staff_count' => 15,
                    'budget' => 2500000,
                    'is_active' => true,
                    'sort_order' => 5,
                ],
                [
                    'code' => $this->generateDepartmentCode('IT', $company),
                    'name' => 'Information Technology',
                    'description' => 'Manages IT infrastructure, software development, and technical support.',
                    'staff_count' => 10,
                    'budget' => 2000000,
                    'is_active' => true,
                    'sort_order' => 6,
                ],
                [
                    'code' => $this->generateDepartmentCode('PROD', $company),
                    'name' => 'Production',
                    'description' => 'Responsible for manufacturing and production operations.',
                    'staff_count' => 50,
                    'budget' => 8000000,
                    'is_active' => true,
                    'sort_order' => 7,
                ],
                [
                    'code' => $this->generateDepartmentCode('QC', $company),
                    'name' => 'Quality Control',
                    'description' => 'Ensures product quality standards and compliance with regulations.',
                    'staff_count' => 8,
                    'budget' => 1000000,
                    'is_active' => true,
                    'sort_order' => 8,
                ],
                [
                    'code' => $this->generateDepartmentCode('LOG', $company),
                    'name' => 'Logistics & Supply Chain',
                    'description' => 'Manages inventory, warehousing, transportation, and supply chain operations.',
                    'staff_count' => 12,
                    'budget' => 1800000,
                    'is_active' => true,
                    'sort_order' => 9,
                ],
                [
                    'code' => $this->generateDepartmentCode('R&D', $company),
                    'name' => 'Research & Development',
                    'description' => 'Focuses on product innovation, research, and development activities.',
                    'staff_count' => 6,
                    'budget' => 2200000,
                    'is_active' => true,
                    'sort_order' => 10,
                ],
            ];

            $parentDepartments = [];

            foreach ($departments as $departmentData) {
                $department = Department::create([
                    'company_id' => $company->id,
                    'code' => $departmentData['code'],
                    'name' => $departmentData['name'],
                    'description' => $departmentData['description'],
                    'staff_count' => $departmentData['staff_count'],
                    'budget' => $departmentData['budget'],
                    'is_active' => $departmentData['is_active'],
                    'sort_order' => $departmentData['sort_order'],
                ]);

                $parentDepartments[$departmentData['code']] = $department->id;
            }

            // Create sub-departments
            $this->createSubDepartments($company, $parentDepartments);
        }

        $this->command->info('Departments seeded successfully!');
    }

    /**
     * Generate department code
     */
    private function generateDepartmentCode(string $prefix, Company $company): string
    {
        $count = Department::where('company_id', $company->id)
            ->where('code', 'like', $prefix . '%')
            ->count();

        return sprintf('%s%03d', $prefix, $count + 1);
    }

    /**
     * Create sub-departments for parent departments
     */
    private function createSubDepartments(Company $company, array $parentDepartments): void
    {
        $subDepartments = [
            'HR' => [
                [
                    'code' => $this->generateDepartmentCode('HR-REC', $company),
                    'name' => 'Recruitment',
                    'description' => 'Handles talent acquisition, interviews, and onboarding processes.',
                    'staff_count' => 3,
                    'budget' => 500000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('HR-TRN', $company),
                    'name' => 'Training & Development',
                    'description' => 'Manages employee training programs and skill development.',
                    'staff_count' => 2,
                    'budget' => 300000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('HR-ER', $company),
                    'name' => 'Employee Relations',
                    'description' => 'Handles employee grievances, conflicts, and relations management.',
                    'staff_count' => 2,
                    'budget' => 400000,
                    'sort_order' => 3,
                ],
                [
                    'code' => $this->generateDepartmentCode('HR-COMP', $company),
                    'name' => 'Compensation & Benefits',
                    'description' => 'Manages salary structures, bonuses, and employee benefits.',
                    'staff_count' => 1,
                    'budget' => 300000,
                    'sort_order' => 4,
                ],
            ],
            'FIN' => [
                [
                    'code' => $this->generateDepartmentCode('FIN-ACC', $company),
                    'name' => 'Accounting',
                    'description' => 'Handles bookkeeping, financial records, and transaction processing.',
                    'staff_count' => 5,
                    'budget' => 1200000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('FIN-BUD', $company),
                    'name' => 'Budgeting',
                    'description' => 'Responsible for budget planning, allocation, and monitoring.',
                    'staff_count' => 3,
                    'budget' => 900000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('FIN-AP', $company),
                    'name' => 'Accounts Payable',
                    'description' => 'Manages vendor payments and accounts payable operations.',
                    'staff_count' => 2,
                    'budget' => 500000,
                    'sort_order' => 3,
                ],
                [
                    'code' => $this->generateDepartmentCode('FIN-AR', $company),
                    'name' => 'Accounts Receivable',
                    'description' => 'Handles customer invoicing and accounts receivable management.',
                    'staff_count' => 2,
                    'budget' => 400000,
                    'sort_order' => 4,
                ],
            ],
            'SALES' => [
                [
                    'code' => $this->generateDepartmentCode('SALES-DOM', $company),
                    'name' => 'Domestic Sales',
                    'description' => 'Manages sales operations within the domestic market.',
                    'staff_count' => 12,
                    'budget' => 2000000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('SALES-INT', $company),
                    'name' => 'International Sales',
                    'description' => 'Handles export and international market sales operations.',
                    'staff_count' => 8,
                    'budget' => 1500000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('SALES-MKT', $company),
                    'name' => 'Marketing',
                    'description' => 'Responsible for marketing campaigns, branding, and promotions.',
                    'staff_count' => 5,
                    'budget' => 1000000,
                    'sort_order' => 3,
                ],
            ],
            'IT' => [
                [
                    'code' => $this->generateDepartmentCode('IT-INFRA', $company),
                    'name' => 'Infrastructure',
                    'description' => 'Manages servers, networks, and IT infrastructure.',
                    'staff_count' => 4,
                    'budget' => 800000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('IT-DEV', $company),
                    'name' => 'Software Development',
                    'description' => 'Responsible for application development and maintenance.',
                    'staff_count' => 4,
                    'budget' => 800000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('IT-SUPPORT', $company),
                    'name' => 'Technical Support',
                    'description' => 'Provides IT support to employees and resolves technical issues.',
                    'staff_count' => 2,
                    'budget' => 400000,
                    'sort_order' => 3,
                ],
            ],
            'PROD' => [
                [
                    'code' => $this->generateDepartmentCode('PROD-MFG', $company),
                    'name' => 'Manufacturing',
                    'description' => 'Handles production line operations and manufacturing processes.',
                    'staff_count' => 35,
                    'budget' => 5000000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('PROD-PLAN', $company),
                    'name' => 'Production Planning',
                    'description' => 'Responsible for production scheduling and capacity planning.',
                    'staff_count' => 8,
                    'budget' => 2000000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('PROD-MAINT', $company),
                    'name' => 'Maintenance',
                    'description' => 'Maintains production equipment and ensures operational efficiency.',
                    'staff_count' => 7,
                    'budget' => 1000000,
                    'sort_order' => 3,
                ],
            ],
            'LOG' => [
                [
                    'code' => $this->generateDepartmentCode('LOG-WH', $company),
                    'name' => 'Warehousing',
                    'description' => 'Manages inventory storage and warehouse operations.',
                    'staff_count' => 6,
                    'budget' => 800000,
                    'sort_order' => 1,
                ],
                [
                    'code' => $this->generateDepartmentCode('LOG-TRANS', $company),
                    'name' => 'Transportation',
                    'description' => 'Handles logistics, shipping, and transportation operations.',
                    'staff_count' => 4,
                    'budget' => 600000,
                    'sort_order' => 2,
                ],
                [
                    'code' => $this->generateDepartmentCode('LOG-INV', $company),
                    'name' => 'Inventory Management',
                    'description' => 'Manages stock levels, inventory tracking, and control.',
                    'staff_count' => 2,
                    'budget' => 400000,
                    'sort_order' => 3,
                ],
            ],
        ];

        foreach ($subDepartments as $parentCode => $subDeptList) {
            if (!isset($parentDepartments[$parentCode])) {
                continue;
            }

            foreach ($subDeptList as $subDeptData) {
                Department::create([
                    'company_id' => $company->id,
                    'parent_id' => $parentDepartments[$parentCode],
                    'code' => $subDeptData['code'],
                    'name' => $subDeptData['name'],
                    'description' => $subDeptData['description'],
                    'staff_count' => $subDeptData['staff_count'],
                    'budget' => $subDeptData['budget'],
                    'is_active' => true,
                    'sort_order' => $subDeptData['sort_order'],
                ]);
            }
        }
    }
}
