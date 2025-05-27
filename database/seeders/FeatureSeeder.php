<?php

namespace Database\Seeders;

use App\Models\FeatureCategory;
use App\Models\FeatureItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            [
                'name' => 'Entertainment',
                'hotel_id' => 1,
                'items' => [
                    ['name' => 'Smart TV', 'description' => '42-inch HD television with smart features', 'image' => 'features/tv.png', 'is_active' => true],
                    ['name' => 'Sound System', 'description' => 'Premium sound system with Bluetooth connectivity', 'image' => 'features/sound.png', 'is_active' => true],
                    ['name' => 'Game Console', 'description' => 'Latest gaming console with popular games', 'image' => 'features/game.png', 'is_active' => true],
                ]
            ],
            [
                'name' => 'Connectivity',
                'hotel_id' => 1,
                'items' => [
                    ['name' => 'High-Speed WiFi', 'description' => 'Fast and reliable internet connection', 'image' => 'features/wifi.png', 'is_active' => true],
                    ['name' => 'USB Charging Ports', 'description' => 'Convenient USB charging ports by the bed', 'image' => 'features/usb.png', 'is_active' => true],
                    ['name' => 'Smart Room Control', 'description' => 'Control room features from your smartphone', 'image' => 'features/smart.png', 'is_active' => true],
                ]
            ],
            [
                'name' => 'Comfort',
                'hotel_id' => 1,
                'items' => [
                    ['name' => 'Climate Control', 'description' => 'Adjustable air conditioning and heating', 'image' => 'features/climate.png', 'is_active' => true],
                    ['name' => 'Premium Bedding', 'description' => 'Luxury bedding for a restful sleep', 'image' => 'features/bedding.png', 'is_active' => true],
                    ['name' => 'Blackout Curtains', 'description' => 'Complete darkness for better sleep', 'image' => 'features/curtains.png', 'is_active' => false],
                ]
            ],
            [
                'name' => 'Kitchen',
                'hotel_id' => 1,
                'items' => [
                    ['name' => 'Mini Fridge', 'description' => 'Compact refrigerator for your refreshments', 'image' => 'features/fridge.png', 'is_active' => true],
                    ['name' => 'Coffee Maker', 'description' => 'Premium coffee machine with complimentary pods', 'image' => 'features/coffee.png', 'is_active' => true],
                    ['name' => 'Microwave', 'description' => 'Convenient for reheating meals', 'image' => 'features/microwave.png', 'is_active' => true],
                ]
            ],
        ];

        foreach ($categories as $category) {
            $items = $category['items'];
            unset($category['items']);

            // Create or update the category
            $featureCategory = FeatureCategory::updateOrCreate(
                ['name' => $category['name'], 'hotel_id' => $category['hotel_id']],
                $category
            );

            // Create items for this category
            foreach ($items as $item) {
                FeatureItem::updateOrCreate(
                    ['name' => $item['name'], 'feature_category_id' => $featureCategory->id],
                    array_merge($item, ['feature_category_id' => $featureCategory->id])
                );
            }
        }
    }
}
