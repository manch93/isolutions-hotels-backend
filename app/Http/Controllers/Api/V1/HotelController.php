<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Hotel;
use App\Models\HotelFacility;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Hotel::with('profile')->where('id', $this->getHotel())->first());
    }

    public function facility() {
        return $this->respondWithSuccess(HotelFacility::where('hotel_id', $this->getHotel())->get());
    }
}
