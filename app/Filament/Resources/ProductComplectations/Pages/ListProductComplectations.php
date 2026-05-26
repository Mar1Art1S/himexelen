<?php

namespace App\Filament\Resources\ProductComplectations\Pages;

use App\Filament\Resources\ProductComplectations\ProductComplectationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductComplectations extends ListRecords
{
    protected static string $resource = ProductComplectationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
