<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'type', // frame, set, price_image
        'sort_order',
    ];

    public function getImageUrlAttribute(): string
    {
        if (Str::contains($this->image, '/') || Str::contains($this->image, '\\')) {
            return Storage::url($this->image);
        }

        return asset('images/beelg/'.$this->image);
    }
}
