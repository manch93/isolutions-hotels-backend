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
        $key = "room_detail_{$id}";
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getRoomDetailData($id);
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getRoomData() {
        return Room::with('roomType')->get();
    }

    public function getRoomDetailData($id) {
        return Room::with('roomType')->where('id', $id)->get();
    }
}
