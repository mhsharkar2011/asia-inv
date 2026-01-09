<?php

namespace Database\Seeders;

use App\Models\Admin\Unit;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();
        DB::table('units')->truncate();
        Schema::enableForeignKeyConstraints();

        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->error('No companies found. Please seed companies first.');
            return;
        }

        // Get ANY user or create one
        $createdById = $this->getOrCreateFirstUser();

        if (!$createdById) {
            $this->command->error('Could not find or create a user. Please run UserSeeder first.');
            return;
        }

        $totalUnits = 0;

        foreach ($companies as $company) {
            $this->command->info("Creating units for Company: {$company->name}");

            // Standard Units - same as before
            $standardUnits = [
                [
                    'unit_code' => 'PCS',
                    'unit_name' => 'Pieces',
                    'unit_type' => 'standard',
                    'description' => 'Individual pieces/items',
                    'is_fraction_allowed' => false,
                    'decimal_places' => 0,
                    'sort_order' => 1,
                ],
                // ... rest of your standard units
            ];

            $createdUnits = [];

            // Create standard units
            foreach ($standardUnits as $unitData) {
                $unit = Unit::create([
                    'company_id' => $company->id,
                    'unit_code' => $this->generateUnitCode($company->id, $unitData['unit_code']),
                    'unit_name' => $unitData['unit_name'],
                    'unit_type' => $unitData['unit_type'],
                    'description' => $unitData['description'],
                    'is_fraction_allowed' => $unitData['is_fraction_allowed'],
                    'decimal_places' => $unitData['decimal_places'],
                    'sort_order' => $unitData['sort_order'],
                    'is_active' => true,
                    'created_by' => $createdById,
                    'updated_by' => $createdById,
                ]);

                $createdUnits[$unitData['unit_code']] = $unit;
                $totalUnits++;
                $this->command->info("  ✓ Created: {$unitData['unit_name']} ({$unit->unit_code})");
            }

            // ... rest of your unit creation logic
        }

        $this->command->info("✅ Successfully seeded {$totalUnits} units!");
    }

    /**
     * Get the first user ID or create one if none exists
     */
    private function getOrCreateFirstUser(): ?int
    {
        // Try to get any user
        $user = User::first();

        if ($user) {
            $this->command->info("Using existing user: {$user->name} (ID: {$user->id})");
            return $user->id;
        }

        // If no user exists, create one
        $this->command->warn('No users found. Creating a default user...');

        $company = Company::first();
        if (!$company) {
            $this->command->error('Cannot create user: no company found.');
            return null;
        }

        try {
            $user = User::create([
                'name' => 'System User',
                'email' => 'system@example.com',
                'password' => bcrypt('password123'),
                'company_id' => $company->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info("✓ Created default user with ID: {$user->id}");
            return $user->id;

        } catch (\Exception $e) {
            $this->command->error('Failed to create user: ' . $e->getMessage());
            return null;
        }
    }

    private function generateUnitCode($companyId, $baseCode): string
    {
        return $baseCode . str_pad($companyId, 2, '0', STR_PAD_LEFT);
    }
}
