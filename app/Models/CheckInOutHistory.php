<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOutHistory extends Model
{
    use HasFactory;

    protected $table = 'check_inout_history';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_id',
        'is_check_in',
        'is_check_out',
        'guest_name',
    ];

    protected $casts = [
        'is_check_in' => 'boolean',
        'is_check_out' => 'boolean',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
