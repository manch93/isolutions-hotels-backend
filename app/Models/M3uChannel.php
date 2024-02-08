<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M3uChannel extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'channels';
    protected $fillable = [
        'm3u_source_id',
        'name',
        'url',
        'icon',
        'active',
    ];

    // Set image url
    public function getIconAttribute($value)
    {
        if (!$value) return null;
        if (str_contains($value, 'storage/' . self::$FILE_PATH)) return $value;
        return asset('storage/' . self::$FILE_PATH . '/' . $value);
    }

    public function source()
    {
        return $this->belongsTo(M3uSource::class);
    }
}
