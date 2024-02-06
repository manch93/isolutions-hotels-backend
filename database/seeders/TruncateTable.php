<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelFacility;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\User;
use App\Models\UserHasHotel;
use Illuminate\Database\Seeder;

class TruncateTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        UserHasHotel::truncate();
        User::truncate();
        Menu::truncate();
        RoomType::truncate();
        Room::truncate();
        HotelFacility::truncate();
        Hotel::truncate();
    }
}
