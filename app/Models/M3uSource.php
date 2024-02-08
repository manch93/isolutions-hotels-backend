<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M3uSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'type',
        'headers',
        'body',
        'active',
    ];

    public function channels()
    {
        return $this->hasMany(M3uChannel::class);
    }
}
