<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Instruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'label',
        'pdf',
        'image',
        'sort_order',
    ];

    public function getImageUrlAttribute(): string
    {
        if (Str::contains($this->image, '/') || Str::contains($this->image, '\\')) {
            return Storage::url($this->image);
        }

        return asset('images/beelg/'.$this->image);
    }

    public function getPdfUrlAttribute(): string
    {
        if (Str::contains($this->pdf, '/') || Str::contains($this->pdf, '\\')) {
            return Storage::url($this->pdf);
        }

        return asset('images/beelg/'.$this->pdf);
    }
}
