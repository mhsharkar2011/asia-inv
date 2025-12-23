<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear tables but NOT users table (to preserve existing users)
        DB::table('categories')->truncate();

        // Only truncate users if empty or you want fresh start
        // DB::table('users')->truncate();

        // If you have Spatie tables, clear them too
        if (DB::getSchemaBuilder()->hasTable('permissions')) {
            DB::table('permissions')->truncate();
        }
        if (DB::getSchemaBuilder()->hasTable('roles')) {
            DB::table('roles')->truncate();
        }
        if (DB::getSchemaBuilder()->hasTable('model_has_roles')) {
            DB::table('model_has_roles')->truncate();
        }
        if (DB::getSchemaBuilder()->hasTable('role_has_permissions')) {
            DB::table('role_has_permissions')->truncate();
        }

        DB::table('companies')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert company
        $companyId = DB::table('companies')->insertGetId([
            'code' => 'AEL.',
            'name' => 'Asia Enterprises Ltd.',
            'tin' => '123456789321',
            'bin' => '212233444444',
            'address' => '123 Main Street, Mumbai, Maharashtra',
            'country' => 'India',
            'currency' => 'INR',
            'fiscal_year_start' => '2024-04-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert admin user ONLY if doesn't exist
        $adminExists = DB::table('users')->where('email', 'admin@asiaenterprise.com')->exists();

        if (!$adminExists) {
            $adminId = DB::table('users')->insertGetId([
                'name' => 'System Administrator',
                'email' => 'admin@asiaenterprise.com',
                'password' => Hash::make('admin@123'),
                'avatar' => 'default_avatar.png',
                'company_id' => $companyId,
                'phone' => '+8801733172007',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'created_by' => 1, // Self-created
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $adminId = DB::table('users')->where('email', 'admin@asiaenterprise.com')->value('id');
        }

        // Insert categories
        $electronicsId = DB::table('categories')->insertGetId([
            'company_id' => $companyId,
            'category_code' => 'ELEC',
            'category_name' => 'Electronics',
            'parent_category_id' => null,
            'description' => 'Electronic items and gadgets',
            'tax_rate_applicable' => 18.00,
            'created_by' => $adminId,
            'updated_by' => $adminId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert subcategories
        DB::table('categories')->insert([
            [
                'company_id' => $companyId,
                'category_code' => 'PRNT',
                'category_name' => 'Printers',
                'parent_category_id' => $electronicsId,
                'description' => 'Printers and Toners Service Provider',
                'tax_rate_applicable' => 5.00,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $companyId,
                'category_code' => 'LAP',
                'category_name' => 'Laptops',
                'parent_category_id' => $electronicsId,
                'description' => 'Laptops and notebooks',
                'tax_rate_applicable' => 5.00,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Run the PermissionsSeeder
        $this->call(PermissionsSeeder::class);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@asiaenterprise.com / admin@123');
    }
}
