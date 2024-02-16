<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Event::where('hotel_id', $this->getHotel())->get());
    }
}
