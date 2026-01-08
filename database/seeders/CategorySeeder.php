<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $companies = DB::table('companies')->get();
        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();

        foreach ($companies as $company) {
            // Insert main category
            $electronicsId = DB::table('categories')->insertGetId([
                'company_id' => $company->id,
                'category_code' => 'ELEC',
                'category_name' => 'Electronics',
                'parent_category_id' => null,
                'description' => 'Electronic items and gadgets',
                'tax_rate_applicable' => 18.00,
                'created_by' => $superAdmin ? $superAdmin->id : 1,
                'updated_by' => $superAdmin ? $superAdmin->id : 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert subcategories
            DB::table('categories')->insert([
                [
                    'company_id' => $company->id,
                    'category_code' => 'PRNT',
                    'category_name' => 'Printers',
                    'parent_category_id' => $electronicsId,
                    'description' => 'Printers and Toners Service Provider',
                    'tax_rate_applicable' => 5.00,
                    'created_by' => $superAdmin ? $superAdmin->id : 1,
                    'updated_by' => $superAdmin ? $superAdmin->id : 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'category_code' => 'LAP',
                    'category_name' => 'Laptops',
                    'parent_category_id' => $electronicsId,
                    'description' => 'Laptops and notebooks',
                    'tax_rate_applicable' => 5.00,
                    'created_by' => $superAdmin ? $superAdmin->id : 1,
                    'updated_by' => $superAdmin ? $superAdmin->id : 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'company_id' => $company->id,
                    'category_code' => 'PHN',
                    'category_name' => 'Smartphones',
                    'parent_category_id' => $electronicsId,
                    'description' => 'Mobile phones and accessories',
                    'tax_rate_applicable' => 12.00,
                    'created_by' => $superAdmin ? $superAdmin->id : 1,
                    'updated_by' => $superAdmin ? $superAdmin->id : 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
