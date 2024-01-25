<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Hotel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HotelController extends Controller
{
    public function get() {
        $key = 'hotel';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getHotelData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getHotelData() {
        return Hotel::with('profile')->where('is_active', 1)->get();
    }
}
