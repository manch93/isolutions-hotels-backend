<?php

namespace App\Models;

use App\Models\FeatureCategory;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'content_id',
        'is_active',
        'is_deleted',
        'version',
    ];

    protected $casts = [
        'is_deleted' => 'boolean'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
