<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function complectations(): HasMany
    {
        return $this->hasMany(ProductComplectation::class, 'product_category_id');
    }

    public function components(): HasMany
    {
        return $this->hasMany(ProductComponent::class, 'product_category_id');
    }
}
