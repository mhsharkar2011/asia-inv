<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin\User;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view dashboard',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'change user status',
            'verify user email',
            'reset user password',
            'login as other users',
            'export users',
            'manage settings',
            'view reports',
            'export reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view dashboard',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'change user status',
            'export users',
            'manage settings',
            'view reports',
            'export reports',
        ]);

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'view dashboard',
            'view users',
            'view reports',
        ]);

        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->givePermissionTo(['view dashboard', 'view reports']);

        $customer = Role::firstOrCreate(['name' => 'customer']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign super_admin role to existing admin user
        $adminUser = User::where('email', 'admin@asiaenterprise.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('super_admin');
        }

        $this->command->info('Permissions and roles created successfully!');
        $this->command->info('Super admin role assigned to admin@asiaenterprise.com');
    }
}
