<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'youtube_id',
        'image_path',
        'video_category_id',
        'sort_order',
    ];

    /**
     * Get the category that owns the video.
     *
     * @return BelongsTo<VideoCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }
}
