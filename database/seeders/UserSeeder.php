<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@canteen.pos',
            'password' => Hash::make('admin_password'),
            'is_admin' => true
        ]);

        // Optional: Create regular user
        // User::create([
        //     'name' => 'Regular User',
        //     'email' => 'user@canteen.pos',
        //     'password' => Hash::make('user_password'),
        //     'is_admin' => false
        // ]);
    }
}
