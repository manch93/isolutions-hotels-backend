<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\WithGetFilterDataApi;

use function Laravel\Prompts\select;

class FoodController extends Controller
{
    use WithGetFilterDataApi;
    public function category(Request $request) {
        $data = $this->getDataWithFilter(
            model: FoodCategory::where('hotel_id', $this->getHotel())
                    ->where('version', '>', $request->after ?? 0),
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

        $maxVersion = FoodCategory::where('hotel_id', $this->getHotel())
                    ->max('version') ?? 0;
        $responseArray = $data->toArray();
        $responseArray['latest_version'] = $maxVersion;
        return $this->respondWithSuccess($responseArray);
    }

    public function getFoodByCategory($category) {
        return $this->respondWithSuccess(Food::where('food_category_id', $category)->get());
    }

    public function get(Request $request) {
        $query = Food::where('hotel_id', $this->getHotel());
    
        if ($request->has('after')) {
            $query->where('version', '>', $request->after ?? 0);
        }
        
        if ($request->has('id') && !empty($request->id)) {

            $ids = is_string($request->id) 
                ? explode(',', $request->id) 
                : (array) $request->id;
            
            
            $ids = array_filter(array_map('intval', $ids));
            
            if (!empty($ids)) {
                $query->whereIn('id', $ids);
            }
        }
        $data = $this->getDataWithFilter(
            model: $query,
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

    public function getFoodCategoryChangeList(Request $request) {
        $data = $this->getDataWithFilter(
            model: FoodCategory::where('hotel_id', $this->getHotel())
                    ->where('version', '>', $request->after ?? 0)
                    ->select('id', 'is_deleted', 'version'),
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

    public function getFoodChangeList(Request $request) {
        $data = $this->getDataWithFilter(
            model: Food::where('hotel_id', $this->getHotel())
                    ->where('version', '>', $request->after ?? 0),
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
