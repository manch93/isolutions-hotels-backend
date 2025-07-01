<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'feature_category_id',
        'is_active',
    ];

    public function featureCategory()
    {
        return $this->belongsTo(FeatureCategory::class);
    }
}
