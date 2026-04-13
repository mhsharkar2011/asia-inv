<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // // Disable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // // Clear tables but NOT users table (to preserve existing users)
        // DB::table('categories')->truncate();

        // // If you have Spatie tables, clear them too
        // if (DB::getSchemaBuilder()->hasTable('permissions')) {
        //     DB::table('permissions')->truncate();
        // }
        // if (DB::getSchemaBuilder()->hasTable('roles')) {
        //     DB::table('roles')->truncate();
        // }
        // if (DB::getSchemaBuilder()->hasTable('model_has_roles')) {
        //     DB::table('model_has_roles')->truncate();
        // }
        // if (DB::getSchemaBuilder()->hasTable('role_has_permissions')) {
        //     DB::table('role_has_permissions')->truncate();
        // }

        // DB::table('companies')->truncate();

        // // Enable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // // Insert company
        // $companyId = DB::table('companies')->insertGetId([
        //     'code' => 'AEL.',
        //     'name' => 'Asia Enterprises Ltd.',
        //     'tin' => '123456789321',
        //     'bin' => '212233444444',
        //     'address' => '123 Main Street, Dhaka, Bangladesh',
        //     'country' => 'Bangladesh',
        //     'currency' => 'BDT',
        //     'fiscal_year_start' => '2024-04-01',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // // Insert admin user ONLY if doesn't exist
        // $adminExists = DB::table('users')->where('email', 'admin@mail.com')->exists();

        // if (!$adminExists) {
        //     $adminId = DB::table('users')->insertGetId([
        //         'name' => 'System Administrator',
        //         'email' => 'admin@mail.com',
        //         'password' => Hash::make('admin@123'),
        //         'avatar' => 'default_avatar.png',
        //         'company_id' => $companyId,
        //         'phone' => '+8801733172007',
        //         'language_preference' => 'en',
        //         'is_active' => true,
        //         'email_verified_at' => now(),
        //         'last_login_at' => now(),
        //         'created_by' => 1,
        //         'updated_by' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // } else {
        //     $adminId = DB::table('users')->where('email', 'admin@mail.com')->value('id');

        //     // Update the user to ensure they have company_id
        //     DB::table('users')
        //         ->where('id', $adminId)
        //         ->update(['company_id' => $companyId]);
        // }

        // Run the PermissionsSeeder (the better one)
        $this->call(RolePermissionSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(LoginLogsSeeder::class);
        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@asiaenterprise.com / admin@123');
        $this->command->info('Password: admin@123');
    }
}
