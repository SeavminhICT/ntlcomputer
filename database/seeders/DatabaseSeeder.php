<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Store Admin',
            'email' => 'admin@computerstore.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $categories = Category::insert([
            ['name' => 'Laptop', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desktop', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gaming PC', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Monitor', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accessories', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $laptop = Category::where('name', 'Laptop')->first();
        $desktop = Category::where('name', 'Desktop')->first();

        Product::create([
            'category_id' => $laptop->id,
            'product_code' => Product::generateCode('LAP'),
            'brand' => 'Lenovo',
            'model' => 'ThinkPad X1',
            'cpu' => 'Intel Core i7',
            'ram' => '16GB',
            'storage' => '512GB SSD',
            'gpu' => 'Intel Iris Xe',
            'display' => '14\" FHD',
            'color' => 'Black',
            'condition' => 'New',
            'warranty' => '1 Year',
            'country' => 'USA',
            'price' => 1499.00,
            'stock' => 12,
            'description' => 'Business-class laptop with premium build.',
            'status' => true,
        ]);

        Product::create([
            'category_id' => $desktop->id,
            'product_code' => Product::generateCode('DTP'),
            'brand' => 'Dell',
            'model' => 'OptiPlex 7010',
            'cpu' => 'Intel Core i5',
            'ram' => '8GB',
            'storage' => '256GB SSD',
            'gpu' => 'Intel UHD',
            'display' => 'Optional',
            'color' => 'Black',
            'condition' => 'New',
            'warranty' => '1 Year',
            'country' => 'USA',
            'price' => 799.00,
            'stock' => 6,
            'description' => 'Reliable desktop for office productivity.',
            'status' => true,
        ]);
    }
}
