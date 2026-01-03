<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==============================================
        // CREATE ALL PERMISSIONS FIRST
        // ==============================================
        $permissions = [
            // Dashboard
            'view dashboard',
            'access admin panel',

            // Users
            'manage users', 'view users', 'create users', 'edit users', 'delete users',
            'export users', 'import users', 'impersonate users',
            'change user status', 'verify user email', 'reset user password', 'login as other users',

            // Roles & Permissions
            'manage roles', 'view roles', 'create roles', 'edit roles', 'delete roles',
            'manage permissions', 'view permissions', 'create permissions', 'edit permissions', 'delete permissions',

            // Companies
            'manage companies', 'view companies', 'create companies', 'edit companies', 'delete companies',
            'export companies', 'import companies',

            // System
            'view audit logs',
            'view settings', 'edit settings',

            // Inventory Permissions
            // Categories
            'manage categories', 'view categories', 'create categories', 'edit categories', 'delete categories',

            // Products
            'manage products', 'view products', 'create products', 'edit products', 'delete products',

            // Stock
            'manage stock', 'view stock', 'create stock', 'edit stock', 'delete stock',

            // Warehouses
            'manage warehouses', 'view warehouses', 'create warehouses', 'edit warehouses', 'delete warehouses',

            // Purchase Permissions
            // Suppliers
            'manage suppliers', 'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',

            // Purchase Orders
            'manage purchase orders', 'view purchase orders', 'create purchase orders',
            'edit purchase orders', 'delete purchase orders',

            // Sales Permissions
            // Customers
            'manage customers', 'view customers', 'create customers', 'edit customers', 'delete customers',

            // Sales Orders
            'manage sales orders', 'view sales orders', 'create sales orders', 'edit sales orders',
            'delete sales orders', 'export sales',

            // Invoices
            'manage invoices', 'view invoices', 'create invoices', 'edit invoices', 'delete invoices',

            // Reports Permissions
            'view reports',
            'view sales reports', 'view customer reports', 'view product reports',
            'view inventory reports', 'view purchase reports', 'view tax reports',
            'view financial reports',
            'export reports'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // ==============================================
        // CREATE ROLES
        // ==============================================
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $inventoryManager = Role::firstOrCreate(['name' => 'inventory_manager', 'guard_name' => 'web']);
        $salesManager = Role::firstOrCreate(['name' => 'sales_manager', 'guard_name' => 'web']);
        $purchaseManager = Role::firstOrCreate(['name' => 'purchase_manager', 'guard_name' => 'web']);
        $accountant = Role::firstOrCreate(['name' => 'accountant', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // ==============================================
        // GET PERMISSION OBJECTS FOR ASSIGNMENT
        // ==============================================
        // Get all permissions as objects to avoid string lookups
        $permissionObjects = [];
        foreach ($permissions as $permissionName) {
            $permissionObjects[$permissionName] = Permission::where('name', $permissionName)->first();
        }

        // ==============================================
        // ASSIGN PERMISSIONS TO ROLES
        // ==============================================

        // 1. SUPER ADMIN - Has ALL permissions
        $superAdmin->syncPermissions($permissionObjects);

        // 2. ADMIN
        $adminPermissions = [
            'view dashboard', 'access admin panel',
            'manage users', 'view users', 'create users', 'edit users', 'export users',
            'change user status',
            'view roles', 'view permissions',
            'manage companies', 'view companies', 'create companies', 'edit companies',
            'export companies', 'import companies',
            'view audit logs', 'view settings', 'edit settings',
            'manage categories', 'view categories', 'create categories', 'edit categories',
            'manage products', 'view products', 'create products', 'edit products',
            'manage stock', 'view stock', 'create stock', 'edit stock',
            'manage warehouses', 'view warehouses', 'create warehouses', 'edit warehouses',
            'manage suppliers', 'view suppliers', 'create suppliers', 'edit suppliers',
            'manage purchase orders', 'view purchase orders', 'create purchase orders', 'edit purchase orders',
            'manage customers', 'view customers', 'create customers', 'edit customers',
            'manage sales orders', 'view sales orders', 'create sales orders', 'edit sales orders', 'export sales',
            'manage invoices', 'view invoices', 'create invoices', 'edit invoices',
            'view reports',
            'view sales reports', 'view customer reports', 'view product reports',
            'view inventory reports', 'view purchase reports', 'view tax reports',
            'view financial reports',
            'export reports'
        ];

        $admin->syncPermissions(array_intersect_key($permissionObjects, array_flip($adminPermissions)));

        // 3. INVENTORY MANAGER
        $inventoryManagerPermissions = [
            'view dashboard',
            'manage categories', 'view categories', 'create categories', 'edit categories',
            'manage products', 'view products', 'create products', 'edit products',
            'manage stock', 'view stock', 'create stock', 'edit stock',
            'manage warehouses', 'view warehouses', 'create warehouses', 'edit warehouses',
            'view suppliers', 'create suppliers', 'edit suppliers',
            'view purchase orders', 'create purchase orders', 'edit purchase orders',
            'view reports',
            'view inventory reports', 'view product reports', 'view purchase reports',
        ];
        $inventoryManager->syncPermissions(array_intersect_key($permissionObjects, array_flip($inventoryManagerPermissions)));

        // 4. SALES MANAGER
        $salesManagerPermissions = [
            'view dashboard',
            'view categories', 'view products', 'view stock',
            'manage customers', 'view customers', 'create customers', 'edit customers',
            'manage sales orders', 'view sales orders', 'create sales orders', 'edit sales orders',
            'manage invoices', 'view invoices', 'create invoices', 'edit invoices',
            'view reports',
            'view sales reports', 'view customer reports',
            'export sales',
        ];
        $salesManager->syncPermissions(array_intersect_key($permissionObjects, array_flip($salesManagerPermissions)));

        // 5. PURCHASE MANAGER
        $purchaseManagerPermissions = [
            'view dashboard',
            'view categories', 'view products', 'view stock',
            'manage suppliers', 'view suppliers', 'create suppliers', 'edit suppliers',
            'manage purchase orders', 'view purchase orders', 'create purchase orders', 'edit purchase orders',
            'view reports',
            'view purchase reports',
        ];
        $purchaseManager->syncPermissions(array_intersect_key($permissionObjects, array_flip($purchaseManagerPermissions)));

        // 6. ACCOUNTANT
        $accountantPermissions = [
            'view dashboard',
            'view products', 'view stock',
            'view customers', 'view sales orders', 'view invoices',
            'view suppliers', 'view purchase orders',
            'view reports',
            'view sales reports', 'view customer reports', 'view purchase reports',
            'view tax reports', 'view financial reports',
            'export reports',
        ];
        $accountant->syncPermissions(array_intersect_key($permissionObjects, array_flip($accountantPermissions)));

        // 7. MANAGER (General Manager)
        $managerPermissions = [
            'view dashboard',
            'view users',
            'view categories', 'view products', 'view stock', 'view warehouses',
            'view suppliers', 'view purchase orders',
            'view customers', 'view sales orders', 'view invoices',
            'view reports',
            'view sales reports', 'view customer reports', 'view product reports',
            'view inventory reports', 'view purchase reports', 'view financial reports',
        ];
        $manager->syncPermissions(array_intersect_key($permissionObjects, array_flip($managerPermissions)));

        // 8. STAFF (Regular Staff)
        $staffPermissions = [
            'view dashboard',
            'view products', 'view stock',
            'view customers',
            'view sales orders', 'create sales orders', 'edit sales orders',
        ];
        $staff->syncPermissions(array_intersect_key($permissionObjects, array_flip($staffPermissions)));

        // 9. VIEWER (Read-only access)
        $viewerPermissions = [
            'view dashboard',
            'view categories', 'view products', 'view stock',
            'view customers', 'view sales orders', 'view invoices',
            'view reports',
        ];
        $viewer->syncPermissions(array_intersect_key($permissionObjects, array_flip($viewerPermissions)));

        // 10. CUSTOMER (External customer access)
        $customerPermissions = [
            'view dashboard',
            'view products',
        ];
        $customer->syncPermissions(array_intersect_key($permissionObjects, array_flip($customerPermissions)));

        // ==============================================
        // ASSIGN SUPER_ADMIN ROLE TO FIRST USER
        // ==============================================
        if (User::count() > 0) {
            $firstUser = User::first();
            if (!$firstUser->hasRole('super_admin')) {
                $firstUser->assignRole('super_admin');
                $this->command->info("Assigned super_admin role to user: {$firstUser->email}");
            }
        }

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Total Permissions: ' . Permission::count());
        $this->command->info('Total Roles: ' . Role::count());
    }
}
