<?php

namespace App\Filament\Resources\ProductComplectations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductComplectationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('productCategory.name')
                    ->label('Категорія')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Ціна (грн)')
                    ->money('UAH', locale: 'uk_UA')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('product_category_id')
                    ->relationship('productCategory', 'name')
                    ->label('Категорія продукту'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
