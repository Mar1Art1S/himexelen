<?php

namespace App\Filament\Resources\Videos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('youtube_id')
                    ->label('YouTube ID')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Категорія')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'success',
                        'assembly' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'general' => 'Загальні відео',
                        'assembly' => 'Відео збірки',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Категорія')
                    ->options([
                        'general' => 'Загальні відео',
                        'assembly' => 'Відео збірки',
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
