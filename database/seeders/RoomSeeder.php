<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = RoomType::create([
            'hotel_id' => 1,
            'name' => 'Standard',
            'description' => 'Standard',
            'image' => 'standard.jpg',
        ]);

        Room::create([
            'hotel_id' => 1,
            'room_type_id' => $type->id,
            'no' => 1,
            'guest_name' => null,
            'greeting' => 'Welcome',
            'device_name' => 'Room 1',
        ]);
    }
}
