<?php

namespace Database\Seeders;

use App\Models\Admin\Company;
use App\Models\Admin\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $companies = Company::all();

            if ($companies->isEmpty()) {
                $company = Company::create([
                    'name'     => 'Asia Enterprise',
                    'code'     => 'ASIA001',
                    'email'    => 'info@asia-enterprise.com',
                    'phone'    => '+8801234567890',
                    'address'  => 'Dhaka, Bangladesh',
                    'website'  => 'https://asia-enterprise.com',
                    'is_active' => true,
                ]);
                $companies = collect([$company]);
            }

            foreach ($companies as $company) {
                $parentDepartments = $this->createMainDepartments($company);
                $this->createSubDepartments($company, $parentDepartments);
            }
        });

        $this->command->info('Departments seeded successfully!');
    }

    /**
     * Create the top-level departments for a company.
     * Returns a map of [prefix => department_id].
     */
    private function createMainDepartments(Company $company): array
    {
        $departments = [
            ['prefix' => 'EXEC',  'name' => 'Executive Management',    'description' => 'Top-level management responsible for overall company strategy and direction.', 'staff_count' => 5,  'budget' => 5000000, 'sort_order' => 1],
            ['prefix' => 'HR',    'name' => 'Human Resources',         'description' => 'Responsible for recruitment, employee relations, training, and benefits administration.', 'staff_count' => 8,  'budget' => 1500000, 'sort_order' => 2],
            ['prefix' => 'FIN',   'name' => 'Finance & Accounting',    'description' => 'Manages financial operations, accounting, budgeting, and financial reporting.', 'staff_count' => 12, 'budget' => 3000000, 'sort_order' => 3],
            ['prefix' => 'SALES', 'name' => 'Sales & Marketing',       'description' => 'Responsible for sales operations, marketing campaigns, and customer acquisition.', 'staff_count' => 25, 'budget' => 4500000, 'sort_order' => 4],
            ['prefix' => 'OPS',   'name' => 'Operations',              'description' => 'Manages day-to-day business operations and process optimization.', 'staff_count' => 15, 'budget' => 2500000, 'sort_order' => 5],
            ['prefix' => 'IT',    'name' => 'Information Technology',  'description' => 'Manages IT infrastructure, software development, and technical support.', 'staff_count' => 10, 'budget' => 2000000, 'sort_order' => 6],
            ['prefix' => 'PROD',  'name' => 'Production',              'description' => 'Responsible for manufacturing and production operations.', 'staff_count' => 50, 'budget' => 8000000, 'sort_order' => 7],
            ['prefix' => 'QC',    'name' => 'Quality Control',         'description' => 'Ensures product quality standards and compliance with regulations.', 'staff_count' => 8,  'budget' => 1000000, 'sort_order' => 8],
            ['prefix' => 'LOG',   'name' => 'Logistics & Supply Chain','description' => 'Manages inventory, warehousing, transportation, and supply chain operations.', 'staff_count' => 12, 'budget' => 1800000, 'sort_order' => 9],
            ['prefix' => 'RD',    'name' => 'Research & Development',  'description' => 'Focuses on product innovation, research, and development activities.', 'staff_count' => 6,  'budget' => 2200000, 'sort_order' => 10],
        ];

        $parentDepartments = [];

        foreach ($departments as $dept) {
            $department = Department::updateOrCreate(
                [
                    'company_id' => $company->id,
                    'code'       => $this->departmentCode($company, $dept['prefix']),
                ],
                [
                    'parent_id'   => null,
                    'name'        => $dept['name'],
                    'description' => $dept['description'],
                    'staff_count' => $dept['staff_count'],
                    'budget'      => $dept['budget'],
                    'is_active'   => true,
                    'sort_order'  => $dept['sort_order'],
                ]
            );

            $parentDepartments[$dept['prefix']] = $department->id;
        }

        return $parentDepartments;
    }

    /**
     * Create sub-departments for each parent.
     */
    private function createSubDepartments(Company $company, array $parentDepartments): void
    {
        $subDepartments = [
            'HR' => [
                ['prefix' => 'HR-REC',   'name' => 'Recruitment',                'description' => 'Handles talent acquisition, interviews, and onboarding processes.', 'staff_count' => 3, 'budget' => 500000, 'sort_order' => 1],
                ['prefix' => 'HR-TRN',   'name' => 'Training & Development',     'description' => 'Manages employee training programs and skill development.', 'staff_count' => 2, 'budget' => 300000, 'sort_order' => 2],
                ['prefix' => 'HR-ER',    'name' => 'Employee Relations',         'description' => 'Handles employee grievances, conflicts, and relations management.', 'staff_count' => 2, 'budget' => 400000, 'sort_order' => 3],
                ['prefix' => 'HR-COMP',  'name' => 'Compensation & Benefits',    'description' => 'Manages salary structures, bonuses, and employee benefits.', 'staff_count' => 1, 'budget' => 300000, 'sort_order' => 4],
            ],
            'FIN' => [
                ['prefix' => 'FIN-ACC',  'name' => 'Accounting',                 'description' => 'Handles bookkeeping, financial records, and transaction processing.', 'staff_count' => 5, 'budget' => 1200000, 'sort_order' => 1],
                ['prefix' => 'FIN-BUD',  'name' => 'Budgeting',                  'description' => 'Responsible for budget planning, allocation, and monitoring.', 'staff_count' => 3, 'budget' => 900000, 'sort_order' => 2],
                ['prefix' => 'FIN-AP',   'name' => 'Accounts Payable',           'description' => 'Manages vendor payments and accounts payable operations.', 'staff_count' => 2, 'budget' => 500000, 'sort_order' => 3],
                ['prefix' => 'FIN-AR',   'name' => 'Accounts Receivable',        'description' => 'Handles customer invoicing and accounts receivable management.', 'staff_count' => 2, 'budget' => 400000, 'sort_order' => 4],
            ],
            'SALES' => [
                ['prefix' => 'SALES-DOM', 'name' => 'Domestic Sales',            'description' => 'Manages sales operations within the domestic market.', 'staff_count' => 12, 'budget' => 2000000, 'sort_order' => 1],
                ['prefix' => 'SALES-INT', 'name' => 'International Sales',       'description' => 'Handles export and international market sales operations.', 'staff_count' => 8, 'budget' => 1500000, 'sort_order' => 2],
                ['prefix' => 'SALES-MKT', 'name' => 'Marketing',                 'description' => 'Responsible for marketing campaigns, branding, and promotions.', 'staff_count' => 5, 'budget' => 1000000, 'sort_order' => 3],
            ],
            'IT' => [
                ['prefix' => 'IT-INFRA',   'name' => 'Infrastructure',           'description' => 'Manages servers, networks, and IT infrastructure.', 'staff_count' => 4, 'budget' => 800000, 'sort_order' => 1],
                ['prefix' => 'IT-DEV',     'name' => 'Software Development',     'description' => 'Responsible for application development and maintenance.', 'staff_count' => 4, 'budget' => 800000, 'sort_order' => 2],
                ['prefix' => 'IT-SUPPORT', 'name' => 'Technical Support',        'description' => 'Provides IT support to employees and resolves technical issues.', 'staff_count' => 2, 'budget' => 400000, 'sort_order' => 3],
            ],
            'PROD' => [
                ['prefix' => 'PROD-MFG',   'name' => 'Manufacturing',            'description' => 'Handles production line operations and manufacturing processes.', 'staff_count' => 35, 'budget' => 5000000, 'sort_order' => 1],
                ['prefix' => 'PROD-PLAN',  'name' => 'Production Planning',      'description' => 'Responsible for production scheduling and capacity planning.', 'staff_count' => 8, 'budget' => 2000000, 'sort_order' => 2],
                ['prefix' => 'PROD-MAINT', 'name' => 'Maintenance',              'description' => 'Maintains production equipment and ensures operational efficiency.', 'staff_count' => 7, 'budget' => 1000000, 'sort_order' => 3],
            ],
            'LOG' => [
                ['prefix' => 'LOG-WH',    'name' => 'Warehousing',               'description' => 'Manages inventory storage and warehouse operations.', 'staff_count' => 6, 'budget' => 800000, 'sort_order' => 1],
                ['prefix' => 'LOG-TRANS', 'name' => 'Transportation',            'description' => 'Handles logistics, shipping, and transportation operations.', 'staff_count' => 4, 'budget' => 600000, 'sort_order' => 2],
                ['prefix' => 'LOG-INV',   'name' => 'Inventory Management',      'description' => 'Manages stock levels, inventory tracking, and control.', 'staff_count' => 2, 'budget' => 400000, 'sort_order' => 3],
            ],
        ];

        foreach ($subDepartments as $parentPrefix => $subDeptList) {
            if (!isset($parentDepartments[$parentPrefix])) {
                continue;
            }

            foreach ($subDeptList as $sub) {
                Department::updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'code'       => $this->departmentCode($company, $sub['prefix']),
                    ],
                    [
                        'parent_id'   => $parentDepartments[$parentPrefix],
                        'name'        => $sub['name'],
                        'description' => $sub['description'],
                        'staff_count' => $sub['staff_count'],
                        'budget'      => $sub['budget'],
                        'is_active'   => true,
                        'sort_order'  => $sub['sort_order'],
                    ]
                );
            }
        }
    }

    /**
     * Generate a code like "HR001", "HR-REC002" — scoped per company.
     * Uses a soft-deleted-aware count so re-runs produce stable codes.
     */
    private function departmentCode(Company $company, string $prefix): string
    {
        $count = Department::withTrashed()
            ->where('company_id', $company->id)
            ->where('code', 'like', $prefix . '%')
            ->count();

        return sprintf('%s%03d', $prefix, $count + 1);
    }
}
