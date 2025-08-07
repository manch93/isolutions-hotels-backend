<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'hotel_id',
        'is_active',
        'is_deleted',
        'version',
    ];

    protected $casts = [
        'is_deleted' => 'boolean'
    ];
}
