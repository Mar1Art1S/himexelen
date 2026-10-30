<?php

namespace App\Filament\Resources\VideoSections\Pages;

use App\Filament\Resources\VideoSections\VideoSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoSection extends EditRecord
{
    protected static string $resource = VideoSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
