<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Promo;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Promo::where('hotel_id', $this->getHotel())->get());
    }
}
