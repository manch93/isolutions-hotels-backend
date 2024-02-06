<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Room;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(Room::with('roomType')->where('hotel_id', $this->getHotel())->get());
    }

    public function detail($id) {
        // Search by room number
        try {
            $result = Room::with('roomType')->where('no', $id)->firstOrFail();
            return $this->respondWithSuccess($result);
        } catch (\Exception $e) {
            return $this->respondNotFound('Room not found');
        }
    }
}
