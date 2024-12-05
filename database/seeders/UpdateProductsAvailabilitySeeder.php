<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductsAvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->update(['is_available' => true]);
    }
}
