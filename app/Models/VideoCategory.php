<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VideoCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'sort_order',
    ];

    /**
     * Get the videos for the category.
     *
     * @return HasMany<Video, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'video_category_id');
    }
}
