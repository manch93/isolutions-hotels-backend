<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Around;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AroundController extends Controller
{
    public function get() {
        $key = 'around';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getAroundData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getAroundData() {
        return Around::all();
    }
}
