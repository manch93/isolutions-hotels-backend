<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'food_category';
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'image',
        'version',
        'is_deleted'
    ];

    // Set image url
    public function getImageAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function foods() {
        return $this->hasMany(Food::class);
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }

    public function version() {
        return static::max('version');
    }
}
