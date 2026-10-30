<?php

namespace App\Filament\Resources\VideoSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideoSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Обкладинка')
                    ->disk('public')
                    ->square(),

                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('youtube_id')
                    ->label('YouTube ID')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Категорія')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label('Сортування')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
