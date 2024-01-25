<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch',
        'address',
        'phone',
        'email',
        'website',
        'is_active',
        'default_greeting',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($hotel) {
            $hotel->profile()->create([
                'hotel_id' => $hotel->id,
            ]);
        });

        static::deleting(function ($hotel) {
            $hotel->profile()->delete();
        });
    }

    public function profile()
    {
        return $this->hasOne(HotelProfile::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
