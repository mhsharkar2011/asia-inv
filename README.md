## Use Iconify with Tailwind:

Install Iconify:
bash
npm install @iconify/iconify

## media Upload

composer require spatie/laravel-medialibrary

## Migrations

1. Create a Migration for Adding Audit Columns

php artisan make:migration add_audit_columns_to_tables

2. Update Your Existing Migrations

// Audit columns
$table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
$table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
$table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');

3. Create an Activity Logs Table (Optional but Recommended)

php artisan make:migration create_activity_logs_table


4. Update Your Models

## Base Model Approach (Recommended)
Create a base model that all your models extend:

## How to use helper function 

{
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/Helpers/DateHelper.php"
        ]
    }
}

composer dump-autoload

php artisan queue:work

## Docker Build

# Build images
docker compose build

# Start all services
docker compose up -d

# Install dependencies
docker compose exec app composer install

# Generate app key (first time)
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# Create storage symlink
docker compose exec app php artisan storage:link

# Access app
# → http://localhost:8080

# View logs
docker compose logs -f app

# Shell into PHP container
docker compose exec app bash

# Stop everything
docker compose down

# Stop and remove volumes (⚠️ deletes DB data)
docker compose down -v

Menu → Comm → Cloud Server Setting (or ADMS)

  Server Address:    192.168.1.9        ← LAN IP, no http:// prefix
  Server Port:       8080
  Server Path:       (leave blank)
  Enable Push:       ON  ← critical
  Enable Real-Time:  ON
  Enable Domain Name: No
  Enable Proxy:      No
  Heartbeat:         10 seconds
  Save → Reboot
