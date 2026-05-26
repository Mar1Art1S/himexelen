<?php

namespace App\Filament\Resources\ProductComponents\Pages;

use App\Filament\Resources\ProductComponents\ProductComponentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductComponents extends ListRecords
{
    protected static string $resource = ProductComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
