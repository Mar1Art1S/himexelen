<?php

namespace App\Filament\Resources\VideoCategories;

use App\Filament\Resources\VideoCategories\Pages\CreateVideoCategory;
use App\Filament\Resources\VideoCategories\Pages\EditVideoCategory;
use App\Filament\Resources\VideoCategories\Pages\ListVideoCategories;
use App\Filament\Resources\VideoCategories\Schemas\VideoCategoryForm;
use App\Filament\Resources\VideoCategories\Tables\VideoCategoriesTable;
use App\Models\VideoCategory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoCategoryResource extends Resource
{
    protected static ?string $model = VideoCategory::class;

    protected static ?string $navigationLabel = 'Категорії відео';

    protected static ?string $pluralLabel = 'Категорії відео';

    protected static ?string $modelLabel = 'Категорія відео';

    protected static string|\UnitEnum|null $navigationGroup = 'Керування контентом';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return VideoCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoCategoriesTable::configure($table);
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
            'index' => ListVideoCategories::route('/'),
            'create' => CreateVideoCategory::route('/create'),
            'edit' => EditVideoCategory::route('/{record}/edit'),
        ];
    }
}
