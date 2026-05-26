<?php

namespace App\Filament\Resources\ProductComponents\Pages;

use App\Filament\Resources\ProductComponents\ProductComponentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductComponent extends CreateRecord
{
    protected static string $resource = ProductComponentResource::class;
}
