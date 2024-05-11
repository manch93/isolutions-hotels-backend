<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wifi extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'ssid_name',
        'ssid_password',
        'security_type',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
