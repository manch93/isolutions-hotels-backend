<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $hotel = User::create([
            'name' => 'Admin Hotel 1',
            'email' => 'adminhotel1@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin');
        $hotel->assignRole('admin_hotel');
        $hotel->userHotel()->create([
            'user_id' => $hotel->id,
            'hotel_id' => Hotel::first()->id,
        ]);
    }
}
