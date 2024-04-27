<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function category() {
        return $this->respondWithSuccess(FoodCategory::where('hotel_id', $this->getHotel())->get());
    }

    public function getFoodByCategory($category) {
        return $this->respondWithSuccess(Food::where('food_category_id', $category)->get());
    }

    public function get() {
        return $this->respondWithSuccess(Food::where('hotel_id', $this->getHotel())->get());
    }
}
