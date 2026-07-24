<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage products',
            'manage categories',
            'manage orders',
            'manage users',
            'manage settings',
            'view admin dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Give all permissions to super_admin and admin
        $superAdminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(Permission::all());
        $moderatorRole->givePermissionTo(['manage orders', 'view admin dashboard']);
        $editorRole->givePermissionTo(['manage products', 'manage categories', 'view admin dashboard']);

        // Create Users
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@nest.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        $admin = User::firstOrCreate(
            ['email' => 'admin@nest.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        $customer = User::firstOrCreate(
            ['email' => 'customer@nest.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole('customer');

        // Seed Categories
        $cat1 = Category::firstOrCreate(['slug' => 'cake-milk'], ['name' => 'Cake & Milk', 'sort_order' => 1]);
        $cat2 = Category::firstOrCreate(['slug' => 'organic-kiwi'], ['name' => 'Organic Kiwi', 'sort_order' => 2]);
        $cat3 = Category::firstOrCreate(['slug' => 'snack'], ['name' => 'Snack', 'sort_order' => 3]);
        $cat4 = Category::firstOrCreate(['slug' => 'vegetables'], ['name' => 'Vegetables', 'sort_order' => 4]);

        // Seed Brands
        $brand1 = Brand::firstOrCreate(['slug' => 'cardinal'], ['name' => 'Cardinal']);
        $brand2 = Brand::firstOrCreate(['slug' => 'birdfly'], ['name' => 'BirdFly']);

        // Seed Products
        $product = Product::firstOrCreate(
            ['slug' => 'seeds-of-change-organic-quinoa'],
            [
                'category_id' => $cat3->id,
                'brand_id' => $brand1->id,
                'name' => 'Seeds of Change Organic Quinoa, Brown, & Red Rice',
                'sku' => 'FWM15VKT',
                'description' => 'Organic quinoa and brown & red rice. A healthy, delicious side dish ready in minutes.',
                'price' => 34.50,
                'sale_price' => 28.00,
                'stock_quantity' => 100,
                'is_featured' => true,
            ]
        );

        ProductImage::firstOrCreate(
            ['product_id' => $product->id, 'is_primary' => true],
            ['image_path' => 'assets/imgs/shop/product-1-1.jpg', 'alt_text' => 'Seeds of Change Organic Quinoa']
        );
    }
}
