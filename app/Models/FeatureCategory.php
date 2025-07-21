<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hotel_id',
        'is_active',
        'is_deleted',
        'version',
    ];

    protected $casts = [
        'is_deleted' => 'boolean'
    ];
}
