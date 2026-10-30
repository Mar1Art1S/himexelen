<?php

namespace App\Filament\Resources\VideoSections;

use App\Filament\Resources\VideoSections\Pages\CreateVideoSection;
use App\Filament\Resources\VideoSections\Pages\EditVideoSection;
use App\Filament\Resources\VideoSections\Pages\ListVideoSections;
use App\Filament\Resources\VideoSections\Schemas\VideoSectionForm;
use App\Filament\Resources\VideoSections\Tables\VideoSectionsTable;
use App\Models\Video;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VideoSectionResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $slug = 'video-section';

    protected static ?string $navigationLabel = 'ВІДЕО';

    protected static ?string $pluralLabel = 'ВІДЕО';

    protected static ?string $modelLabel = 'Відео ВІДЕО';

    protected static string|\UnitEnum|null $navigationGroup = 'Керування контентом';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static ?int $navigationSort = 30;

    /**
     * Only videos that belong to a category of the "ВІДЕО" type are managed here.
     *
     * @return Builder<Video>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('category', fn (Builder $query) => $query->where('type', 'videos'));
    }

    public static function form(Schema $schema): Schema
    {
        return VideoSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoSections::route('/'),
            'create' => CreateVideoSection::route('/create'),
            'edit' => EditVideoSection::route('/{record}/edit'),
        ];
    }
}
