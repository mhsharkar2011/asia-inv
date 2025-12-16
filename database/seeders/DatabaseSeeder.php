<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Tax;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create default company
        $company = Company::create([
            'company_name' => 'Asia Enterprises Ltd.',
            'registration_no' => 'ABC123456',
            'tax_id' => 'GSTIN123456789',
            'address' => '123 Main Street, Mumbai, Maharashtra',
            'country' => 'India',
            'currency_base' => 'INR',
            'fiscal_year_start' => '2024-04-01',
            'gst_registered' => true,
        ]);

        // Create admin user
        User::create([
            'company_id' => $company->company_id,
            'username' => 'admin',
            'password_hash' => Hash::make('admin@123'),
            'full_name' => 'System Administrator',
            'role' => 'admin',
            'email' => 'admin@asiaenterprise.com',
            'phone' => '+91-9876543210',
            'language_preference' => 'en',
            'is_active' => true,
        ]);

        // Create default tax rates (India GST)
        $gstRates = [
            ['tax_code' => 'GST0', 'tax_name' => 'GST 0%', 'tax_rate' => 0, 'tax_type' => 'exclusive'],
            ['tax_code' => 'GST5', 'tax_name' => 'GST 5%', 'tax_rate' => 5, 'tax_type' => 'exclusive'],
            ['tax_code' => 'GST12', 'tax_name' => 'GST 12%', 'tax_rate' => 12, 'tax_type' => 'exclusive'],
            ['tax_code' => 'GST18', 'tax_name' => 'GST 18%', 'tax_rate' => 18, 'tax_type' => 'exclusive'],
            ['tax_code' => 'GST28', 'tax_name' => 'GST 28%', 'tax_rate' => 28, 'tax_type' => 'exclusive'],
        ];

        foreach ($gstRates as $rate) {
            Tax::create(array_merge($rate, [
                'company_id' => $company->company_id,
                'effective_date' => '2024-01-01',
                'country_applicable' => 'India'
            ]));
        }

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
