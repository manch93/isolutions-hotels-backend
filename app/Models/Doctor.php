<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public static $FILE_PATH = 'doctor';
    protected $fillable = [
        'hotel_id',
        'doctor_category_id',
        'name',
        'image',
        'slug',
        'description',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function doctorCategory()
    {
        return $this->belongsTo(DoctorCategory::class);
    }
}
