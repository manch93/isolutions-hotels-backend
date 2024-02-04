<?php

namespace Database\Seeders;

use App\Models\Around;
use App\Models\Food;
use App\Models\Hotel;
use App\Models\HotelFacility;
use App\Models\Promo;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotel = Hotel::create([
            'name' => 'Waduh',
            'branch' => 'Waduh',
            'address' => 'Alamat',
            'phone' => '08123456789',
            'email' => 'waduh@waduh',
            'website' => 'waduh.com',
            'is_active' => 1,
            'default_greeting' => 'Waduh',
        ]);

        $hotel->profile()->update([
            'logo_color' => 'waduh',
            'logo_white' => 'waduh',
            'logo_black' => 'waduh',
            'primary_color' => 'waduh',
            'description' => 'Waduh',
            'main_photo' => 'waduh',
            'background_photo' => 'waduh',
            'intro_video' => 'waduh',
        ]);

        HotelFacility::create([
            'hotel_id' => $hotel->id,
            'name' => 'Facility 1',
            'description' => 'Facility 1',
            'image' => 'waduh',
        ]);

        Around::create([
            'hotel_id' => $hotel->id,
            'name' => 'Around 1',
            'description' => 'Around 1',
            'image' => 'waduh',
        ]);

        Promo::create([
            'hotel_id' => $hotel->id,
            'name' => 'Promo 1',
            'description' => 'Promo 1',
            'image' => 'waduh',
        ]);

        Food::create([
            'hotel_id' => $hotel->id,
            'name' => 'Food 1',
            'description' => 'Food 1',
            'image' => 'waduh',
            'price' => 10000,
        ]);
    }
}
