<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function category() {
        return $this->respondWithSuccess(DoctorCategory::where('hotel_id', $this->getHotel())->get());
    }

    public function getDoctorByCategory($category) {
        return $this->respondWithSuccess(Doctor::where('doctor_category_id', $category)->get());
    }
}
