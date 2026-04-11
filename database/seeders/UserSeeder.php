<?php

namespace Database\Seeders;

use App\Models\Admin\User;
use App\Models\Admin\Company;
use App\Models\Admin\Branch;
use App\Models\Admin\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Only run in development environment
        if (!app()->environment('local', 'development', 'testing')) {
            $this->command->warn('UserSeeder only runs in development environments.');
            return;
        }

        // Create or get the default company for development
        $company = Company::firstOrCreate(
            ['name' => 'Asia Enterprises Ltd'],
            [
                'code' => 'ASIA-001',
                'name' => 'ASIA',
                'email' => 'info@asiaenterprises.com',
                'phone' => '+8801733172000',
                'address' => '123 Business Street',
                'city' => 'Dhaka',
                'district' => 'Gulshan',
                'country' => 'Bangladesh',
                'postal_code' => '1212',
                'tin' => '123456789321',
                'bin' => '212233444444',
                'trade_license' => 'TL-ASIA-001',
                'website' => 'https://asiaenterprises.com',
                'currency' => 'BDT',
                'timezone' => 'Asia/Dhaka',
                'logo' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create head office branch for development
        $headOffice = Branch::firstOrCreate(
            [
                'company_id' => $company->id,
                'name' => 'Head Office'
            ],
            [
                'code' => 'HO-001',
                'type' => 'office',
                'contact_person' => 'John Doe',
                'designation' => 'General Manager',
                'email' => 'headoffice@asiaenterprises.com',
                'primary_phone' => '+8801733172002',
                'secondary_phone' => '+8801733172003',
                'address' => '123 Business Street',
                'postal_area' => 'Gulshan',
                'postal_code' => '1212',
                'city' => 'Dhaka',
                'district' => 'dhaka',
                'country' => 'Bangladesh',
                'opening_time' => '09:00:00',
                'closing_time' => '18:00:00',
                'working_days' => 'Monday-Friday',
                'staff_count' => 50,
                'area_sqft' => 5000,
                'is_head_office' => true,
                'is_active' => true,
                'has_warehouse' => true,
                'has_showroom' => true,
                'description' => 'Main head office location',
                'additional_info' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create IT department for development
        $itDepartment = Department::firstOrCreate(
            [
                'company_id' => $company->id,
                'name' => 'Information Technology'
            ],
            [
                'code' => 'DEPT-IT',
                'description' => 'IT and Software Development Department',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Ensure roles exist
        $this->ensureRolesExist();

        // 1. Create Super Admin
        $superAdmin = User::firstOrCreate(
            [
                'email' => 'superadmin@asiaenterprises.com'
            ],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('admin@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172003',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Super Admin role
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdmin->syncRoles([$superAdminRole]);
            $this->command->info('Super Admin role assigned.');
        }

        // 2. Create Admin
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@asiaenterprises.com'
            ],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('admin@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172004',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $admin->syncRoles([$adminRole]);
            $this->command->info('Admin role assigned.');
        }

        // 3. Create Inventory Manager
        $inventoryManager = User::firstOrCreate(
            [
                'email' => 'inventory@asiaenterprises.com'
            ],
            [
                'name' => 'Inventory Manager',
                'username' => 'inventory',
                'password' => Hash::make('inventory@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172005',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Inventory Manager role
        $inventoryRole = Role::where('name', 'Inventory Manager')->first();
        if ($inventoryRole) {
            $inventoryManager->syncRoles([$inventoryRole]);
            $this->command->info('Inventory Manager role assigned.');
        }

        // 4. Create Sales Person
        $salesPerson = User::firstOrCreate(
            [
                'email' => 'sales@asiaenterprises.com'
            ],
            [
                'name' => 'Sales Person',
                'username' => 'sales',
                'password' => Hash::make('sales@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172006',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Sales Person role
        $salesRole = Role::where('name', 'Sales Person')->first();
        if ($salesRole) {
            $salesPerson->syncRoles([$salesRole]);
            $this->command->info('Sales Person role assigned.');
        }

        // 5. Create Purchase Manager
        $purchaseManager = User::firstOrCreate(
            [
                'email' => 'purchase@asiaenterprises.com'
            ],
            [
                'name' => 'Purchase Manager',
                'username' => 'purchase',
                'password' => Hash::make('purchase@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172007',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Purchase Manager role
        $purchaseRole = Role::where('name', 'Purchase Manager')->first();
        if ($purchaseRole) {
            $purchaseManager->syncRoles([$purchaseRole]);
            $this->command->info('Purchase Manager role assigned.');
        }

        // 6. Create View Only User (for testing limited permissions)
        $viewOnlyUser = User::firstOrCreate(
            [
                'email' => 'viewonly@asiaenterprises.com'
            ],
            [
                'name' => 'View Only User',
                'username' => 'viewonly',
                'password' => Hash::make('view@123'),
                'avatar' => null,
                'company_id' => $company->id,
                'branch_id' => $headOffice->id,
                'department_id' => $itDepartment->id,
                'phone' => '+8801733172008',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'two_factor_enabled' => false,
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Assign Viewer role or basic permissions
        $viewerRole = Role::where('name', 'Viewer')->first();
        if ($viewerRole) {
            $viewOnlyUser->syncRoles([$viewerRole]);
            $this->command->info('Viewer role assigned.');
        }

        // Output login information
        $this->command->info('========================================');
        $this->command->info('🎉 DEVELOPMENT USERS CREATED SUCCESSFULLY');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 Login Credentials:');
        $this->command->info('----------------------------------------');
        $this->command->info('Super Admin: superadmin@asiaenterprises.com / admin@123');
        $this->command->info('Admin: admin@asiaenterprises.com / admin@123');
        $this->command->info('Inventory Manager: inventory@asiaenterprises.com / inventory@123');
        $this->command->info('Sales Person: sales@asiaenterprises.com / sales@123');
        $this->command->info('Purchase Manager: purchase@asiaenterprises.com / purchase@123');
        $this->command->info('View Only User: viewonly@asiaenterprises.com / view@123');
        $this->command->info('');
        $this->command->info('Company: Asia Enterprises Ltd');
        $this->command->info('Branch: Head Office');
        $this->command->info('Department: Information Technology');
        $this->command->info('========================================');
    }

    /**
     * Ensure all necessary roles exist
     */
    private function ensureRolesExist(): void
    {
        $roles = [
            'Super Admin' => ['description' => 'Has full system access and administrative privileges'],
            'Admin' => ['description' => 'Has administrative access but limited to company scope'],
            'Inventory Manager' => ['description' => 'Manages inventory, products, and stock'],
            'Sales Person' => ['description' => 'Manages sales, customers, and invoices'],
            'Purchase Manager' => ['description' => 'Manages purchases, suppliers, and procurement'],
            'Viewer' => ['description' => 'Read-only access to view data'],
            'Manager' => ['description' => 'Department or team manager'],
            'Staff' => ['description' => 'Regular staff member with basic permissions'],
        ];

        foreach ($roles as $name => $attributes) {
            Role::firstOrCreate(
                ['name' => $name],
                [
                    'guard_name' => 'web',
                    // 'description' => $attributes['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ All roles have been created.');
    }
}
