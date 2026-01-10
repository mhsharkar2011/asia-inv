<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear all tables in proper order
        $this->truncateTables();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Run seeders in proper order
        $this->call([
            RolePermissionSeeder::class, // This should create permissions and roles
            CompanySeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            UnitSeeder::class,      // Add this
            TaxSeeder::class,
            UserSeeder::class, // This uses roles created above
            BrandSeeder::class,
            CategorySeeder::class,
            // ProductSeeder::class,
            // Add other seeders as needed
        ]);

        $this->command->info('Database seeded successfully!');
    }

    private function truncateTables(): void
    {
        // Clear tables in proper order to avoid foreign key constraints
        $tables = [
            'categories',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'permissions',
            'roles',
            'branches',
            'departments',
            'companies',
            'products'
            // Don't truncate users table to preserve existing users
        ];

        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }
}
