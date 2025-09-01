<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelProfile extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'hotel';
    protected $fillable = [
        'hotel_id',
        'logo_color',
        'logo_white',
        'logo_black',
        'primary_color',
        'description',
        'main_photo',
        'background_photo',
        'intro_video',
        'running_text',
        'welcome_text',
        'instagram_username',
        'facebook_username',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getLogoColorAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function getLogoWhiteAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function getLogoBlackAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function getMainPhotoAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function getBackgroundPhotoAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function getIntroVideoAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    // Helper methods for social media URLs
    public function getInstagramUrlAttribute()
    {
        return $this->instagram_username ? 'https://instagram.com/' . $this->instagram_username : null;
    }

    public function getFacebookUrlAttribute()
    {
        return $this->facebook_username ? 'https://facebook.com/' . $this->facebook_username : null;
    }
}
