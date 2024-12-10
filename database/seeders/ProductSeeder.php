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
                'image_url' => 'https://thefoodietakesflight.com/wp-content/uploads/2020/10/Lumpiang-Shanghai.jpg'
            ],
            [
                'name' => 'Chicken Siomai',
                'description' => 'Steamed Filipino-Chinese dumplings with ground chicken and vegetables',
                'price' => 35.00,
                'stock' => 80,
                'category' => 'Food',
                'image_url' => 'https://panlasangpinoy.com/wp-content/uploads/2020/01/pork-siomai-recipe-728x750.jpg'
            ],
            [
                'name' => 'Beef Shawarma Rice',
                'description' => 'Grilled beef strips with rice, vegetables, and special sauce',
                'price' => 89.00,
                'stock' => 50,
                'category' => 'Food',
                'image_url' => 'https://philippinesfoodrecipes.wordpress.com/wp-content/uploads/2016/11/pinoy-shawarma-rice.jpg'
            ],
            
            // Filipino Snacks
            [
                'name' => 'Turon',
                'description' => 'Sweet banana and jackfruit spring rolls with caramelized sugar coating',
                'price' => 20.00,
                'stock' => 60,
                'category' => 'Snack',
                'image_url' => 'https://themayakitchen.com/wp-content/uploads/2019/10/TURON.jpg'
            ],
            [
                'name' => 'Kwek-Kwek',
                'description' => 'Deep-fried orange battered quail eggs with vinegar dip',
                'price' => 25.00,
                'stock' => 70,
                'category' => 'Snack',
                'image_url' => 'https://themayakitchen.com/wp-content/uploads/2020/09/Kwek-%E2%80%93-Kwek-7.jpg'
            ],
            
            // Filipino Drinks
            [
                'name' => 'Sago\'t Gulaman',
                'description' => 'Sweet Filipino drink with tapioca pearls and gelatin',
                'price' => 25.00,
                'stock' => 100,
                'category' => 'Drink',
                'image_url' => 'https://i.ytimg.com/vi/xphYsAzeuvo/maxresdefault.jpg'
            ],
            [
                'name' => 'Melon Juice',
                'description' => 'Fresh and sweet cantaloupe juice',
                'price' => 30.00,
                'stock' => 80,
                'category' => 'Drink',
                'image_url' => 'https://i0.wp.com/ricelifefoodie.com/wp-content/uploads/2023/06/cantaloupe-drink-with-milk-summer-beverage-recipe.jpg?fit=810%2C1080&ssl=1'
            ],
            
            // Filipino Coffee
            [
                'name' => 'Barako Coffee',
                'description' => 'Strong Filipino Liberica coffee',
                'price' => 35.00,
                'stock' => 100,
                'category' => 'Coffee',
                'image_url' => 'https://ph-test-11.slatic.net/p/936ba17004e93362daaf98f756e05d97.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
