<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'facilities';
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
    ];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}
