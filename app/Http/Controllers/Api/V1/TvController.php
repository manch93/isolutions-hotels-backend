<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\M3uChannel;

class TvController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(M3uChannel::where('active', 1)->get());
    }
}
