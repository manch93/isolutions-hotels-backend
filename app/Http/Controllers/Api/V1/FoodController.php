<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Food;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Food::where('hotel_id', $this->getHotel())->get());
    }
}
