<?php

namespace App\Filament\Resources\Instructions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstructionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Обкладинка'),

                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('label')
                    ->label('Комплектація')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('pdf')
                    ->label('Шлях до PDF')
                    ->copyable(),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                //
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
