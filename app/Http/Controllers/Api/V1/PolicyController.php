<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Policy;
use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Policy::where('hotel_id', $this->getHotel())->get());
    }
}
