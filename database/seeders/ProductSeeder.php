<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Inventory\Product;
use App\Models\Admin\Company;
use App\Models\Admin\Brand;
use App\Models\Inventory\Category;
use App\Models\Admin\Unit;
use App\Models\Admin\Tax;
use App\Models\Admin\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        // Seed products
        $this->seedProducts();
    }

    private function seedProducts()
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->error('No companies found. Please seed companies first.');
            return;
        }

        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();
        $createdById = $superAdmin ? $superAdmin->id : 1;

        $totalProducts = 0;

        foreach ($companies as $company) {
            $this->command->info("Creating products for Company: {$company->product_name}");

            // Get company-specific data
            $brands = Brand::where('company_id', $company->id)->get();
            $categories = Category::where('company_id', $company->id)->get();
            $units = Unit::where('company_id', $company->id)->get();
            $taxes = Tax::where('company_id', $company->id)->get();

            // Check if we have the minimum required data
            if ($brands->isEmpty()) {
                $this->command->warn("No brands found for company {$company->product_name}. Creating default brand...");
                $brands = $this->createDefaultBrand($company, $createdById);
            }

            if ($categories->isEmpty()) {
                $this->command->warn("No categories found for company {$company->product_name}. Creating default category...");
                $categories = $this->createDefaultCategory($company, $createdById);
            }

            if ($units->isEmpty()) {
                $this->command->warn("No units found for company {$company->product_name}. Creating default unit...");
                $units = $this->createDefaultUnit($company, $createdById);
            }

            // Get default IDs with null-safe operators
            $defaultUnit = $units->firstWhere('unit_code', 'like', '%PCS%') ?? $units->first();
            $defaultCategory = $categories->firstWhere('category_name', 'like', '%Smartphone%') ??
                               $categories->firstWhere('category_name', 'like', '%Electronics%') ??
                               $categories->first();
            $defaultBrand = $brands->firstWhere('product_name', 'like', '%Apple%') ??
                            $brands->firstWhere('product_name', 'like', '%Samsung%') ??
                            $brands->first();
            $defaultTax = $taxes->first();

            // Validate we have required IDs
            if (!$defaultUnit || !$defaultCategory || !$defaultBrand) {
                $this->command->error("Missing required data for company {$company->product_name}. Skipping...");
                continue;
            }

            // Sample products data
            $products = [
                [
                    'product_name' => 'iPhone 15 Pro',
                    'sku' => $this->generateSku($company->id, 'PHN'),
                    'description' => 'Latest Apple smartphone with A17 Pro chip',
                    'product_type' => 'physical',
                    'unit_id' => $defaultUnit->id,
                    'category_id' => $defaultCategory->id,
                    'brand_id' => $defaultBrand->id,
                    'tax_id' => $defaultTax->id ?? null,
                    'cost_price' => 90000,
                    'selling_price' => 120000,
                    'wholesale_price' => 110000,
                    'minimum_price' => 100000,
                    'stock_quantity' => 50,
                    'alert_quantity' => 10,
                    'barcode' => $this->generateBarcode(),
                    'weight' => 0.187,
                    'dimensions' => '146.6 x 70.6 x 8.25 mm',
                    'is_active' => true,
                    'is_featured' => true,
                    'has_variants' => false,
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ],
                [
                    'product_name' => 'Samsung Galaxy S24 Ultra',
                    'sku' => $this->generateSku($company->id, 'PHN'),
                    'description' => 'Flagship Samsung phone with S Pen',
                    'product_type' => 'physical',
                    'unit_id' => $defaultUnit->id,
                    'category_id' => $defaultCategory->id,
                    'brand_id' => $defaultBrand->id,
                    'tax_id' => $defaultTax->id ?? null,
                    'cost_price' => 85000,
                    'selling_price' => 115000,
                    'wholesale_price' => 105000,
                    'minimum_price' => 95000,
                    'stock_quantity' => 75,
                    'alert_quantity' => 15,
                    'barcode' => $this->generateBarcode(),
                    'weight' => 0.232,
                    'dimensions' => '162.3 x 79 x 8.6 mm',
                    'is_active' => true,
                    'is_featured' => true,
                    'has_variants' => true,
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ],
            ];

            // Create initial products
            foreach ($products as $productData) {
                Product::create($productData);
                $totalProducts++;
                $this->command->info("  ✓ Created: {$productData['product_name']}");
            }

            // Create additional electronics products
            $electronicsProducts = [
                ['product_name' => 'Dell XPS 15 Laptop', 'category' => 'Laptop', 'brand' => 'Dell', 'cost' => 120000, 'price' => 150000],
                ['product_name' => 'HP LaserJet Pro Printer', 'category' => 'Printer', 'brand' => 'HP', 'cost' => 25000, 'price' => 35000],
                ['product_name' => 'Sony WH-1000XM5 Headphones', 'category' => 'Audio', 'brand' => 'Sony', 'cost' => 25000, 'price' => 35000],
                ['product_name' => 'LG 55" 4K Smart TV', 'category' => 'Television', 'brand' => 'LG', 'cost' => 55000, 'price' => 75000],
                ['product_name' => 'Canon EOS R5 Camera', 'category' => 'Camera', 'brand' => 'Canon', 'cost' => 350000, 'price' => 450000],
            ];

            foreach ($electronicsProducts as $productData) {
                // Find or use default category
                $category = $categories->firstWhere('category_name', 'like', "%{$productData['category']}%") ?? $defaultCategory;
                $brand = $brands->firstWhere('product_name', 'like', "%{$productData['brand']}%") ?? $defaultBrand;

                Product::create([
                    'company_id' => $company->id,
                    'product_name' => $productData['product_name'],
                    'sku' => $this->generateSku($company->id, substr($productData['category'], 0, 3)),
                    'description' => $productData['product_name'] . ' - High quality product',
                    'product_type' => 'physical',
                    'unit_id' => $defaultUnit->id,
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'tax_id' => $defaultTax->id ?? null,
                    'cost_price' => $productData['cost'],
                    'selling_price' => $productData['price'],
                    'wholesale_price' => $productData['price'] * 0.9,
                    'minimum_price' => $productData['price'] * 0.8,
                    'stock_quantity' => rand(10, 100),
                    'alert_quantity' => 5,
                    'barcode' => $this->generateBarcode(),
                    'weight' => rand(0.5, 10.0),
                    'dimensions' => null,
                    'is_active' => true,
                    'is_featured' => rand(0, 1),
                    'has_variants' => false,
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ]);
                $totalProducts++;
                $this->command->info("  ✓ Created: {$productData['product_name']}");
            }

            // Create fashion products if company has fashion categories
            $fashionCategory = $categories->firstWhere('category_name', 'like', '%Fashion%');
            if ($fashionCategory) {
                $fashionProducts = [
                    ['product_name' => "Men's Casual Shirt", 'cost' => 800, 'price' => 1500],
                    ['product_name' => "Women's Dress", 'cost' => 1200, 'price' => 2500],
                    ['product_name' => "Kids T-Shirt", 'cost' => 300, 'price' => 600],
                    ['product_name' => 'Sports Shoes', 'cost' => 1500, 'price' => 3000],
                    ['product_name' => 'Leather Belt', 'cost' => 400, 'price' => 800],
                ];

                foreach ($fashionProducts as $productData) {
                    Product::create([
                        'company_id' => $company->id,
                        'product_name' => $productData['product_name'],
                        'sku' => $this->generateSku($company->id, 'FSH'),
                        'description' => $productData['product_name'] . ' - Comfortable and stylish',
                        'product_type' => 'physical',
                        'unit_id' => $defaultUnit->id,
                        'category_id' => $fashionCategory->id,
                        'brand_id' => $defaultBrand->id,
                        'tax_id' => $defaultTax->id ?? null,
                        'cost_price' => $productData['cost'],
                        'selling_price' => $productData['price'],
                        'wholesale_price' => $productData['price'] * 0.85,
                        'minimum_price' => $productData['price'] * 0.7,
                        'stock_quantity' => rand(50, 200),
                        'alert_quantity' => 20,
                        'barcode' => $this->generateBarcode(),
                        'weight' => rand(0.1, 1.0),
                        'dimensions' => null,
                        'is_active' => true,
                        'is_featured' => rand(0, 1),
                        'has_variants' => true,
                        'created_by' => $createdById,
                        'updated_by' => $createdById,
                    ]);
                    $totalProducts++;
                    $this->command->info("  ✓ Created: {$productData['product_name']}");
                }
            }

            // Create grocery products if company has grocery categories
            $groceryCategory = $categories->firstWhere('category_name', 'like', '%Grocery%');
            if ($groceryCategory) {
                $groceryProducts = [
                    ['product_name' => 'Basmati Rice 5kg', 'cost' => 600, 'price' => 800],
                    ['product_name' => 'Pure Mustard Oil 1L', 'cost' => 250, 'price' => 350],
                    ['product_name' => 'Aromatic Tea 250g', 'cost' => 150, 'price' => 250],
                    ['product_name' => 'Fresh Milk 1L', 'cost' => 80, 'price' => 100],
                    ['product_name' => 'Farm Eggs (12 pcs)', 'cost' => 120, 'price' => 150],
                ];

                foreach ($groceryProducts as $productData) {
                    Product::create([
                        'company_id' => $company->id,
                        'product_name' => $productData['product_name'],
                        'sku' => $this->generateSku($company->id, 'GRC'),
                        'description' => $productData['product_name'] . ' - Fresh and high quality',
                        'product_type' => 'physical',
                        'unit_id' => $units->firstWhere('unit_code', 'like', '%KG%')->id ?? $defaultUnit->id,
                        'category_id' => $groceryCategory->id,
                        'brand_id' => $defaultBrand->id,
                        'tax_id' => $taxes->firstWhere('tax_rate', 5.00)->id ?? $defaultTax->id ?? null,
                        'cost_price' => $productData['cost'],
                        'selling_price' => $productData['price'],
                        'wholesale_price' => $productData['price'] * 0.9,
                        'minimum_price' => $productData['price'] * 0.8,
                        'stock_quantity' => rand(100, 500),
                        'alert_quantity' => 50,
                        'barcode' => $this->generateBarcode(),
                        'weight' => rand(0.5, 5.0),
                        'dimensions' => null,
                        'is_active' => true,
                        'is_featured' => false,
                        'has_variants' => false,
                        'created_by' => $createdById,
                        'updated_by' => $createdById,
                    ]);
                    $totalProducts++;
                    $this->command->info("  ✓ Created: {$productData['product_name']}");
                }
            }
        }

        $this->command->info("✅ Successfully seeded {$totalProducts} products!");
    }

    /**
     * Create default brand if none exists
     */
    private function createDefaultBrand($company, $createdById)
    {
        $brand = Brand::create([
            'company_id' => $company->id,
            'code' => 'BRAND' . str_pad($company->id, 2, '0', STR_PAD_LEFT) . '001',
            'product_name' => 'Default Brand',
            'description' => 'Default brand for ' . $company->product_name,
            'country_of_origin' => 'Bangladesh',
            'is_active' => true,
            'created_by' => $createdById,
            'updated_by' => $createdById,
        ]);

        return collect([$brand]);
    }

    /**
     * Create default category if none exists
     */
    private function createDefaultCategory($company, $createdById)
    {
        $category = Category::create([
            'company_id' => $company->id,
            'category_code' => 'CAT' . str_pad($company->id, 2, '0', STR_PAD_LEFT) . '001',
            'category_name' => 'Electronics',
            'parent_category_id' => null,
            'description' => 'Default electronics category',
            'tax_rate_applicable' => 15.00,
            'created_by' => $createdById,
            'updated_by' => $createdById,
        ]);

        return collect([$category]);
    }

    /**
     * Create default unit if none exists
     */
    private function createDefaultUnit($company, $createdById)
    {
        $unit = Unit::create([
            'company_id' => $company->id,
            'unit_code' => 'PCS' . str_pad($company->id, 2, '0', STR_PAD_LEFT),
            'unit_product_name' => 'Pieces',
            'unit_type' => 'standard',
            'description' => 'Default unit - pieces',
            'is_fraction_allowed' => false,
            'decimal_places' => 0,
            'sort_order' => 1,
            'is_active' => true,
            'created_by' => $createdById,
            'updated_by' => $createdById,
        ]);

        return collect([$unit]);
    }

    /**
     * Generate unique SKU
     */
    private function generateSku($companyId, $prefix): string
    {
        return $prefix . str_pad($companyId, 3, '0', STR_PAD_LEFT) .
               now()->format('md') .
               strtoupper(Str::random(3));
    }

    /**
     * Generate barcode
     */
    private function generateBarcode(): string
    {
        return '8' . rand(100000000000, 999999999999);
    }
}
