<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Promo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PromoController extends Controller
{
    public function get() {
        $key = 'promo';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getPromoData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getPromoData() {
        return Promo::get();
    }
}
