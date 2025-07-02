<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Application::where('hotel_id', $this->getHotel())->get());
    }
}
