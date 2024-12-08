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
            // Filipino Main Dishes
            [
                'name' => 'Lumpia Shanghai',
                'description' => 'Crispy Filipino spring rolls filled with ground pork, carrots, and spices',
                'price' => 45.00,
                'stock' => 100,
                'category' => 'Food',
                'image_url' => 'https://images.unsplash.com/photo-1601628828688-632f38a5a7d0?w=500'
            ],
            [
                'name' => 'Chicken Siomai',
                'description' => 'Steamed Filipino-Chinese dumplings with ground chicken and vegetables',
                'price' => 35.00,
                'stock' => 80,
                'category' => 'Food',
                'image_url' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?w=500'
            ],
            [
                'name' => 'Beef Shawarma Rice',
                'description' => 'Grilled beef strips with rice, vegetables, and special sauce',
                'price' => 89.00,
                'stock' => 50,
                'category' => 'Food',
                'image_url' => 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=500'
            ],
            
            // Filipino Snacks
            [
                'name' => 'Turon',
                'description' => 'Sweet banana and jackfruit spring rolls with caramelized sugar coating',
                'price' => 20.00,
                'stock' => 60,
                'category' => 'Snack',
                'image_url' => 'https://images.unsplash.com/photo-1624374053855-39a5a1a41402?w=500'
            ],
            [
                'name' => 'Kwek-Kwek',
                'description' => 'Deep-fried orange battered quail eggs with vinegar dip',
                'price' => 25.00,
                'stock' => 70,
                'category' => 'Snack',
                'image_url' => 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?w=500'
            ],
            
            // Filipino Drinks
            [
                'name' => 'Sago\'t Gulaman',
                'description' => 'Sweet Filipino drink with tapioca pearls and gelatin',
                'price' => 25.00,
                'stock' => 100,
                'category' => 'Drink',
                'image_url' => 'https://images.unsplash.com/photo-1562707786-c0b4cc0a8746?w=500'
            ],
            [
                'name' => 'Melon Juice',
                'description' => 'Fresh and sweet cantaloupe juice',
                'price' => 30.00,
                'stock' => 80,
                'category' => 'Drink',
                'image_url' => 'https://images.unsplash.com/photo-1622597467836-f3c7ca3b4c25?w=500'
            ],
            
            // Filipino Coffee
            [
                'name' => 'Barako Coffee',
                'description' => 'Strong Filipino Liberica coffee',
                'price' => 35.00,
                'stock' => 100,
                'category' => 'Coffee',
                'image_url' => 'https://images.unsplash.com/photo-1511920170033-f8396924c348?w=500'
            ],
            [
                'name' => 'Iced Kapeng Pinoy',
                'description' => 'Sweet iced Filipino coffee with creamer',
                'price' => 40.00,
                'stock' => 90,
                'category' => 'Coffee',
                'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
