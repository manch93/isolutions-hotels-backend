<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\WithGetFilterDataApi;

class FoodController extends Controller
{
    use WithGetFilterDataApi;
    public function category() {
        $data = $this->getDataWithFilter(
            model: new FoodCategory,
            searchBy: [
                'name',
                'description',
            ],
            orderBy: $request?->orderBy ?? 'id',
            order: $request?->order ?? 'asc',
            paginate: $request?->paginate ?? 10,
            searchBySpecific: $request?->searchBySpecific ?? '',
            s: $request?->search ?? '',
        );
        return $this->respondWithSuccess($data);
    }

    public function getFoodByCategory($category) {
        return $this->respondWithSuccess(Food::where('food_category_id', $category)->get());
    }

    public function get(Request $request) {
        
        $data = $this->getDataWithFilter(
            model: Food::where('hotel_id', $this->getHotel()),
            searchBy: [
                'name',
                'description',
            ],
            orderBy: $request?->orderBy ?? 'id',
            order: $request?->order ?? 'asc',
            paginate: $request?->paginate ?? 10,
            searchBySpecific: $request?->searchBySpecific ?? '',
            s: $request?->search ?? '',
        );
        return $this->respondWithSuccess($data);
    }
}
