<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'documentation';
    protected $fillable = [
        'menu_id',
        'title',
        'image',
        'description',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
