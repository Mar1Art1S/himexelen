<?php

namespace App\Filament\Resources\ProductComplectations;

use App\Filament\Resources\ProductComplectations\Pages\CreateProductComplectation;
use App\Filament\Resources\ProductComplectations\Pages\EditProductComplectation;
use App\Filament\Resources\ProductComplectations\Pages\ListProductComplectations;
use App\Filament\Resources\ProductComplectations\Schemas\ProductComplectationForm;
use App\Filament\Resources\ProductComplectations\Tables\ProductComplectationsTable;
use App\Models\ProductComplectation;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductComplectationResource extends Resource
{
    protected static ?string $model = ProductComplectation::class;

    protected static ?string $navigationLabel = 'Комплектації продуктів';

    protected static ?string $pluralLabel = 'Комплектації продуктів';

    protected static ?string $modelLabel = 'Комплектація';

    protected static string|\UnitEnum|null $navigationGroup = 'Керування контентом';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return ProductComplectationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductComplectationsTable::configure($table);
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
            'index' => ListProductComplectations::route('/'),
            'create' => CreateProductComplectation::route('/create'),
            'edit' => EditProductComplectation::route('/{record}/edit'),
        ];
    }
}
