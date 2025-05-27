<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FeatureCategory;

class FeatureController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(FeatureCategory::where('hotel_id', $this->getHotel())->get());
    }
}
