<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FeatureCategory;
use App\Models\FeatureItem;

class FeatureController extends Controller
{
    public function get() {
        return $this->respondWithSuccess(FeatureCategory::where('hotel_id', $this->getHotel())->get());
    }

    public function getFeatureItems($id)
    {
        $featureItem = FeatureItem::where('feature_category_id', $id)->get();

        if ($featureItem->isEmpty()) {
            return $this->respondWithError('No feature items found for this category.', 404);
        }

        return $this->respondWithSuccess(FeatureItem::where('feature_category_id', $id)->get());
    }
}
