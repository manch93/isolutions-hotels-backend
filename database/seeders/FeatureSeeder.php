<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{

    public function run(): void
    {
        $features = [
            'Promo',
            'Room Type',
            'Facility',
            'Nearby Attraction',
            'Policy',
        ];

        foreach ($features as $feature) {
            \App\Models\FeatureCategory::updateOrCreate(
                ['name' => $feature, 'hotel_id' => 1],
            );
        }
    }
}
