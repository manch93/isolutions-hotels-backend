<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Policy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PolicyController extends Controller
{
    public function get() {
        $key = 'policy';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getPolicyData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getPolicyData() {
        return Policy::all();
    }
}
