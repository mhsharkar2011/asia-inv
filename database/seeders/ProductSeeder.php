<?php

namespace Database\Seeders;

use App\Models\Inventory\Product;
use App\Models\Admin\Company;
use App\Models\Inventory\Category;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products
        DB::table('products')->truncate();

        $companies = Company::all();
        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();
        $admin = User::where('email', 'like', 'admin@%')->first();

        foreach ($companies as $company) {
            // Get categories for this company
            $categories = Category::where('company_id', $company->id)->get();

            if ($categories->isEmpty()) {
                $this->command->warn("No categories found for company: {$company->name}. Creating default categories first.");

                // Create default categories
                $electronics = Category::create([
                    'company_id' => $company->id,
                    'category_code' => 'ELEC',
                    'category_name' => 'Electronics',
                    'parent_category_id' => null,
                    'description' => 'Electronic items and gadgets',
                    'tax_rate_applicable' => 18.00,
                    'created_by' => $superAdmin->id,
                    'updated_by' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $categories = [$electronics];
            }

            // Create products for each category
            foreach ($categories as $category) {
                $this->createProductsForCategory($company, $category, $superAdmin);
            }
        }

        $this->command->info('Products seeded successfully!');
        $this->command->info('Total products created: ' . Product::count());
    }

    /**
     * Create products for a specific category
     */
    private function createProductsForCategory($company, $category, $superAdmin): void
    {
        $products = [];

        switch ($category->category_code) {
            case 'ELEC':
                $products = $this->getElectronicsProducts();
                break;
            case 'PRNT':
                $products = $this->getPrinterProducts();
                break;
            case 'LAP':
                $products = $this->getLaptopProducts();
                break;
            case 'PHN':
                $products = $this->getSmartphoneProducts();
                break;
            default:
                $products = $this->getGenericProducts();
                break;
        }

        foreach ($products as $productData) {
            $product = Product::create([
                'company_id' => $company->id,
                'category_id' => $category->id,
                'product_code' => Product::generateProductCode(),
                'product_name' => $productData['name'],
                'description' => $productData['description'],
                'short_description' => substr($productData['description'], 0, 100) . '...',
                'unit_of_measure' => $productData['unit'],
                'brand' => $productData['brand'],
                'model' => $productData['model'],
                'weight' => $productData['weight'],
                'dimensions' => $productData['dimensions'],
                'color' => $productData['color'],
                'material' => $productData['material'],
                'cost_price' => $productData['cost_price'],
                'purchase_price' => $productData['cost_price'] * 1.1, // 10% markup
                'selling_price' => $productData['selling_price'],
                'wholesale_price' => $productData['wholesale_price'],
                'mrp' => $productData['selling_price'] * 1.2, // 20% above selling price
                'tax_rate' => $category->tax_rate_applicable,
                'discount_percentage' => $productData['discount'],
                'stock_quantity' => $productData['stock'],
                'available_quantity' => $productData['stock'],
                'min_stock' => $productData['min_stock'],
                'max_stock' => $productData['max_stock'],
                'reorder_level' => $productData['reorder'],
                'hsn_sac_code' => $this->generateHSNCode(),
                'hs_code' => '8543.70' . rand(10, 99),
                'ait_rate' => 5.00,
                'manufacturer' => $productData['manufacturer'],
                'country_of_origin' => $productData['origin'],
                'warranty_period' => $productData['warranty'],
                'expiry_date' => $productData['expiry_date'] ? now()->addYears(2) : null,
                'track_batch' => $productData['has_variants'],
                'track_expiry' => !empty($productData['expiry_date']),
                'is_active' => true,
                'is_featured' => $productData['featured'],
                'has_variants' => $productData['has_variants'],
                'rating' => $productData['rating'],
                'created_by' => $superAdmin->id,
                'updated_by' => $superAdmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate barcode and SKU if not auto-generated
            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(substr(md5($product->id), 0, 8));
            }
            if (empty($product->barcode)) {
                $product->barcode = '8' . str_pad($product->id + 10000000000, 12, '0', STR_PAD_LEFT);
            }
            $product->save();
        }
    }

    /**
     * Generate HSN/SAC code
     */
    private function generateHSNCode(): string
    {
        $codes = ['9964', '9965', '9966', '9967', '9968', '9969'];
        return $codes[array_rand($codes)] . str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Electronics products
     */
    private function getElectronicsProducts(): array
    {
        return [
            [
                'name' => 'Smart LED TV 55" 4K UHD',
                'description' => '55-inch 4K Ultra HD Smart LED TV with HDR, Android TV, and built-in Google Assistant',
                'unit' => 'Piece',
                'brand' => 'Samsung',
                'model' => 'UN55NU7100FXZA',
                'weight' => 18.5,
                'dimensions' => '124.7 x 71.9 x 8.9 cm',
                'color' => 'Black',
                'material' => 'Plastic, Metal',
                'cost_price' => 45000.00,
                'selling_price' => 59999.00,
                'wholesale_price' => 52000.00,
                'discount' => 10.00,
                'stock' => 25,
                'min_stock' => 5,
                'max_stock' => 50,
                'reorder' => 10,
                'manufacturer' => 'Samsung Electronics',
                'origin' => 'South Korea',
                'warranty' => '2 Years',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => false,
                'rating' => 4.5,
            ],
            [
                'name' => 'Soundbar Home Theater System',
                'description' => '5.1 Channel Soundbar with Wireless Subwoofer, Dolby Audio, and Bluetooth connectivity',
                'unit' => 'Piece',
                'brand' => 'Sony',
                'model' => 'HT-S20R',
                'weight' => 8.2,
                'dimensions' => '90 x 6.4 x 8.9 cm',
                'color' => 'Black',
                'material' => 'Metal, Plastic',
                'cost_price' => 12000.00,
                'selling_price' => 18999.00,
                'wholesale_price' => 15000.00,
                'discount' => 15.00,
                'stock' => 40,
                'min_stock' => 10,
                'max_stock' => 100,
                'reorder' => 20,
                'manufacturer' => 'Sony Corporation',
                'origin' => 'Japan',
                'warranty' => '1 Year',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => false,
                'rating' => 4.3,
            ],
        ];
    }

    /**
     * Printer products
     */
    private function getPrinterProducts(): array
    {
        return [
            [
                'name' => 'Wireless All-in-One Inkjet Printer',
                'description' => 'Color Inkjet Wireless All-in-One Printer with Scanner, Copier, and Fax functionality',
                'unit' => 'Piece',
                'brand' => 'HP',
                'model' => 'DeskJet 2723',
                'weight' => 3.5,
                'dimensions' => '44 x 35 x 18 cm',
                'color' => 'White',
                'material' => 'Plastic',
                'cost_price' => 6500.00,
                'selling_price' => 8999.00,
                'wholesale_price' => 7500.00,
                'discount' => 8.00,
                'stock' => 60,
                'min_stock' => 15,
                'max_stock' => 150,
                'reorder' => 25,
                'manufacturer' => 'HP Inc.',
                'origin' => 'USA',
                'warranty' => '1 Year',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => true,
                'rating' => 4.2,
            ],
            [
                'name' => 'Monochrome Laser Printer',
                'description' => 'High-speed Monochrome Laser Printer for Office Use with Ethernet connectivity',
                'unit' => 'Piece',
                'brand' => 'Canon',
                'model' => 'LBP2900B',
                'weight' => 6.8,
                'dimensions' => '38 x 25 x 24 cm',
                'color' => 'Black',
                'material' => 'Plastic, Metal',
                'cost_price' => 8500.00,
                'selling_price' => 12499.00,
                'wholesale_price' => 10000.00,
                'discount' => 12.00,
                'stock' => 35,
                'min_stock' => 8,
                'max_stock' => 80,
                'reorder' => 15,
                'manufacturer' => 'Canon Inc.',
                'origin' => 'Japan',
                'warranty' => '2 Years',
                'expiry_date' => null,
                'featured' => false,
                'has_variants' => false,
                'rating' => 4.4,
            ],
        ];
    }

    /**
     * Laptop products
     */
    private function getLaptopProducts(): array
    {
        return [
            [
                'name' => 'Gaming Laptop RTX 3050',
                'description' => '15.6" FHD 144Hz Gaming Laptop with NVIDIA RTX 3050, Intel i7, 16GB RAM, 512GB SSD',
                'unit' => 'Piece',
                'brand' => 'ASUS',
                'model' => 'TUF Gaming F15 FX506',
                'weight' => 2.3,
                'dimensions' => '36 x 25.6 x 2.5 cm',
                'color' => 'Graphite Black',
                'material' => 'Plastic, Aluminum',
                'cost_price' => 75000.00,
                'selling_price' => 94999.00,
                'wholesale_price' => 82000.00,
                'discount' => 15.00,
                'stock' => 15,
                'min_stock' => 3,
                'max_stock' => 30,
                'reorder' => 5,
                'manufacturer' => 'ASUSTeK Computer Inc.',
                'origin' => 'Taiwan',
                'warranty' => '2 Years',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => true,
                'rating' => 4.7,
            ],
            [
                'name' => 'Business Laptop i7 16GB',
                'description' => '14" Full HD Business Laptop with Intel Core i7, 16GB RAM, 1TB SSD, Windows 11 Pro',
                'unit' => 'Piece',
                'brand' => 'Dell',
                'model' => 'Latitude 5420',
                'weight' => 1.5,
                'dimensions' => '32.4 x 21.8 x 1.9 cm',
                'color' => 'Black',
                'material' => 'Carbon Fiber, Aluminum',
                'cost_price' => 85000.00,
                'selling_price' => 109999.00,
                'wholesale_price' => 92000.00,
                'discount' => 12.00,
                'stock' => 20,
                'min_stock' => 4,
                'max_stock' => 40,
                'reorder' => 8,
                'manufacturer' => 'Dell Technologies',
                'origin' => 'USA',
                'warranty' => '3 Years',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => true,
                'rating' => 4.6,
            ],
            [
                'name' => 'Student Laptop i3 8GB',
                'description' => '15.6" HD Laptop with Intel Core i3, 8GB RAM, 256GB SSD, Windows 11 Home',
                'unit' => 'Piece',
                'brand' => 'Lenovo',
                'model' => 'IdeaPad 3 15IAU7',
                'weight' => 1.7,
                'dimensions' => '36.3 x 25.2 x 2.0 cm',
                'color' => 'Platinum Grey',
                'material' => 'Plastic',
                'cost_price' => 32000.00,
                'selling_price' => 44999.00,
                'wholesale_price' => 38000.00,
                'discount' => 10.00,
                'stock' => 30,
                'min_stock' => 8,
                'max_stock' => 60,
                'reorder' => 15,
                'manufacturer' => 'Lenovo Group',
                'origin' => 'China',
                'warranty' => '1 Year',
                'expiry_date' => null,
                'featured' => false,
                'has_variants' => false,
                'rating' => 4.0,
            ],
        ];
    }

    /**
     * Smartphone products
     */
    private function getSmartphoneProducts(): array
    {
        return [
            [
                'name' => 'Flagship Smartphone 108MP Camera',
                'description' => '6.7" AMOLED Display, 108MP Quad Camera, Snapdragon 8 Gen 2, 5000mAh Battery, 256GB Storage',
                'unit' => 'Piece',
                'brand' => 'Samsung',
                'model' => 'Galaxy S23 Ultra',
                'weight' => 0.234,
                'dimensions' => '16.3 x 7.8 x 0.9 cm',
                'color' => 'Phantom Black',
                'material' => 'Gorilla Glass, Aluminum',
                'cost_price' => 85000.00,
                'selling_price' => 124999.00,
                'wholesale_price' => 95000.00,
                'discount' => 5.00,
                'stock' => 25,
                'min_stock' => 5,
                'max_stock' => 50,
                'reorder' => 10,
                'manufacturer' => 'Samsung Electronics',
                'origin' => 'South Korea',
                'warranty' => '1 Year',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => true,
                'rating' => 4.8,
            ],
            [
                'name' => 'Mid-Range Smartphone 64MP',
                'description' => '6.5" AMOLED 120Hz Display, 64MP Triple Camera, MediaTek Dimensity 1080, 6000mAh Battery',
                'unit' => 'Piece',
                'brand' => 'Xiaomi',
                'model' => 'Redmi Note 12 Pro 5G',
                'weight' => 0.210,
                'dimensions' => '16.5 x 7.6 x 0.8 cm',
                'color' => 'Onyx Gray',
                'material' => 'Gorilla Glass, Plastic',
                'cost_price' => 22000.00,
                'selling_price' => 29999.00,
                'wholesale_price' => 25000.00,
                'discount' => 8.00,
                'stock' => 50,
                'min_stock' => 12,
                'max_stock' => 100,
                'reorder' => 25,
                'manufacturer' => 'Xiaomi Corporation',
                'origin' => 'China',
                'warranty' => '1 Year',
                'expiry_date' => null,
                'featured' => true,
                'has_variants' => true,
                'rating' => 4.4,
            ],
        ];
    }

    /**
     * Generic products for other categories
     */
    private function getGenericProducts(): array
    {
        return [
            [
                'name' => 'Premium Office Chair',
                'description' => 'Ergonomic office chair with lumbar support, adjustable height, and breathable mesh',
                'unit' => 'Piece',
                'brand' => 'Generic',
                'model' => 'OC-2023',
                'weight' => 12.5,
                'dimensions' => '60 x 60 x 110 cm',
                'color' => 'Black',
                'material' => 'Mesh, Nylon, Steel',
                'cost_price' => 4500.00,
                'selling_price' => 6999.00,
                'wholesale_price' => 5500.00,
                'discount' => 5.00,
                'stock' => 30,
                'min_stock' => 5,
                'max_stock' => 50,
                'reorder' => 10,
                'manufacturer' => 'Generic Manufacturer',
                'origin' => 'Bangladesh',
                'warranty' => '2 Years',
                'expiry_date' => null,
                'featured' => false,
                'has_variants' => true,
                'rating' => 4.1,
            ],
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Adjustable LED desk lamp with touch control, 3 color temperatures, USB charging port',
                'unit' => 'Piece',
                'brand' => 'Generic',
                'model' => 'DL-LED01',
                'weight' => 0.8,
                'dimensions' => '35 x 15 x 8 cm',
                'color' => 'White',
                'material' => 'Plastic, Aluminum',
                'cost_price' => 800.00,
                'selling_price' => 1499.00,
                'wholesale_price' => 1200.00,
                'discount' => 10.00,
                'stock' => 100,
                'min_stock' => 20,
                'max_stock' => 200,
                'reorder' => 40,
                'manufacturer' => 'Generic Manufacturer',
                'origin' => 'China',
                'warranty' => '1 Year',
                'expiry_date' => now()->addYears(3),
                'featured' => false,
                'has_variants' => false,
                'rating' => 4.0,
            ],
        ];
    }
}
