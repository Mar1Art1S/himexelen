<?php

namespace App\Filament\Resources\ProductComponents\Pages;

use App\Filament\Resources\ProductComponents\ProductComponentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductComponent extends EditRecord
{
    protected static string $resource = ProductComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
