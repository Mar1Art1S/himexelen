<?php

namespace App\Filament\Resources\ProductComplectations\Pages;

use App\Filament\Resources\ProductComplectations\ProductComplectationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductComplectation extends EditRecord
{
    protected static string $resource = ProductComplectationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
