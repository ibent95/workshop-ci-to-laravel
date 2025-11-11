<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // generate 10 user acak + profile
        Profile::factory()->count(10)->create();

        // buat admin khusus
        $admin = \App\Models\User::create([
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'username' => 'admin'
        ]);

        \App\Models\Profile::create([
            'user_id' => $admin->id,
            'email' => 'admin_test@yopmail.com',
            'name' => 'Administrator',
            'phone_number' => '081234567890'
        ]);
    }
}
