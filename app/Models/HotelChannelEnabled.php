<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelChannelEnabled extends Model
{
    use HasFactory;

    protected $table = 'hotel_channel_enabled';

    protected $fillable = [
        'hotel_id',
        'm3u_channel_id',
        'alternative_name',
        'active',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function channel()
    {
        return $this->belongsTo(M3uChannel::class);
    }
}
