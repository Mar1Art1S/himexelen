<?php

namespace App\Filament\Resources\ProductComponents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductComponentsTable
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

                TextColumn::make('group')
                    ->label('Група')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '8' => 'success',
                        '10' => 'info',
                        '12' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '8' => '8-рамковий',
                        '10' => '10-рамковий',
                        '12' => '12-рамковий',
                        'інше' => 'інше',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Група розміру')
                    ->options([
                        '8' => '8-рамковий',
                        '10' => '10-рамковий',
                        '12' => '12-рамковий',
                        'інше' => 'інше',
                    ]),

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
