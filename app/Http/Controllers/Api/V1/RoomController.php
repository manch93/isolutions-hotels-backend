<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    public function get() {
        $key = 'room';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getRoomData();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function detail($id) {
        // Search by room number
        $result = Room::with('roomType')->where('no', $id)->first();

        return $this->respondWithSuccess($result);
    }

    public function getRoomData() {
        return Room::with('roomType')->get();
    }
}
