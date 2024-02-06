<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Around;
use App\Http\Controllers\Controller;

class AroundController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Around::where('hotel_id', $this->getHotel())->get());
    }
}
