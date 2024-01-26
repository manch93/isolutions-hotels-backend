<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Food;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class FoodController extends Controller
{
    public function get() {
        $key = 'food';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getFoodData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getFoodData() {
        return Food::all();
    }
}
