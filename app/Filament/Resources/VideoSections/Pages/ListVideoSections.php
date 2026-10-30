<?php

namespace App\Filament\Resources\VideoSections\Pages;

use App\Filament\Resources\VideoSections\VideoSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoSections extends ListRecords
{
    protected static string $resource = VideoSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
