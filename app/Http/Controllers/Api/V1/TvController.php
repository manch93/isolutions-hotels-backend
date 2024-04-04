<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\HotelChannelEnabled;
use App\Models\M3uChannel;
use Illuminate\Support\Facades\DB;

class TvController extends Controller
{
    public function get() {
        $result = HotelChannelEnabled::join('m3u_channels', 'm3u_channels.id', '=', 'hotel_channel_enabled.m3u_channel_id')
            ->where('hotel_channel_enabled.hotel_id', $this->getHotel())
            ->where('hotel_channel_enabled.active', 1)
            ->where('m3u_channels.active', 1)
            ->select('m3u_channels.*', DB::raw("COALESCE(
                NULLIF(hotel_channel_enabled.alternative_name, ''),
                NULLIF(m3u_channels.secondary_name, ''),
                m3u_channels.name
            ) as name"))
            ->get();

        return $this->respondWithSuccess($result);
    }
}
