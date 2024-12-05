<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Classic Burger',
                'description' => 'Juicy beef patty with fresh lettuce, tomatoes, and our special sauce',
                'price' => 8.99,
                'stock' => 50,
                'category' => 'Burgers',
                'image_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500'
            ],
            [
                'name' => 'Chicken Caesar Salad',
                'description' => 'Fresh romaine lettuce, grilled chicken, parmesan cheese, and caesar dressing',
                'price' => 10.99,
                'stock' => 30,
                'category' => 'Salads',
                'image_url' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=500'
            ],
            [
                'name' => 'Margherita Pizza',
                'description' => 'Fresh mozzarella, tomatoes, and basil on our homemade crust',
                'price' => 14.99,
                'stock' => 25,
                'category' => 'Pizza',
                'image_url' => 'https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?w=500'
            ],
            [
                'name' => 'Iced Caramel Latte',
                'description' => 'Espresso with caramel syrup and milk over ice',
                'price' => 4.99,
                'stock' => 100,
                'category' => 'Beverages',
                'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500'
            ],
            [
                'name' => 'Chocolate Brownie',
                'description' => 'Rich, fudgy brownie with chocolate chips',
                'price' => 3.99,
                'stock' => 40,
                'category' => 'Desserts',
                'image_url' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=500'
            ],
            [
                'name' => 'Fish and Chips',
                'description' => 'Crispy battered cod with golden fries and tartar sauce',
                'price' => 12.99,
                'stock' => 35,
                'category' => 'Main Course',
                'image_url' => 'https://images.unsplash.com/photo-1579208575657-c595a05383b7?w=500'
            ],
            [
                'name' => 'Fruit Smoothie',
                'description' => 'Blend of fresh seasonal fruits with yogurt',
                'price' => 5.99,
                'stock' => 60,
                'category' => 'Beverages',
                'image_url' => 'https://images.unsplash.com/photo-1505252585461-04db1eb84625?w=500'
            ],
            [
                'name' => 'Pasta Carbonara',
                'description' => 'Spaghetti with creamy sauce, pancetta, and parmesan',
                'price' => 13.99,
                'stock' => 45,
                'category' => 'Pasta',
                'image_url' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=500'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
