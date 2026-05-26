<?php

namespace App\Filament\Resources\ProductComponents;

use App\Filament\Resources\ProductComponents\Pages\CreateProductComponent;
use App\Filament\Resources\ProductComponents\Pages\EditProductComponent;
use App\Filament\Resources\ProductComponents\Pages\ListProductComponents;
use App\Filament\Resources\ProductComponents\Schemas\ProductComponentForm;
use App\Filament\Resources\ProductComponents\Tables\ProductComponentsTable;
use App\Models\ProductComponent;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductComponentResource extends Resource
{
    protected static ?string $model = ProductComponent::class;

    protected static ?string $navigationLabel = 'Комплектуючі';

    protected static ?string $pluralLabel = 'Комплектуючі';

    protected static ?string $modelLabel = 'Комплектуюче';

    protected static string|\UnitEnum|null $navigationGroup = 'Керування контентом';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    public static function form(Schema $schema): Schema
    {
        return ProductComponentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductComponentsTable::configure($table);
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
            'index' => ListProductComponents::route('/'),
            'create' => CreateProductComponent::route('/create'),
            'edit' => EditProductComponent::route('/{record}/edit'),
        ];
    }
}
