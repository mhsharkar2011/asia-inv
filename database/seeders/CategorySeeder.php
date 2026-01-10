<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Admin\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing categories safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $companies = DB::table('companies')->get();
        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();
        $createdById = $superAdmin ? $superAdmin->id : 1;

        $categoryCounter = 1;

        foreach ($companies as $company) {
            $this->command->info("Creating categories for Company: {$company->name} (ID: {$company->id})");

            // Generate unique code for electronics category
            $electronicsCode = $this->generateCategoryCode($company->id, 'ELEC', $categoryCounter++);

            // Insert main category
            $electronicsId = DB::table('categories')->insertGetId([
                'company_id' => $company->id,
                'category_code' => $electronicsCode,
                'category_name' => 'Electronics',
                'parent_category_id' => null,
                'description' => 'Electronic items and gadgets',
                'tax_rate_applicable' => 18.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Electronics: {$electronicsCode}");

            // Insert subcategories
            $subcategories = [
                [
                    'code_prefix' => 'PRNT',
                    'name' => 'Printers',
                    'description' => 'Printers and Toners Service Provider',
                    'tax_rate' => 5.00,
                ],
                [
                    'code_prefix' => 'LAP',
                    'name' => 'Laptops',
                    'description' => 'Laptops and notebooks',
                    'tax_rate' => 5.00,
                ],
                [
                    'code_prefix' => 'PHN',
                    'name' => 'Smartphones',
                    'description' => 'Mobile phones and accessories',
                    'tax_rate' => 12.00,
                ],
                [
                    'code_prefix' => 'TV',
                    'name' => 'Televisions',
                    'description' => 'TVs and home entertainment',
                    'tax_rate' => 15.00,
                ],
                [
                    'code_prefix' => 'AUD',
                    'name' => 'Audio',
                    'description' => 'Speakers, headphones, and audio equipment',
                    'tax_rate' => 10.00,
                ],
            ];

            foreach ($subcategories as $subcat) {
                $subcatCode = $this->generateCategoryCode($company->id, $subcat['code_prefix'], $categoryCounter++);

                DB::table('categories')->insert([
                    'company_id' => $company->id,
                    'category_code' => $subcatCode,
                    'category_name' => $subcat['name'],
                    'parent_category_id' => $electronicsId,
                    'description' => $subcat['description'],
                    'tax_rate_applicable' => $subcat['tax_rate'],
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("    ↳ Created {$subcat['name']}: {$subcatCode}");
            }

            // Create Fashion category and subcategories
            $fashionCode = $this->generateCategoryCode($company->id, 'FSHN', $categoryCounter++);
            $fashionId = DB::table('categories')->insertGetId([
                'company_id' => $company->id,
                'category_code' => $fashionCode,
                'category_name' => 'Fashion',
                'parent_category_id' => null,
                'description' => 'Clothing, footwear, and accessories',
                'tax_rate_applicable' => 12.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Fashion: {$fashionCode}");

            $fashionSubcategories = [
                ['code_prefix' => 'MEN', 'name' => "Men's Wear", 'tax_rate' => 12.00],
                ['code_prefix' => 'WOM', 'name' => "Women's Wear", 'tax_rate' => 12.00],
                ['code_prefix' => 'KID', 'name' => "Kids' Wear", 'tax_rate' => 5.00],
                ['code_prefix' => 'SHO', 'name' => 'Footwear', 'tax_rate' => 12.00],
                ['code_prefix' => 'ACC', 'name' => 'Accessories', 'tax_rate' => 15.00],
            ];

            foreach ($fashionSubcategories as $subcat) {
                $subcatCode = $this->generateCategoryCode($company->id, $subcat['code_prefix'], $categoryCounter++);

                DB::table('categories')->insert([
                    'company_id' => $company->id,
                    'category_code' => $subcatCode,
                    'category_name' => $subcat['name'],
                    'parent_category_id' => $fashionId,
                    'description' => $subcat['name'] . ' and related products',
                    'tax_rate_applicable' => $subcat['tax_rate'],
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Home Appliances category
            $homeCode = $this->generateCategoryCode($company->id, 'HOME', $categoryCounter++);
            $homeId = DB::table('categories')->insertGetId([
                'company_id' => $company->id,
                'category_code' => $homeCode,
                'category_name' => 'Home Appliances',
                'parent_category_id' => null,
                'description' => 'Home and kitchen appliances',
                'tax_rate_applicable' => 15.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Home Appliances: {$homeCode}");

            $homeSubcategories = [
                ['code_prefix' => 'KIT', 'name' => 'Kitchen Appliances', 'tax_rate' => 15.00],
                ['code_prefix' => 'CLN', 'name' => 'Cleaning Appliances', 'tax_rate' => 15.00],
                ['code_prefix' => 'AC', 'name' => 'Air Conditioners', 'tax_rate' => 25.00],
                ['code_prefix' => 'FRZ', 'name' => 'Refrigerators', 'tax_rate' => 25.00],
                ['code_prefix' => 'WM', 'name' => 'Washing Machines', 'tax_rate' => 25.00],
            ];

            foreach ($homeSubcategories as $subcat) {
                $subcatCode = $this->generateCategoryCode($company->id, $subcat['code_prefix'], $categoryCounter++);

                DB::table('categories')->insert([
                    'company_id' => $company->id,
                    'category_code' => $subcatCode,
                    'category_name' => $subcat['name'],
                    'parent_category_id' => $homeId,
                    'description' => $subcat['name'],
                    'tax_rate_applicable' => $subcat['tax_rate'],
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Furniture category
            $furnitureCode = $this->generateCategoryCode($company->id, 'FURN', $categoryCounter++);
            DB::table('categories')->insert([
                'company_id' => $company->id,
                'category_code' => $furnitureCode,
                'category_name' => 'Furniture',
                'parent_category_id' => null,
                'description' => 'Home and office furniture',
                'tax_rate_applicable' => 10.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Furniture: {$furnitureCode}");

            // Create Groceries category
            $groceryCode = $this->generateCategoryCode($company->id, 'GROC', $categoryCounter++);
            DB::table('categories')->insert([
                'company_id' => $company->id,
                'category_code' => $groceryCode,
                'category_name' => 'Groceries',
                'parent_category_id' => null,
                'description' => 'Food items and daily essentials',
                'tax_rate_applicable' => 5.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Groceries: {$groceryCode}");

            // Create Books & Stationery category
            $booksCode = $this->generateCategoryCode($company->id, 'BOOK', $categoryCounter++);
            DB::table('categories')->insert([
                'company_id' => $company->id,
                'category_code' => $booksCode,
                'category_name' => 'Books & Stationery',
                'parent_category_id' => null,
                'description' => 'Books, notebooks, and stationery items',
                'tax_rate_applicable' => 5.00,
                'created_by' => $createdById,
                'updated_by' => $createdById,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("  ✓ Created Books & Stationery: {$booksCode}");
        }

        $totalCategories = DB::table('categories')->count();
        $this->command->info("✅ Successfully seeded {$totalCategories} categories!");
    }

    /**
     * Generate unique category code
     */
    private function generateCategoryCode($companyId, $prefix, $counter): string
    {
        // Option 1: Include company ID
        // return $prefix . '-' . str_pad($companyId, 3, '0', STR_PAD_LEFT) . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

        // Option 2: Simple format
        return $prefix . str_pad($companyId, 2, '0', STR_PAD_LEFT) . str_pad($counter, 3, '0', STR_PAD_LEFT);

        // Option 3: Random suffix
        // return $prefix . '-' . str_pad($companyId, 2, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(4));
    }
}
