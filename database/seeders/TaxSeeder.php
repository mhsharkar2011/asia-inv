<?php

namespace Database\Seeders;

use App\Models\Admin\Tax;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TaxSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        DB::table('taxes')->truncate();
        Schema::enableForeignKeyConstraints();

        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->error('No companies found. Please seed companies first.');
            return;
        }

        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();
        $createdById = $superAdmin ? $superAdmin->id : 1;

        $totalTaxes = 0;

        foreach ($companies as $company) {
            $this->command->info("Creating taxes for Company: {$company->name}");

            // Common Taxes
            $commonTaxes = [
                [
                    'tax_code' => 'GST',
                    'tax_name' => 'Goods and Services Tax',
                    'tax_rate' => 5.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'Standard GST applicable on most goods and services',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'VAT',
                    'tax_name' => 'Value Added Tax',
                    'tax_rate' => 15.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Value Added Tax on sales',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'CGST',
                    'tax_name' => 'Central GST',
                    'tax_rate' => 9.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'Central Goods and Services Tax',
                    'is_compound' => true,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'SGST',
                    'tax_name' => 'State GST',
                    'tax_rate' => 9.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'State Goods and Services Tax',
                    'is_compound' => true,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'IGST',
                    'tax_name' => 'Integrated GST',
                    'tax_rate' => 18.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'Integrated Goods and Services Tax',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'ZERO',
                    'tax_name' => 'Zero Tax',
                    'tax_rate' => 0.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'Zero tax rate for exempted items',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'EXEMPT',
                    'tax_name' => 'Exempt',
                    'tax_rate' => 0.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'both',
                    'description' => 'Tax exempted items',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'SERVICE',
                    'tax_name' => 'Service Tax',
                    'tax_rate' => 14.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Service tax on services',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'CUSTOM',
                    'tax_name' => 'Custom Duty',
                    'tax_rate' => 25.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'purchase',
                    'description' => 'Custom duty on imported goods',
                    'is_compound' => false,
                    'effective_from' => '2024-01-01',
                ],
                [
                    'tax_code' => 'LUXURY',
                    'tax_name' => 'Luxury Tax',
                    'tax_rate' => 28.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Luxury tax on high-end products',
                    'is_compound' => true,
                    'effective_from' => '2024-01-01',
                ],
            ];

            // Category-specific taxes
            $categoryTaxes = [
                [
                    'tax_code' => 'ELECTRONICS',
                    'tax_name' => 'Electronics Tax',
                    'tax_rate' => 18.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Special tax on electronic goods',
                ],
                [
                    'tax_code' => 'FASHION',
                    'tax_name' => 'Fashion Tax',
                    'tax_rate' => 12.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Tax on fashion and clothing items',
                ],
                [
                    'tax_code' => 'GROCERY',
                    'tax_name' => 'Grocery Tax',
                    'tax_rate' => 5.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Reduced tax rate for grocery items',
                ],
                [
                    'tax_code' => 'BOOKS',
                    'tax_name' => 'Books Tax',
                    'tax_rate' => 0.00,
                    'tax_type' => 'percentage',
                    'applicable_on' => 'sales',
                    'description' => 'Zero tax for books and educational materials',
                ],
            ];

            // Create common taxes
            foreach ($commonTaxes as $taxData) {
                $tax = Tax::create([
                    'company_id' => $company->id,
                    'tax_code' => $this->generateTaxCode($company->id, $taxData['tax_code']),
                    'tax_name' => $taxData['tax_name'],
                    'tax_rate' => $taxData['tax_rate'],
                    'tax_type' => $taxData['tax_type'],
                    'applicable_on' => $taxData['applicable_on'],
                    'description' => $taxData['description'],
                    'is_compound' => $taxData['is_compound'] ?? false,
                    'is_active' => true,
                    'effective_from' => $taxData['effective_from'] ?? '2024-01-01',
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ]);

                $totalTaxes++;
                $this->command->info("  ✓ Created: {$taxData['tax_name']} ({$tax->tax_code} - {$tax->tax_rate}%)");
            }

            // Create category-specific taxes
            foreach ($categoryTaxes as $taxData) {
                $tax = Tax::create([
                    'company_id' => $company->id,
                    'tax_code' => $this->generateTaxCode($company->id, $taxData['tax_code']),
                    'tax_name' => $taxData['tax_name'],
                    'tax_rate' => $taxData['tax_rate'],
                    'tax_type' => $taxData['tax_type'],
                    'applicable_on' => $taxData['applicable_on'],
                    'description' => $taxData['description'],
                    'is_compound' => false,
                    'is_active' => true,
                    'effective_from' => '2024-01-01',
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ]);

                $totalTaxes++;
                $this->command->info("  ✓ Created: {$taxData['tax_name']} ({$tax->tax_code} - {$tax->tax_rate}%)");
            }
        }

        $this->command->info("✅ Successfully seeded {$totalTaxes} taxes!");
    }

    private function generateTaxCode($companyId, $baseCode): string
    {
        return $baseCode . str_pad($companyId, 2, '0', STR_PAD_LEFT);
    }
}
