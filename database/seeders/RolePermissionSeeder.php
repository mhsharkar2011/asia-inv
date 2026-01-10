<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = $this->getPermissions();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $this->command->info("✓ Created " . count($permissions) . " permissions");

        // Create roles
        $this->createSuperAdminRole();
        $this->createAdminRole();
        $this->createManagerRole();
        $this->createStaffRole();
        $this->createCustomerRole();

        $this->command->info("✅ Role and permission seeding completed!");
    }

    private function getPermissions(): array
    {
        return [
            // Dashboard
            'view dashboard',

            // User Management
            'view users', 'create users', 'edit users', 'delete users', 'export users',

            // Company Management
            'view companies', 'create companies', 'edit companies', 'delete companies',

            // Branch Management
            'view branches', 'create branches', 'edit branches', 'delete branches',

            // Department Management
            'view departments', 'create departments', 'edit departments', 'delete departments',

            // Product Management
            'view products', 'create products', 'edit products', 'delete products', 'import products', 'export products',

            // Category Management
            'view categories', 'create categories', 'edit categories', 'delete categories',

            // Brand Management
            'view brands', 'create brands', 'edit brands', 'delete brands',

            // Unit Management
            'view units', 'create units', 'edit units', 'delete units',

            // Tax Management
            'view taxes', 'create taxes', 'edit taxes', 'delete taxes',

            // Inventory Management
            'view inventory', 'create inventory', 'edit inventory', 'delete inventory', 'adjust inventory',

            // Purchase Management
            'view purchases', 'create purchases', 'edit purchases', 'delete purchases', 'approve purchases',

            // Sale Management
            'view sales', 'create sales', 'edit sales', 'delete sales', 'approve sales', 'create invoice',

            // Customer Management
            'view customers', 'create customers', 'edit customers', 'delete customers',

            // Supplier Management
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',

            // Report Management
            'view reports', 'generate reports', 'export reports',

            // Settings
            'view settings', 'edit settings', 'manage roles',

            // Audit Logs
            'view audit logs',
        ];
    }

    private function createSuperAdminRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        $this->command->info("✓ Created 'superadmin' role with all permissions");
    }

    private function createAdminRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $adminPermissions = Permission::whereNotIn('name', [
            'delete companies',
            'manage roles',
        ])->pluck('name')->toArray();

        $role->syncPermissions($adminPermissions);
        $this->command->info("✓ Created 'admin' role with " . count($adminPermissions) . " permissions");
    }

    private function createManagerRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);

        $managerPermissions = [
            'view dashboard',
            'view users', 'create users', 'edit users',
            'view products', 'create products', 'edit products',
            'view inventory', 'create inventory', 'edit inventory', 'adjust inventory',
            'view sales', 'create sales', 'edit sales', 'create invoice',
            'view purchases', 'create purchases', 'edit purchases',
            'view customers', 'create customers', 'edit customers',
            'view suppliers', 'create suppliers', 'edit suppliers',
            'view reports', 'generate reports',
        ];

        $role->syncPermissions($managerPermissions);
        $this->command->info("✓ Created 'manager' role with " . count($managerPermissions) . " permissions");
    }

    private function createStaffRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

        $staffPermissions = [
            'view dashboard',
            'view products',
            'view inventory',
            'create sales', 'edit sales', 'create invoice',
            'view customers', 'create customers',
            'view reports',
        ];

        $role->syncPermissions($staffPermissions);
        $this->command->info("✓ Created 'staff' role with " . count($staffPermissions) . " permissions");
    }

    private function createCustomerRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        $customerPermissions = [
            'view products',
            'create sales',
        ];

        $role->syncPermissions($customerPermissions);
        $this->command->info("✓ Created 'customer' role with " . count($customerPermissions) . " permissions");
    }
}
