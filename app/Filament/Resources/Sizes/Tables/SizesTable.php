<?php

namespace App\Filament\Resources\Sizes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SizesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Зображення'),

                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Розділ / Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'frame' => 'success',
                        'set' => 'info',
                        'price_image' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'frame' => 'Креслення рамок',
                        'set' => 'Варіанти наборів',
                        'price_image' => 'Таблиці цін',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->placeholder('Немає опису'),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Розділ')
                    ->options([
                        'frame' => 'Креслення рамок',
                        'set' => 'Варіанти наборів',
                        'price_image' => 'Таблиці цін',
                    ]),
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
