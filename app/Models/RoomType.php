<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'room_type';
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'image',
    ];

    // Set image url
    public function getImageAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
