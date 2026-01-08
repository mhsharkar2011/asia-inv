<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission Management
            'view permissions',
            'assign permissions',

            // Company Management
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // Branch Management
            'view branches',
            'create branches',
            'edit branches',
            'delete branches',

            // Department Management
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Customer Management
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            // Order Management
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',

            // Invoice Management
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',

            // Report Management
            'view reports',
            'generate reports',
            'export reports',

            // System Settings
            'view settings',
            'edit settings',
            'manage system',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $adminPermissions = [
            'view users', 'create users', 'edit users',
            'view roles', 'view permissions',
            'view companies', 'edit companies',
            'view branches', 'create branches', 'edit branches',
            'view departments', 'create departments', 'edit departments',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view products', 'create products', 'edit products', 'delete products',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view orders', 'create orders', 'edit orders', 'delete orders',
            'view invoices', 'create invoices', 'edit invoices',
            'view reports', 'generate reports', 'export reports',
            'view settings', 'edit settings',
        ];
        $adminRole->givePermissionTo($adminPermissions);

        $managerRole = Role::create(['name' => 'Manager', 'guard_name' => 'web']);
        $managerPermissions = [
            'view categories', 'edit categories',
            'view products', 'create products', 'edit products',
            'view customers', 'create customers', 'edit customers',
            'view orders', 'create orders', 'edit orders',
            'view invoices', 'create invoices', 'edit invoices',
            'view reports', 'generate reports',
            'view settings',
        ];
        $managerRole->givePermissionTo($managerPermissions);

        $staffRole = Role::create(['name' => 'Staff', 'guard_name' => 'web']);
        $staffPermissions = [
            'view products',
            'view customers',
            'view orders', 'create orders',
            'view invoices',
        ];
        $staffRole->givePermissionTo($staffPermissions);

        $viewerRole = Role::create(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewerPermissions = [
            'view products',
            'view customers',
            'view orders',
            'view invoices',
            'view reports',
        ];
        $viewerRole->givePermissionTo($viewerPermissions);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
